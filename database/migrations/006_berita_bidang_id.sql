ALTER TABLE `berita`
  ADD COLUMN `bidang_id` int(11) DEFAULT NULL AFTER `bidang`,
  ADD KEY `idx_bidang_id` (`bidang_id`);

UPDATE `berita` b
INNER JOIN `bidang` bd ON b.`bidang` = bd.`kode`
SET b.`bidang_id` = bd.`id`;

UPDATE `berita` b
INNER JOIN `bidang` bd ON b.`bidang` = bd.`label`
SET b.`bidang_id` = bd.`id`
WHERE b.`bidang_id` IS NULL;

UPDATE `berita` b
INNER JOIN `bidang` bd ON b.`bidang_id` IS NULL
  AND bd.`aliases` IS NOT NULL
  AND FIND_IN_SET(b.`bidang`, REPLACE(bd.`aliases`, ' ', '')) > 0
SET b.`bidang_id` = bd.`id`;

UPDATE `berita` b
INNER JOIN `bidang` bd ON b.`bidang_id` = bd.`id`
SET b.`bidang` = bd.`kode`
WHERE b.`bidang` <> bd.`kode`;

ALTER TABLE `berita`
  ADD CONSTRAINT `fk_berita_bidang` FOREIGN KEY (`bidang_id`) REFERENCES `bidang` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
