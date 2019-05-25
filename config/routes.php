<?php

return [
    'web' => [
        'GET' => [
            '/' => 'UserController@index',
            '/phone' => 'PhoneController@index',
            '/phone/{^(([1-9])([0-9]*))$}' => 'PhoneController@show'
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