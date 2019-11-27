<?php

/**
 * @return App
 */


/**
 * Set constant paths
 * @root
 * @dir
 */
define('PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views');
define('ROOT_PATH', dirname(__DIR__));


/**
 * Start autoloading classes and vendors
 * @start App
 */
require_once "../vendor/autoload.php";

$app = new \App\Kernel\Components\Core();
$app::run();