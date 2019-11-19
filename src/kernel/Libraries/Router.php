<?php

namespace App\Kernel\Libraries;

use \Exception;
use App\Kernel\Libraries\View;
use App\Kernel\Libraries\Request;

class Router {

	public function boot(Request $request) {
	    global $routes;

	    if (empty($routes)) return (new View)->render('errors.404');

	    // Loop all loaded routes
	    foreach ($routes as $name => $route) {

	        list($pathMethod, $controllerMethod) = $route;

	        list($method, $path) = explode("::", $pathMethod);

            // Get the parameter declared on uri routes
	        $param = get_string_between($path, '{', '}');
	        $uri = [
	            'start' => substr($path, 0, strpos($path, '{')),
                'param' => $param,
                'end' => substr($path, strpos($path, '}') + 1, strlen($path))
            ];

	        foreach ($uri as $k => $v) $$k = $v;
	        if (strlen($request->uri) < strpos($path, "{") + 1 && isset($param)) {
                return (new View)->render('errors.404', ['error' => 'Parameter missing {' . $param . '}.']);
            }

	        // Check if request has the required length of uri requested
	        $req_uri = substr($request->uri, 0, strpos($path, "{"));


	        // Checking
            if ($request->method !== $method) return (new View)->render('errors.404', ['error' => 'method not match.']);
            if ($req_uri !== $start) return (new View)->render('errors.404', ['error' => 'path not match.']);


            // Get controller::class and method
            list($controller, $function) = explode("@", $controllerMethod);
            // Check if method exists on class requestd
            $class = "App\Controllers\\" . $controller;

            if (!class_exists($class)) return (new View)->render('errors.404', ['error' => 'class does not exists.']);

            if (method_exists($controller, $function))  return (new View)->render('errors.404', ['error' => 'Method did not match.']);


            // Finally return the class and execute the method
            return (new $class)->{$function}($param);
        }
	}
}