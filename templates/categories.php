<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category) { ?>
            <li class="nav__item <?= (isset($_GET['category_id']) && ($_GET['category_id'] == $category['id'])) ? 'nav__item--current' : '' ;?>">
                <a href="all-lots.php?category_id=<?= $category['id'] ;?>"><?= htmlspecialchars($category['name']) ;?></a>
            </li>
        <?php } ?>
    </ul>
</nav>
