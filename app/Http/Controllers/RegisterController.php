<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Security\Hash;
use App\Models\User;

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
            'email'     => 'required|max:254|unique:users,email',
            'password'  => 'required|string|min:8',
            'csrf'      => 'required|csrf'
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = new User();
        $user->fill($data);

        $user->save();

        dp($user);
    }
}