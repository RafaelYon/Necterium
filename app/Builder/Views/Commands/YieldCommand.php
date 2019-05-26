<?php

namespace App\Builder\Views\Commands;

use App\Builder\Views\Commands\CommandContract;
use App\Builder\Views\Commands\Command;

use App\Builder\Views\TemplateCompiler;

class YieldCommand extends Command implements CommandContract
{    
    public function handler(string $parameter)
    {
        $this->compiler->setResultContent(
            str_replace(
                '{{yield=' . $parameter . '}}', 
                $this->compiler->getVar($parameter),
                $this->compiler->getResultContent()
            )
        );
    }
}