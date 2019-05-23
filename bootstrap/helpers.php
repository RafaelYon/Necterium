<?php

/**
 * "Die and print"
 * 
 * Exibe o valor de $data formatado e encerra a execução
 * 
 * @param $data
 */
function dp ($data)
{
    echo '<pre>';
    die(print_r($data));
}

/**
 * Obtém um dado específicado dos arquivos de configuração configuração
 */
function config(string $section)
{    
    $firstDotPos = strpos($section, '.');

    $file = substr($section, 0, $firstDotPos);
    $keys = substr($section, $firstDotPos + 1);

    $data = include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
            . 'config' . DIRECTORY_SEPARATOR . $file . '.php';

    return App\Support\ArrayHelper::dotNestedAccess($keys, $data);
}

/**
 * Obtém um grupo de rotas a disponívels
 * 
 * @param string $type Valores possíveis: 'web' || 'api'
 * @param string $method Valores possíveis: 'GET' || 'POST'
 */
function routes(string $type, string $method)
{
    return config(implode('.', ['routes', $type, $method]));
}