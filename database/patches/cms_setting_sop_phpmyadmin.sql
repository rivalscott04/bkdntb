-- =============================================================================
-- BKD NTB — Pengaturan CMS (ukuran maks SOP) + kolom sop_file jika belum ada
-- phpMyAdmin: pilih database → tab SQL → paste → Go
-- =============================================================================

CREATE TABLE IF NOT EXISTS `cms_setting` (
  `kunci` varchar(100) NOT NULL,
  `nilai` text DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`kunci`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `cms_setting` (`kunci`, `nilai`)
VALUES ('sop_max_size_kb', '2048')
ON DUPLICATE KEY UPDATE `kunci` = `kunci`;

-- Abaikan error "Duplicate column" jika kolom sudah ada
ALTER TABLE `bidang_layanan`
  ADD COLUMN `sop_file` varchar(500) DEFAULT NULL AFTER `url`;

UPDATE `bidang_layanan` bl
INNER JOIN `bidang` b ON b.`id` = bl.`bidang_id`
SET bl.`sop_file` = 'download/SOP Tugas Belajar.pdf'
WHERE b.`url_slug` = 'pengembangan'
  AND bl.`url` IN ('/tugasbelajar', 'tugasbelajar')
  AND (bl.`sop_file` IS NULL OR bl.`sop_file` = '');

UPDATE `bidang_layanan` bl
INNER JOIN `bidang` b ON b.`id` = bl.`bidang_id`
SET bl.`url` = '/konseling',
    bl.`sop_file` = 'download/SOP PELAYANAN KONSELING NEW.pdf'
WHERE b.`url_slug` = 'uppk'
  AND bl.`judul` LIKE '%Konseling Psikologi%'
  AND (bl.`sop_file` IS NULL OR bl.`sop_file` = '');
