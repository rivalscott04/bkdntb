<?php
/**
 * Backward-compatible wrapper.
 *
 * Usage:
 *   php scripts/setup_database.php
 *   php scripts/setup_database.php --seed
 */
$args = array(PHP_BINARY, __DIR__ . '/db.php', 'migrate', '--create-db');
if (in_array('--seed', $argv, true)) {
	$args[] = '--seed';
}

$cmd = implode(' ', array_map('escapeshellarg', $args));
passthru($cmd, $exitCode);
exit($exitCode);
