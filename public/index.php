<?php

$query = rtrim($_SERVER['QUERY_STRING'], '/');

require '../vendor/core/Router.php';
require '../vendor/libs/functions.php';

Router::addRoutes('posts/add', ['controller' => 'Posts', 'action' => 'add']);
Router::addRoutes('posts', ['controller' => 'Posts', 'action' => 'index']);
Router::addRoutes('', ['controller' => 'Main', 'action' => 'index']);

debug(Router::getRoutes());

if (Router::matchRoute($query)) {
    debug(Router::getRoute());
} else {
    echo '404';
}