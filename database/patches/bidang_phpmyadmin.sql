-- =============================================================================
-- BKD NTB — Setup tabel `bidang` (gabungan 003 + 004 + 005)
-- phpMyAdmin: pilih database → tab SQL → paste → Go
-- =============================================================================


-- =============================================================================
-- BLOK A — INSTALASI BARU (belum ada tabel `bidang`)
-- Copas & jalankan blok ini saja.
-- =============================================================================

CREATE TABLE IF NOT EXISTS `bidang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(100) NOT NULL,
  `label` varchar(255) NOT NULL,
  `judul_halaman` varchar(255) DEFAULT NULL,
  `subjudul` varchar(255) DEFAULT NULL,
  `kepala_judul` varchar(255) DEFAULT NULL,
  `kepala_nama` varchar(255) DEFAULT NULL,
  `kepala_nip` varchar(50) DEFAULT NULL,
  `kepala_foto` varchar(255) DEFAULT NULL,
  `layanan_judul` varchar(255) DEFAULT NULL,
  `ringkasan_tugas_judul` varchar(255) DEFAULT NULL,
  `filter_class` varchar(50) DEFAULT NULL,
  `url_slug` varchar(100) NOT NULL,
  `aliases` text DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`),
  UNIQUE KEY `url_slug` (`url_slug`),
  KEY `idx_urutan` (`urutan`),
  KEY `idx_aktif` (`aktif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `bidang` (
  `kode`, `label`, `judul_halaman`, `subjudul`,
  `kepala_judul`, `kepala_nama`, `kepala_nip`, `kepala_foto`,
  `layanan_judul`, `ringkasan_tugas_judul`, `filter_class`,
  `url_slug`, `aliases`, `urutan`, `aktif`
) VALUES
(
  'Sekretariat', 'Sekretariat',
  'Sekretariat BKD NTB', 'PPID BKD Provinsi NTB',
  'Sekretaris Badan', 'Ida Bagus Arnawa, SE', '197406121993031003', 'images/team/sekban.png',
  NULL, 'Ringkasan Tugas - Sekretaris Badan', 'sek',
  'sekretariat', NULL, 1, 1
),
(
  'PPI', 'Pengadaan, Pemberhentian & Informasi (PPI)',
  'Bidang PPI', '(Pengadaan, Pemberhentian & Informasi)',
  'Kepala Bidang PPI', 'Rusdi Bahalwan, S.Adm.,M.E', '197704152011011004', 'images/team/ppi.png',
  'Layanan Bidang PPI', 'Ringkasan Tugas - Kepala Bidang Pengadaan, Pemberhentian & Informasi (PPI)', 'ppi',
  'ppi', NULL, 2, 1
),
(
  'Mutasi & Promosi', 'Mutasi & Promosi',
  'Bidang Mutasi & Promosi', 'BKD Provinsi Nusa Tenggara Barat',
  'Kepala Bidang Mutasi & Promosi', 'Savitri, S.T, M.Eng', '198112032005012010', 'images/team/savitri-min66.png',
  'Layanan Bidang Mutasi', 'Ringkasan Tugas - Kepala Bidang Mutasi & Promosi', 'mutasi',
  'mutasi', 'Mutasi', 3, 1
),
(
  'Pengembangan Aparatur', 'Pengembangan Aparatur',
  'Bidang Pengembangan Aparatur', 'BKD Provinsi Nusa Tenggara Barat',
  'Kepala Bidang Pengembangan Aparatur', 'Akhmad Fajar Karya', '197106161998031008', 'images/team/fajar.png',
  'Layanan Bidang Pengembangan', 'Ringkasan Tugas - Kepala Bidang Pengembangan Aparatur', 'pengembangan',
  'pengembangan', NULL, 4, 1
),
(
  'Penilaian Kinerja Aparatur & Penghargaan', 'Penilaian Kinerja Aparatur & Penghargaan',
  'Bidang Penilaian Kinerja & Penghargaan', 'BKD Provinsi Nusa Tenggara Barat',
  'Kepala Bidang Penilaian Kinerja & Penghargaan', 'Sry Wahyuningsih, S.STP, M.H.', '198106281999122001', 'images/team/mbsryevaluasi.png',
  'Layanan Bidang Penilaian Kinerja & Penghargaan', 'Ringkasan Tugas - Kepala Bidang Penilaian Kinerja Aparatur & Penghargaan', 'penilaian',
  'evaluasi', 'PKAP,Penilaian Kinerja Aparatur dan Penghargaan', 5, 1
),
(
  'UPTB UPPK', 'UPTB UPPK',
  'UPTB UPPK', 'Unit Pelayanan Penilaian Kompetensi',
  'Kepala UPTB UPPK', 'Erwin Rahadi, S.Psi.,MM', '197403081999031010', 'images/team/erwin-min.png',
  'Layanan UPTB UPPK', NULL, 'uppk',
  'uppk', 'UPPK', 6, 1
)
ON DUPLICATE KEY UPDATE
  `label` = VALUES(`label`),
  `judul_halaman` = VALUES(`judul_halaman`),
  `subjudul` = VALUES(`subjudul`),
  `kepala_judul` = VALUES(`kepala_judul`),
  `kepala_nama` = VALUES(`kepala_nama`),
  `kepala_nip` = VALUES(`kepala_nip`),
  `kepala_foto` = VALUES(`kepala_foto`),
  `layanan_judul` = VALUES(`layanan_judul`),
  `ringkasan_tugas_judul` = VALUES(`ringkasan_tugas_judul`),
  `filter_class` = VALUES(`filter_class`),
  `url_slug` = VALUES(`url_slug`),
  `aliases` = VALUES(`aliases`),
  `urutan` = VALUES(`urutan`),
  `aktif` = VALUES(`aktif`);

UPDATE `berita`
SET `bidang` = 'Penilaian Kinerja Aparatur & Penghargaan'
WHERE `bidang` IN ('PKAP', 'Penilaian Kinerja Aparatur dan Penghargaan');

UPDATE `berita`
SET `bidang` = 'Mutasi & Promosi'
WHERE `bidang` = 'Mutasi';

UPDATE `berita`
SET `bidang` = 'UPTB UPPK'
WHERE `bidang` = 'UPPK';


-- =============================================================================
-- BLOK B — UPGRADE (sudah punya tabel `bidang` versi lama tanpa kolom baru)
-- Jalankan BLOK B saja (jangan jalankan CREATE di Blok A lagi).
-- Abaikan error "Duplicate column name" untuk kolom yang sudah ada.
-- =============================================================================

/*
ALTER TABLE `bidang`
  ADD COLUMN `aliases` text DEFAULT NULL AFTER `url_slug`;

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

-- Setelah ALTER, jalankan lagi INSERT ... ON DUPLICATE KEY UPDATE
-- dan UPDATE berita dari Blok A di atas.
*/
