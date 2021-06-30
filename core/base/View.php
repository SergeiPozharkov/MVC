<?php


namespace core\base;


class View
{
    /**
     * Текущий маршрут
     * @var array
     */
    public array $route = [];

    /**
     * Текущий вид
     * @var string
     */
    public string $view;

    /**
     * Текущий шаблон
     * @var string
     */
    public string $layout;

    /**
     * Массив в котором содержатся вырезанные js скрипты
     * @var array
     */
    public array $scripts = [];

    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;
        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
        $this->view = $view;
    }

    public function render($data)
    {
        if (is_array($data)) {
            extract($data);
        }
        $fileView = APP . "/views/{$this->route['controller']}/{$this->view}.php";
        ob_start();
        if (file_exists($fileView)) {
            require $fileView;
        } else {
            echo "Не найден вид <b>$fileView</b>";
        }
        $content = ob_get_clean();

        if (false !== $this->layout) {
            $fileLayout = APP . "/views/layouts/{$this->layout}.php";
            if (file_exists($fileLayout)) {
                $content = $this->getScript($content);
                $scripts = [];
                if (!empty($this->scripts[0])) {
                    $scripts = $this->scripts[0];
                }
                require $fileLayout;
            } else {
                echo "Не найден шаблон <b>$fileLayout</b>";
            }
        }

    }

    /**
     * Ищет js скрипты, вырезает их и возвращает html код без них
     * @param  $content
     * @return mixed
     */
    protected function getScript($content): mixed
    {
        $pattern = "#<script.*?>.*?</script>#si";
        preg_match_all($pattern, $content, $this->scripts);
        if (!empty($this->scripts)) {
            $content = preg_replace($pattern, "", $content);
        }

        return $content;
    }

}