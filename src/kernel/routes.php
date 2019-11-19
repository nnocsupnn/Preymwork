<?php

use App\Kernel\Libraries\Router;


/**
 * Routes path
 */
$GLOBALS['routes'] = [
    'index' => [
        'GET::/',
        'HomeController@index'
    ],
    'user' => [
        'GET::/user',
        'UserController@user'
    ]
];


