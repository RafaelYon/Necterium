<?php

namespace App\Http;

use App\Support\UrlHelper;
use App\Security\Session;
use App\Validation\Validator;
use App\Exceptions\ValidationException;

class Request
{
    public const API_URL_PREFIX = 'api';

    private $parameters = array();
    private $queryParametes = array();

    public function __construct()
    {
        Session::start();
    }

    public function __destruct()
    {
        Session::set('previous_url', $this->getRequestUri());
    }

    public function getRequestUri(bool $withAPIPrefix = true, bool $withParamenter = false) : string
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (!$withAPIPrefix)
            $uri = str_replace(self::API_URL_PREFIX, '', $uri);

        if (!$withParamenter)
        {
            $queryPos = strpos($uri, '?');

            if ($queryPos !== false)
            {
                $param = substr($uri, $queryPos + 1);
                $this->queryParametes =  explode('&', $param);
                
                $uri = substr($uri, 0, $queryPos);
            }
        }

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
        if ($this->getRequestMethod() == 'POST')
            return $this->getPost($key);

        return $this->getGet($key);
    }

    public function validate(array $rules) : array
    {
        try
        {
            return Validator::verify($rules, $this);
        }
        catch (ValidationException $ex)
        {
            $this->backWithError($ex->getErrors());
        }
    }

    public function backWithErrors(array $errors)
    {
        Session::setErrors($errors);
        Session::setOldInput(($this->getRequestMethod() == 'POST') ? $_POST : $_GET);
        
        redirect(Session::pop('previous_url'));
    }
}