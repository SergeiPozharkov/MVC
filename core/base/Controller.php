<?php


namespace core\base;


abstract class Controller
{
    public array $route = [];
    public string $view;
    public string $layout;

    public function __construct($route, $layout = '')
    {
        $this->route = $route;
        $this->view = $route['action'];
        $this->layout = $layout ?: LAYOUT;
    }


    public function getView(): void
    {
        $viewObj = new View($this->route, $this->layout, $this->view);
        $viewObj->render();
    }
}