<?php


namespace App\Kernel\Libraries;


class Request
{
    public $request;
    public $uri;
    public $method;
    public function __construct()
    {
        $this->request = (object) $_SERVER;
        $this->uri = $this->request->REQUEST_URI;
        $this->method = $this->request->REQUEST_METHOD;
        return $this;
    }
}