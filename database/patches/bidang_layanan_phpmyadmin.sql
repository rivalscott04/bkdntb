-- =============================================================================
-- BKD NTB — Tabel `bidang_layanan` (menu layanan sidebar per bidang) + sop_file
-- phpMyAdmin: pilih database → tab SQL → paste → Go
-- Prasyarat: tabel `bidang` sudah ada.
-- Aman dijalankan ulang: seed hanya diisi jika bidang belum punya layanan.
-- =============================================================================

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
  KEY `idx_aktif` (`aktif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Jika tabel sudah ada tanpa kolom sop_file, jalankan baris ini (abaikan error Duplicate column):
-- ALTER TABLE `bidang_layanan` ADD COLUMN `sop_file` varchar(500) DEFAULT NULL AFTER `url`;

INSERT INTO `bidang_layanan` (`bidang_id`, `judul`, `judul_overlay`, `url`, `sop_file`, `urutan`, `aktif`)
SELECT b.`id`, v.`judul`, v.`judul_overlay`, v.`url`, v.`sop_file`, v.`urutan`, 1
FROM `bidang` b
INNER JOIN (
  SELECT 'ppi' AS slug, 'Perencanaan Kebutuhan ASN' AS judul, 'Perencanaan Kebutuhan ASN' AS judul_overlay, 'https://asndigital.bkn.go.id/' AS url, NULL AS sop_file, 1 AS urutan
  UNION ALL SELECT 'ppi', 'Seleksi Pengadaan ASN', 'Seleksi Pengadaan ASN', '/rekrutmen', NULL, 2
  UNION ALL SELECT 'ppi', 'Pengurusan KARIS, KARPEG & KARSU', 'Pengurusan Kartu ASN', '/karpeg', NULL, 3
  UNION ALL SELECT 'ppi', 'Pemberhentian & Pensiun ASN', 'Pemberhentian & Pensiun', '/pensiun', NULL, 4
  UNION ALL SELECT 'ppi', 'Data & Informasi Kepegawaian', 'Data & Informasi', 'https://asndigital.bkn.go.id/', NULL, 5
  UNION ALL SELECT 'mutasi', 'Kenaikan Pangkat', 'Kenaikan Pangkat', '/kenaikanpangkat', NULL, 1
  UNION ALL SELECT 'mutasi', 'Ujian Dinas', 'Ujian Dinas', '#', NULL, 2
  UNION ALL SELECT 'mutasi', 'Peninjauan Masa Kerja', 'Masa Kerja', '#', NULL, 3
  UNION ALL SELECT 'mutasi', 'Mutasi & Promosi ASN', 'Mutasi & Promosi', '/layananmutasi', NULL, 4
  UNION ALL SELECT 'mutasi', 'Penerbitan Plt/Plh', 'Penerbitan Plt/Plh', '#', NULL, 5
  UNION ALL SELECT 'pengembangan', 'Izin Tugas Belajar', 'Tugas Belajar', '/tugasbelajar', 'download/SOP Tugas Belajar.pdf', 1
  UNION ALL SELECT 'pengembangan', 'Permohonan Formasi JF', 'Formasi JF', '#', NULL, 2
  UNION ALL SELECT 'pengembangan', 'Penerbitan SK JF', 'Penerbitan SK JF', '#', NULL, 3
  UNION ALL SELECT 'pengembangan', 'Uji Kompetensi JF', 'Uji Kompetensi JF', '#', NULL, 4
  UNION ALL SELECT 'pengembangan', 'Pencantuman Gelar', 'Pencantuman Gelar', '#', NULL, 5
  UNION ALL SELECT 'evaluasi', 'Pengajuan Cuti ASN', 'Pengajuan Cuti', '/pengajuancuti', NULL, 1
  UNION ALL SELECT 'evaluasi', 'E-Kinerja & E-Sensi', 'Ekin & Esensi', 'https://asndigital.bkn.go.id/', NULL, 2
  UNION ALL SELECT 'evaluasi', 'Izin Perkawinan, Cerai & Poligami', 'Izin Perkawinan', '/kawin', NULL, 3
  UNION ALL SELECT 'evaluasi', 'Kasus Disiplin ASN', 'Disiplin ASN', '/disiplin', NULL, 4
  UNION ALL SELECT 'evaluasi', 'Satya Lencana Karya Satya', 'Satya Lencana Karya Satya', '#', NULL, 5
  UNION ALL SELECT 'uppk', 'Penilaian Kompetensi', 'Penilaian Kompetensi', '#', NULL, 1
  UNION ALL SELECT 'uppk', 'Konseling Karir ASN', 'Konseling Karir ASN', '#', NULL, 2
  UNION ALL SELECT 'uppk', 'Konseling Psikologi ASN', 'Konseling Psikologi ASN', '/konseling', 'download/SOP PELAYANAN KONSELING NEW.pdf', 3
) v ON v.slug = b.`url_slug`
WHERE NOT EXISTS (
  SELECT 1 FROM `bidang_layanan` bl WHERE bl.`bidang_id` = b.`id`
);
