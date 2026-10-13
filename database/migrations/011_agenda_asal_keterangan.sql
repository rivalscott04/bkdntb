-- Kolom dari tampilan agenda publik: asal surat/undangan dan keterangan.
-- Dicek dulu karena patch phpMyAdmin agenda sudah bisa menambahkan kolom ini.
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
