<?php

namespace App\Support;

class Singleton
{
    protected static $instance = null;

    protected function __construct()
    {
        self::$instance = $this;
    }

    public static function getInstance()
    {
        if (self::$instance == null)
            new static();
        
        return self::$instance;
    }
}