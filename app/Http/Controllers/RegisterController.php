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
        $data = $request->validate([
            'name'      => 'required|string|max:256',
            'email'     => 'required|email|max:254',
            'password'  => 'required|string'
        ]);

        dp($data);
    }
}