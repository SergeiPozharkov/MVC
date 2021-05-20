<?php


namespace vendor\core\base;


abstract class Controller
{
    public array $route = [];
    public string $view;

    public function __construct($route)
    {
        $this->route = $route;
//        $this->view = $route['action'];
//        include_once APP . "/views/{$route['controller']}/{$this->view}.php";
    }
}