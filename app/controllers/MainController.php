<?php

namespace app\controllers;

use app\models\Main;
use core\App;

class MainController extends AppController
{

    public function indexAction()
    {
//        App::$app->getList();
        $model = new Main();
        $posts = \R::findAll('posts');
        App::$app->cache->set('posts', $posts);
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