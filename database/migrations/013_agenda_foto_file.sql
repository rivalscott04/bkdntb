-- Foto kegiatan agenda (gambar), disimpan di assets/images/agenda/.
-- Di halaman publik hanya ditampilkan sebagai tautan, tanpa thumbnail.
SET @db := DATABASE();

SET @sql := (
  SELECT IF(
    COUNT(*) = 0,
    'ALTER TABLE `agenda` ADD COLUMN `foto_file` varchar(255) DEFAULT NULL AFTER `surat_file`',
    'SELECT 1'
  )
  FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = @db AND TABLE_NAME = 'agenda' AND COLUMN_NAME = 'foto_file'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
