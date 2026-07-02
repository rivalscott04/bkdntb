<?php

require_once __DIR__ . '/db_config.php';

function migration_dir()
{
	return db_project_root() . '/database/migrations';
}

function migration_bootstrap_sql()
{
	return <<<'SQL'
CREATE TABLE IF NOT EXISTS `_migrations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `applied_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `migration` (`migration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
}

function migration_execute_sql(mysqli $mysqli, $sql, $label)
{
	if ($mysqli->multi_query($sql)) {
		do {
			if ($result = $mysqli->store_result()) {
				$result->free();
			}
		} while ($mysqli->more_results() && $mysqli->next_result());
	}

	if ($mysqli->error) {
		throw new RuntimeException("Migration {$label} gagal: {$mysqli->error}");
	}
}

function migration_ensure_table(mysqli $mysqli)
{
	migration_execute_sql($mysqli, migration_bootstrap_sql(), '_migrations');
}

function migration_list_files()
{
	$dir = migration_dir();
	if (!is_dir($dir)) {
		return array();
	}

	$files = glob($dir . '/*.sql');
	sort($files, SORT_STRING);
	return $files ?: array();
}

function migration_applied_map(mysqli $mysqli)
{
	$map = array();
	$result = $mysqli->query('SELECT migration FROM `_migrations` ORDER BY id ASC');
	if (!$result) {
		throw new RuntimeException('Gagal membaca tabel _migrations: ' . $mysqli->error);
	}

	while ($row = $result->fetch_assoc()) {
		$map[$row['migration']] = true;
	}
	$result->free();

	return $map;
}

function migration_status(mysqli $mysqli)
{
	$applied = migration_applied_map($mysqli);
	$files = migration_list_files();
	$pending = array();
	$done = array();

	foreach ($files as $file) {
		$name = basename($file);
		if (isset($applied[$name])) {
			$done[] = $name;
		} else {
			$pending[] = $name;
		}
	}

	return array(
		'applied' => $done,
		'pending' => $pending,
	);
}

function migration_run(mysqli $mysqli, $options = array())
{
	$dryRun = !empty($options['dry_run']);
	migration_ensure_table($mysqli);

	$applied = migration_applied_map($mysqli);
	$files = migration_list_files();
	$executed = 0;

	foreach ($files as $file) {
		$name = basename($file);
		if (isset($applied[$name])) {
			continue;
		}

		echo ($dryRun ? '[dry-run] ' : '') . "Running {$name}...\n";

		if ($dryRun) {
			$executed++;
			continue;
		}

		$sql = file_get_contents($file);
		if ($sql === false || trim($sql) === '') {
			throw new RuntimeException("File migration kosong: {$name}");
		}

		migration_execute_sql($mysqli, $sql, $name);

		$stmt = $mysqli->prepare('INSERT INTO `_migrations` (`migration`) VALUES (?)');
		$stmt->bind_param('s', $name);
		if (!$stmt->execute()) {
			throw new RuntimeException("Gagal mencatat migration {$name}: {$stmt->error}");
		}
		$stmt->close();

		echo "  OK {$name}\n";
		$executed++;
	}

	if ($executed === 0) {
		echo "Tidak ada migration baru.\n";
	}

	return $executed;
}
