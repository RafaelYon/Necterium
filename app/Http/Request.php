<?php

namespace App\Http;

class Request
{
    public function getRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}