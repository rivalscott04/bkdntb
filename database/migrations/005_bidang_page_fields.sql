ALTER TABLE `bidang`
  ADD COLUMN `judul_halaman` varchar(255) DEFAULT NULL AFTER `label`,
  ADD COLUMN `subjudul` varchar(255) DEFAULT NULL AFTER `judul_halaman`,
  ADD COLUMN `kepala_judul` varchar(255) DEFAULT NULL AFTER `subjudul`,
  ADD COLUMN `kepala_nama` varchar(255) DEFAULT NULL AFTER `kepala_judul`,
  ADD COLUMN `kepala_nip` varchar(50) DEFAULT NULL AFTER `kepala_nama`,
  ADD COLUMN `kepala_foto` varchar(255) DEFAULT NULL AFTER `kepala_nip`,
  ADD COLUMN `layanan_judul` varchar(255) DEFAULT NULL AFTER `kepala_foto`,
  ADD COLUMN `ringkasan_tugas_judul` varchar(255) DEFAULT NULL AFTER `layanan_judul`,
  ADD COLUMN `filter_class` varchar(50) DEFAULT NULL AFTER `ringkasan_tugas_judul`;

UPDATE `bidang` SET
  `judul_halaman` = 'Sekretariat BKD NTB',
  `subjudul` = 'PPID BKD Provinsi NTB',
  `kepala_judul` = 'Sekretaris Badan',
  `kepala_nama` = 'Ida Bagus Arnawa, SE',
  `kepala_nip` = '197406121993031003',
  `kepala_foto` = 'images/team/sekban.png',
  `ringkasan_tugas_judul` = 'Ringkasan Tugas - Sekretaris Badan',
  `filter_class` = 'sek'
WHERE `kode` = 'Sekretariat';

UPDATE `bidang` SET
  `judul_halaman` = 'Bidang PPI',
  `subjudul` = '(Pengadaan, Pemberhentian & Informasi)',
  `kepala_judul` = 'Kepala Bidang PPI',
  `kepala_nama` = 'Rusdi Bahalwan, S.Adm.,M.E',
  `kepala_nip` = '197704152011011004',
  `kepala_foto` = 'images/team/ppi.png',
  `layanan_judul` = 'Layanan Bidang PPI',
  `ringkasan_tugas_judul` = 'Ringkasan Tugas - Kepala Bidang Pengadaan, Pemberhentian & Informasi (PPI)',
  `filter_class` = 'ppi'
WHERE `kode` = 'PPI';

UPDATE `bidang` SET
  `judul_halaman` = 'Bidang Mutasi & Promosi',
  `subjudul` = 'BKD Provinsi Nusa Tenggara Barat',
  `kepala_judul` = 'Kepala Bidang Mutasi & Promosi',
  `kepala_nama` = 'Savitri, S.T, M.Eng',
  `kepala_nip` = '198112032005012010',
  `kepala_foto` = 'images/team/savitri-min66.png',
  `layanan_judul` = 'Layanan Bidang Mutasi',
  `ringkasan_tugas_judul` = 'Ringkasan Tugas - Kepala Bidang Mutasi & Promosi',
  `filter_class` = 'mutasi'
WHERE `kode` = 'Mutasi & Promosi';

UPDATE `bidang` SET
  `judul_halaman` = 'Bidang Pengembangan Aparatur',
  `subjudul` = 'BKD Provinsi Nusa Tenggara Barat',
  `kepala_judul` = 'Kepala Bidang Pengembangan Aparatur',
  `kepala_nama` = 'Akhmad Fajar Karya',
  `kepala_nip` = '197106161998031008',
  `kepala_foto` = 'images/team/fajar.png',
  `layanan_judul` = 'Layanan Bidang Pengembangan',
  `ringkasan_tugas_judul` = 'Ringkasan Tugas - Kepala Bidang Pengembangan Aparatur',
  `filter_class` = 'pengembangan'
WHERE `kode` = 'Pengembangan Aparatur';

UPDATE `bidang` SET
  `judul_halaman` = 'Bidang Penilaian Kinerja & Penghargaan',
  `subjudul` = 'BKD Provinsi Nusa Tenggara Barat',
  `kepala_judul` = 'Kepala Bidang Penilaian Kinerja & Penghargaan',
  `kepala_nama` = 'Sry Wahyuningsih, S.STP, M.H.',
  `kepala_nip` = '198106281999122001',
  `kepala_foto` = 'images/team/mbsryevaluasi.png',
  `layanan_judul` = 'Layanan Bidang Penilaian Kinerja & Penghargaan',
  `ringkasan_tugas_judul` = 'Ringkasan Tugas - Kepala Bidang Penilaian Kinerja Aparatur & Penghargaan',
  `filter_class` = 'penilaian'
WHERE `kode` = 'Penilaian Kinerja Aparatur & Penghargaan';

UPDATE `bidang` SET
  `judul_halaman` = 'UPTB UPPK',
  `subjudul` = 'Unit Pelayanan Penilaian Kompetensi',
  `kepala_judul` = 'Kepala UPTB UPPK',
  `kepala_nama` = 'Erwin Rahadi, S.Psi.,MM',
  `kepala_nip` = '197403081999031010',
  `kepala_foto` = 'images/team/erwin-min.png',
  `layanan_judul` = 'Layanan UPTB UPPK',
  `filter_class` = 'uppk'
WHERE `kode` = 'UPTB UPPK';
