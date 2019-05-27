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
        return @$_SESSION[$key];
    }

    public static function pop($key)
    {
        $result = self::get($key);
        self::remove($key);

        return $result;
    }

    public static function setErrors(array $errors)
    {
        self::set('errors', $errors);
    }

    public static function getErrors()
    {
        return self::get('errors');
    }

    public static function hasErrors() : bool
    {
        return (!empty(self::getErrors()));
    }

    public static function popArrayData($keyOne, $keyTwo)
    {
        $data = $_SESSION[$keyOne][$keyTwo];
        unset($_SESSION[$keyOne][$keyTwo]);

        return $data;
    }

    public static function popErrors()
    {
        return self::pop('errors');
    }

    public static function popError($key)
    {
        return self::popArrayData('errors', $key);
    }

    public static function setOldInput(array $input)
    {
        self::set('old_input', $input);
    }

    public static function popOldInput($key)
    {
        return self::popArrayData('old_input', $key);
    }
}