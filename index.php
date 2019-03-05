<?php
session_start();

require('init.php');

$categoriesIcons = [
    'promo__item--boards',
    'promo__item--attachment',
    'promo__item--boots',
    'promo__item--clothing',
    'promo__item--tools',
    'promo__item--other'
];

$productsSql = '
SELECT p.id as id, p.name as title, price, img_url as url, c.name as category, DATE(date_end) as date_end,
(SELECT MAX(sum) FROM rates WHERE product_id = p.id) as last_rate,
(SELECT COUNT(*) FROM rates WHERE product_id = p.id) as rates 
FROM products p
JOIN categories c ON p.category_id = c.id
ORDER BY p.id DESC LIMIT 12';
$products = getDataAsArray($link, $productsSql);

$pageContent = includeTemplate('index.php', [
    'products' => $products,
    'categoriesTemplate' => $categoriesTemplate,
    'categoriesIcons' => $categoriesIcons,
    'categories' => $categories,
    'config' => $config
]);

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'categoriesTemplate' => $categoriesTemplate,
    'config' => $config
]);

print($layoutContent);
