<?php


namespace app\controllers;


use app\models\Main;
use core\base\Controller;

class AppController extends Controller
{
    public array $menu;
    public array $meta = [];

    public function __construct($route, $layout = '')
    {
        parent::__construct($route, $layout);
        new Main();
        $this->menu = \R::findAll('category');
    }

    /**
     * @param string $title
     * @param string $desc
     * @param string $keyWords
     */
    protected function setMeta(string $title = '', string $desc = '', string $keyWords = '')
    {
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keyWords;
    }


}