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

    public static function except(array $arr, array $except)
    {
        foreach ($arr as $key => $value)
        {            
            if (in_array($value, $except))
                unset($arr[$key]);
        }

        return array_values($arr);
    }
}