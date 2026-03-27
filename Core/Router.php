<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    public function __construct(array $routes)
    {
        $this->routes = $routes;
        
    }

    public function dispatch(Request $request): void
    {
        $path = $request->getPath();
        $method = $request->method();

        if(!isset($this->routes[$method][$path])) {
            http_response_code(404);
            echo "404- Page non trouvée";
            return;
        }

        $callback = $this->routes[$method][$path];

        if (is_array($callback)) {
            $controller =new $callback[0];
            $action = $callback [1];
            call_user_func([$controller,$action],$request);
        }

        if (is_callable($callback)) {
            echo call_user_func($callback,$request);
        }
    }
}