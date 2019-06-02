<?php

namespace App\Builder\Views\Commands;
use App\Contracts\Builder\Views\Commands\Command as CommandContract;

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