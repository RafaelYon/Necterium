<?php

namespace App\Builder\Views\Commands;

use App\Contracts\Builder\Views\Commands\Command as CommandContract;
use App\Builder\Views\Commands\Command;

use App\Builder\Views\TemplateCompiler;

class ExtendsCommand extends Command implements CommandContract
{    
    public function handler(string $parameter)
    {
        $this->compiler->setNextTemplateToCompile(
            resourcePath('views.' . $parameter)
        );
    }
}