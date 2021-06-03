<?php

namespace app\controllers;

use app\models\Main;

class MainController extends AppController
{

    public function indexAction()
    {
        $model = new Main();
        $posts = $model->findAll();
        print_r($posts);
        $this->setData(compact('posts'));
    }

}