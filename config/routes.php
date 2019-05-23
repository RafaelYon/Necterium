<?php

return [
    'web' => [
        'GET' => [
            '/product/{^(([1-9])([0-9])*)$}' => 'ProductController@show',
            '/product/{([1-9])([0-9])*}/data',
            '/product/{([1-9])([0-9])*}/data/{([a-z])([a-z]*)}',
        ],
        'POST' => [

        ]
    ],

    'api' => [
        'GET' => [

        ],
        'POST' => [
            
        ]
    ]
];