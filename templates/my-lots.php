<main>
    <?= $categoriesTemplate ;?>

    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
            <?php if (isset($rates) && count($rates)) { ?>
                <?php foreach ($rates as $rate) { ?>

                    <?php $itemClass = '';
                    if ($rate['winner_id'] == $_SESSION['user']['id']) {$itemClass = 'rates__item--win';}
                    else if (strtotime($rate['date_end']) < time()) {$itemClass = 'rates__item--end';} ;?>
                    <tr class="rates__item <?= $itemClass ;?>">
                        <td class="rates__info">
                            <div class="rates__img">
                                <img src="<?= htmlspecialchars($rate['url']) ;?>" width="54" height="40" alt="<?= htmlspecialchars($rate['title']) ;?>">
                            </div>
                            <div>
                                <h3 class="rates__title"><a href="lot.php?id=<?= $rate['id'] ;?>"><?= htmlspecialchars($rate['title']) ;?></a></h3>
                                <?php if ($rate['winner_id'] !== null) {?>
                                <p><?= htmlspecialchars($rate['contacts']) ;?></p>
                                <?php } ?>
                            </div>
                        </td>
                        <td class="rates__category">
                            <?= htmlspecialchars($categories[$rate['category_id'] - 1]['name']) ;?>
                        </td>

                        <?php $value = timeLeft($rate['date_end']);
                        $timerClass = '';
                        if ($rate['winner_id'] == $_SESSION['user']['id']) {$timerClass = 'timer--win'; $value = 'Ставка выиграла';}
                        else if (strtotime($rate['date_end']) < time()) {$timerClass = 'timer--end'; $value = 'Торги окончены';}
                        else if (strtotime($rate['date_end']) < strtotime('+24 hours')) {$timerClass = 'timer--finishing';} ?>
                        <td class="rates__timer">
                            <div class="timer <?= $timerClass ;?>">
                                <?= $value ;?>
                            </div>
                        </td>
                        <td class="rates__price">
                            <?= $rate['rate'] . ' р';?>
                        </td>
                        <td class="rates__time">
                            <?= ratePostTime($rate['rate_date']) ;?>
                        </td>
                    </tr>
                <?php } ?>
            <?php }?>
        </table>
    </section>
</main>
