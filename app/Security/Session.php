<?php

namespace App\Security;

class Session
{
    private function __construct() { }

    public static function start()
    {
        if (session_id() == '')
            session_start();
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public static function get($key)
    {
        return $_SESSION[$key];
    }

    public static function pop($key)
    {
        $result = self::get($key);
        self::remove($key);

        return $result;
    }
}