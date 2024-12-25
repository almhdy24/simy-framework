<?php

namespace Almhdy\Simy\Core;

class Router
{
    private array $routes = [
        "GET" => [],
        "POST" => [],
        "PUT" => [],
        "DELETE" => [],
    ];
    public array $params = [];
    private array $middleware = [];

    public function get($uri, $handler)
    {
        $this->addRoute("GET", $uri, $handler);
    }

    public function post($uri, $handler)
    {
        $this->addRoute("POST", $uri, $handler);
    }

    public function put($uri, $handler)
    {
        $this->addRoute("PUT", $uri, $handler);
    }

    public function delete($uri, $handler)
    {
        $this->addRoute("DELETE", $uri, $handler);
    }

    public function map($uri, $handler, $methods = ["GET"])
    {
        foreach ($methods as $method) {
            $this->addRoute($method, $uri, $handler);
        }
    }

    private function addRoute($httpMethod, $uri, $handler)
    {
        $this->routes[$httpMethod][$uri] = $handler;
    }

    public function routeRequest($uri, $httpMethod)
    {
        $handler = $this->findMatchingRoute($uri, $httpMethod);

        if ($handler) {
            $this->handleMiddleware($uri, $httpMethod, function() use ($handler) {
                $this->callHandler($handler);
            });
        } else {
            $this->handleNotFound();
        }
    }

    private function findMatchingRoute($uri, $httpMethod)
    {
        foreach ($this->routes[$httpMethod] as $route => $handler) {
            if ($this->isMatchingRoute($route, $uri)) {
                return $handler;
            }
        }
        return null;
    }

    private function isMatchingRoute($route, $uri)
    {
        if ($route === "/") {
            return $uri === "/";
        }

        $route = str_replace("/", "\/", $route);

        $route = preg_replace_callback(
            "/\{(\w+)\}/",
            function ($matches) {
                return "(?P<" . $matches[1] . ">[^\/]+)";
            },
            $route
        );

        $pattern = "/^" . $route . '$/i';

        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches);

            $this->params = array_intersect_key(
                $matches,
                array_flip(array_filter(array_keys($matches), "is_string"))
            );

            return true;
        }

        return false;
    }

    private function callHandler($handler)
    {
        if (is_callable($handler)) {
            $handler();
        } elseif (
            is_array($handler) &&
            count($handler) == 2 &&
            class_exists($handler[0]) &&
            method_exists($handler[0], $handler[1])
        ) {
            $controller = new ($handler[0])();
            $method = $handler[1];
            call_user_func_array([$controller, $method], $this->params);
        } else {
            $this->handleNotFound();
        }
    }

    private function handleNotFound()
    {
        http_response_code(404);
        require "../app/Views/errors/404.php";
    }

    public function addMiddleware($uri, $httpMethod, $middleware)
    {
        $this->middleware[$httpMethod][$uri][] = $middleware;
    }

    private function handleMiddleware($uri, $httpMethod, $next)
    {
        if (isset($this->middleware[$httpMethod][$uri])) {
            foreach ($this->middleware[$httpMethod][$uri] as $middleware) {
                if (is_callable($middleware)) {
                    $middleware();
                } elseif (
                    is_array($middleware) &&
                    count($middleware) == 2 &&
                    class_exists($middleware[0]) &&
                    method_exists($middleware[0], $middleware[1])
                ) {
                    $controller = new ($middleware[0])();
                    $method = $middleware[1];
                    call_user_func_array([$controller, $method], $this->params);
                }
            }
        }
        $next();
    }
}