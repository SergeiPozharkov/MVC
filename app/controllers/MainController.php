<?php

namespace app\controllers;

class MainController extends AppController
{
//    public string $layout = 'main';

    public function indexAction()
    {
//        $this->layout = false;
//        $this->layout = 'main';
//        $this->view = 'test';
        $name = 'Sergey';
        $this->setData(['name' => $name, 'msg' => 'Hi all!']);
    }

}