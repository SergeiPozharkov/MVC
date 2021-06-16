<?php


namespace app\controllers;

class PageController extends AppController
{

    public function viewAction()
    {
//        debug($this->route);
        $menu = $this->menu;
        $this->setData(compact('menu'));
    }

}