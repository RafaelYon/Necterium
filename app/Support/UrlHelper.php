<?php

namespace App\Support;

use App\Support\ArrayHelper;

class UrlHelper
{
    public const PART_DELIMITER = '/';

    private function __construct() { }

    public static function getParts(string $uri, bool $withEmpty = false)
    {
        $parts = explode(self::PART_DELIMITER, $uri);

        if (!$withEmpty)
        {
            $parts = ArrayHelper::except($parts, ['']);
        }

        return $parts;
    }
}