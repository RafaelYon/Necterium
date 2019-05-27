<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        return view('welcome');
    }
}