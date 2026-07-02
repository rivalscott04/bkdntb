-- Bootstrap untuk database baru (lokal/dev).
-- Database live bkdntbprov_admin: pakai database/patches/bkdntbprov_admin_berita_cms.sql
-- Atau: php scripts/db.php migrate

CREATE DATABASE IF NOT EXISTS `bkdntbprov_admin` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bkdntbprov_admin`;

SOURCE database/migrations/001_create_berita_table.sql;
SOURCE database/migrations/002_create_cms_user_table.sql;
