<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request;
use App\Security\Auth\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middlewares\GuestMiddleware::class);
    }

    public function index(Request $request)
    {                
        return view('login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'     => 'required|email|max:254',
            'password'  => 'required|string|min:8',
            'csrf'      => 'required|csrf'
        ]);

        if (Auth::attempt($data['email'], $data['password']))
            redirect('/home');
        
        $request->backWithErrors([
            ['Credenciais inválidas']
        ]);
    }
}