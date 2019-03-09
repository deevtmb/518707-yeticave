<?php
date_default_timezone_set('Europe/Moscow');

require('functions.php');
$config = include('config/config.php');

$link = mysqli_connect(
    $config['db']['host'],
    $config['db']['user'],
    $config['db']['pass'],
    $config['db']['name']
);

if (!$link) {
    print(includeTemplate('error.php', []));
    exit();
}

$categoriesSql = 'SELECT * FROM categories ORDER BY id ASC';
$categories = getDataAsArray($link, $categoriesSql);
$categoriesTemplate = includeTemplate(
    'categories.php',
    ['categories' => $categories]
);
