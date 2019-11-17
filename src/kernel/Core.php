<?php

namespace App\Kernel;

use App\Kernel\Database;

class Core {

    public function __construct() {
        initEnvironmentConfig();
        (new Database);

    }

    public static function run() {
        $route = new Router;
        require_once 'routes.php';
        $route->boot();
    }
}