<?php

use App\Builder\Views\Commands;
use App\Builder\Views\Commands\CommandContract;

use App\Builder\Views\TemplateCompiler;

abstract class Command
{
    protected $compiler;
    
    public static function create(TemplateCompiler $compiler) : CommandContract
    {
        $instance = new static();
        $instance->compiler = $compiler;

        return $instance;
    }
}