<?php

namespace App\Builder\Views\Commands;

interface AwaitableCommandContract
{    
    public function finish(int $commandPostion);
}