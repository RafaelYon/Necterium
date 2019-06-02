<?php

namespace App\Builder\Views\Commands;

use App\Contracts\Builder\Views\Commands\Command as CommandContract;
use App\Builder\Views\Commands\Command;

class VarCommand extends Command implements CommandContract
{    
    public function handler(string $parameter)
    {
        $parts = explode(':', $parameter);

        if (is_string($parts[1]))
        {
            $parts[1] = str_replace("'", '', $parts[1]);
        }

        $this->compiler->setVar($parts[0], $parts[1]);
    }
}