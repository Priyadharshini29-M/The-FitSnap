<?php
require __DIR__ . '/_boot.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    // crude brute-force brake: a few failures per session slow every further attempt
    $_SESSION['fails'] = $_SESSION['fails'] ?? 0;
    if ($_SESSION['fails'] >= 5) sleep(min(10, $_SESSION['fails'] - 3));
    try {
        $st = db()->prepare('SELECT id, password_hash FROM admins WHERE username = ?');
        $st->execute([trim((string) ($_POST['username'] ?? ''))]);
        $row = $st->fetch();
        // always run a hash check so the response time does not reveal valid usernames
        $hash = $row['password_hash'] ?? '$2y$10$abcdefghijklmnopqrstuuAbcdefghijklmnopqrstuvwxyz01234';
        if (password_verify((string) ($_POST['password'] ?? ''), $hash) && $row) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int) $row['id'];
            $_SESSION['fails'] = 0;
            header('Location: index.php');
            exit;
        }
        $_SESSION['fails']++;
        $error = 'Wrong username or password.';
    } catch (Throwable $e) {
        $error = 'Cannot reach the database. Run "php install.php" first and check config.local.php.';
    }
}
if (!empty($_SESSION['admin_id'])) { header('Location: index.php'); exit; }
?><!doctype html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Log in · Brix-Tryon admin</title>
<link rel="stylesheet" href="style.css">
</head><body class="login">
<form method="post" class="card login-card">
    <h1>Brix-Tryon admin</h1>
    <?php if ($error): ?><div class="flash err"><?= h($error) ?></div><?php endif; ?>
    <?= csrf_field() ?>
    <label>Username<input name="username" autocomplete="username" required autofocus></label>
    <label>Password<input name="password" type="password" autocomplete="current-password" required></label>
    <button class="btn">Log in</button>
</form>
</body></html>
