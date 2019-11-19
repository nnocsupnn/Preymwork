<?php


namespace App\Kernel\Libraries;


class Request
{
    public $request;
    public $uri;
    public $method;
    public $duration;
    public $host;

    public function __construct()
    {
        $this->request = (object) $_SERVER;
        $this->uri = $this->request->REQUEST_URI;
        $this->method = $this->request->REQUEST_METHOD;
        $this->duration = microtime(true) - $this->request->REQUEST_TIME_FLOAT;
        $this->host = $this->request->HTTP_HOST;

        date_default_timezone_set($this->request->TIMEZONE);
        return $this;
    }

    public function queries () {
        return $this->request->QUERY_STRING;
    }
}