<?php
/** Shared admin bootstrap: session, login check, CSRF, upload helper, page layout. */
require_once dirname(__DIR__) . '/lib/bootstrap.php';

session_name('brix_admin');
session_set_cookie_params(['lifetime' => 0, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS'])]);
session_start();

header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

function require_login(): void
{
    if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
}

function csrf_token(): string
{
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(16));
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . h(csrf_token()) . '">';
}

function check_csrf(): void
{
    if (!hash_equals(csrf_token(), (string) ($_POST['csrf'] ?? ''))) { http_response_code(400); exit('Session expired. Go back, reload the page and try again.'); }
}

function flash(?string $msg = null, string $type = 'ok')
{
    if ($msg !== null) { $_SESSION['flash'] = [$msg, $type]; return null; }
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

/** Save an uploaded image into /uploads and return its site-relative path, or null. Throws on a bad file. */
function save_upload(array $file): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
    if ($file['error'] !== UPLOAD_ERR_OK) throw new RuntimeException('Upload failed (error ' . $file['error'] . '). The file may be too large for the server.');
    if ($file['size'] > 8 * 1024 * 1024) throw new RuntimeException('Image is larger than 8 MB.');
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'][$mime] ?? null;
    if (!$ext || !@getimagesize($file['tmp_name'])) throw new RuntimeException('Only JPG, PNG, WebP or GIF images are allowed.');
    $dir = dirname(__DIR__) . '/uploads';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $name = date('Ym') . '-' . bin2hex(random_bytes(6)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], "$dir/$name")) throw new RuntimeException('Could not save the image. Is the uploads folder writable?');
    return 'uploads/' . $name;
}

/** Path to show an image from inside /admin */
function admin_img(string $path): string
{
    return preg_match('#^(https?:)?//#', $path) ? $path : '../' . ltrim($path, '/');
}

function page_start(string $title, string $active = ''): void
{
    $unread = 0;
    try { $unread = (int) db()->query('SELECT COUNT(*) FROM leads WHERE is_read = 0')->fetchColumn(); } catch (Throwable $e) {}
    $f = flash();
    ?><!doctype html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= h($title) ?> · Brix-Tryon admin</title>
<link rel="stylesheet" href="style.css">
</head><body>
<aside class="side">
    <a class="brand" href="index.php">Brix-Tryon <small>admin</small></a>
    <nav>
        <a href="index.php" class="<?= $active === 'home' ? 'on' : '' ?>">Dashboard</a>
        <p>Page content</p>
        <?php foreach (content_def()['groups'] as $i => $g): ?>
            <a href="content.php?g=<?= $i ?>" class="<?= $active === "g$i" ? 'on' : '' ?>"><?= h($g['name']) ?></a>
        <?php endforeach; ?>
        <p>Lists</p>
        <?php foreach (content_def()['lists'] as $t => $l): ?>
            <a href="items.php?t=<?= h($t) ?>" class="<?= $active === "l$t" ? 'on' : '' ?>"><?= h($l['label']) ?></a>
        <?php endforeach; ?>
        <p>Visitors</p>
        <a href="leads.php" class="<?= $active === 'leads' ? 'on' : '' ?>">Sign-ups<?= $unread ? " <b>$unread</b>" : '' ?></a>
        <p>Account</p>
        <a href="password.php" class="<?= $active === 'pw' ? 'on' : '' ?>">Change password</a>
        <a href="../index.php" target="_blank" rel="noopener">View website ↗</a>
        <a href="logout.php">Log out</a>
    </nav>
</aside>
<main class="main">
<?php if ($f): ?><div class="flash <?= h($f[1]) ?>"><?= h($f[0]) ?></div><?php endif; ?>
<h1><?= h($title) ?></h1>
<?php
}

function page_end(): void
{
    echo "</main></body></html>";
}
