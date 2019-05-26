<?php

namespace App\Builder\Views\Commands;

interface CommandContract
{
    public static function create($compiler) : CommandContract;
    
    public function handler(string $parameter);
}