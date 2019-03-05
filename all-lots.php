<?php
session_start();

require('init.php');

$categoryId = $_GET['category_id'] ?? '';

$products = [];
$pagesCount = 1;

if ($categoryId) {
    $countSql = 'SELECT COUNT(*) as count FROM products 
WHERE category_id = ?';
    $productsPerPage = 9;

    $productsCount = getDataAsArray($link, $countSql, [$categoryId])[0]['count'];

    $currentPage = $_GET['page'] ?? 1;
    $pagesCount = ceil($productsCount / $productsPerPage);
    $offset = ($currentPage - 1) * $productsPerPage;
    $pages = range(1, $pagesCount);

    $searchSql = '
SELECT p.id as id, p.name as title, description, price, price_step, img_url as url, c.name as category, DATE(date_end) as date_end, 
(SELECT MAX(sum) FROM rates WHERE product_id = p.id) as last_rate,
(SELECT COUNT(*) FROM rates WHERE product_id = p.id) as rates 
FROM products p 
JOIN categories c ON p.category_id = c.id  
WHERE category_id = ?
ORDER BY p.id DESC LIMIT ' . $productsPerPage . ' OFFSET ' . $offset;

    $products = getDataAsArray($link, $searchSql, [$categoryId]);
}

$pageContent = includeTemplate('all-lots.php', [
    'categoriesTemplate' => $categoriesTemplate,
    'categories' => $categories,
    'config' => $config,
    'products' => $products,
    'pagesCount' => $pagesCount,
    'pages' => $pages,
    'currentPage' => $currentPage
]);

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'categoriesTemplate' => $categoriesTemplate,
    'config' => $config
]);

print($layoutContent);
