<?php

namespace App\Support;

class ArrayHelper
{
    private function __construct() { }

    public static function dotNestedAccess(string $dotKey, array $data)
    {
        $keys = explode('.', $dotKey);

        if (empty($keys))
            return null;

        $value = $data;

        foreach ($keys as $key)
        {
            $value = $value[$key];
        }

        return $value;
    }
}