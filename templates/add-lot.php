<main>
    <?= $categoriesTemplate ;?>

    <?php $classname = (isset($errors) && count($errors)) ? 'form--invalid' : '';?>

    <form class="form form--add-lot container <?= $classname; ?>" action="add-lot.php" method="post" enctype="multipart/form-data">
        <h2>Добавление лота</h2>
        <div class="form__container-two">

            <?php $classname = isset($errors['name']) ? 'form__item--invalid' : '';
            $value = isset($product['name']) ? $product['name'] : ''; ?>

            <div class="form__item <?= $classname; ?>">
                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="name" placeholder="Введите наименование лота" value="<?= $value; ?>" required>
                <span class="form__error"><?= isset($errors['name']) ? $errors['name'] : ''; ?></span>
            </div>

            <?php $classname = isset($errors['category']) ? 'form__item--invalid' : '';?>

            <div class="form__item <?= $classname; ?>">
                <label for="category">Категория</label>
                <select id="category" name="category" required>
                    <option>Выберите категорию</option>
                    <?php foreach ($categories as $item) {
                      $selected = '';
                        if (isset($product['category'])) {
                            if ($product['category'] === strval($item['id'])) {
                                $selected = 'selected';
                            }
                        } ?>
                        <option value='<?= $item['id'] ;?>' <?= $selected ;?>><?= $item['name']; ?></option>
                    <?php } ?>
                </select>
                <span class="form__error"><?= isset($errors['category']) ? $errors['category'] : ''; ?></span>
            </div>
        </div>

        <?php $classname = isset($errors['description']) ? 'form__item--invalid' : '';
        $value = isset($product['description']) ? $product['description'] : ''; ?>

        <div class="form__item form__item--wide <?= $classname; ?>">
            <label for="message">Описание</label>
            <textarea id="message" name="description" placeholder="Напишите описание лота"><?= $value ;?></textarea>
            <span class="form__error"><?= isset($errors['description']) ? $errors['description'] : ''; ?></span>
        </div>

        <?php $classname = isset($errors['photo']) ? 'form__item--invalid' : '';?>

        <div class="form__item form__item--file <?= $classname ;?>">
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" name="photo" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
            <span class="form__error"><?= isset($errors['photo']) ? $errors['photo'] : '' ;?></span>
        </div>
        <div class="form__container-three">

            <?php $classname = isset($errors['price']) ? 'form__item--invalid' : '';
            $value = isset($product['price']) ? $product['price'] : ''; ?>

            <div class="form__item form__item--small <?= $classname; ?>">
                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="number" name="price" placeholder="0" value="<?= $value ;?>" required>
                <span class="form__error"><?= isset($errors['price']) ? $errors['price'] : ''; ?></span>
            </div>

            <?php $classname = isset($errors['price_step']) ? 'form__item--invalid' : '';
            $value = isset($product['price_step']) ? $product['price_step'] : ''; ?>

            <div class="form__item form__item--small <?= $classname ;?>">
                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="number" name="price_step" placeholder="0" value="<?= $value ;?>" required>
                <span class="form__error"><?= isset($errors['price_step']) ? $errors['price_step'] : ''; ?></span>
            </div>

            <?php $classname = isset($errors['end_date']) ? 'form__item--invalid' : '';
            $value = isset($product['end_date']) ? $product['end_date'] : ''; ?>

            <div class="form__item <?= $classname ;?>">
                <label for="lot-date">Дата окончания торгов</label>
                <input class="form__input-date" id="lot-date" type="date" name="end_date" value="<?= $value ;?>" required>
                <span class="form__error"><?= isset($errors['end_date']) ? $errors['end_date'] : ''; ?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
