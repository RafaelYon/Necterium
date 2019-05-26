<?php

namespace App\Exceptions;

use Exception;

class UnableOpenFileException extends Exception
{
    public $filePath;
    public $mode;
    
    public function __construct(string $filePath, string $mode)
    {
        $this->filePath = $filePath;
        $this->mode = $mode;
        
        parent::__construct("Não foi possível abrir o arquivo \"{$filePath}\" no modo \"{$mode}\"");
    }
}