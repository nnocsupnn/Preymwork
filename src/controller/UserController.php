<?php


namespace App\Controllers;

use App\Kernel\Libraries\View;
use Illuminate\Database\Capsule\Manager as DB;

class UserController
{
    public function user($arguments) {
        foreach ($arguments as $var => $val) $$var = $val;
        
        $parameter_data = [
            'message' => 'Preymworks',
            'title' => 'Preymwork',
            'body' => 'USERS PAGE',
            // You can set your custom js for every method/controller
            'css' => staticFiles([
                'style.css',
                ['src' => 'https://fonts.googleapis.com/css?family=VT323&display=swap']
            ], 'css'),
            'js' => staticFiles([
                'user.js'
            ])
        ];

        $view = new View();
        $view->render('index', $parameter_data)->show();
    }
}