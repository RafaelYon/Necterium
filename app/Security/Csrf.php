<?php

namespace App\Security;

use App\Security\Session;

class Csrf
{
    private const TOKEN_KEY = 'csrf_token';
    private const TIME_KEY = 'csrf_time';
    
    private function __construct() { }

    public static function create() : string
    {        
        $token = sha1(uniqid(rand(), true) . time());
        
        Session::set(self::TOKEN_KEY, $token);
        Session::set(self::TIME_KEY, time());

        return $token;
    }

    public static function check($token) : bool
    {   
        if (empty($token))
            return false;
        
        $storagedToken = Session::get(self::TOKEN_KEY);

        if (empty($storagedToken))
            return false;

        $time = Session::get(self::TIME_KEY);

        if (empty($time))
            return false;

        return ($storagedToken === $token && $time + config('security.csrf.expires') >= time());
    }
}