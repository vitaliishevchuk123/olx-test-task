<?php

namespace App\Http;

use App\Http\Exceptions\RouteNotFoundException;

class Router
{
    protected $routes = []; // stores routes

    public function addRoute(string $method, string $url, \Closure $target): void
    {
        $this->routes[$method][$url] = $target;
    }

    /**
     * @throws RouteNotFoundException
     */
    public function matchRoute(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $target) {
                // Simple string comparison to see if the route URL matches the requested URL
                if ($routeUrl === $url) {
                    call_user_func($target);
                }
            }
        }

        throw new RouteNotFoundException('Route not found');
    }
}
