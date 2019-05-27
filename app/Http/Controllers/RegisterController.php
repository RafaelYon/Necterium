<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Security\Csrf;

class RegisterController
{
    public function index(Request $request)
    {        
        return view('register');
    }

    public function register(Request $request)
    {
        
    }
}