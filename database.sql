-- Database siap import untuk aplikasi Rental Playstation
-- Cara pakai: buka phpMyAdmin > Import > pilih file ini > Go

CREATE DATABASE IF NOT EXISTS `rental_playstation` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rental_playstation`;

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

-- Akun demo, ganti sebelum dipakai sungguhan:
-- Email    : admin@gmail.com
-- Password : admin123
INSERT INTO `users` (`name`, `email`, `password`) VALUES
('Admin', 'admin@gmail.com', '$2y$08$BMOKdhN7f4QOF.08wALwN.3QiKLRFv/hYYSz1dg.2rFROrSEdAH6W');

-- Data contoh fiktif untuk demonstrasi laporan
INSERT INTO `dataps` (`nama`, `no_hp`, `jenis`, `durasi`, `harga`, `created_at`) VALUES
('Budi Santoso', '081200009263', 'PlayStation 4', 2, 120000, '2026-05-15 10:00:00'),
('Fajar Nugroho', '081200004947', 'PlayStation 3', 2, 80000, '2026-05-09 10:00:00'),
('Dewi Anggraini', '081200001368', 'PlayStation 3', 2, 80000, '2026-05-17 10:00:00'),
('Lina Marlina', '081200004210', 'PlayStation 5', 1, 75000, '2026-05-19 10:00:00'),
('Rudi Hartono', '081200002105', 'PlayStation 4', 2, 120000, '2026-05-24 10:00:00'),
('Andi Saputra', '081200000000', 'PlayStation 5', 1, 75000, '2026-05-19 10:00:00'),
('Dewi Anggraini', '081200001368', 'PlayStation 4', 4, 240000, '2026-06-01 10:00:00'),
('Dewi Anggraini', '081200001368', 'PlayStation 5', 1, 75000, '2026-06-18 10:00:00'),
('Lina Marlina', '081200004210', 'PlayStation 5', 2, 150000, '2026-06-15 10:00:00'),
('Hendra Wijaya', '081200000631', 'PlayStation 5', 4, 300000, '2026-06-01 10:00:00'),
('Rudi Hartono', '081200002105', 'PlayStation 3', 1, 40000, '2026-06-07 10:00:00'),
('Maya Sari', '081200008526', 'PlayStation 4', 3, 180000, '2026-06-08 10:00:00'),
('Rudi Hartono', '081200002105', 'PlayStation 5', 1, 75000, '2026-07-03 10:00:00'),
('Dewi Anggraini', '081200001368', 'PlayStation 5', 4, 300000, '2026-07-19 10:00:00'),
('Siti Aminah', '081200005684', 'PlayStation 5', 3, 225000, '2026-07-20 10:00:00'),
('Rudi Hartono', '081200002105', 'PlayStation 5', 2, 150000, '2026-07-06 10:00:00'),
('Rudi Hartono', '081200002105', 'PlayStation 4', 3, 180000, '2026-07-07 10:00:00'),
('Hendra Wijaya', '081200000631', 'PlayStation 4', 1, 60000, '2026-07-13 10:00:00'),
('Lina Marlina', '081200004210', 'PlayStation 3', 2, 80000, '2026-08-13 10:00:00'),
('Rina Lestari', '081200006421', 'PlayStation 3', 2, 80000, '2026-08-22 10:00:00'),
('Hendra Wijaya', '081200000631', 'PlayStation 5', 2, 150000, '2026-08-08 10:00:00'),
('Hendra Wijaya', '081200000631', 'PlayStation 5', 4, 300000, '2026-08-06 10:00:00'),
('Dimas Pratama', '081200002842', 'PlayStation 3', 3, 120000, '2026-08-24 10:00:00'),
('Fajar Nugroho', '081200004947', 'PlayStation 4', 3, 180000, '2026-08-03 10:00:00'),
('Maya Sari', '081200008526', 'PlayStation 4', 4, 240000, '2026-08-02 10:00:00'),
('Hendra Wijaya', '081200000631', 'PlayStation 4', 3, 180000, '2026-08-10 10:00:00'),
('Siti Aminah', '081200005684', 'PlayStation 5', 4, 300000, '2026-09-23 10:00:00'),
('Maya Sari', '081200008526', 'PlayStation 5', 1, 75000, '2026-09-10 10:00:00'),
('Dimas Pratama', '081200002842', 'PlayStation 5', 3, 225000, '2026-09-27 10:00:00'),
('Rina Lestari', '081200006421', 'PlayStation 3', 4, 160000, '2026-09-12 10:00:00'),
('Andi Saputra', '081200000000', 'PlayStation 5', 3, 225000, '2026-09-15 10:00:00'),
('Fajar Nugroho', '081200004947', 'PlayStation 5', 1, 75000, '2026-09-22 10:00:00'),
('Budi Santoso', '081200009263', 'PlayStation 5', 4, 300000, '2026-09-20 10:00:00'),
('Maya Sari', '081200008526', 'PlayStation 3', 4, 160000, '2026-09-19 10:00:00'),
('Fajar Nugroho', '081200004947', 'PlayStation 4', 1, 60000, '2026-10-02 10:00:00'),
('Dimas Pratama', '081200002842', 'PlayStation 4', 4, 240000, '2026-10-22 10:00:00'),
('Budi Santoso', '081200009263', 'PlayStation 5', 2, 150000, '2026-10-04 10:00:00'),
('Fajar Nugroho', '081200004947', 'PlayStation 5', 4, 300000, '2026-10-21 10:00:00'),
('Fajar Nugroho', '081200004947', 'PlayStation 5', 4, 300000, '2026-10-27 10:00:00'),
('Fajar Nugroho', '081200004947', 'PlayStation 4', 3, 180000, '2026-10-21 10:00:00'),
('Hendra Wijaya', '081200000631', 'PlayStation 4', 3, 180000, '2026-10-24 10:00:00'),
('Dewi Anggraini', '081200001368', 'PlayStation 5', 1, 75000, '2026-10-08 10:00:00'),
('Rina Lestari', '081200006421', 'PlayStation 4', 3, 180000, '2026-10-08 10:00:00'),
('Siti Aminah', '081200005684', 'PlayStation 4', 3, 180000, '2026-10-20 10:00:00'),
('Agus Setiawan', '081200007789', 'PlayStation 3', 3, 120000, '2026-10-16 10:00:00');
