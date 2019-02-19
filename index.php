<?php
date_default_timezone_set('Europe/Moscow');

$isAuth = rand(0, 1);
$config = include('config/config.php');

$categoriesSql = 'SELECT name FROM categories';

$productsSql = 'SELECT p.name as title, price, img_url as url, c.name as category, p.id, DATE(date_end) as date_end
FROM products p
JOIN categories c ON p.category_id = c.id
ORDER BY p.id DESC';

require('data.php');
require('functions.php');

$categories = getData($categoriesSql);
$products = getData($productsSql);

$pageContent = includeTemplate('index.php', [
    'products' => $products,
    'categories' => $categories,
    'config' => $config
]);

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'title' => 'YetiCave - Главная страница',
    'isAuth' => $isAuth,
    'userName' => $userName,
    'categories' => $categories,
    'config' => $config
]);

print($layoutContent);
