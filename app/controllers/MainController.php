<?php

namespace app\controllers;

use app\models\Main;

class MainController extends AppController
{

    public function indexAction()
    {
        $model = new Main();
        $posts = \R::findAll('posts');
        $menu = $this->menu;
        $this->setMeta('Main page', 'Page description', 'Key words');
        $meta = $this->meta;
        $this->setData(compact('posts', 'menu', 'meta'));
    }

    public function testAction()
    {
        $this->layout = 'test';
    }

}