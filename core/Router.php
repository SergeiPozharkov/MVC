<?php

namespace core;

class Router
{
    /**
     * Массив содержащий все маршруты
     * @var array
     */
    protected static array $routes = [];

    /**
     * Массив содержащий маршрут
     * @var array
     */
    protected static array $route = [];

    /**
     * Создает маршрут
     * @param string $regexp регулярное выражение
     * @param array $route текущий маршрут
     */
    public static function addRoutes(string $regexp, array $route = []): void
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

    /**
     * Ищет URL в массиве с маршрутами
     * @param mixed $url входной URL
     * @return bool
     */
    public static function matchRoute(mixed $url): bool
    {
        foreach (self::$routes as $pattern => $route) {

            if (preg_match("#$pattern#", $url, $matches)) {

                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }

                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * Перенаправляет URL по корректному маршруту
     * @param string $url входной URL
     */
    public static function dispatch(string $url): void
    {

        $url = self::removeQueryString($url);
        if (self::matchRoute($url)) {

            $controller = 'app\controllers\\' . self::$route['controller'] . 'Controller';
            if (class_exists($controller)) {

                $controllerObj = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';

                if (method_exists($controllerObj, $action)) {
                    $controllerObj->$action();
                    $controllerObj->getView();
                } else {
//                    echo "Action (method) <b>$controller::$action</b> not found";
                    throw new \Exception("Action (method) <b>$controller::$action</b> not found", 404);
                }

            } else {
                throw new \Exception("Controller (class) <b>$controller</b> not found", 404);

//                echo "Controller (class) <b>$controller</b> not found";
            }

        } else {

//            http_response_code(404);
//            include '404.html';
            throw new \Exception("Page not found", 404);
        }
    }

    /**
     * Возвращает отформатированное имя контроллера (класса) по стандарту PSR
     * @param string $string
     * @return array|string
     */
    protected static function upperCamelCase(string $string): array|string
    {
        return $string = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Возвращает отформатированное имя экшона (метода) по стандарту PSR
     * @param string $string
     * @return array|string
     */
    protected static function lowerCamelCase(string $string): array|string
    {
        return $string = lcfirst(self::upperCamelCase($string));
    }

    /**
     * Возвращает не явную часть URL адреса
     * @param mixed $url
     * @return string
     */
    protected static function removeQueryString(mixed $url)
    {
        if ($url) {
            $params = explode('&', $url);
            if (strpos($params[0], '=') === false) {
                return rtrim($params[0], '/');
            } else {
                return '';
            }
        }
    }
}