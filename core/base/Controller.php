<?php


namespace core\base;


abstract class Controller
{
    /**
     * Текущий маршрут
     * @var array
     */
    public array $route = [];
    /**
     * Текущий вид
     * @var string|mixed
     */
    public string $view;
    /**
     * Текущий шаблон
     * @var string|mixed
     */
    public string $layout;
    /**
     * Пользовательские данные
     * @var array
     */
    public array $data = [];

    public function __construct($route, $layout = '')
    {
        $this->route = $route;
        $this->view = $route['action'];
        $this->layout = $layout ?: LAYOUT;
    }


    public function getView(): void
    {
        $viewObj = new View($this->route, $this->layout, $this->view);
        $viewObj->render($this->data);
    }

    /**
     * @param array $data
     * @return Controller
     */
    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }


}