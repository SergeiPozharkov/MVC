<?php


class Router
{
    protected static array $routes = [];
    protected static array $route = [];

    /**
     * @param $regexp
     * @param array $route
     */
    public static function addRoutes($regexp, array $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * @return array
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }

    /**
     * @return array
     */
    public static function getRoute(): array
    {
        return self::$route;
    }

    public static function matchRoute($url): bool
    {
        foreach (self::$routes as $pattern => $route) {
            if ($url == $pattern) {
                self::$route = $route;
                return true;
            }
        }
        return false;
    }
}