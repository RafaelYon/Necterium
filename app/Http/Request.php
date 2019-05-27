<?php

namespace App\Http;

use App\Support\UrlHelper;
use App\Security\Session;

class Request
{
    public const API_URL_PREFIX = 'api';

    private $parameters = array();

    public function __construct()
    {
        Session::start();
    }

    public function getRequestUri(bool $withAPIPrefix = true) : string
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (!$withAPIPrefix)
            $uri = str_replace(self::API_URL_PREFIX, '', $uri);

        return $uri;
    }

    public function getRequestMethod() : string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isApiRequest() : bool
    {   
        $urlParts = UrlHelper::getParts($this->getRequestUri());

        if (empty($urlParts))
            return false;

        return ($urlParts[0] === self::API_URL_PREFIX);
    }

    public function addParameter($parameter)
    {
        $this->parameters[] = $parameter;
    }

    public function clearParameters()
    {
        $this->parameters = array();
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getParameter(int $index)
    {
        return $this->parameters[$index];
    }

    public function getPost($key)
    {
        return @$_POST[$key];
    }

    public function getGet($key)
    {
        return @$_GET[$key];
    }

    public function getInput($key)
    {
        try
        {
            return $this->getPost($key);
        } 
        catch (\Throwable $th) {
            return $this->getGet($key);
        }
    }
}