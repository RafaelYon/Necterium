<?php

namespace App\Http\Controllers;

use App\Http\Request;

class ProductController
{
    public function show(Request $request)
    {
        dp(['ProductController', 'product', $request->getParameters()[0]]);
    }
}