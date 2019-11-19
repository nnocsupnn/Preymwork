<?php
// Routes
$route->get('/', 'App\Controllers\HomeController@index');
$route->get('/user', 'App\Controllers\UserController@user');