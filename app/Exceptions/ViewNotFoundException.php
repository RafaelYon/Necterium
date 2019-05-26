<?php

namespace App\Exceptions;

use Exception;

class ViewNotFoundException extends Exception
{
    public function __construct(string $keyView, string $path)
    {
        parent::__construct("A view \"{$keyView}\" não foi encontrada. Caminho utilizado: \"{$path}\".");
    }
}