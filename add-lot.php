<?php
session_start();

require('init.php');

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product = $_POST;

    $required = ['name', 'description', 'end_date'];
    $number = ['price', 'price_step'];
    $errors = [];

    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Необходимо заполнить поле ' . $field;
        }
    }

    foreach ($number as $field) {
        if (isset($_POST[$field])) {
            $param = (int)$_POST[$field];

            if ($param <= 0) {
                $errors[$field] = 'Необходимо указать число > 0';
            }
        }
    }

    foreach ($categories as $item) {
        $array[] = $item['id'];
    }

    if (!in_array($_POST['category'], $array)) {
        $errors['category'] = 'Выберите одну из предложенных категорий';
    }

    if (!empty($_FILES['photo']['name'])) {
        $tmp_name = $_FILES['photo']['tmp_name'];
        $path = uniqid();

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type == 'image/jpeg' || $file_type == 'image/png') {

            $file_extension = ($file_type == 'image/jpeg') ? '.jpg' : '.png';

            move_uploaded_file($tmp_name, $config['upload_dir'] . $path . $file_extension);
            $product['photo'] = $config['upload_dir'] . $path . $file_extension;
        } else {
            $errors['photo'] = 'Загрузите картинку в формате JPEG или PNG';
        }
    }

    if (!checkDateFormat($_POST['end_date'])) {
        $errors['end_date'] = 'Неверный формат даты';
    }

    if (isset($_POST['end_date'])) {
        if (strtotime('tomorrow') > strtotime($_POST['end_date'])) {
            $errors['end_date'] = 'Минимиум 1 день к текущей дате';
        }
    }

    if (count($errors)) {
        $pageContent = includeTemplate('add-lot.php', [
            'product' => $product,
            'errors' => $errors,
            'categoriesTemplate' => $categoriesTemplate,
            'categories' => $categories
        ]);

    } else {

        $productAddSql = 'INSERT INTO products 
(user_id, category_id, date_create, date_end, name, description, img_url, price, price_step) 
VALUES (2, ?, NOW(), TIMESTAMP(?), ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($link, $productAddSql, [
            $product['category'],
            $product['end_date'],
            $product['name'],
            $product['description'],
            $product['photo'] ?? '',
            $product['price'],
            $product['price_step']
        ]);

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $product_id = mysqli_insert_id($link);

            header("Location: lot.php?id=" . $product_id);
        } else {
            $pageContent = includeTemplate('add-lot.php', [
                'product' => $product,
                'errors' => $errors,
                'categoriesTemplate' => $categoriesTemplate,
                'categories' => $categories
            ]);
        }
    }
} else {
    $pageContent = includeTemplate('add-lot.php', [
        'categoriesTemplate' => $categoriesTemplate,
        'categories' => $categories
    ]);
}

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'categoriesTemplate' => $categoriesTemplate,
    'config' => $config
]);

print($layoutContent);
