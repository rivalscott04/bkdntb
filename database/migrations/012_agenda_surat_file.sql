-- File scan/foto surat undangan agenda (gambar atau PDF), disimpan di assets/images/agenda/.
SET @db := DATABASE();

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
