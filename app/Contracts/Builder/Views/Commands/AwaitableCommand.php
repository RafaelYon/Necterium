<?php

namespace App\Contracts\Builder\Views\Commands;

interface AwaitableCommand
{    
    public function finish(int $commandPostion);
}