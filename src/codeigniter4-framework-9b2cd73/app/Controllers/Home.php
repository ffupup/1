<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        //load URL helper
        helper('url');
    }
    public function index(): string
    {
        return view('home');
    }

    public function login(): string
    {
        return view('login');
    }

    public function signup(): string
    {
        return view('signup');
    }
    
    public function menu(): string
    {
        return view('menu');
    }
    
    public function qrcode(): string
    {
        return view('table_list');
    }

    public function add_table(): string
    {
        return view('add_table');
    }
    
    public function home(): string
    {
        return view('home');
    }




}
?>