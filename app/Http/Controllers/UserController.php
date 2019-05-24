<?php

namespace App\Http\Controllers;

use App\Http\Request;

class UserController
{
    public function index(Request $request)
    {
        // $phone = new \App\Models\Phone();

        // $phone->number = '111111111';
        // dp($phone->save());

        dp(\App\Models\Phone::find(1));       
        
        dp('Ok');
    }
}