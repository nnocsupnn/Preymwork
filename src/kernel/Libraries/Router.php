<?php

namespace App\Kernel\Libraries;

use App\Kernel\Libraries\View;
use \Exception;
use App\Kernel\Libraries\Request;
use App\Kernel\Interfaces\IRequest;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use App\Kernel\Libraries\DebugingBar;


class Router {
	private $request;
	private $debug;
    private $supportedHttpMethods = array(
        "GET",
        "POST"
    );

    function __construct(IRequest $request)
    {
        $this->request = $request;
        $this->debug = new DebugingBar();
    }


    function __call($name, $args)
    {
        list($route, $method) = $args;

        if (is_callable($method)) {
            if(!in_array(strtoupper($name), $this->supportedHttpMethods)) {
                $this->invalidMethodHandler();
            }

            $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
        } else if (is_string($method)) {
            list($controller, $method) = explode("@", $method);
            $controller = "\\App\\Controllers\\" . $controller;

            if (method_exists($controller, $method)) {
                $this->{strtolower($name)}[$this->formatRoute($route)] = function () use ($controller, $method) { (new $controller)->{$method}($this->request); };
            } else {
                try {
                    return;
                } catch (LoaderError $e) {
                    $this->debug->console($e->getMessage(), 'error');
                } catch (RuntimeError $e) {
                    $this->debug->console($e->getMessage(), 'error');
                } catch (SyntaxError $e) {
                    $this->debug->console($e->getMessage(), 'error');
                }
            }
        } else {
            try {
                throw new Exception('Invalid callable');
            } catch (Exception $e) {
                $this->debug->console(__FILE__ . ':' . __LINE__ . ' ' . $e->getMessage(), 'error');
                exit;
            }
        }
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     * @param route (string)
     * @return string
     */
    private function formatRoute($route):string
    {
        $result = rtrim($route, '/');
        if ($result === '') return '/';
        return $result;
    }


    private function invalidMethodHandler():void
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }


    private function defaultRequestHandler():?Classname
    {
        return (new View())->render('errors.404', ['error' => 'Method not exists'])->show();
    }


    /**
     * Resolves a route
     */
    function resolve():void
    {
        $methodDictionary = @$this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->request->requestUri);
        $method = @$methodDictionary[$formatedRoute];

        if (is_null($method)) {
            $this->defaultRequestHandler();
            return;
        }

        call_user_func_array($method, array($this->request));
    }


    function __destruct()
    {
        $this->debug->console('TIMEZONE: ' . date_default_timezone_get(), 'info');
        $this->resolve();
    }
}