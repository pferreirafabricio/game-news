<?php

namespace Source\Core;

class Route
{
    /** @var array */
    private static $route;

    /** @var string */
    public static $needle = ':';

    /** @var string */
    private static $currentHttpMethod;

    /** @const int Bad Request */
    private const BAD_REQUEST = 400;

    /** @const int Method not allowed */
    private const METHOD_NOT_ALLOWED = 405;

    /**
     * Returns the current request URI
     *
     * @return string
     */
    private static function getCurrentUri(): string
    {
        return filter_input(INPUT_GET, "route", FILTER_SANITIZE_SPECIAL_CHARS) ?? "/";
    }

    /**
     * getParams
     *
     * @return array|null
     */
    private static function getParams(string $routeName): ?array
    {
        $routeParams = array_filter(explode('/', $routeName));
        $urlParams = array_filter(explode('/', self::getCurrentUri()));
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
        foreach($routeParams as $param) {
            if (strpos($param, ':') !== false) {
                $arrayKey = array_search($param, $routeParams);
                $variableName = str_replace(':', '', strstr($param, ':', false));
                $data[$variableName] = $urlParams[$arrayKey];
            }
        }

        return $data;
    }

    /**
     * get
     *
     * @param  string $routeName
     * @param  string|\Closure $handler
     * @return void
     */
    public static function get(string $routeName, $handler)
    {
        self::$currentHttpMethod = 'GET';
        self::validateHttpMethod();
        
        $params = self::getParams($routeName);

        self::mountRoute($routeName, $handler, $params);
    }
    
    /**
     * post
     *
     * @param  string $routeName
     * @param  string|\Closure $handler
     * @return void
     */
    public static function post(string $routeName, $handler)
    {
        self::$currentHttpMethod = 'POST';
        self::validateHttpMethod();

        $params = self::getParams($routeName);

        self::mountRoute($routeName, $handler, $params);
    }
    
    /**
     * put
     *
     * @param  string $routeName
     * @param  string|\Closure $handler
     * @return void
     */
    public static function put(string $routeName, $handler)
    {
        self::$currentHttpMethod = 'PUT';
        self::validateHttpMethod();

        $params = self::getParams($routeName);

        self::mountRoute($routeName, $handler, $params);
    }
    
    /**
     * delete
     *
     * @param  string $routeName
     * @param  string|\Closure $handler
     * @return void
     */
    public static function delete(string $routeName, $handler)
    {
        self::$currentHttpMethod = 'DELETE';
        self::validateHttpMethod();

        $params = self::getParams($routeName);

        self::mountRoute($routeName, $handler, $params);
    }
    
    /**
     * mountRoute
     *
     * @param  string $routeName
     * @param  string|\Closure $handler
     * @param  mixed $params
     * @return void
     */
    private static function mountRoute(string $routeName, $handler, array $params): void
    {
        self::$route = [
            $routeName => [
                "routeName" => $routeName,
                "controller" => (!is_string($handler) ? $handler : strstr($handler, static::$needle, true)),
                "method" => (!is_string($handler) ? null : str_replace(static::$needle, '', strstr($handler, static::$needle, false))),
                "params" => (!empty($params) ? $params : null)
            ]
        ];
        
        self::dispatch($routeName);
    }

    /**
     * Execute the given route
     *
     * @param  string $route
     * @return void
     */
    private static function dispatch(string $route): void
    {
        $route = (self::$route[$route] ?? []);
        
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
     * namespace
     *
     * @return string
     */
    private static function namespace(): string
    {
        return "Source\Controllers\\";
    }
    
    /**
     * validateHttpMethod
     *
     * @return void
     */
    private static function validateHttpMethod(): void
    {
        if (self::$currentHttpMethod !== $_SERVER['REQUEST_METHOD']) {
            echo response([
                'message' => 'This method is not supported by this route',
                'code' => self::METHOD_NOT_ALLOWED,
            ])->json();
            exit;
        }
    } 
}
