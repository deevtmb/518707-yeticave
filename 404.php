<?php
date_default_timezone_set('Europe/Moscow');

require('data.php');
require('functions.php');
$config = include('config/config.php');

$isAuth = rand(0, 1);
$link = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name']);

$categoriesSql = 'SELECT name FROM categories';
$categories = getDataAsArray($link, $categoriesSql);

$pageContent = includeTemplate('404.php', [
    'categories' => $categories
]);

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'isAuth' => $isAuth,
    'userName' => $userName,
    'categories' => $categories,
    'config' => $config
]);

print($layoutContent);

