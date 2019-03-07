<main>
    <?= $categoriesTemplate ;?>

    <?php $classname = (isset($errors) && count($errors)) ? 'form--invalid' : '';?>

    <form class="form container <?= $classname ;?>" action="login.php" method="post">
        <h2>Вход</h2>
        <?php if (count($errors)) { ?>
            <div class="form__item form__item--invalid">
                <span class="form__error">Вы ввели неверный email/пароль</span>
            </div>
        <?php } ?>

        <?php $classname = isset($errors['email']) ? 'form__item--invalid' : '';
        $value = isset($userLogin['email']) ? $userLogin['email'] : ''; ?>

        <div class="form__item <?= $classname ;?>">
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $value ;?>" required>
            <span class="form__error"><?= $errors['email'] ;?></span>
        </div>

        <?php $classname = isset($errors['password']) ? 'form__item--invalid' : '';?>

        <div class="form__item form__item--last <?= $classname ;?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" required>
            <span class="form__error"><?= $errors['password'] ;?></span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>
