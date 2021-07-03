<?php


namespace core;

use core\Registry;
use core\ErrorHandler;

class App
{

    public static ?Registry $app = null;

    public function __construct()
    {
        self::$app = Registry::instance();
        new ErrorHandler();
    }

}