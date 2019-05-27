<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request;
use App\Security\Auth\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middlewares\AuthMiddleware::class);
    }

    public function index(Request $request)
    {
        dp(Auth::user());
    }

    public function logout(Request $request)
    {
        $request->validate([
            'csrf'  => 'required|csrf'
        ]);
        
        Auth::logout();

        redirect('/login');
    }
}