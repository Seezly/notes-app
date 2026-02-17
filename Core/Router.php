<?php

namespace Core;

class Router
{
    protected $routes = [];

    private function add($uri, $controller, $method, $middlewares = [])
    {
        $this->routes[] = compact('uri', 'controller', 'method', 'middlewares');
        return $this;
    }

    public function get($uri, $controller)
    {
        return $this->add($uri, $controller, 'GET');
    }

    public function post($uri, $controller)
    {
        return $this->add($uri, $controller, 'POST');
    }

    public function put($uri, $controller)
    {
        return $this->add($uri, $controller, 'PUT');
    }

    public function delete($uri, $controller)
    {
        return $this->add($uri, $controller, 'DELETE');
    }

    public function patch($uri, $controller)
    {
        return $this->add($uri, $controller, 'PATCH');
    }

    public function any($uri, $controller)
    {
        return $this->add($uri, $controller, 'ANY');
    }

    public function middleware($middleware)
    {
        $this->routes[count($this->routes) - 1]['middlewares'][] = $middleware;
        return $this;
    }

    public static function previousUrl()
    {
        return $_SERVER['HTTP_REFERER'] ?? '/';
    }

    public function route($uri, $method, $connection)
    {
        foreach ($this->routes as $route) {
            if (($route['uri'] === $uri && $route['method'] === strtoupper($method)) || $route['uri'] === $uri && $route['method'] === 'ANY') {
                if ($middlewares = $route['middlewares'] ?? false) {
                    foreach ($middlewares as $middleware) {
                        Middleware::resolve($middleware);
                    }
                }
                return require asset('Http/controllers/' . $route['controller']);
            }
        }
        abort();
    }
}
