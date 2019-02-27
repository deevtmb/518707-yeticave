<?php
date_default_timezone_set('Europe/Moscow');

require('data.php');
require('functions.php');
$config = include('config/config.php');

$isAuth = rand(0, 1);
$link = mysqli_connect(
    $config['db']['host'],
    $config['db']['user'],
    $config['db']['pass'],
    $config['db']['name']
);

$categoriesSql = 'SELECT id, name FROM categories';
$categories = getDataAsArray($link, $categoriesSql);
