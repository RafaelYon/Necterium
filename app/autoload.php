<?php

spl_autoload_register(function($className) 
{
    $className = ltrim($className, '\\');
    $fileName = '';
    $namespace = '';

    // Remove application namespace prefix
    $className = str_replace('App\\', '', $className);

    if ($lastSeparatorPos = strpos($className, '\\'))
    {
        $namespace = substr($className, 0, $lastSeparatorPos);
        $className = substr($className, $lastSeparatorPos + 1);

        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }

    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require $fileName;
});