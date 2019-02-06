<?php
function includeTemplate($name, $data) {
$name = 'templates/' . $name;
$result = '';

if (!is_readable($name)) {
return $result;
}

ob_start();
extract($data);
require $name;

$result = ob_get_clean();

return $result;
}

function asCurrency ($number) {
    ceil($number);
    $number = number_format($number, 0, '.',  ' ');
    $number .= ' <b class="rub">р</b>';

    return $number;
};

function dataFilter($data) {
    $text = htmlspecialchars($data);

    return $text;
}
