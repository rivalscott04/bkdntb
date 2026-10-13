-- =============================================================================
-- BKD NTB: Tabel agenda Kepala Badan (/agenda)
-- phpMyAdmin: pilih database → tab SQL → paste → Go
-- =============================================================================

CREATE TABLE IF NOT EXISTS `agenda` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `kegiatan` varchar(500) NOT NULL,
  `tempat` varchar(255) DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_agenda_tanggal` (`aktif`, `tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
