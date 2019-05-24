<?php

namespace App\Http\Controllers;

use App\Http\Request;

class ProductController
{
    public function show(Request $request)
    {        
        \App\Models\Telefone::new()        
                 ->where('active', 1)
                 ->where('name', 'AAA', 'LIKE')
                 ->get();
    }
}