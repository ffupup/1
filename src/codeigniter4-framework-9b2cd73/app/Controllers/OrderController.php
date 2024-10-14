<?php

namespace App\Controllers;
use CodeIgniter\Database\Exceptions\DatabaseException; // debug
use App\Models\Menu; // Import the menu model class
use App\Models\OrderModel; // Import Order model class
use App\Models\QRModel; // import qr code model
use App\Models\OrderItemsModel; // import orderitems model
    
class OrderController extends BaseController{
    
    public function __construct(){
        // load helper
        helper('url');

        // session controller
        $this->session = \Config\Services::session();
    }


    public function index_menu($table_identifier)
{ // this is very similar to the index_menu function in the MenuController
    // Load necessary helpers and models
    helper(['form', 'url']);
    $Menumodel = new Menu();
    $QRModel = new QRModel();
    
    // Get the table name or ID from the URL segment
    //$uri = service('uri');
    
    //$table_identifier = $uri->getSegment(3); // this uses the name table_name, but this is actually the table's ID
    // should be fixed in a future version but for now this is functional
    //$table_identifier = '1';
    // logic to get the ID for the business the table and menu belongs to
    $table_info = $QRModel->where('qr_id', $table_identifier)->first();
    // save the business' ID
    $business_id = ($table_info) ? $table_info['user_id'] : null;

    // Generate a new session ID for the order
    $order_session_id = uniqid();

    // get the menu items for this business using if foreach logic
    if ($table_info) {
        // find all menu items matching the business' user ID
        $menus = $Menumodel->where('user_id', $business_id)->findAll(); 
        
         // Update image URLs in the $menus array
         foreach ($menus as &$menu) {
            // Check if image URL is null
            if ($menu['image_url'] !== null) {
                // Update image URL with base URL
                $menu['image_url'] = base_url($menu['image_url']); 
            }
    } 
    }else {
        // if menu items are not found return an empty array
        $menus = [];
    }

    // save data to load it to the view page
    $data = [
        'menus' => $menus,
        'table_identifier' => $table_identifier,
        'user_id' => $business_id,
        'order_session_id' => $order_session_id,
        
    ];

    // Load orders page with stored data
    return view('orders', $data);
}
    // function for making an order, this function shows a confirmation for the order and allows a user to go back and edit their order
    public function make_order(){

        //load helpers
        helper(['form','url']);
        // load models related to this
        $QRModel = new QRModel(); // load the qr code model
        $MenuModel = new Menu(); // load menu model
        
        // load the table name from the posted data
        $table_name = $this->request->getPost('table_name');
        
        // match the table name/ID to a business/user id
        $business_info = $QRModel->where('qr_id', $table_name)->first(); // read from the column titled table_name in the database
        $business_id = ($business_info) ? $business_info['user_id'] : null; // match the business info where the user_id matches the table name
        
        // potentially generate a new session for the order, this does not need to be random and could be a very high user number that is reserved
        // for a customer using a QR code, but also quite difficult to implement
        $customer_ordering_id = uniqid();

        // Initialize an array to store menu items with quantities to ensure that items with no quantity are not included
        $menus_with_quantities = [];
        // Loop through all posted order items and retrieve their quantities
        foreach ($this->request->getPost('order_items') as $itemId => $quantity) {
            if ($quantity > 0) { // Quantity greater than 0
                $menus_with_quantities[] = [
                    'item_id' => $itemId,
                    'order_quantity' => $quantity,
                ];
            }
        }
        // now use an if loop to find menu items based on the business_id
        if ($business_info) {
            $menus = $MenuModel->where('user_id', $business_id)->findAll();
            foreach ($menus as &$menu) {
                //$menu['image_url'] = base_url($menu['image_url']);
                // Retrieve order quantity from the array of selected items
                foreach ($menus_with_quantities as $item) {
                    if ($item['item_id'] == $menu['item_id']) {
                        $menu['order_quantity'] = $item['order_quantity'];
                        break;
                    }
                }
            }
        } else {
            $menus = [];
        }
       
        
        // Calculate total price
        $finalPrice = 0;
        foreach ($menus_with_quantities as $menuItem) {
            // Retrieve the item price from the database based on the item_id
            $itemPrice = $MenuModel->find($menuItem['item_id'])['item_price'];
            $finalPrice += $itemPrice * $menuItem['order_quantity'];
        }
        // if successful, save the data and load it on the next page
        $data = [
            'menus' => $menus,
            'table_name' => $table_name,
            'user_id' => $business_id,
            'customer_ordering_id' => $customer_ordering_id,
            'table_identifier' => $table_name,
            'final_price' => $finalPrice
        ];

        // return the view page for the confirmation page which will include a 
        // form to submit the data to the database -- this will load the data collected by this controller
        return view('order_confirm', $data);

    }
                // function to place the order and post the data to their databases
				public function place_order(){
					// helpers and models
					helper(['form', 'url']);
					$QRModel = new QRModel();
					$MenuModel = new Menu();
					$OrderModel = new OrderModel();
					$OrderItemModel = new OrderItemsModel();
					
					// read data from saved data/post request
					$table_id = $this->request->getPost('table_name'); // table id
					$business_info = $QRModel->where('qr_id', $table_id)->first(); // for the QR model, find table that matches this qr_id
					$business_id = ($business_info) ? $business_info['user_id'] : null; // get the business ID from their user_id
					$customer_ordering_id = uniqid(); // give customer ordering ID a unique ID. Not required, thought it would be but ran out of time to remove
					
					// add this data to an array for storage in the order data table
					$orderData = [
									'table_name' => $table_id, // this is actually the table's ID
									'customer_ordering_id' => $customer_ordering_id,
									'business_id' => $business_id,
									'order_status' => 'Active', // order is active not complete
					];
                    // store in the orders table in database
					$orderId = $OrderModel->insert($orderData);
					
					// find menu items selected with post request from the previous page
					$orderItems = [];
					foreach ($this->request->getPost('order_items') as $itemId => $quantity) {
									if ($quantity > 0) {
													// Retrieve the item price from the database based on the item ID
													$itemPrice = $MenuModel->find($itemId)['item_price'];
													$orderItems[] = [
																	'order_id' => $orderId,
																	'item_id' => $itemId,
																	'order_quantity' => $quantity,
																	'item_price' => $itemPrice,
													];
									}
					}
					
					// Store order items in the order_items table
					$OrderItemModel->insertBatch($orderItems);
					
					// display success and redirect
					return redirect()->to('/home')->with('success', 'Your order has been placed');
	}
    // function to index a business' orders
    public function index_orders() {
        // Ensure only users with user_type 'Business' can access this page
        if (session()->get('user_type') !== 'Business') {
            return redirect()->to('/home')->with('error', 'You do not have permission to access this page.');
        }
    
        // Load necessary models
        $OrderModel = new OrderModel();
        $OrderItemModel = new OrderItemsModel();
        $MenuModel = new Menu();
    
        // Get the business ID of the logged-in user
        $business_id = session()->get('user_id');
        $username = session()->get('username');
        // Fetch orders for the logged-in business
        $orders = $OrderModel->where('business_id', $business_id)->findAll();
    
        // Fetch items associated with each order
        foreach ($orders as &$order) {
            $order['items'] = $OrderItemModel->where('order_id', $order['order_id'])->findAll();
    
            // Fetch item details for each item
            foreach ($order['items'] as &$item) {
                $item_details = $MenuModel->find($item['item_id']);
                $item['item_name'] = $item_details['item_name'];
                
            }
        }
    
        // Pass orders data to the view and username data
        $data = [
            'orders' => $orders,
            'username' => $username
        ];
        // Load the view
        return view('order_list', $data);
    }

