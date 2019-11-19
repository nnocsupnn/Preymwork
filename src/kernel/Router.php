<?php

namespace App\Kernel;

use Illuminate\Http\Request;
use \Exception;
use App\Kernel\Libraries\View;

class Router {

	private $routes = [];
	private $uriLs = [];
	private $instance;
	private $path;
	private $end_points = [];

	public function get($path, $controller) {	
		$patch = '';
		$this->end_points[] = $path;
		$this->path  = @(trim($_SERVER['PATH_INFO'], '/')) ? trim($_SERVER['PATH_INFO'], '/') : null;
		$_path 		 = explode('/', $this->path);
		$_controller = explode('@', $controller)[0];
		$_endpath 	 = explode('/', $this->path);

		$patch = $_path[count($_path) - 1];
		
		$this->routes[$path] = [
			'method' 	 => 'GET',
			'controller' => $_controller,
			'attr' 	 	 => explode('@', $controller)[1],
			'patch' 	 => isset($patch) ? $patch : ''
		];
	}

	public function boot() {
	    $uri = '/' . $this->path;
		$_endpoints = $new_end = [];
		foreach ($this->routes as $key => $route) {
			$_endpoints[] = $key;
		}

        if (empty($this->uriLs[0])) {
            $this->uriLs[0] = '/';
        }

		if (!in_array($uri, $_endpoints)) {
		    $view = new View();
			$view->render('errors.404', []);
		}
		
		/**
		* Error Handling
		*/
		try {
			if (in_array($uri, $_endpoints)) {
				/**
				* instantiate controller
				*/
				$this->instance = (object) $this->routes[$uri];
				$cont 	= new $this->instance->controller;
				$func 	= $this->instance->attr;
				if (!method_exists($cont, $func)) throw new Exception("Page/URL not found.");
				$cont->$func($this->instance->patch);
			} else {
				throw new Exception("Page/URL not found.");
			}
		} catch(Exception $e) {
			print($e->getMessage());
		}
	}
}