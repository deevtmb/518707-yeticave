<?php
/**
 * Функция-шаблонизатор
 *
 * @param string $name
 * @param array $data
 * @return false|string
 */
function includeTemplate($name, $data)
{
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

/**
 * Функция для форматирования цены продукта
 *
 * @param $number
 * @return string
 */
function asCurrency($number)
{
    ceil($number);
    $number = number_format($number, 0, '.', ' ');
    $number .= ' <b class="rub">р</b>';

    return $number;
}

/**
 * Функция возвращает время до конца аукциона
 *
 * @param string $timeEnd
 * @return string
 */
function timeLeft($timeEnd)
{
    $secsLeft = strtotime($timeEnd) - time();
    $minutesLeft = floor(($secsLeft % 3600) / 60);
    $hoursLeft = floor($secsLeft / 3600);

    return $hoursLeft . ':' . $minutesLeft;
}

;
