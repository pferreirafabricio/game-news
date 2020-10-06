<?php

namespace Source\Core;

class Route
{
    /** @var array */
    private static $route;

    /** @var string */
    public static $needle;

    /**
     * Returns the current request URI
     *
     * @return string
     */
    private static function getCurrentUri(): string
    {
        return filter_input(INPUT_GET, "route", FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * getParams
     *
     * @return array
     */
    private static function getParams(): array
    {
        return explode(':', self::getCurrentUri());
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
        $url = self::getCurrentUri();
        //$params = self::getParams();

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
                    $newController->$method();
                }
            }
        }
    }

    private static function namespace(): string
    {
        return "Source\Controllers\\";
    }
}
