<?php

namespace App\Controllers;

use App\Kernel\Components\Controller;
use App\Kernel\Libraries\DebugingBar;
use App\Kernel\Libraries\View;
use Illuminate\Database\Capsule\Manager as DB;

/**
 * @return view
 */
class HomeController extends Controller {
    public function index() {
        $result = null;
        $result = $this->debug->measure(function () {
            return DB::connection(getenv('CONNECTION_NAME'))->table('info_user')->limit(1)->get();
        }, 'query1');
        $this->debug->console($result, 'error');

        $parameter_data = [
            'message' => 'Preymwork',
            'title' => 'Preymwork',
            'body' => 'Preymwork',
            // You can set your custom js for every method/controller
            'css' => staticFiles([
                'style.css',
                ['src' => 'https://fonts.googleapis.com/css?family=VT323&display=swap']
            ], 'css'),

            'js' => staticFiles([
                'index.js',
                'about.js',
            ], 'js')
        ];

        $view = new View();
        $view->render('index', $parameter_data)->show();
    }
}