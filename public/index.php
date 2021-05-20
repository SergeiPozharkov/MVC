<?php

error_reporting(-1);

use vendor\core\Router;

$query = rtrim($_SERVER['QUERY_STRING'], '/');

const WWW = __DIR__;
define('CORE', dirname(__DIR__) . '/vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');

//require '../vendor/core/Router.php';
require '../vendor/libs/functions.php';

spl_autoload_register(function ($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
//    $file = APP . "/controllers/$class.php";
    if (file_exists($file)) {
        require_once $file;
    }
});

Router::addRoutes('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Page']);
Router::addRoutes('^page/(?P<alias>[a-z-]+)$', ['controller' => 'Page', 'action' => 'view']);

//Default routes
Router::addRoutes('^$', ['controller' => 'Main', 'action' => 'index']);
Router::addRoutes('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

debug(Router::getRoutes());

Router::dispatch($query);


