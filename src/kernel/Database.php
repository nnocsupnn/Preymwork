<?php

namespace App\Kernel;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Framework\Kernel\Router;
use \Exception;

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
            ]);

            $db->setEventDispatcher(new Dispatcher(new Container));
            $db->setAsGlobal();
            $db->bootEloquent();
        } catch (Exception $e) {
            print($e->getMessage());
        }
    }
}