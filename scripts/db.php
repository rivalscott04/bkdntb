<?php
/**
 * Database setup & migration CLI.
 *
 * Membaca koneksi dari application/config/database.php
 *
 * Usage:
 *   php scripts/db.php migrate                 # jalankan migration baru
 *   php scripts/db.php migrate --create-db     # buat database dulu (lokal)
 *   php scripts/db.php migrate --seed          # migration + seed berita
 *   php scripts/db.php migrate --fresh-seed    # migration + seed ulang berita
 *   php scripts/db.php status                  # cek migration
 *   php scripts/db.php install                 # alias migrate --seed
 */
require_once __DIR__ . '/lib/db_config.php';
require_once __DIR__ . '/lib/migration_runner.php';

$command = $argv[1] ?? 'help';
$flags = array_slice($argv, 2);

try {
	$config = db_load_config();

	switch ($command) {
		case 'migrate':
			run_migrate($config, $flags);
			break;
		case 'status':
			run_status($config);
			break;
		case 'install':
			$flags[] = '--seed';
			run_migrate($config, $flags);
			break;
		case 'help':
		default:
			print_help();
			break;
	}
} catch (Throwable $e) {
	fwrite(STDERR, 'ERROR: ' . $e->getMessage() . PHP_EOL);
	exit(1);
}

function has_flag(array $flags, $name)
{
	return in_array($name, $flags, true);
}

function run_migrate(array $config, array $flags)
{
	if (has_flag($flags, '--create-db')) {
		echo "Membuat database `{$config['database']}` jika belum ada...\n";
		db_create_database_if_needed($config);
	}

	$mysqli = db_connect($config, true);
	echo "Terhubung ke `{$config['database']}` di {$config['hostname']}\n";

	$count = migration_run($mysqli, array(
		'dry_run' => has_flag($flags, '--dry-run'),
	));
	$mysqli->close();

	echo "Migration selesai ({$count} file dijalankan).\n";

	if (has_flag($flags, '--seed') || has_flag($flags, '--fresh-seed')) {
		run_seed($flags);
	}
}

function run_status(array $config)
{
	$mysqli = db_connect($config, true);
	migration_ensure_table($mysqli);
	$status = migration_status($mysqli);
	$mysqli->close();

	echo "Database: `{$config['database']}` @ {$config['hostname']}\n\n";

	if ($status['applied']) {
		echo "Sudah dijalankan:\n";
		foreach ($status['applied'] as $name) {
			echo "  [x] {$name}\n";
		}
		echo "\n";
	}

	if ($status['pending']) {
		echo "Belum dijalankan:\n";
		foreach ($status['pending'] as $name) {
			echo "  [ ] {$name}\n";
		}
	} else {
		echo "Semua migration sudah up to date.\n";
	}
}

function run_seed(array $flags)
{
	$seedScript = __DIR__ . '/seed_berita.php';
	if (!is_file($seedScript)) {
		throw new RuntimeException('Seeder tidak ditemukan: scripts/seed_berita.php');
	}

	echo "\nMenjalankan seed berita...\n";
	$args = array(PHP_BINARY, $seedScript);
	if (has_flag($flags, '--fresh-seed')) {
		$args[] = '--fresh';
	}

	$cmd = implode(' ', array_map('escapeshellarg', $args));
	passthru($cmd, $exitCode);
	if ($exitCode !== 0) {
		throw new RuntimeException('Seed berita gagal.');
	}
}

function print_help()
{
	echo <<<TXT
Database CLI — BKD NTB Berita CMS

Perintah:
  php scripts/db.php migrate              Jalankan migration yang belum diterapkan
  php scripts/db.php migrate --create-db Buat database dulu (untuk lokal/dev)
  php scripts/db.php migrate --seed       Migration lalu seed berita
  php scripts/db.php migrate --fresh-seed Migration lalu seed ulang semua berita
  php scripts/db.php status               Lihat status migration
  php scripts/db.php install              Migration + seed (deploy pertama)

Config dibaca dari application/config/database.php

Contoh live server:
  php scripts/db.php migrate
  php scripts/db.php migrate --seed

Contoh lokal Windows/XAMPP:
  php scripts/db.php migrate --create-db --seed

TXT;
}
