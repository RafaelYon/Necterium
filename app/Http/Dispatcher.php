<?php

namespace App\Http;

use Exception;

use App\Http\Request;
use App\Http\Router;

class Dispatcher
{
    private function __construct() { }

    public static function handler()
    {
        $request = new Request();
        $router = new Router($request);

        return $router->doAction();
    }
}