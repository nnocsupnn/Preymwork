<?php

namespace App\Controllers;

use App\Kernel\Controller;

use Illuminate\Database\Capsule\Manager as DB;
use App\Kernel\DebuggingBar;

/**
 * @return view
 */
class HomeController extends Controller {
    // Import helper functions
    use \App\Helpers\HomeHelper;

    private $assets;
    private $debug;

    public function __construct() {
        $this->debug = new DebuggingBar();
    }

    public function index () {
        $result = null;
        $result = $this->debug->measure(function () {
            return DB::table('info_user')->where('IU_ID', 'ruby2')->first();
        }, 'operations');

        $this->debug->console($result, 'info');

        $parameter_data = [
            'debugbar' => debugbar(),
            'message' => 'Preymwork 1.0',
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

        render('index', $parameter_data);
    }
}