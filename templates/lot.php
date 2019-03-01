<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $item) { ?>
                <li class="nav__item">
                    <a href="pages/all-lots.html"><?=$item['name'];?></a>
                </li>
            <?php } ?>
        </ul>
    </nav>
    <section class="lot-item container">

        <h2><?=htmlspecialchars($product['title']);?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?=htmlspecialchars($product['url']);?>" width="730" height="548" alt="<?=htmlspecialchars($product['title']);?>">
                </div>
                <p class="lot-item__category">Категория: <span><?=htmlspecialchars($product['category']);?></span></p>
                <p class="lot-item__description"><?=htmlspecialchars($product['description']);?></p>
            </div>
            <div class="lot-item__right">

                <?php if (isset($_SESSION['user'])) { ;?>

                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?= htmlspecialchars(timeLeft($product['date_end'])); ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= asCurrency($price, $config) ;?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= ($price + $product['price_step']) . ' р' ;?></span>
                        </div>
                    </div>

                    <?php if (!count($userRate)) { ;?>
                    <form class="lot-item__form" action="lot.php?id=<?= $product['id'] ;?>" method="post">

                        <?php $classname = isset($errors['cost']) ? 'form__item--invalid' : '';?>

                        <p class="lot-item__form-item form__item <?= $classname ;?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="12 000">
                            <span class="form__error"><?= $errors['cost'] ;?></span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                    <?php } ?>

                </div>

                <?php } ?>
                <div class="history">
                    <h3>История ставок (<span><?= count($rates) ?? 0 ;?></span>)</h3>
                    <table class="history__list">

                        <?php foreach ($rates as $rate) {?>
                            <tr class="history__item">
                                <td class="history__name"><?= $rate['user'] ;?></td>
                                <td class="history__price"><?= $rate['price'] ;?></td>
                                <td class="history__time"><?= ratePostTime($rate['date']) ;?></td>
                            </tr>
                        <?php } ?>

                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