    // function to index all orders for admins
    public function admin_index_orders() {
        // Ensure only users with user_type 'Business' can access this page
        if (session()->get('user_type') !== 'Admin') {
            return redirect()->to('/home')->with('error', 'You do not have permission to access this page.');
        }
    
        // Load necessary models
        $OrderModel = new OrderModel();
        $OrderItemModel = new OrderItemsModel();
        $MenuModel = new Menu();
        
        //$builder = $OrderModel->builder();

        //$orders = $builder->get()->getResultArray();

        // Get the business ID of the logged-in user
        //$business_id = session()->get('user_id');
        //$username = session()->get('username');
        // Fetch orders for the logged-in business
        $orders = $OrderModel->findAll();
    
        // Fetch items associated with each order
        foreach ($orders as &$order) {
            $order['items'] = $OrderItemModel->where('order_id', $order['order_id'])->findAll();
    
            // Fetch item details for each item
            foreach ($order['items'] as &$item) {
                $item_details = $MenuModel->find($item['item_id']);
                $item['item_name'] = $item_details['item_name'];
                
            }
        }
    
        // Pass orders data to the view and username data
        $data = [
            'orders' => $orders,
            
        ];
        // Load the view
        return view('admin_order_list', $data);
    }

    // function to mark an order as completed
    public function update($order_id){
        // Load helpers
        helper(['form', 'url']);
        
        
        
        // load model and session id to get current active user
        $model = new \App\Models\OrderModel();
        $user_id = session()->get('user_id');

        // Check if the user is logged in, if not return to login page with error
        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'You need to login to change an order status.');
        }

        // Get the order ID from the route parameter using a uri request
        //$uri = service('uri'); // allow uri request
        //$order_id = $uri->getSegment(4);
        // see if order exists
        $order = $model->find($order_id);  
        // if the order does not exist return to oder_list with an error message
        if (!$order) {

            return redirect()->to('order_list')->with('error', 'No matching order in database');
        }      
        
        // generate new value for order_status
        $status = 'Complete';
        // store data
        $data = [
            'order_status' => $status,
        ];
        // order status change logic (update the model where the order_id matches)
        if ($model->update($order_id, $data)) {
            // success flashdata
            $this->session->setFlashdata('success', 'Order status changed successfully');
        } else { 
            // error flashdata
            $this->session->setFlashdata('error', 'Error changing order status');
        }
        // return to the order list
        return redirect()->to('order_list');
    }
}
    

