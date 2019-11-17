<?php

/**
 * @return App
 */

define('PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views');

require_once "../vendor/autoload.php";
$app = new \App\Kernel\Core();
$app::run();