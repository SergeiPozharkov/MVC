<?php


namespace core;


class App
{

    public static ?Registry $app = null;

    public function __construct()
    {
        self::$app = Registry::instance();
    }

}