<?php

function db_project_root()
{
	return realpath(dirname(__DIR__, 2));
}

function db_load_config()
{
	$root = db_project_root();
	$configFile = $root . '/application/config/database.php';

	if (!is_file($configFile)) {
		throw new RuntimeException("Config tidak ditemukan: {$configFile}");
	}

	if (!defined('BASEPATH')) {
		define('BASEPATH', $root . '/system/');
	}
	if (!defined('ENVIRONMENT')) {
		define('ENVIRONMENT', 'production');
	}

	$db = array();
	require $configFile;

	if (empty($db['default']) || !is_array($db['default'])) {
		throw new RuntimeException('Grup database default tidak ditemukan di application/config/database.php');
	}

	return $db['default'];
}

function db_connect(array $config, $withDatabase = true)
{
	$host = $config['hostname'] ?? '127.0.0.1';
	$user = $config['username'] ?? 'root';
	$pass = $config['password'] ?? '';
	$port = isset($config['port']) ? (int) $config['port'] : 3306;
	$database = $config['database'] ?? '';

	$mysqli = new mysqli(
		$host,
		$user,
		$pass,
		$withDatabase ? $database : '',
		$port
	);

	if ($mysqli->connect_error) {
		throw new RuntimeException('Koneksi database gagal: ' . $mysqli->connect_error);
	}

	$mysqli->set_charset('utf8mb4');
	return $mysqli;
}

function db_create_database_if_needed(array $config)
{
	$database = $config['database'] ?? '';
	if ($database === '') {
		throw new RuntimeException('Nama database kosong di application/config/database.php');
	}

	$mysqli = db_connect($config, false);
	$escaped = $mysqli->real_escape_string($database);
	$sql = "CREATE DATABASE IF NOT EXISTS `{$escaped}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
	if (!$mysqli->query($sql)) {
		$error = $mysqli->error;
		$mysqli->close();
		throw new RuntimeException("Gagal membuat database `{$database}`: {$error}");
	}
	$mysqli->close();
}
