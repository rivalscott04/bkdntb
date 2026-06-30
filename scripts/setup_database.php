<?php
/**
 * Setup database berita + user tables.
 * Usage: php scripts/setup_database.php
 */
$sqlFile = dirname(__DIR__) . '/database/setup.sql';
if (!file_exists($sqlFile)) {
    fwrite(STDERR, "SQL file not found: {$sqlFile}\n");
    exit(1);
}

$mysqli = new mysqli('127.0.0.1', 'root', '', '', 3306);
if ($mysqli->connect_error) {
    fwrite(STDERR, "Connection failed: {$mysqli->connect_error}\n");
    exit(1);
}

$sql = file_get_contents($sqlFile);
if ($mysqli->multi_query($sql)) {
    do {
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());
}

if ($mysqli->error) {
    fwrite(STDERR, "Error: {$mysqli->error}\n");
    exit(1);
}

$mysqli->select_db('berita');
$tables = $mysqli->query("SHOW TABLES");
echo "Database setup OK\n";
while ($row = $tables->fetch_row()) {
    echo "  - {$row[0]}\n";
}

$mysqli->close();
exit(0);
