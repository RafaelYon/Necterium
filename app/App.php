<?php

namespace App;

use App\Http\Dispatcher;

class App
{
    public function __construct()
    {
        Dispatcher::handler();
    }
}