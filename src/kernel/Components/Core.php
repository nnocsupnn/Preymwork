<?php

namespace App\Kernel\Components;

use App\Kernel\Components\Database;
use App\Kernel\Libraries\Router;
use App\Kernel\Libraries\Request;


class Core {

    public function __construct() {
        initEnvironmentConfig();
        (new Database);

        date_default_timezone_set(getenv('TIMEZONE'));
    }


    public static function run():void {
        $router = new Router(new Request());
        routes($router);
    }
}