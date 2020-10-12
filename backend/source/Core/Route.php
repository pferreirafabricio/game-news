<?php

namespace Source\Core;

class Route
{
    /** @var array */
    private $route;

    /** @var string */
    private $needle;

    /** @var string */
    private $currentHttpMethod;

    /** @const int Bad Request */
    private const BAD_REQUEST = 400;

    /** @const int Method not allowed */
    private const METHOD_NOT_ALLOWED = 405;

    /**
     * __construct
     *
     * @param  string $needle
     * @return void
     */
    public function __construct(?string $needle = "@")
    {
        $this->needle = $needle;
    }
    
    /**
     * __debug
     *
     * @return array
     */
    public function __debug(): ?array
    {
        return $this->route;
    }

    /**
     * Returns the current request URI
     *
     * @return string
     */
    private function getCurrentUri(): string
    {
        return filter_input(INPUT_GET, "route", FILTER_SANITIZE_SPECIAL_CHARS) ?? "/";
    }

    /**
     * Get the params of the url
     *
     * @return array|null
     */
    private function getParams(string $routeName): ?array
    {
        $routeParams = array_filter(explode('/', $routeName));
        $urlParams = array_filter(explode('/', $this->getCurrentUri()));
        ksort($routeParams);
        ksort($urlParams);

        if (sizeof($routeParams) !== sizeof($urlParams)) {
            echo response([
                'message' => 'The number of arguments is invalid',
                'code' => self::BAD_REQUEST,
            ])->json();
            exit;
        }

        $data = [];
        foreach ($routeParams as $param) {
            if (strpos($param, ':') !== false) {
                $arrayKey = array_search($param, $routeParams);
                $variableName = str_replace(':', '', strstr($param, ':', false));
                $data[$variableName] = $urlParams[$arrayKey];
            }
        }

        return $data;
    }

    /**
     * Get HTTP Method
     *
     * @param  string $routeName
     * @param  string|\Closure $handler
     * @return void
     */
    public function get(string $routeName, $handler)
    {
        $this->currentHttpMethod = 'GET';
        $this->validateHttpMethod();

        $this->addRoute($routeName, $handler);
    }

    /**
     * Post HTTP Method
     *
     * @param  string $routeName
     * @param  string|\Closure $handler
     * @return void
     */
    public function post(string $routeName, $handler)
    {
        $this->currentHttpMethod = 'POST';
        $this->validateHttpMethod();

        $this->addRoute($routeName, $handler);
    }

    /**
     * Put HTTP Method
     *
     * @param  string $routeName
     * @param  string|\Closure $handler
     * @return void
     */
    public function put(string $routeName, $handler)
    {
        $this->currentHttpMethod = 'PUT';
        $this->validateHttpMethod();

        $this->addRoute($routeName, $handler);
    }

    /**
     * Delete HTTP Method
     *
     * @param  string $routeName
     * @param  string|\Closure $handler
     * @return void
     */
    public function delete(string $routeName, $handler)
    {
        $this->currentHttpMethod = 'DELETE';
        $this->validateHttpMethod();

        $this->addRoute($routeName, $handler);
    }

    /**
     * Add a route to the array
     *
     * @param  string $routeName
     * @param  string|\Closure $handler
     * @param  mixed $params
     * @return void
     */
    private function addRoute(string $routeName, $handler): void
    {
        $url = $this->getCurrentUri();
        $params = $this->getParams($routeName);
        
        $this->route = [
            $this->currentHttpMethod . $url => [
                "routeName" => $routeName,
                "controller" => (!is_string($handler) ? $handler : strstr($handler, $this->needle, true)),
                "method" => (!is_string($handler) ? null : str_replace($this->needle, '', strstr($handler, $this->needle, false))),
                "params" => (!empty($params) ? $params : [])
            ]
        ];

        $this->dispatch($this->currentHttpMethod . $url);
    }

    /**
     * Execute the given route
     *
     * @param  string $route
     * @return void
     */
    private function dispatch(string $route): void
    {
        $route = ($this->route[$route] ?? []);
        
        if (!empty($route)) {
            if ($route["controller"] instanceof \Closure) {
                call_user_func($route["controller"], $route["params"]);
                return;
            }

            $controller = self::namespace() . $route["controller"];
            $method = $route["method"];

            if (class_exists($controller)) {
                if (method_exists($controller, $method)) {
                    $newController = new $controller;
                    echo $newController->$method($route["params"]);
                    exit;
                }
            }
        }
    }

    /**
     * Gets the controllers's namespace
     *
     * @return string
     */
    private static function namespace(): string
    {
        return "Source\Controllers\\";
    }

    /**
     * Validate if the current http method is the same of the request
     *
     * @return void
     */
    private function validateHttpMethod(): void
    {
        if ($this->currentHttpMethod !== $_SERVER['REQUEST_METHOD']) {
            echo response([
                'message' => 'This method is not supported by this route',
                'code' => self::METHOD_NOT_ALLOWED,
            ], 405)->json();
            exit;
        }
    }
}
