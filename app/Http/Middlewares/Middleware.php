<?php

namespace App\Http\Middlewares;

use App\Http\Request;

interface Middleware
{
    public static function handler(Request $requets);
}