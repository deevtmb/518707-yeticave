<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php foreach ($categories as $category) { ?>
                <li class="promo__item <?= $categoriesIcons[$category['id'] - 1] ;?>">
                    <a class="promo__link" href="all-lots.php?category_id=<?= $category['id'] ;?>"><?= htmlspecialchars($category['name']) ;?></a>
                </li>
            <?php } ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <?php foreach ($products as $product) { ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= htmlspecialchars($product['url']) ;?>" width="350" height="260" alt="<?= htmlspecialchars($product['title']) ;?>">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($product['category']) ;?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $product['id'] ;?>"><?= htmlspecialchars($product['title']) ;?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount"><?= htmlspecialchars($product['rates'] ? 'Количество ставок: ' . $product['rates'] : 'Стартовая цена') ;?></span>
                                <span class="lot__cost"><?= asCurrency($product['last_rate'] ?? $product['price'], $config) ;?></span>
                            </div>
                            <div class="lot__timer timer">
                                <?= htmlspecialchars(timeLeft($product['date_end'])) ;?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </section>
</main>
