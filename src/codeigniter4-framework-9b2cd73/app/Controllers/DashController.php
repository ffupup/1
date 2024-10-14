<?php


namespace App\Controllers;

use CodeIgniter\Controller;

class DashController extends BaseController{
    // Create a function to index the session
    public function index()
    {
        // check logged in
        if (!session()->get('logged_in')){
            // If not logged in, prompt the user to login and give an error message
            session()->setFlashdata('error', 'Please sign in first');
            return view('login');
        }
        
        // logged in display dashbord
        $data = [
            'username' => session()->get('username'),
            'user_type' => session()->get('user_type')
        ];
        // return the dashboard with the elements from the data array
        return view('dashboard', $data);
    }

}