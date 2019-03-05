<main>
    <?= $categoriesTemplate ;?>

    <div class="container">
        <section class="lots">
            <h2>Результаты поиска по запросу «<span><?= htmlspecialchars($_GET['search']) ;?></span>»</h2>

            <?php if (empty($products)) { ?>
                <div>Ничего не найдено по вашему запросу</div>
            <?php } ?>

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
        <?php if ($pagesCount > 1) { ?>
            <ul class="pagination-list">
                <li class="pagination-item pagination-item-prev"><a href="search.php?search=<?= htmlspecialchars($_GET['search']) ;?>&page=<?= $currentPage == 1 ? $currentPage : $currentPage - 1 ;?>">Назад</a></li>

                <?php foreach ($pages as $page) { ?>
                    <li class="pagination-item <?= $page == $currentPage ? 'pagination-item-active' : '' ?>">
                        <a href="search.php?search=<?= htmlspecialchars($_GET['search']) ;?>&page=<?=$page;?>"><?=$page;?></a>
                    </li>
                <?php } ?>
                <li class="pagination-item pagination-item-next"><a href="search.php?search=<?= htmlspecialchars($_GET['search']) ;?>&page=<?= $currentPage == $pagesCount ? $currentPage : $currentPage + 1 ;?>">Вперед</a></li>
            </ul>
        <?php } ?>
    </div>
</main>
