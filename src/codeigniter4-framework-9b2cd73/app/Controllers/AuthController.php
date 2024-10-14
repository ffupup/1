<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel; // Import the UserModel class

class AuthController extends BaseController
{
        // load url helper and session crontroller
    public function __construct(){
        // load helper
        helper('url');
    
        // session controller
        $this->session = \Config\Services::session();
    }

    // create a function to sign in a user
    public function signin()
    {

        $model = new UserModel(); // Instantiate the UserModel
        // check if get method is post
        if ($this->request->getMethod() === 'POST') {
            // read username and password from post data and save
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
    
            // Validate the input is entered
            if (empty($username) || empty($password)) {
                session()->setFlashdata('error', 'Username and password are required');
                return redirect()->back();
            }
    
            // Search for the user in the database
            $user = $model->where('username', $username)->first();
    
            // Verify password
            if ($user) {
                // password verify will unhash the passwords, this is okay and what we want
                if (password_verify($password, $user['password'])) {
                    // Correct password, store user data in session
                    $sessionData = [
                        
                        'username' => $user['username'],
                        'logged_in' => true,
                        'user_type' => $user['user_type'],
                        'user_id' => $user['id']

                    ];
                    // set the session data using the stored sessiondata
                    session()->set($sessionData);
                    // redirect the user to their user dashboard
                    return redirect()->to('dashboard');
                } else {
                    // Incorrect password
                    session()->setFlashdata('error', 'Incorrect password');
                    // send user back to the page with error message
                    return redirect()->back();
                }
            } else {
                // User not found
                session()->setFlashdata('error', 'User not found');
                // send user back with error message
                return redirect()->back();
            }
        }

        // If the request method is not POST, load the login view
        return view('login');
    }

    // function to logout a user
    public function logout(){
        // destroy the session
        session()->destroy();
        // redirect the user to the login page
        return redirect()->to('/login');
    }
}