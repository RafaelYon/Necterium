<?php

namespace App\Database;

use App\Support\Singleton;
use App\Database\Connection;

class ConnectionManager extends Singleton
{
    private $connections = array();

    protected function handlerConnectionRequisition(string $name)
    {
        if (!isset($this->connections[$name]))
        {
            $this->connections[$name] = new Connection($name);
        }

        return $this->connections[$name];
    }

    public static function getConnection(string $name = null) : Connection
    {        
        if ($name == null)
            $name = config('database.default');

        $instance = self::getInstance();

        return $instance->handlerConnectionRequisition($name);
    }
}