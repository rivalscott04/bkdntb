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
  `asal_surat` varchar(255) DEFAULT NULL,
  `tempat` varchar(255) DEFAULT NULL,
  `keterangan` varchar(500) DEFAULT NULL,
  `surat_file` varchar(255) DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_agenda_tanggal` (`aktif`, `tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Jika tabel sudah ada dari patch lama, tambahkan kolom yang belum ada.
SET @db := DATABASE();
SET @sql := (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE `agenda` ADD COLUMN `asal_surat` varchar(255) DEFAULT NULL AFTER `kegiatan`',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = @db AND TABLE_NAME = 'agenda' AND COLUMN_NAME = 'asal_surat'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sql := (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE `agenda` ADD COLUMN `keterangan` varchar(500) DEFAULT NULL AFTER `tempat`',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = @db AND TABLE_NAME = 'agenda' AND COLUMN_NAME = 'keterangan'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sql := (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE `agenda` ADD COLUMN `surat_file` varchar(255) DEFAULT NULL AFTER `keterangan`',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = @db AND TABLE_NAME = 'agenda' AND COLUMN_NAME = 'surat_file'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
