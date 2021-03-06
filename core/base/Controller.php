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

    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }


    public function loadView(string $view, array $vars = []): void
    {
        extract($vars);
        require APP . "/views/{$this->route['controller']}/{$view}.php";

    }
}