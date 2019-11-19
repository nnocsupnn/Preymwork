<?php

/**
 * @return App
 */



ini_set('display_errors', '1');
define('PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views');

require_once "../vendor/autoload.php";

$app = new \App\Kernel\Core();
$app::run();