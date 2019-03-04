<?php
date_default_timezone_set('Europe/Moscow');

require('data.php');
require('functions.php');
$config = include('config/config.php');

$link = mysqli_connect(
    $config['db']['host'],
    $config['db']['user'],
    $config['db']['pass'],
    $config['db']['name']
);

$categoriesSql = 'SELECT * FROM categories ORDER BY id ASC';
$categories = getDataAsArray($link, $categoriesSql);
