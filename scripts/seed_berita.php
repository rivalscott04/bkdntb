<?php
/**
 * Seed berita dari data statis lama (views HTML + arsip manual).
 *
 * Usage:
 *   php scripts/seed_berita.php          # insert yang belum ada (by slug)
 *   php scripts/seed_berita.php --fresh  # hapus semua berita lalu seed ulang
 */
require __DIR__ . '/lib/db_config.php';
require __DIR__ . '/../database/seeds/Berita_html_parser.php';

if (!defined('BASEPATH')) {
	define('BASEPATH', realpath(__DIR__ . '/../system/') . '/');
}
if (!defined('APPPATH')) {
	define('APPPATH', realpath(__DIR__ . '/../application/') . '/');
}
require APPPATH . 'helpers/berita_helper.php';

$fresh = in_array('--fresh', $argv, true);

$config = db_load_config();
$mysqli = db_connect($config, true);

if ($fresh) {
	$mysqli->query('DELETE FROM berita');
	echo "Tabel berita dikosongkan.\n";
}

$sources = array(
	array('file' => __DIR__ . '/../database/seeds/sources/sekretariat.html', 'bidang' => 'Sekretariat'),
	array('file' => __DIR__ . '/../database/seeds/sources/uppk.html', 'bidang' => 'UPTB UPPK'),
	array('file' => __DIR__ . '/../application/views/hoaks.php', 'bidang' => 'PPI', 'view' => true),
);

$all = array();

foreach ($sources as $src) {
	if (!empty($src['view'])) {
		$rows = Berita_html_parser::parse_view_file($src['file'], $src['bidang']);
	} else {
		$rows = Berita_html_parser::parse_file($src['file'], $src['bidang']);
	}
	echo 'Parsed ' . basename($src['file']) . ': ' . count($rows) . " artikel\n";
	$all = array_merge($all, $rows);
}

$manual = require __DIR__ . '/../database/seeds/berita_manual.php';
echo 'Manual entries: ' . count($manual) . " artikel\n";
$all = array_merge($all, $manual);

$inserted = 0;
$skipped = 0;

foreach ($all as $row) {
	$slug = buat_slug($row['judul_berita']);
	$base = $slug;
	$i = 1;
	while (slug_exists($mysqli, $slug)) {
		$existing = get_by_slug($mysqli, $slug);
		if ($existing && $existing['judul_berita'] === $row['judul_berita']) {
			$skipped++;
			continue 2;
		}
		$slug = $base . '-' . $i;
		$i++;
	}

	$stmt = $mysqli->prepare(
		'INSERT INTO berita (judul_berita, slug, isi_berita, penulis, tanggal, gambar_berita, bidang, status)
		 VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
	);
	$stmt->bind_param(
		'ssssssss',
		$row['judul_berita'],
		$slug,
		$row['isi_berita'],
		$row['penulis'],
		$row['tanggal'],
		$row['gambar_berita'],
		$row['bidang'],
		$row['status']
	);
	if ($stmt->execute()) {
		$inserted++;
		echo "  + {$row['judul_berita']}\n";
	}
	$stmt->close();
}

$res = $mysqli->query('SELECT COUNT(*) c FROM berita');
$total = $res->fetch_assoc()['c'];
$mysqli->close();

echo "\nSelesai: {$inserted} ditambahkan, {$skipped} dilewati (sudah ada).\n";
echo "Total berita di database: {$total}\n";

function slug_exists($mysqli, $slug)
{
	$stmt = $mysqli->prepare('SELECT id FROM berita WHERE slug = ? LIMIT 1');
	$stmt->bind_param('s', $slug);
	$stmt->execute();
	$res = $stmt->get_result();
	$row = $res->fetch_assoc();
	$stmt->close();
	return (bool) $row;
}

function get_by_slug($mysqli, $slug)
{
	$stmt = $mysqli->prepare('SELECT judul_berita FROM berita WHERE slug = ? LIMIT 1');
	$stmt->bind_param('s', $slug);
	$stmt->execute();
	$res = $stmt->get_result();
	$row = $res->fetch_assoc();
	$stmt->close();
	return $row;
}
