<?php

namespace App\Kernel\Components;

use App\Kernel\Components\Database;
use App\Kernel\Libraries\Router;
use App\Kernel\Libraries\Request;


class Core {

    public function __construct() {
        initEnvironmentConfig();
        (new Database);
    }

    public static function run() {
        (new Router)->boot(new Request());
    }
}