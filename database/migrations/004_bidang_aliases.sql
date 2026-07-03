ALTER TABLE `bidang`
  ADD COLUMN `aliases` text DEFAULT NULL AFTER `url_slug`;

UPDATE `bidang`
SET `aliases` = 'PKAP,Penilaian Kinerja Aparatur dan Penghargaan'
WHERE `kode` = 'Penilaian Kinerja Aparatur & Penghargaan';

UPDATE `bidang`
SET `aliases` = 'Mutasi'
WHERE `kode` = 'Mutasi & Promosi';

UPDATE `bidang`
SET `aliases` = 'UPPK'
WHERE `kode` = 'UPTB UPPK';

UPDATE `berita`
SET `bidang` = 'Penilaian Kinerja Aparatur & Penghargaan'
WHERE `bidang` IN ('PKAP', 'Penilaian Kinerja Aparatur dan Penghargaan');

UPDATE `berita`
SET `bidang` = 'Mutasi & Promosi'
WHERE `bidang` = 'Mutasi';

UPDATE `berita`
SET `bidang` = 'UPTB UPPK'
WHERE `bidang` = 'UPPK';
