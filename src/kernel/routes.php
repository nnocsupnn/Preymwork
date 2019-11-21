<?php

/**
 * Routes path
 */
use App\Controllers\HomeController;

function routes($router) {
    /**
     * Routes declare here.
     */
    $router->get('/', function($request) {
        (new HomeController)->index($request);
    });
}


