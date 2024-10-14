<?php
// this function is not required, it was for testing only
namespace App\Controllers;

use CodeIgniter\Controller;

class UploadController extends Controller{

    // Function construct, load URL helper
    public function __construct(){
        helper('url');
    }

    // index, view upload form
    public function index(){
        // show upload form
        return view('uploadform');
    }



}