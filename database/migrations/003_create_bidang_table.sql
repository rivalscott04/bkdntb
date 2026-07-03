CREATE TABLE IF NOT EXISTS `bidang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(100) NOT NULL,
  `label` varchar(255) NOT NULL,
  `url_slug` varchar(100) NOT NULL,
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

INSERT INTO `bidang` (`kode`, `label`, `url_slug`, `urutan`, `aktif`) VALUES
('Sekretariat', 'Sekretariat', 'sekretariat', 1, 1),
('PPI', 'Pengadaan, Pemberhentian & Informasi (PPI)', 'ppi', 2, 1),
('Mutasi & Promosi', 'Mutasi & Promosi', 'mutasi', 3, 1),
('Pengembangan Aparatur', 'Pengembangan Aparatur', 'pengembangan', 4, 1),
('Penilaian Kinerja Aparatur & Penghargaan', 'Penilaian Kinerja Aparatur & Penghargaan', 'evaluasi', 5, 1),
('UPTB UPPK', 'UPTB UPPK', 'uppk', 6, 1);
