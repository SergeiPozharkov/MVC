<?php


namespace app\controllers;

class Page extends App
{

    public function viewAction()
    {
        debug($this->route);
        debug($_GET);
        echo $_GET['page'];
        echo 'Page::view';
    }

}