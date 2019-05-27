<?php

namespace App\Builder\Views\Commands;

use App\Builder\Views\Commands\CommandContract;
use App\Builder\Views\Commands\AwaitableCommandContract;
use App\Builder\Views\Commands\Command;

use App\Builder\Views\TemplateCompiler;

class SectionCommand extends Command implements CommandContract, AwaitableCommandContract
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
        $fullCommandLength = strlen($fullCommand);

        $commandPosition = strpos($this->compiler->getResultContent(), $fullCommand) + $fullCommandLength;
        $endCommandPosition = strpos($this->compiler->getResultContent(), '{{{{endsection}}}}') -  3; // Fix command position

        $section = \substr($this->compiler->getResultContent(), 
            $commandPosition, $endCommandPosition - $commandPosition);
        
        $this->compiler->setVar($this->varKey, $section);
    }
}