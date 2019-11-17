<?php

namespace App\Controllers;

use App\Kernel\Controller;
/**
 * @return view
 */
class HomeController extends Controller {
    // Import helper functions
    use \App\Helpers\HomeHelper;

    public function index () {
        render('index', [
            'data' => 'testessss',
            'body' => 'TwigCustomssss',
            'array' => [],
            'css' => staticFiles([['src' => 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'], 'style.css'], 'css'),
            'js' => staticFiles([
                'index.js',
                'about.js',
                ['src' => 'https://code.jquery.com/jquery-3.4.1.min.js'],
                ['src' => 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js']
            ], 'js')
        ]);
    }

}