<?php

namespace App\Exceptions;

use Exception;

class RecordNotFoundException extends Exception
{
    public function __construct(string $table, array $conditions)
    {
        parent::__construct("Registros não encontrados na tabela \"{$table}\" com as condições: " 
            . implode("\n\t", $conditions));
    }
}