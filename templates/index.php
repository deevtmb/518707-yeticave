<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php foreach ($categories as $category) { ?>
                <li class="promo__item <?= $categoriesIcons[$category['id'] - 1] ;?>">
                    <a class="promo__link" href="all-lots.php?category_id=<?= $category['id'] ;?>"><?= $category['name'] ;?></a>
                </li>
            <?php } ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <?php include('lots-list.php');?>
    </section>
</main>
