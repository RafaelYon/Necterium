<?php

namespace App\Support;

class StringHelper
{
    private function __construct() { }

    public static function toSnakeCase(string $str) : string
    {
        $upperCaseParts = array();

        preg_match_all('/[A-Z]/', $str, $upperCaseParts, PREG_OFFSET_CAPTURE);

        $result = strtolower($str);

        $lastCharPos = strlen($result) - 1;

        if ($result[$lastCharPos] != 'y')
            $result .= 's';
        else
            $result = substr_replace($result, 'ies', $lastCharPos, 3);

        if (empty($upperCaseParts))
            return $result;

        foreach ($upperCaseParts[0] as $upperCasePart)
        {
            if ($upperCasePart[1] < 1)
                continue;

            $result = substr_replace($result, '_', $upperCasePart[1], 0);
        }

        return $result;
    }
}