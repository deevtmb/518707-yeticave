<?php
date_default_timezone_set('Europe/Moscow');

require('data.php');
require('functions.php');
$config = include('config/config.php');

$isAuth = rand(0, 1);
$link = mysqli_connect(
    $config['db']['host'],
    $config['db']['user'],
    $config['db']['pass'],
    $config['db']['name']
);

$categoriesSql = 'SELECT name FROM categories';
$categories = getDataAsArray($link, $categoriesSql);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userLogin = $_POST;

    $required = ['email', 'password'];
    $errors = [];

    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Необходимо заполнить поле ' . $field;
        }
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Заполните поле email в верном формате';
    }

    $email = mysqli_real_escape_string($link, $userLogin['email']);
    $findUserSql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $findUserSql);

    $user = $result ? mysqli_fetch_array($result, MYSQLI_ASSOC) : null;

    if (!count($errors) and $user) {
        if (password_verify($userLogin['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Введен неверный пароль';
        }
    } else {
        $errors['email'] = 'Пользователь с таким email не зарегестрирован';
    }

    if (count($errors)) {
        $pageContent = includeTemplate('login.php', [
            'categories' => $categories,
            'userLogin' => $userLogin,
            'errors' => $errors
        ]);
    } else {
        header("Location: /index.php");
        exit();
    }

} else {
    $pageContent = includeTemplate('login.php', [
        'categories' => $categories
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
