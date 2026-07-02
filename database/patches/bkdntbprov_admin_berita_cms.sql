-- Patch CMS Berita untuk database live: bkdntbprov_admin
-- Hanya menambah tabel baru, TIDAK mengubah tabel users/beritas/lainnya.
--
-- Jalankan:
--   php scripts/db.php migrate
-- atau:
--   mysql -u USER -p bkdntbprov_admin < database/patches/bkdntbprov_admin_berita_cms.sql

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
SELECT 'Administrator Berita', 'admin', '$2y$10$DIqOkYw9tBMHBk6119S1bu1b2kOjsa0fJV1mjbapSiq3mtzZZlir2'
WHERE NOT EXISTS (SELECT 1 FROM `user` WHERE `username` = 'admin');

-- Login CMS berita: admin / admin123 (tabel `user`, terpisah dari `users`)
