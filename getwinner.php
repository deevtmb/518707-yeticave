<?php
require('vendor/autoload.php');

$transport = new Swift_SmtpTransport('phpdemo.ru', 25);
$transport->setUsername('keks@phpdemo.ru');
$transport->setPassword('htmlacademy');

$mailer = new Swift_Mailer($transport);

$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

$expiredProductsSql = '
    SELECT * FROM products
    WHERE winner_id is NULL AND DATE(date_end) <= NOW()';
$expiredProducts = getDataAsArray($link, $expiredProductsSql);

if (count($expiredProducts)) {
    foreach ($expiredProducts as $product) {
        $lastRateSql = 'SELECT sum, user_id FROM rates WHERE product_id = ? ORDER BY id DESC LIMIT 1';
        $lastRate = getDataAsArrayOne($link, $lastRateSql, [$product['id']]);

        if ($lastRate) {
            $winnerSetSql = 'UPDATE products SET winner_id = ? WHERE id = ?';
            $stmt = db_get_prepare_stmt($link, $winnerSetSql, [$lastRate['user_id'], $product['id']]);

            mysqli_stmt_execute($stmt);

            $winnerSql = 'SELECT p.id AS id, u.name AS name, u.email AS email, p.name AS title
            FROM users u 
            JOIN products p ON u.id = ?';
            $winner = getDataAsArrayOne($link, $winnerSql, [$lastRate['user_id']]);

            $recipient[$winner['email']] = $winner['name'];

            $message = new Swift_Message();
            $message->setSubject('Ваша ставка победила');
            $message->setFrom(['keks@phpdemo.ru' => 'YetiCave']);
            $message->setBcc($recipient);

            $messageContent = includeTemplate('email.php', [
                'winner' => $winner,
                'product' => $product
            ]);
            $message->setBody($messageContent, 'text/html');

            $mailer->send($message);
        }
    }
}
