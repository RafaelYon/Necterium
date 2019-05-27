<?php

return [
    'web' => [
        'GET' => [
            '/' => 'WelcomeController@index',
            '/register' => 'RegisterController@index',
            '/login'    => 'LoginController@index',

            '/home'     => 'UserController@index',

            '/phone' => 'PhoneController@index',
            '/phone/{^(([1-9])([0-9]*))$}' => 'PhoneController@show'
        ],
        'POST' => [
            '/register' => 'RegisterController@register',
            '/login'    => 'LoginController@login',
            '/logout'   => 'UserController@logout',
        ]
    ],

    'api' => [
        'GET' => [

        ],
        'POST' => [
            
        ]
    ]
];