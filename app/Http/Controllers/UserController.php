<?php

namespace App\Http\Controllers;

use App\Http\Request;

class UserController
{
    public function index(Request $request)
    {
        return view('home');
    }
}