<?php
require __DIR__ . '/_boot.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $st = db()->prepare('SELECT password_hash FROM admins WHERE id = ?');
    $st->execute([$_SESSION['admin_id']]);
    $hash = (string) $st->fetchColumn();
    $new = (string) ($_POST['new'] ?? '');
    if (!password_verify((string) ($_POST['current'] ?? ''), $hash)) flash('Current password is wrong.', 'err');
    elseif (mb_strlen($new) < 10) flash('New password must be at least 10 characters.', 'err');
    elseif ($new !== (string) ($_POST['again'] ?? '')) flash('The two new passwords do not match.', 'err');
    else {
        db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?')->execute([password_hash($new, PASSWORD_DEFAULT), $_SESSION['admin_id']]);
        session_regenerate_id(true);
        flash('Password changed.');
    }
    header('Location: password.php');
    exit;
}

page_start('Change password', 'pw');
?>
<form method="post" class="card form narrow">
    <?= csrf_field() ?>
    <div class="row"><label>Current password</label><input type="password" name="current" autocomplete="current-password" required></div>
    <div class="row"><label>New password (10+ characters)</label><input type="password" name="new" autocomplete="new-password" required minlength="10"></div>
    <div class="row"><label>New password again</label><input type="password" name="again" autocomplete="new-password" required minlength="10"></div>
    <div class="bar"><button class="btn">Change password</button></div>
</form>
<?php page_end();
