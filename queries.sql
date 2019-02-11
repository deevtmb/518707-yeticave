USE yeticave;

-- Добавление списка категорий
INSERT INTO categories(name)
VALUES ('Доски и лыжи'), ('Крепления'), ('Ботинки'), ('Одежда'), ('Инструменты'), ('Разное');

-- Добавление пользователей
INSERT INTO users(reg_date, email, name, password, avatar_url, contacts)
VALUES
(NOW(), 'mymail@mail.ru', 'User1', 'qwerty', 'avatar-1.jpg', '891234567890'),
(NOW(), 'mail@gmail.com', 'User2', '123456', 'avatar-2.jpg', 'Телеграмм @user'),
(NOW(), 'user3@gmail.com', 'User3', '654321', 'avatar-3.jpg', NULL);

-- Добавление списка объявлений
INSERT INTO products(user_id, winner_id, category_id, date_create, date_end, name, description, img_url, price, price_step)
VALUES
(2, NULL, 1, NOW(), TIMESTAMP('2019-03-20'), 'Доска BURTON', 'Отличный борд для каталки', 'burton-img.jpg', 30000, 1000),
(1, NULL, 4, TIMESTAMP('2019-02-02'), TIMESTAMP('2019-04-02'), 'Куртка QUIKSILVER', 'Теплая куртка', 'jacket-img.jpg', 9999, 100),
(2, 1, 2, NOW(), TIMESTAMP('2019-02-08'), 'Крепления USD', 'Крепления в хорошем состоянии', 'usd-img.jpg', 1000, 100);

-- Добавление ставок
INSERT INTO rates(user_id, product_id, date, sum)
VALUES
(2, 2, TIMESTAMP('2019-02-07'), 11999),
(3, 2, TIMESTAMP('2019-02-08'), 13999),
(3, 1, TIMESTAMP('2019-02-08'), 31000);

-- Запрос списка категорий
SELECT name FROM categories;

-- Запрос лотов
SELECT p.name, price, img_url, price_step, c.name, p.id, winner_id
FROM products p JOIN categories c ON p.category_id = c.id
WHERE winner_id is NULL
ORDER BY p.id DESC;

-- Показ лота по id
SELECT * FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = 2;

-- Обновление имени лота
UPDATE products SET name = 'Доска для фрирайда Burton'
WHERE id = '1';

-- Запрос списка свежих ставок для лота по id
SELECT * FROM rates
WHERE product_id = '2'
ORDER BY date DESC;
