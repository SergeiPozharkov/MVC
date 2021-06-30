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
        \R::fancyDebug(true);
        $posts = App::$app->cache->get('posts');
        if (!$posts) {
            $posts = \R::findAll('posts');
            App::$app->cache->set('posts', $posts, 3600 * 24);
        }
//        echo date('Y-m-d H:i', time());
//        echo '<br>';
//        echo date('Y-m-d H:i', 1624628124);

        $menu = $this->menu;
        $this->setMeta('Main page', 'Page description', 'Key words');
        $meta = $this->meta;
        $this->setData(compact('posts', 'menu', 'meta'));
    }

    public function testAction()
    {
        if ($this->isAjax()) {
            echo "test 1";
            die();
        }
        echo 'test 2';
//        $this->layout = 'test';
    }

}