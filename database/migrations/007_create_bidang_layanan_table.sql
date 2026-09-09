CREATE TABLE IF NOT EXISTS `bidang_layanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bidang_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `judul_overlay` varchar(255) DEFAULT NULL,
  `url` varchar(500) NOT NULL DEFAULT '#',
  `sop_file` varchar(500) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_bidang_id` (`bidang_id`),
  KEY `idx_urutan` (`urutan`),
  KEY `idx_aktif` (`aktif`),
  CONSTRAINT `fk_bidang_layanan_bidang`
    FOREIGN KEY (`bidang_id`) REFERENCES `bidang` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed: PPI
INSERT INTO `bidang_layanan` (`bidang_id`, `judul`, `judul_overlay`, `url`, `urutan`, `aktif`)
SELECT `id`, 'Perencanaan Kebutuhan ASN', 'Perencanaan Kebutuhan ASN', 'https://asndigital.bkn.go.id/', 1, 1 FROM `bidang` WHERE `url_slug` = 'ppi'
UNION ALL
SELECT `id`, 'Seleksi Pengadaan ASN', 'Seleksi Pengadaan ASN', '/rekrutmen', 2, 1 FROM `bidang` WHERE `url_slug` = 'ppi'
UNION ALL
SELECT `id`, 'Pengurusan KARIS, KARPEG & KARSU', 'Pengurusan Kartu ASN', '/karpeg', 3, 1 FROM `bidang` WHERE `url_slug` = 'ppi'
UNION ALL
SELECT `id`, 'Pemberhentian & Pensiun ASN', 'Pemberhentian & Pensiun', '/pensiun', 4, 1 FROM `bidang` WHERE `url_slug` = 'ppi'
UNION ALL
SELECT `id`, 'Data & Informasi Kepegawaian', 'Data & Informasi', 'https://asndigital.bkn.go.id/', 5, 1 FROM `bidang` WHERE `url_slug` = 'ppi';

-- Seed: Mutasi & Promosi
INSERT INTO `bidang_layanan` (`bidang_id`, `judul`, `judul_overlay`, `url`, `urutan`, `aktif`)
SELECT `id`, 'Kenaikan Pangkat', 'Kenaikan Pangkat', '/kenaikanpangkat', 1, 1 FROM `bidang` WHERE `url_slug` = 'mutasi'
UNION ALL
SELECT `id`, 'Ujian Dinas', 'Ujian Dinas', '#', 2, 1 FROM `bidang` WHERE `url_slug` = 'mutasi'
UNION ALL
SELECT `id`, 'Peninjauan Masa Kerja', 'Masa Kerja', '#', 3, 1 FROM `bidang` WHERE `url_slug` = 'mutasi'
UNION ALL
SELECT `id`, 'Mutasi & Promosi ASN', 'Mutasi & Promosi', '/layananmutasi', 4, 1 FROM `bidang` WHERE `url_slug` = 'mutasi'
UNION ALL
SELECT `id`, 'Penerbitan Plt/Plh', 'Penerbitan Plt/Plh', '#', 5, 1 FROM `bidang` WHERE `url_slug` = 'mutasi';

-- Seed: Pengembangan Aparatur
INSERT INTO `bidang_layanan` (`bidang_id`, `judul`, `judul_overlay`, `url`, `urutan`, `aktif`)
SELECT `id`, 'Izin Tugas Belajar', 'Tugas Belajar', '/tugasbelajar', 1, 1 FROM `bidang` WHERE `url_slug` = 'pengembangan'
UNION ALL
SELECT `id`, 'Permohonan Formasi JF', 'Formasi JF', '#', 2, 1 FROM `bidang` WHERE `url_slug` = 'pengembangan'
UNION ALL
SELECT `id`, 'Penerbitan SK JF', 'Penerbitan SK JF', '#', 3, 1 FROM `bidang` WHERE `url_slug` = 'pengembangan'
UNION ALL
SELECT `id`, 'Uji Kompetensi JF', 'Uji Kompetensi JF', '#', 4, 1 FROM `bidang` WHERE `url_slug` = 'pengembangan'
UNION ALL
SELECT `id`, 'Pencantuman Gelar', 'Pencantuman Gelar', '#', 5, 1 FROM `bidang` WHERE `url_slug` = 'pengembangan';

-- Seed: Penilaian Kinerja (evaluasi)
INSERT INTO `bidang_layanan` (`bidang_id`, `judul`, `judul_overlay`, `url`, `urutan`, `aktif`)
SELECT `id`, 'Pengajuan Cuti ASN', 'Pengajuan Cuti', '/pengajuancuti', 1, 1 FROM `bidang` WHERE `url_slug` = 'evaluasi'
UNION ALL
SELECT `id`, 'E-Kinerja & E-Sensi', 'Ekin & Esensi', 'https://asndigital.bkn.go.id/', 2, 1 FROM `bidang` WHERE `url_slug` = 'evaluasi'
UNION ALL
SELECT `id`, 'Izin Perkawinan, Cerai & Poligami', 'Izin Perkawinan', '/kawin', 3, 1 FROM `bidang` WHERE `url_slug` = 'evaluasi'
UNION ALL
SELECT `id`, 'Kasus Disiplin ASN', 'Disiplin ASN', '/disiplin', 4, 1 FROM `bidang` WHERE `url_slug` = 'evaluasi'
UNION ALL
SELECT `id`, 'Satya Lencana Karya Satya', 'Satya Lencana Karya Satya', '#', 5, 1 FROM `bidang` WHERE `url_slug` = 'evaluasi';

-- Seed: UPTB UPPK
INSERT INTO `bidang_layanan` (`bidang_id`, `judul`, `judul_overlay`, `url`, `urutan`, `aktif`)
SELECT `id`, 'Penilaian Kompetensi', 'Penilaian Kompetensi', '#', 1, 1 FROM `bidang` WHERE `url_slug` = 'uppk'
UNION ALL
SELECT `id`, 'Konseling Karir ASN', 'Konseling Karir ASN', '#', 2, 1 FROM `bidang` WHERE `url_slug` = 'uppk'
UNION ALL
SELECT `id`, 'Konseling Psikologi ASN', 'Konseling Psikologi ASN', '#', 3, 1 FROM `bidang` WHERE `url_slug` = 'uppk';
