-- =============================================================================
-- BKD NTB — Kolom sop_file pada bidang_layanan + seed SOP yang sudah ada
-- phpMyAdmin: pilih database → tab SQL → paste → Go
-- Aman jika kolom sudah ada: lewati error "Duplicate column" lalu jalankan UPDATE.
-- =============================================================================

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
