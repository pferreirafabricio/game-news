<?php

namespace Source\Core;

class Route
{
    /** @var array */
    private static $route;

    /** @var string */
    public static $needle = ':';

    /** @var string */
    private static $requestHttpMethod;

    /** @var string */
    private static $currentHttpMethod;

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
     * @return array
     */
    private static function getParams(string $routeName): array
    {
        $routeParams = array_filter(explode('/', $routeName));
        $urlParams = array_filter(explode('/', self::getCurrentUri()));
        ksort($routeParams);
        ksort($urlParams);

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
        
        $url = self::getCurrentUri();
        $params = self::getParams($routeName);

        var_dump($params);

        self::$route = [
            $routeName => [
                "routeName" => $routeName,
                "controller" => (!is_string($handler) ? $handler : strstr($handler, static::$needle, true)),
                "method" => (!is_string($handler) ? null : str_replace(static::$needle, '', strstr($handler, static::$needle, false))),
                "params" => (!empty($params) ? $params : null)
            ]
        ];

        self::dispatch($url);
    }

    public static function post(string $routeName, $handler)
    {
        self::$currentHttpMethod = 'POST';
        self::validateHttpMethod();

        $url = self::getCurrentUri();
        $params = self::getParams($routeName);

        self::$route = [
            $routeName => [
                "routeName" => $routeName,
                "controller" => (!is_string($handler) ? $handler : strstr($handler, static::$needle, true)),
                "method" => (!is_string($handler) ? null : str_replace(static::$needle, '', strstr($handler, static::$needle, false))),
                "params" => (!empty($params) ? $params : null)
            ]
        ];

        self::dispatch($url);
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
                call_user_func($route["controller"]);
                return;
            }

            $controller = self::namespace() . $route["controller"];
            $method = $route["method"];

            if (class_exists($controller)) {
                if (method_exists($controller, $method)) {
                    $newController = new $controller;
                    echo $newController->$method();
                }
            }
        }
    }

    private static function namespace(): string
    {
        return "Source\Controllers\\";
    }
    
    /**
     * validateHttpMethod
     *
     * @return bool
     */
    private static function validateHttpMethod(): bool
    {
        if (self::$currentHttpMethod !== self::$requestHttpMethod) {
            return false;
        }
    } 
}
