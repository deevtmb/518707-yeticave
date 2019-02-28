<?php
session_start();

require('init.php');

$pageContent = includeTemplate('all-lots.php', [
    'categories' => $categories,
    'config' => $config
]);

$layoutContent = includeTemplate('layout.php', [
    'content' => $pageContent,
    'categories' => $categories,
    'config' => $config
]);

print($layoutContent);
