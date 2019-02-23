<?php
date_default_timezone_set('Europe/Moscow');

require('data.php');
require('functions.php');
$config = include('config/config.php');

$isAuth = rand(0, 1);
$link = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name']);

$categoriesSql = 'SELECT name FROM categories';
$categories = getDataAsArray($link, $categoriesSql);

$productSql = 'SELECT p.id as id, p.name as title, description, price, price_step, img_url as url, c.name as category, DATE(date_end) as date_end
FROM products p 
JOIN categories c ON p.category_id = c.id
WHERE p.id = ?';

$productId = $_GET['id'] ?? '';

$product = getDataAsArray($link, $productSql, [$productId]);

if (!$product || !$productId) {
    $pageContent = includeTemplate('404.php', [
        'categories' => $categories
    ]);
} else {
    $pageContent = includeTemplate('lot.php', [
        'categories' => $categories,
        'product' => $product,
        'config' => $config
    ]);
}

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'isAuth' => $isAuth,
    'userName' => $userName,
    'categories' => $categories,
    'config' => $config
]);

print($layoutContent);
