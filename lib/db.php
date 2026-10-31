<?php
/** Shared PDO connection (lazy). Throws PDOException when the database is unreachable. */
function app_config(): array
{
    static $cfg;
    return $cfg ??= require dirname(__DIR__) . '/config.php';
}

function db(): PDO
{
    static $pdo;
    if ($pdo) return $pdo;
    $c = app_config();
    $dsn = "mysql:host={$c['db_host']};port={$c['db_port']};dbname={$c['db_name']};charset=utf8mb4";
    return $pdo = new PDO($dsn, $c['db_user'], $c['db_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}
