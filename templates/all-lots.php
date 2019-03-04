<main>
    <?php include('categories.php') ;?>
    <div class="container">
        <section class="lots">
            <h2>Все лоты в категории <span>«<?= $categories[$_GET['category_id'] - 1]['name'] ;?>»</span></h2>
            <?php include('lots-list.php');?>
        </section>
        <?php if ($pagesCount > 1) { ?>
            <ul class="pagination-list">
                <li class="pagination-item pagination-item-prev"><a href="all-lots.php?category_id=<?= $_GET['category_id'] ;?>&page=<?= $currentPage == 1 ? $currentPage : $currentPage - 1 ;?>">Назад</a></li>

                <?php foreach ($pages as $page) { ?>
                    <li class="pagination-item <?= $page == $currentPage ? 'pagination-item-active' : '' ?>">
                        <a href="all-lots.php?category_id=<?= $_GET['category_id'] ;?>&page=<?= $page ;?>"><?= $page ;?></a>
                    </li>
                <?php } ?>
                <li class="pagination-item pagination-item-next"><a href="all-lots.php?category_id=<?= $_GET['category_id'] ;?>&page=<?= $currentPage == $pagesCount ? $currentPage : $currentPage + 1 ;?>">Вперед</a></li>
            </ul>
        <?php } ?>
    </div>
</main>
