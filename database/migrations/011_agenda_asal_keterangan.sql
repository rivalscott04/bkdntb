-- Kolom dari tampilan agenda publik: asal surat/undangan dan keterangan.
ALTER TABLE `agenda`
  ADD COLUMN `asal_surat` varchar(255) DEFAULT NULL AFTER `kegiatan`,
  ADD COLUMN `keterangan` varchar(500) DEFAULT NULL AFTER `tempat`;
