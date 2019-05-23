<?php

/**
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
 * Obtém dados de configuração
 */
function config(string $section)
{
    $firstDotPos = strpos($section, '.');

    $config = substr($section, 0, $firstDotPos);
    $keys = substr($section, $firstDotPos + 1);

    $data = include __DIR__ . '/../config/' . $config . '.php';

    return App\Support\ArrayHelper::dotNestedAccess($keys, $data);
}