<?php

require('data.php');
require('functions.php');

$pageContent = includeTemplate('index.php', [
    'products' => $products,
    'categories' => $categories
]);

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'title' => 'YetiCave - Главная страница',
    'isAuth' => $isAuth,
    'userName' => $userName,
    'categories' => $categories
]);

print($layoutContent);
