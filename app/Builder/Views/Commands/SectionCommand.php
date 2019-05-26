<?php

namespace App\Builder\Views\Commands;

use App\Builder\Views\Commands\CommandContract;
use App\Builder\Views\Commands\AwaitableCommandContract;
use App\Builder\Views\Commands\Command;

use App\Builder\Views\TemplateCompiler;

class ExtendsCommand extends Command implements CommandContract, AwaitableCommandContract
{    
    private $varKey;

    public function handler(string $parameter)
    {
        $this->varKey = $parameter;

        $this->compiler->addWaitingCommand(
            'endsection',
            $this
        );
    }

    public function finish(int $endCommandPosition)
    {
        $fullCommand = '{{section='.$this->varKey.'}}';
        $fullCommandLength = str_len($fullCommand);

        $commandPosition = strpos($this->compiler->getResultContent(), $fullCommand);
        $endCommandPosition -= 3; // Fix command position

        
    }
}