<?php

namespace App\Controllers;
use App\Models\Menu;
use App\Models\UserModel; // Import the UserModel class
    // DATABASES
class UserController extends BaseController{
    public function __construct(){
        // load helper
        helper('url');

        // session controller
        $this->session = \Config\Services::session();
    }
    public function register() {

        
        $users = new UserModel(); // create new instance

        $db = db_connect(); // Not sure if this is actually required or not, but it is there

        $validationRules = [
            'username' => 'required|min_length[1]|max_length[20]', // |is_unique[users.username]', //min length of 1 character and maximum 20, cannot already be in use
            'password' => 'required|min_length[1]|max_length[20]', // same as above but multiple people can use the same password
        //    'password_confirm' => 'matches[password]' //I need to add this back in soon, just tried to get something working

        ];



        if (!$this->validate($validationRules)) {
            // Form validation failed, redirect back with errors
            return redirect()->back()->withInput()->with('error', 'Username or password do not meet the required length'); // will need to add error codes!!
       }

        
        // Form validation success, now read posted data

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user_type = $this->request->getPost('user_type');
        // hash password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // ERROR MESSAGES
        //Check table
        $builder = $db->table('users');
        //EXISTING USER IN DATABASE ERROR
        $existingUser = $builder->where('username', $username)->countAllResults() > 0;

        //return error message
        if ($existingUser) {
        //    // Username already exists, show error message
            return redirect()->to('/signup')->with('error', 'Username unavailable.');
        }        
        
       

        // Insert posted data into the database
        // make an array for it
        $data = [
            'username' => $username,
            'password' => $hashedPassword,
            'user_type' => $user_type,
        ];
        //post the data
        $users->insert($data);
        //move the user to the register view
        return view('register');


}



    // function for reading the user data for debug/future use (used lecture notes to create this)
    public function index(){
        // Load a new user model
        $model = new \App\Models\UserModel();
        // set values based on the get request made by the webpage
        $searchField = $this->request->getGet('search_field');
        $searchValue = $this->request->getGet('search_value');
        $user_type = ''; // need a field for the user type, can be empty since it is not using a get request

        // if and else logic to determine if the search fields have data?? This doesn't seem to be used, unsure how this is working for now
        if (!empty($searchField) && !empty($searchValue)) {
            $users = $model->where($searchField, $searchValue)->findAll();
        } else{
            $users = $model->findAll();
        }


        // Create a new array which can be displayed in a table in the php/html script on users.php
        $data = [
            'users' => $users,
            'searchField' => $searchField,
            'searchValue' => $searchValue,
            'user_type' => $user_type,
            
        ];
        // Return the view to the users page while loading the data array above
        return view('users', $data);

        }
    
// function to delete a user (ADMIN ONLY)
public function delete($id){
    // Check logged in
    $user_id = session()->get('user_id'); // Get userID of current session
    if (!$user_id) {
        // If user is not logged in, redirect them to the login page
        return redirect()->to('/login')->with('error', 'You need to login to manage users.');
    }
    // load user model
    $model = new \App\Models\UserModel();
    // if and else logic to set the flash data if successful or failed
    if ($model->delete($id)){
        $this->session->setFlashdata('success', 'User deleted');
    }
    else{
        $this->session->setFlashdata('error', 'Could not delete user');
    }
    // return the admin to the users page where the flash data will be displayed
    return redirect()->to('users');
}
}
?>