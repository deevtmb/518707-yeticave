<?php
require('init.php');

$user = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST;

    $required = ['email', 'password', 'name', 'contacts'];

    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Необходимо заполнить поле ' . $field;
        }
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Заполните поле email в верном формате';
    }

    if (!empty($_FILES['avatar']['name'])) {
        $tmp_name = $_FILES['avatar']['tmp_name'];
        $path = uniqid();

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type == 'image/jpeg' || $file_type == 'image/png') {

            $file_extension = ($file_type == 'image/jpeg') ? '.jpg' : '.png';

            move_uploaded_file($tmp_name, $config['upload_dir'] . $path . $file_extension);
            $user['avatar'] = $config['upload_dir'] . $path . $file_extension;
        } else {
            $errors['avatar'] = 'Загрузите картинку в формате JPEG или PNG';
        }
    }

    if (isset($_POST['email'])) {
        $email = mysqli_real_escape_string($link, $user['email']);
        $emailSql = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($link, $emailSql);

        if (mysqli_num_rows($result) > 0) {
            $errors['email'] = 'Пользователь с указанным email уже зарегистрирован на сайте';
        }
    }

    if (empty($errors)) {
        $password = password_hash($user['password'], PASSWORD_DEFAULT);

        $userAddSql = 'INSERT INTO users (reg_date, email, name, password, avatar_url, contacts)
 VALUES (NOW(), ?, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($link, $userAddSql, [
            $user['email'],
            $user['name'],
            $password,
            $user['avatar'] ?? '',
            $user['contacts']
        ]);

        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            header("Location: /index.php");
            exit();
        }
    }
}

$pageContent = includeTemplate('sign-up.php', [
    'user' => $user,
    'errors' => $errors,
    'categories' => $categories
]);

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'isAuth' => $isAuth,
    'userName' => $userName,
    'categories' => $categories,
    'config' => $config
]);

print($layoutContent);
