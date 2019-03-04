<?php
session_start();

require('init.php');

$search = trim($_GET['search']) ?? '';

$products = [];
$pagesCount = 1;
$currentPage = 1;
$pages = [];

if ($search) {
    $countSql = 'SELECT COUNT(*) as count FROM products 
WHERE MATCH(name, description) AGAINST(?)';
    $productsPerPage = 9;

    $productsCount = getDataAsArray($link, $countSql, [$search])[0]['count'];

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
WHERE MATCH(p.name, description) AGAINST(?)
ORDER BY p.id DESC LIMIT ' . $productsPerPage . ' OFFSET ' . $offset;

    $products = getDataAsArray($link, $searchSql, [$search]);

}

$pageContent = includeTemplate('search.php', [
    'categories' => $categories,
    'config' => $config,
    'products' => $products,
    'pagesCount' => $pagesCount,
    'pages' => $pages,
    'currentPage' => $currentPage
]);

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'categories' => $categories,
    'config' => $config
]);

print($layoutContent);
