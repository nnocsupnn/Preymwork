<?php

namespace App\Kernel\Components;

use App\Kernel\Libraries\DebugingBar;

class Controller {

    public $debug;
    public function __construct()
    {
        $this->debug = new DebugingBar();
    }
}