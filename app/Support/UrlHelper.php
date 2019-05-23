<?php

namespace App\Support;

class UrlHelper
{
    public const PART_DELIMITER = '/';

    private function __construct() { }

    public static function getParts(string $uri)
    {
        return explode(self::PART_DELIMITER, $uri);
    }
}