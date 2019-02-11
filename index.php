<?php
date_default_timezone_set('Europe/Moscow');

$isAuth = rand(0, 1);
$config = include('config/config.php');

require('data.php');
require('functions.php');

$pageContent = includeTemplate('index.php', [
    'products' => $products,
    'categories' => $categories,
    'config'=>$config
]);

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'title' => 'YetiCave - Главная страница',
    'isAuth' => $isAuth,
    'userName' => $userName,
    'categories' => $categories,
    'config'=>$config
]);

print($layoutContent);
