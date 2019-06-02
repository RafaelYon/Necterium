<?php

namespace App\Builder\Views\Commands;

use App\Contracts\Builder\Views\Commands\Command as CommandContract;
use App\Contracts\Builder\Views\Commands\AwaitableCommand as AwaitableCommandContract;
use App\Builder\Views\Commands\Command;

class SectionCommand extends Command implements CommandContract, AwaitableCommandContract
{    
    private const END_COMMAND = '{{endsection}}';
    
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

        $commandPosition = strpos(
            $this->compiler->getOriginalContent(), 
            $fullCommand
        ) + $fullCommandLength;
                            
        $endCommandPosition = strpos(
            $this->compiler->getOriginalContent(),
            self::END_COMMAND
        );

        $section = \substr($this->compiler->getOriginalContent(),
            $commandPosition, $endCommandPosition - $commandPosition);

        $this->compiler->setOriginalContent(
            preg_replace('/' . self::END_COMMAND . '/', '', $this->compiler->getOriginalContent(), 1)
        );
        
        $this->compiler->setVar($this->varKey, $section);
    }
}