<?php


namespace App\Kernel\Libraries;

use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\PDO\TraceablePDO;
use DebugBar\DataCollector\TimeDataCollector;
use PDO;


class DebugingBar {
    public $renderer;
    public $footer;
    public $head;
    public $debug;

    public function __construct() {
        if (!isset($GLOBALS['debugbar'])) {
            die();
        }

        $this->debug = $GLOBALS['debugbar'];
        $this->renderer = $this->debug->getJavascriptRenderer();
    }

    public function init ():object {
        return (object) [
            'head' => debugbar()['head'],
            'footer' => $this->renderer->render()
        ];
    }

    /**
     * @param string $msg
     * @param string $type | error, warning and info
     */
    public function console($msg = 'console.message', $type = 'info'):void {
        $this->debug['messages']->{$type}($msg);
    }


    /**
     * @param $closure
     * @param string $name
     * @return mixed
     */
    public function measure($callback, $name = 'operation') {
        $this->debug['time']->startMeasure($name);
        $result = $callback();
        $this->debug['time']->stopMeasure($name);

        return $result;
    }


    /**
     * @param PDO $pdo
     * @return $this
     */
    public function enableDatabase(PDO $pdos, $connection_name):self {
        if (getenv('DEBUG') !== 'true') return $this;
        (new PDOCollector())->addConnection(new TraceablePDO($pdos), $connection_name);
        $this->debug->addCollector(new PDOCollector(new TraceablePDO($pdos), new TimeDataCollector(), $connection_name));

        return $this;
    }
}