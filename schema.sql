CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(50)
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  winner_id INT,
  category_id INT,
  date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  date_end TIMESTAMP,
  name CHAR(100),
  description CHAR(255),
  img_url CHAR(100),
  price INT,
  price_step INT
);

CREATE INDEX p_name ON products(name);

CREATE TABLE rates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  product_id INT,
  date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  sum INT
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reg_date TIMESTAMP,
  email CHAR(100),
  name CHAR(50),
  password CHAR(50),
  avatar_url CHAR(100),
  contacts CHAR(255)
);

CREATE UNIQUE INDEX email ON users(email);

ALTER TABLE products ADD FOREIGN KEY (user_id) REFERENCES users(id)
ON DELETE CASCADE;
ALTER TABLE products ADD FOREIGN KEY (winner_id) REFERENCES users(id)
ON DELETE CASCADE;
ALTER TABLE products ADD FOREIGN KEY (category_id) REFERENCES categories(id)
ON DELETE CASCADE;

ALTER TABLE rates ADD FOREIGN KEY (user_id) REFERENCES users(id)
ON DELETE CASCADE;
ALTER TABLE rates ADD FOREIGN KEY (product_id) REFERENCES products(id)
ON DELETE CASCADE;
