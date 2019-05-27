<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request;
use App\Security\Hash;
use App\Models\User;
use App\Security\Auth\Auth;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middlewares\GuestMiddleware::class);
    }

    public function index(Request $request)
    {                
        return view('register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:256',
            'email'     => 'required|email|max:254|unique:users,email',
            'password'  => 'required|string|min:8',
            'csrf'      => 'required|csrf'
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = new User();
        $user->fill($data);

        $user->save();

        Auth::loginDirect($user);

        redirect('/home');
    }
}