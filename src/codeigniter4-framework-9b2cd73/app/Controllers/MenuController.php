<?php

namespace App\Controllers;

use App\Models\Menu; // Import the UserModel class
    // DATABASES
class MenuController extends BaseController{
    
    
    // load url helper and session crontroller
    public function __construct(){
        // load helper
        helper('url');

        // session controller
        $this->session = \Config\Services::session();
    }
    public function index_image(){
        return view('uploadform');
    }
    // FUNCTION TO UPLOAD AN IMAGE this is irrelevant now
    public function upload_image() {
        // Check if files were uploaded
        if ($this->request->getFile('file')) {
            // Get uploaded file
            $file = $this->request->getFile('file');
    
            // Check if file is valid
            if ($file->isValid() && $file->getSize() < 2048) { // Adjust file size limit as needed
                // Generate a unique name for the file
                $newName = $file->getRandomName();
    
                // Move the file to the writable directory
                if ($file->move(WRITEPATH . 'uploads', $newName)) {
                    // File uploaded successfully, return the file URL
                    $imageUrl = base_url('uploads/' . $newName);
                    // Store the $imageUrl in your database or associate it with the menu item
                    // You can access other form fields using $this->request->getPost('field_name')
                    return $imageUrl;
                    return this->response->setJSON(['success' => true]);
                } else {
                    // Error moving file
                    return $this->response->setJSON(['success' => false]);
                    return 'Error uploading file.';
                }
            } else {
                // Invalid file
                return 'Invalid file or file size too large.';
            }
        } else {
            // No file uploaded
            return 'No file uploaded.';
        }
    }

    // FUNCTION TO CREATE AN ITEM
    public function make_item() {

        
        $menu = new Menu(); // create new instance

        $user_id = session()->get('user_id'); // Get userID of current session
        if (!$user_id) {
            // If user is not logged in, redirect them to the login page
            return redirect()->to('/login')->with('error', 'You need to login to create a menu item.');
        }
        $db = db_connect(); // Not sure if this is actually required or not, but it is there

        $validationRules = [
            'item_name' => 'required|min_length[1]|max_length[20]', // min length of 1 character and maximum 20, can be in use already
            'item_category' => 'required|min_length[1]|max_length[20]', // same as above
            'item_price' => 'required|decimal', // simply required and needs to be a decimal

        ];


        // Test the validation rules
        if (!$this->validate($validationRules)) {
            // Form validation failed, redirect back with errors
            return redirect()->back()->withInput()->with('error', 'Item name or category do not meet the required length'); // will need to add error codes!!
       }



        // Form validation success, now read posted data
        // Set variables
        $itemname = $this->request->getPost('item_name');
        $itemcategory = $this->request->getPost('item_category');
        $itemprice = $this->request->getPost('item_price');
        

        // Insert posted data into the database
        // make an array for it
        $data = [
            'item_name' => $itemname,
            'item_category' => $itemcategory,
            'item_price' => $itemprice,
            'user_id' => $user_id,
            //'image_url' => '', Add this feature later.
        ];
        //post the data
        $menu->insert($data);
        //move the user to the register view
        return view('make_item');
    }

    //now a function for displaying the data on the next page
        
    public function index_menu()
    {
        // Create a new Menu model
        helper(['form', 'url']);
        $imageURL = '';
        $model = new Menu();

        // save values from the get request
        $searchField = $this->request->getGet('search_field');
        $searchValue = $this->request->getGet('search_value');
        $user_id = session()->get('user_id');
        
        // load the builder
        $builder = $model->builder();
        
        // check if there is a user ID
        if (!empty($user_id)){
            $builder->where('user_id', $user_id);
        }

        // check the search fields are not empty
        if (!empty($searchField) && !empty($searchValue)) {
            $builder->like($searchField, $searchValue);
        } 
        
        

        // create a new array
        $menus = $builder->get()->getResultArray();
        
        foreach ($menus as &$menu) {
            $imageURL = $menu['image_url']; // Assuming the image file name is stored in the 'image' column
            
        }
        // save data to load to page
        $data = [
            'menus' => $menus,
            'searchField' => $searchField,
            'searchValue' => $searchValue,
            'user_id' => $user_id,
            'image_url' => $imageURL,
        ];
        
        // return the view page menu list with the data saved above
        return view('menu_list', $data);

        }
    // New function, very similar to index_menu but will show ALL item entries - will not comment similar code
    public function admin_menu(){
        $imageURL = ''; // load a blank variable in case there are images with no URL
        $model = new Menu();

        $searchField = $this->request->getGet('search_field');
        $searchValue = $this->request->getGet('search_value');
        $builder = $model->builder();
        // check the search fields are not empty
        if (!empty($searchField) && !empty($searchValue)) {
            $builder->like($searchField, $searchValue);
        } 
        
        

        // create a new array
        $menus = $builder->get()->getResultArray();

        foreach ($menus as &$menu) {
            $imageURL = $menu['image_url']; // load the image URL stored in the database menu table
            
        }

        $data = [
            'menus' => $menus,
            'searchField' => $searchField,
            'searchValue' => $searchValue,
            //'user_id' => $user_id,
            //'image_url'=> $imageURL,
        ];
        // return the menulisttest view with the saved data
        return view('menu_list_test', $data);

    }

