<?php

return [
    'web' => [
        'GET' => [
            '/' => 'WelcomeController@index',
            '/register' => 'RegisterController@index',
            '/home'     => 'UserController@index',

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