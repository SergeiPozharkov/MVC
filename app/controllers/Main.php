<?php

namespace app\controllers;

class Main extends App
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