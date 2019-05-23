<?php

namespace App\Http;

use App\Support\UrlHelper;

class Request
{
    public const API_URL_PREFIX = 'api';

    private $parameters = array();

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
        return (UrlHelper::getParts($this->getRequestUri())[1] === self::API_URL_PREFIX);
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
}