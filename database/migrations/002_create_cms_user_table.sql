CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`nama`, `username`, `password`)
SELECT 'Administrator Berita', 'admin', '$2y$10$DIqOkYw9tBMHBk6119S1bu1b2kOjsa0fJV1mjbapSiq3mtzZZlir2'
WHERE NOT EXISTS (SELECT 1 FROM `user` WHERE `username` = 'admin');
