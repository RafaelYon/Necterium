<?php

namespace App\Builder\Views\Commands;
use App\Builder\Views\Commands\CommandContract;

abstract class Command
{
    protected $compiler;
    
    public static function create($compiler) : CommandContract
    {
        $instance = new static();
        $instance->compiler = $compiler;

        return $instance;
    }
}