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
function asCurrency($number, $config, $currency = 'rub')
{
    if (!isset ($config['currency'][$currency])) {
        return $currency . ' not found';
    }

    ceil($number);
    $number = number_format($number, 0, '.', ' ');
    $number .= $config['currency'][$currency];

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
    $timeLeft = gmdate('j ' . 'дн. ' . 'H:i', $secsLeft);

    return $timeLeft;
}


/**
 * @param $sql query
 * @param $link database connect
 * @return array|null
 */
function getDataAsArray($link, $sql)
{
    if ($link == false) {
        print('Ошибка подключения: ' . mysqli_connect_error());

    } else {
        mysqli_set_charset($link, 'utf8');

        require_once('mysql_helper.php');
        $stmt = db_get_prepare_stmt($link, $sql);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            $error = mysqli_error($link);
            print("Ошибка MySQL: " . $error);
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
