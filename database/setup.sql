CREATE DATABASE IF NOT EXISTS `berita` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `berita`;

CREATE TABLE IF NOT EXISTS `berita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul_berita` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `isi_berita` text NOT NULL,
  `penulis` varchar(100) NOT NULL DEFAULT 'Admin',
  `tanggal` datetime NOT NULL,
  `gambar_berita` varchar(255) NOT NULL,
  `bidang` varchar(100) NOT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'published',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_bidang` (`bidang`),
  KEY `idx_tanggal` (`tanggal`),
  KEY `idx_status` (`status`),
  KEY `idx_status_tanggal` (`status`, `tanggal`),
  KEY `idx_bidang_status_tanggal` (`bidang`, `status`, `tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`nama`, `username`, `password`)
SELECT 'Administrator', 'admin', '$2y$10$DIqOkYw9tBMHBk6119S1bu1b2kOjsa0fJV1mjbapSiq3mtzZZlir2'
WHERE NOT EXISTS (SELECT 1 FROM `user` WHERE `username` = 'admin');

-- Jalankan seeder berita (data statis lama):
--   php scripts/seed_berita.php
--   php scripts/seed_berita.php --fresh
