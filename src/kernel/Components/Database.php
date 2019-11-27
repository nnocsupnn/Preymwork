<?php

namespace App\Kernel\Components;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Framework\Kernel\Router;
use \Exception;
use App\Kernel\Libraries\DebugingBar;

class Database {
    public $db;
    public function __construct() {
        try {
            $this->db = new Manager;
            $this->db->addConnection([
                'driver'    => getenv('DB_DRIVER'),
                'host'      => getenv('DB_HOST'),
                'database'  => getenv('DB_NAME'),
                'username'  => getenv('DB_USER'),
                'password'  => getenv('DB_PASS'),
                'charset'   => getenv('DB_CHARSET'),
                'collation' => getenv('DB_COLLATION'),
                'prefix'    => getenv('DB_PREFIX')
            ], getenv('CONNECTION_NAME'));

            $this->db->setEventDispatcher(new Dispatcher(new Container));
            $this->db->setAsGlobal();
            $this->db->bootEloquent();
        } catch (Exception $e) {
            print($e->getMessage());
            exit;
        }

        /*
         * Implement database debugging tool under debug bar
         */
        $debug = new DebugingBar();
        $debug->enableDatabase(
            Manager::connection(getenv('CONNECTION_NAME'))->getPdo(),
            getenv('CONNECTION_NAME')
        );
    }
}