        // Now a function for the updating of the menu items :)
    public function additem(){
        // New array
        $user_id = session()->get('user_id'); // Get userID of current session
        if (!$user_id) {
            // If user is not logged in, redirect them to the login page
            return redirect()->to('/login')->with('error', 'You need to login to create a menu item.');
        }
        $data = [
            'title' => 'Add Menu Item',
            'menu' => null,
        ];



        // return to makeitem list
        return view('menu_form',$data);
    }

    // new function to save an item
    public function saveitem(){
        
        // Load necessary helpers and libraries
        helper(['form', 'url']);
        // Load a new model
        $model = new \App\Models\Menu();
        $user_id = session()->get('user_id'); // Get userID of current session
        if (!$user_id) {
            // If user is not logged in, redirect them to the login page
            return redirect()->to('/login')->with('error', 'You need to login to create a menu item.');
        }
        // If user is logged in
        // If no file was uploaded, set the image URL to null or any default value
        $imageURL = null;
        // Get the uploaded file information from DropZone
        $uploadedFile = $this->request->getFile('file');
        // Check if a file was uploaded
        if ($uploadedFile && $uploadedFile->isValid()) {
            // Save the uploaded file to the uploads folder
            $newName = $uploadedFile->getRandomName();
            // Save the uploaded file to the uploads folder in the public folder... This will need to be changed later to use the directory for the writable folder, potentially
            
            $uploadedFile->move('./uploads', $newName);
            
            // Get the URL of the uploaded file
            $imageURL = 'uploads/' . $newName;
            //return $this->response->setJSON(['success' => true]);
        } 
        

        $data = [
            'item_name' => $this->request->getPost('item_name'),
            'item_category' => $this->request->getPost('item_category'),
            'item_price' => $this->request->getPost('item_price'),
            'user_id' => $user_id,
            'image_url' => $imageURL,
            
        ];
        // Menu item added
        if ($model->save($data)){
        $this->session->setFlashdata('success', 'Menu item added');

        }
        //menu item not added
        else{
            $this->session->setFlashdata('error', 'Error creating menu item');
        }
        // return the user to the menu list
        return redirect()->to('menu_list');
        
    
    }

    public function edititem($id){
        $user_id = session()->get('user_id'); // Get userID of current session
        if (!$user_id) {
            // If user is not logged in, redirect them to the login page
            return redirect()->to('/login')->with('error', 'You need to login to create a menu item.');
        }
        $model = new \App\Models\Menu();

        $menu = $model->find($id);

        if (!$menu){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Menu item not found');

        }

        $data = [
            'title' => 'Edit Menu Item',
            'menu' => $menu,
        ];

        return view('menu_form', $data);
    }
    // function for updating a model
    public function update($id){
        $user_id = session()->get('user_id'); // Get userID of current session
        if (!$user_id) {
            // If user is not logged in, redirect them to the login page
            return redirect()->to('/login')->with('error', 'You need to login to create a menu item.');
        }
        // Load a new menu model
        $model = new \App\Models\Menu();
        // save new post data request as an array called $data
        // Check for new image_url
        $uploadedFile = $this->request->getFile('file');
        // Check if a file was uploaded
        if ($uploadedFile && $uploadedFile->isValid()) {
            // Save the uploaded file to the uploads folder
            $newName = $uploadedFile->getRandomName();
            // Save the uploaded file to the uploads folder in the public folder... This will need to be changed later to use the directory for the writable folder, potentially
            
            $uploadedFile->move('./uploads/menu/', $newName);
            
            // Get the URL of the uploaded file
            $imageURL = 'uploads/menu' . $newName;
            //return $this->response->setJSON(['success' => true]);
        } 
        $data = [
            'item_name' => $this->request->getPost('item_name'),
            'item_category' => $this->request->getPost('item_category'),
            'item_price' => $this->request->getPost('item_price'),
        ];
        // if and else functions to display success or failure as flashdata
        if($model->update($id,$data)){
            $this->session->setFlashdata('success', 'item updated');

        }
        else{
            $this->session->setFlashdata('success', 'item updated');

        }
        // return the business owner to their menu list
        return redirect()->to('menu_list');
    }

    // function to delete an item
    public function delete($id){
        // Check logged in
        $user_id = session()->get('user_id'); // Get userID of current session
        if (!$user_id) {
            // If user is not logged in, redirect them to the login page
            return redirect()->to('/login')->with('error', 'You need to login to create a menu item.');
        }
        // load menu model
        $model = new \App\Models\Menu();
        // if and else logic to set the flash data if successful or failes
        if ($model->delete($id)){
            $this->session->setFlashdata('success', 'Menu item deleted');
        }
        else{
            $this->session->setFlashdata('error', 'Could not delete menu item');
        }
        // return the business to their menu list
        return redirect()->to('menu_list');
    }

    
}

?>