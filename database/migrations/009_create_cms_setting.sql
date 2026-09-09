CREATE TABLE IF NOT EXISTS `cms_setting` (
  `kunci` varchar(100) NOT NULL,
  `nilai` text DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`kunci`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `cms_setting` (`kunci`, `nilai`)
VALUES ('sop_max_size_kb', '2048')
ON DUPLICATE KEY UPDATE `kunci` = `kunci`;
