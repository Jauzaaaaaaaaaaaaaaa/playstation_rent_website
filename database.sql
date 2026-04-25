-- Database siap import untuk aplikasi Rental Playstation
-- Cara pakai: buka phpMyAdmin > Import > pilih file ini > Go

CREATE DATABASE IF NOT EXISTS `ujk` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ujk`;

DROP TABLE IF EXISTS `dataps`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `dataps` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(120) NOT NULL,
    `no_hp` VARCHAR(20) NOT NULL,
    `jenis` VARCHAR(50) NOT NULL,
    `durasi` INT(11) NOT NULL,
    `harga` INT(11) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Login default:
-- Email    : admin@gmail.com
-- Password : admin123
INSERT INTO `users` (`name`, `email`, `password`) VALUES
('Admin', 'admin@gmail.com', '$2y$08$BMOKdhN7f4QOF.08wALwN.3QiKLRFv/hYYSz1dg.2rFROrSEdAH6W');

INSERT INTO `dataps` (`nama`, `no_hp`, `jenis`, `durasi`, `harga`) VALUES
('Andi Saputra', '081234567890', 'PlayStation 5', 3, 225000),
('Rina Lestari', '082198765432', 'PlayStation 4', 2, 120000),
('Dimas Pratama', '083812345678', 'PlayStation 3', 1, 40000);
