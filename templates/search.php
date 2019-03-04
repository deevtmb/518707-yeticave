<main>
    <?php include('categories.php') ;?>

    <div class="container">
        <section class="lots">
            <h2>Результаты поиска по запросу «<span><?= $_GET['search'] ;?></span>»</h2>

            <?php if (empty($products)) { ?>
                <div>Ничего не найдено по вашему запросу</div>
            <?php } ?>

            <?php include('lots-list.php');?>

        </section>
        <?php if ($pagesCount > 1) { ?>
            <ul class="pagination-list">
                <li class="pagination-item pagination-item-prev"><a href="search.php?search=<?= $_GET['search'] ;?>&page=<?= $currentPage == 1 ? $currentPage : $currentPage - 1 ;?>">Назад</a></li>

                <?php foreach ($pages as $page) { ?>
                    <li class="pagination-item <?= $page == $currentPage ? 'pagination-item-active' : '' ?>">
                        <a href="search.php?search=<?= $_GET['search'] ;?>&page=<?=$page;?>"><?=$page;?></a>
                    </li>
                <?php } ?>
                <li class="pagination-item pagination-item-next"><a href="search.php?search=<?= $_GET['search'] ;?>&page=<?= $currentPage == $pagesCount ? $currentPage : $currentPage + 1 ;?>">Вперед</a></li>
            </ul>
        <?php } ?>
    </div>
</main>
