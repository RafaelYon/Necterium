<?php

return [
    'web' => [
        'GET' => [
            '/' => 'UserController@index',
            '/register' => 'RegisterController@index',
            '/phone' => 'PhoneController@index',
            '/phone/{^(([1-9])([0-9]*))$}' => 'PhoneController@show'
        ],
        'POST' => [
            '/register' => 'RegisterController@register'
        ]
    ],

    'api' => [
        'GET' => [

        ],
        'POST' => [
            
        ]
    ]
];