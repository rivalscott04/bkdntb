-- Pengunjung yang memuat halaman dalam 5 menit terakhir.
CREATE TABLE IF NOT EXISTS `pengunjung_online` (
  `vid` char(16) NOT NULL,
  `terakhir` int unsigned NOT NULL,
  PRIMARY KEY (`vid`),
  KEY `idx_pengunjung_terakhir` (`terakhir`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
