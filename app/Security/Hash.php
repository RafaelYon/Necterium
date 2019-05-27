<?php

namespace App\Security;

class Hash
{
    private function __construct() { }

    public static function make(string $data) : string
    {
        return password_hash($data, PASSWORD_DEFAULT);
    }

    public static function check(string $attempt, string $hash) : bool
    {
        return password_verify($attempt, $hash);
    }
}