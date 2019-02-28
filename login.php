<?php
session_start();

require('init.php');
$errors = [];
$userLogin = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userLogin = $_POST;

    $required = ['email', 'password'];

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

    if (!count($errors)) {
        header("Location: /index.php");
        exit();
    }
}

$pageContent = includeTemplate('login.php', [
    'categories' => $categories,
    'errors' => $errors,
    'userLogin' => $userLogin
]);


$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'categories' => $categories,
    'config' => $config
]);

print($layoutContent);
