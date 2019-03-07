<?php
session_start();

// Проверка авторизации
auth();

require('init.php');

$ratesSql = '
SELECT p.id as id, img_url as url, winner_id, p.name as title, category_id, date_end, sum as rate, date as rate_date, u.contacts as contacts 
FROM products p 
JOIN rates r ON p.id = r.product_id 
RIGHT JOIN users u ON u.id = p.user_id 
WHERE r.user_id = ?
ORDER BY r.id DESC';

$rates = getDataAsArray($link, $ratesSql, [$_SESSION['user']['id']]);

$pageContent = includeTemplate('my-lots.php', [
    'categoriesTemplate' => $categoriesTemplate,
    'categories' => $categories,
    'config' => $config,
    'rates' => $rates
]);

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'categoriesTemplate' => $categoriesTemplate,
    'title' => 'YetiCave - Мои ставки'
]);

print($layoutContent);
