<?php

require 'rb.php';

$db = require '../config/config_db.php';
R::setup($db['dsn'], $db['user'], $db['pass']);
R::freeze(true);
R::fancyDebug(TRUE);
//Create

$cat = R::dispense('category');
$cat->title = 'Категория 1';
$id = R::store($cat);
//var_dump($id);

//Read

//$cat = R::load('category', 4);
//echo $cat['title'];

//Update

//$cat = R::load('category', 1);
//
//echo $cat->title . '<br>';
//
//$cat->title = 'Категория тест';
//R::store($cat);
//
//echo $cat->title;

//or

//$cat = R::dispense('category');
//$cat->title = 'Категория 3 ';
//$cat->id = 3;
//R::store($cat);

//Delete

//$cat = R::load('category', 6);
//R::trash($cat);
//R::wipe('category');

//$cats = R::findAll('category');
//print_r($cats);
$cats = R::findOne('category', 'id=2');
echo '<pre>';
print_r($cats);