<?php

namespace App\Kernel;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Framework\Kernel\Router;
use \Exception;
use App\Kernel\Libraries\DebugingBar;

class Database {
    public function __construct() {
        try {
            $db = new Manager;
            $db->addConnection([
                'driver'    => getenv('DB_DRIVER'),
                'host'      => getenv('DB_HOST'),
                'database'  => getenv('DB_NAME'),
                'username'  => getenv('DB_USER'),
                'password'  => getenv('DB_PASS'),
                'charset'   => getenv('DB_CHARSET'),
                'collation' => getenv('DB_COLLATION'),
                'prefix'    => getenv('DB_PREFIX')
            ], getenv('CONNECTION_NAME'));

            $db->setEventDispatcher(new Dispatcher(new Container));
            $db->setAsGlobal();
            $db->bootEloquent();
        } catch (Exception $e) {
            print($e->getMessage());
        }

        /*
         * Implement database debugging tool under debug bar
         */
        $debug = new DebugingBar();
        $debug->enableDatabase(Manager::connection(getenv('CONNECTION_NAME'))->getPdo(), getenv('CONNECTION_NAME'));
    }
}