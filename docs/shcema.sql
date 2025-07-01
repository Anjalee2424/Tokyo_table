CREATE TABLE `categories` (
  `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `image_path` VARCHAR(255) DEFAULT NULL,
);

CREATE TABLE `recipes` (
  `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `category_id` INT(11) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `ingredients` TEXT NOT NULL,
  `steps` TEXT NOT NULL,
  `image_path` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
);

CREATE TABLE `users` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(50) UNIQUE NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
);