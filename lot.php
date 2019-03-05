<?php
session_start();

require('init.php');
$errors = [];
$product = [];
$rates = [];
$userRate = [];

$productId = $_GET['id'] ?? '';

$productSql = 'SELECT p.id as id, p.name as title, description, price, price_step, img_url as url, c.name as category, DATE(date_end) as date_end
FROM products p 
JOIN categories c ON p.category_id = c.id
WHERE p.id = ?';
$products = getDataAsArray($link, $productSql, [$productId]);
$product = $products['0'];

$ratesSql = 'SELECT r.id as id, u.name as user, r.sum as price, r.date as date, u.id as user_id
FROM rates r 
JOIN users u ON r.user_id = u.id
WHERE r.product_id = ? ORDER BY r.id DESC LIMIT 10';
$rates = getDataAsArray($link, $ratesSql, [$productId]);

$price = count($rates) ? $rates[0]['price'] : $product['price'];

if (isset($_SESSION['user'])) {
    $userRateSql = "SELECT * FROM rates WHERE user_id = ? AND product_id = ?";
    $userRate = getDataAsArray($link, $userRateSql, [
            $_SESSION['user']['id'],
            $productId
        ]
    );
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rate = (int)$_POST['cost'];

    if (($price + $product['price_step']) > $rate) {
        $errors['cost'] = 'Укажите ставку выше минимальной';
    }

    if ($rate === 0) {
        $errors['cost'] = 'Необходимо указать целое число';
    }

    if (!count($errors)) {
        $rateAddSql = 'INSERT INTO rates(user_id, product_id, date, sum) VALUES (?, ?, NOW(), ?)';

        $stmt = db_get_prepare_stmt($link, $rateAddSql, [
            (int)$_SESSION['user']['id'],
            (int)$productId,
            (int)$rate
        ]);

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            header('Location: /lot.php?id=' . $productId);
            exit();
        }
    }
}

$pageContent = includeTemplate('lot.php', [
    'categoriesTemplate' => $categoriesTemplate,
    'product' => $product,
    'errors' => $errors,
    'rates' => $rates,
    'userRate' => $userRate,
    'price' => $price,
    'config' => $config
]);

if (!$product || !$productId) {
    $pageContent = includeTemplate('404.php', [
        'categoriesTemplate' => $categoriesTemplate
    ]);
}

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'categoriesTemplate' => $categoriesTemplate,
    'config' => $config
]);

print($layoutContent);
