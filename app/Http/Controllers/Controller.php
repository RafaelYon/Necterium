<?php

namespace App\Http\Controllers;

use App\Http\Request;

abstract class Controller
{
    private $middlewares = [];
    
    public function middleware(string $className)
    {
        $this->middlewares[] = $className;
    }

    public function dispatch($action, Request $request)
    {
        foreach ($this->middlewares as $middleware)
        {
            $middleware::handler($request);
        }

        return $this->{$action}($request);
    }
}