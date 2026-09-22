-- Video YouTube layanan di sidebar halaman bidang (satu kotak per bidang).
ALTER TABLE `bidang`
  ADD COLUMN `video_youtube` varchar(500) DEFAULT NULL AFTER `layanan_judul`;
