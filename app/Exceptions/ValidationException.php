<?php

namespace App\Exceptions;

use Exception;

use App\Http\Request;

class ValidationException extends Exception
{
    private $errors;
    private $request;
    
    public function __construct(array $errors, Request $request)
    {
        $this->errors = $errors;
        $this->request = $request;

        parent::__construct('Os dados da requisição não são válidos, para as regras utilizadas');
    }

    public function getErrors() : array
    {
        return $this->errors;
    }

    public function getRequest() : Request
    {
        return $this->request;
    }
}