<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Models\Phone;

class PhoneController
{
    public function index(Request $request)
    {
        dp('PHONES!');
    }

    public function show(Request $request)
    {
        $phone = Phone::findOrFail($request->getParameter(0));

        dp($phone->toJson());
    }

    public function create(Request $request)
    {
        $phone = new \App\Models\Phone();

        $phone->number = $request->getParameter(0);
        dp($phone->save());
    }
}