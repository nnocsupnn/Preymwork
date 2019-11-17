<?php


namespace App\Kernel;

use DebugBar\StandardDebugBar;

class DebuggingBar {
    public $renderer;
    /**
     * @var string
     */
    private $footer;
    /**
     * @var string
     */
    private $head;
    /**
     * @var StandardDebugBar
     */
    private $debug;

    public function __construct() {
        if (!$GLOBALS['debugbar']) {
            die();
        }
    }

    public function init () {
        return (object) [
            'head' => $this->head,
            'footer' => $this->footer
        ];
    }

    /**
     * @param string $msg
     * @param string $type | error, warning and info
     */
    public function console($msg = 'console.message', $type = 'info') {
        $GLOBALS['debugbar']['messages']->{$type}($msg);
    }

    public function measure ($closure, $name = 'operation') {
        $GLOBALS['debugbar']['time']->startMeasure($name);
        $result = $closure();
        $GLOBALS['debugbar']['time']->stopMeasure($name);
        return $result;
    }
}