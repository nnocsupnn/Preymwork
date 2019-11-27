<?php

/**
 * Routes define here
 */
use App\Controllers\HomeController;

function routes($router) {
    /**
     * Routes declare here.
     * You can set-up a route same as laravel does.
     * eg: ControllerName@methodName
     * eg: Closure function
     */

    $router->get('/user', 'HomeController@index');

    $router->get('/', function($request) {
        (new HomeController)->index($request);
    });

    /**
     * Routes end here.
     */
}


