<?php

namespace App\Contracts\Builder\Views\Commands;

interface Command
{
    public static function create($compiler) : Command;
    
    public function handler(string $parameter);
}