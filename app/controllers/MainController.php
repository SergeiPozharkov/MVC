<?php

namespace app\controllers;

use app\models\Main;

class MainController extends AppController
{

    public function indexAction()
    {
        $model = new Main();
        $posts = $model->findAll();
//        $post = $model->findOne('Тестовый пост', 'title');
//        $data = $model->findBySql("SELECT * FROM {$model->tableName} WHERE title LIKE ?", ['%то%']);
//        debug($data);
//        print_r($post);
        $data = $model->findLike('Тест', 'title');
        debug($data);
        $this->setData(compact('posts'));
    }

}