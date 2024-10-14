<?php
namespace App\Controllers;
// Import QR code libraries
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;


// extend basecontroller
class TableController extends BaseController{
    
    // load url helper and session controller
    public function __construct(){
        // load helpers
        helper('url');

        // session controller
        $this->session = \Config\Services::session();
    }
    // function to create a table
    public function makeTable(){
        // load necessary helpers
        helper(['form', 'url']);
        
        // Load a new model
        $model = new \App\Models\QRModel();
        $user_id = session()->get('user_id'); // Get userID of current session
        // check user is logged in
        if (!$user_id) {
            // If user is not logged in, redirect them to the login page
            return redirect()->to('/login')->with('error', 'You need to login to add a table to your restaurant.');
        }

        // get table name from post request, for database
        $tableName = $this->request->getPost('table_name');
        
        $data = [
            // set data, table name, user id. make qr link empty for now
            'table_name' => $tableName,
            'user_id' => $user_id,
            'qr_link' => '', // 
        ];
        
        // Table added logic
        if ($model->save($data)){
            $this->session->setFlashdata('success', 'Table added successfully');
    
            }
            //table not added logic
            else{
                $this->session->setFlashdata('error', 'Error creating table');
            }
            // reditect to table list
            return redirect()->to('table_list');

    }
    
    // function for creating a qr code and attaching it to a table
    public function generateQRCode($qr_id) {
        // Load helpers
        helper(['form', 'url']);
    
        // load model and session id to get current active user
        $model = new \App\Models\QRModel();
        $user_id = session()->get('user_id');
    
        // Check if the user is logged in, if not return to login page with error
        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'You need to login to add a table to your restaurant.');
        }
    
        // get qr_id from database
        $qrID = $this->request->getPost('qr_id');
        // Create a URL specific to the qr_id
        // ensures all table urls are unique
        $tableURL = base_url('orders/' . $qr_id);
    
        // Generate QR code
        $qrCode = new \Endroid\QrCode\QrCode($tableURL);
        // set qr code size
        $qrCode->setSize(400);
    
        // initialise new writer
        $writer = new \Endroid\QrCode\Writer\PngWriter();
    
        // Create QR code image and save it to qrpath file
        $qrPath = 'uploads/qr/' . $qrID . '.png';
        $result = $writer->write($qrCode);
        $result->saveToFile($qrPath);
    
        // store qr code path and ids in database
        $data = [
            // tested and this data seems to work best. not sure why
            'qr_id' => $qr_id,
            'user_id' => $user_id,
            'qr_link' => base_url($qrPath), // store qr code link
        ];
    
        // qr code added logic
        if ($model->save($data)) {
            // success flashdata
            $this->session->setFlashdata('success', 'QR code added successfully');
        } else { // qr code not added error
            // error flashdata
            $this->session->setFlashdata('error', 'Error saving QR code');
        }
        // return to the table list
        return redirect()->to('table_list');
    }

    // function to display a QR code
    public function index_qr(){
        
        // verify user is logged in
        $user_id = session()->get('user_id'); // Get userID of current session
        if (!$user_id) {
            // If user is not logged in, redirect them to the login page
            return redirect()->to('/login')->with('error', 'You need to login to create a table.');
        }
        // Create a new qr code model
        helper(['form', 'url']);
        // create empty qrURL in to include tables with no qr code
        $qrURL = '';
        // load qr model
        $model = new \App\Models\QRModel();

        

        // save values from the get request
        $searchField = $this->request->getGet('search_field');
        $searchValue = $this->request->getGet('search_value');
        
        
        // load the builder
        $builder = $model->builder();
        
        // check for user_id and load qr data for the current user
        if (!empty($user_id)){
            $builder->where('user_id', $user_id);
        }

        // check the search fields are not empty
        if (!empty($searchField) && !empty($searchValue)) {
            $builder->like($searchField, $searchValue);
        } 
        
        

        // create new array
        $qrs = $builder->get()->getResultArray();
        // for loop to add qr links to view page and show qr codes
        foreach ($qrs as &$qr) {
            $qrURL = $qr['qr_link']; // Assuming the image file name is stored in the 'image' column
            
        }
        // save data to load to page
        $data = [
            'qrs' => $qrs,
            'searchField' => $searchField,
            'searchValue' => $searchValue,
            'user_id' => $user_id,
            'qr_link' => $qrURL,
        ];
        
        // return the view page menu list with data
        return view('table_list', $data);

    }
    
    // function to delete a table
    public function delete($id){
        // Check logged in
        $user_id = session()->get('user_id'); // Get userID of current session
        if (!$user_id) {
            // If user is not logged in, redirect them to the login page
            return redirect()->to('/login')->with('error', 'You need to login to manage tables.');
        }
        // load qr model
        $model = new \App\Models\QRModel();
        // if and else logic to set the flash data if successful or failed
        if ($model->delete($id)){
            $this->session->setFlashdata('success', 'Table deleted');
        }
        else{
            $this->session->setFlashdata('error', 'Could not delete table');
        }
        // return the business to their table list where the flash data will be displayed
        return redirect()->to('table_list');
    }
}
?>