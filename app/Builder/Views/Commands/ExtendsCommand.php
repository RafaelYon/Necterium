<?php

namespace App\Builder\Views\Commands;

use App\Builder\Views\Commands\CommandContract;
use App\Builder\Views\Commands\Command;

use App\Builder\Views\TemplateCompiler;

class ExtendsCommand extends Command implements CommandContract
{    
    public function handler(string $parameter)
    {
        $this->compiler->addNextTemplateCompile(
            '{{extends='.$parameter.'}}',
            new TemplateCompiler(
                resourcePath('views' . $parameter),
                $this->compiler->getVars()
            )
        );
    }
}