<?php
/**
 * One-time setup (command line only):
 *   php install.php [--user=admin] [--pass=secret]
 * Creates the database and tables, loads the current website text/lists as the
 * starting content, and creates the first admin login. Safe to run again: it
 * never overwrites content you have already edited.
 */
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }

require __DIR__ . '/lib/db.php';
require __DIR__ . '/lib/content.php';

$opt = getopt('', ['user::', 'pass::']);
$cfg = app_config();

// 1. database
try {
    $root = new PDO("mysql:host={$cfg['db_host']};port={$cfg['db_port']};charset=utf8mb4", $cfg['db_user'], $cfg['db_pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $root->exec('CREATE DATABASE IF NOT EXISTS `' . str_replace('`', '', $cfg['db_name']) . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
} catch (PDOException $e) {
    fwrite(STDERR, "Cannot reach MySQL: {$e->getMessage()}\nCheck config.local.php (see config.sample.php).\n");
    exit(1);
}
$pdo = db();
foreach (array_filter(array_map('trim', explode(';', file_get_contents(__DIR__ . '/lib/schema.sql')))) as $sql) $pdo->exec($sql);
// older installs: add the column that tracks which leads reached the Google Sheet
$has = $pdo->query("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'leads' AND COLUMN_NAME = 'sheet_synced'")->fetchColumn();
if (!$has) { $pdo->exec('ALTER TABLE leads ADD COLUMN sheet_synced TINYINT(1) NOT NULL DEFAULT 0 AFTER is_read'); echo "Added leads.sheet_synced\n"; }
echo "Tables ready.\n";

// 2. starting content (only what is missing)
$n = $pdo->prepare('INSERT IGNORE INTO settings (skey, svalue) VALUES (?, ?)');
$added = 0;
foreach (setting_defaults() as $k => $v) { $n->execute([$k, $v]); $added += $n->rowCount(); }
echo "Settings added: $added\n";

$has = $pdo->prepare('SELECT COUNT(*) FROM items WHERE type = ?');
$ins = $pdo->prepare('INSERT INTO items (type, sort_order, active, data) VALUES (?, ?, 1, ?)');
foreach (content_def()['lists'] as $type => $list) {
    $has->execute([$type]);
    if ((int) $has->fetchColumn() > 0) continue;
    foreach ($list['items'] as $i => $row) $ins->execute([$type, ($i + 1) * 10, json_encode($row, JSON_UNESCAPED_UNICODE)]);
    echo "List '$type': " . count($list['items']) . " rows added\n";
}

// 3. admin login
$user = $opt['user'] ?? 'admin';
$exists = $pdo->prepare('SELECT id FROM admins WHERE username = ?');
$exists->execute([$user]);
if ($exists->fetch()) {
    echo "Admin '$user' already exists (not changed).\n";
} else {
    $generated = !isset($opt['pass']);
    $pass = $opt['pass'] ?? substr(bin2hex(random_bytes(8)), 0, 12);
    $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (?, ?)')->execute([$user, password_hash($pass, PASSWORD_DEFAULT)]);
    echo "Admin created. Username: $user   Password: $pass" . ($generated ? '   (change it after logging in)' : '') . "\n";
}
echo "Done. Admin panel: /admin/\n";
