<?php

namespace App\Exceptions;

use Exception;

use App\Http\Request;

class NotFoundException extends Exception
{
    private $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;

        parent::__construct('404 - Não encontrado:');
    }
}