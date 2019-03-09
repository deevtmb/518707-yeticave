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
    $timeLeft = gmdate('z ' . 'дн. ' . 'H:i', $secsLeft);

    return $timeLeft;
}

/**
 * Функция возвращает время публикации ставки
 *
 * @param $time
 * @return false|string
 */
function ratePostTime($time) {
    $secsLeft = time() - strtotime($time);

    if ($secsLeft < 3600) {
        $postTime = (int)gmdate('i', $secsLeft) . ' мин. назад';
    } elseif ($secsLeft < 86400) {
        $postTime = gmdate('G', $secsLeft) . ' ч. назад';
    } else {
        $postTime = gmdate('d.m.y H:i');
    }

    return $postTime;
}


/**
 * Функция для получения массива из БД
 *
 * @param $link connect
 * @param $sql string query
 * @param $data array params of query
 * @return array|null
 */
function getDataAsArray($link, $sql, $data = [])
{
    if ($link === false) {
        print('Ошибка подключения: ' . mysqli_connect_error());

    } else {
        mysqli_set_charset($link, 'utf8');

        require_once('mysql_helper.php');
        $stmt = db_get_prepare_stmt($link, $sql, $data);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            $error = mysqli_error($link);
            print('Ошибка MySQL: ' . $error);
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

/**
 * Функция для получения одной записи из БД
 *
 * @param $link connect
 * @param $sql string query
 * @param $data array params of query
 * @return array|null
 */
function getDataAsArrayOne($link, $sql, $data = [])
{
    if ($link === false) {
        print('Ошибка подключения: ' . mysqli_connect_error());

    } else {
        mysqli_set_charset($link, 'utf8');

        require_once('mysql_helper.php');
        $stmt = db_get_prepare_stmt($link, $sql, $data);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            $error = mysqli_error($link);
            print('Ошибка MySQL: ' . $error);
        }

        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
}

/**
 * Проверяет, что переданная дата соответствует формату ГГГГ-ММ-ДД
 *
 * checkdate ( int $month , int $day , int $year )
 * @param string $date строка с датой
 * @return bool
 */
function checkDateFormat($date) {
    if ($date === date('d.m.Y', strtotime($date))) {
        $date = date('Y-m-d', strtotime($date));
    }

    $result = false;
    $regexp = '/(\d{4})\-(\d{2})\-(\d{2})/m';
    if (preg_match($regexp, $date, $parts) && count($parts) === 4) {
        $mounth = $parts[2];
        $day= $parts[3];
        $year = $parts[1];
        $result = checkdate($mounth, $day, $year);
    }
    return $result;
}

/**
 * Функция проверяет наличие сессии пользователя
 */
function auth () {
    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        exit();
    }
}
