<?php

namespace App\Builder\Views\Commands;

use App\Builder\View\TemplateCompiler;

interface CommandContract
{
    public static function create(TemplateCompiler $compiler) : CommandContract;
    
    public function handler(string $parameter);
}