-- create_tables.sql (MySQL)
-- Jalankan di MySQL 5.7+ / 8.0
CREATE DATABASE IF NOT EXISTS `if0_40116604_ayam_rempah`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `if0_40116604_ayam_rempah`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `customer_name` VARCHAR(200) DEFAULT 'Pembeli',
  `note` TEXT NULL,
  `delivery_time` DATETIME NULL,
  `start_time` DATETIME NULL,
  `duration_memasak` INT DEFAULT 15,
  `duration_packing` INT DEFAULT 5,
  `duration_mengantar` INT DEFAULT 20,
  `status_override` VARCHAR(50) NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
