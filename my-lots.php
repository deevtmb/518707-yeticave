<?php
session_start();

if (isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}

require('init.php');

$pageContent = includeTemplate('my-lots.php', [
    'categoriesTemplate' => $categoriesTemplate,
    'config' => $config
]);

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'categoriesTemplate' => $categoriesTemplate,
    'config' => $config
]);

print($layoutContent);
