<?php
require __DIR__ . '/_boot.php';
require_login();

$groups = content_def()['groups'];
$gi = (int) ($_GET['g'] ?? 0);
if (!isset($groups[$gi])) { header('Location: index.php'); exit; }
$group = $groups[$gi];
$current = settings();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $save = db()->prepare('INSERT INTO settings (skey, svalue) VALUES (?, ?) ON DUPLICATE KEY UPDATE svalue = VALUES(svalue)');
    $errors = [];
    foreach ($group['fields'] as $f) {
        $k = $f['key'];
        $field = str_replace('.', '_', $k); // PHP turns dots in input names into underscores
        $val = $f['type'] === 'image' ? ($current[$k] ?? '') : (string) ($_POST['f'][$field] ?? '');
        if ($f['type'] === 'image') {
            try {
                $up = save_upload($_FILES['file'] ?? [] ? [
                    'name' => $_FILES['file']['name'][$field] ?? '', 'tmp_name' => $_FILES['file']['tmp_name'][$field] ?? '',
                    'error' => $_FILES['file']['error'][$field] ?? UPLOAD_ERR_NO_FILE, 'size' => $_FILES['file']['size'][$field] ?? 0,
                ] : []);
            } catch (RuntimeException $e) { $errors[] = $f['label'] . ': ' . $e->getMessage(); $up = null; }
            $typed = trim((string) ($_POST['f'][$field] ?? ''));
            if ($up) $val = $up;
            elseif ($typed !== '') $val = $typed;
            if (!empty($_POST['reset'][$field])) $val = $f['default'];
            if (preg_match('#^\s*(javascript|data|vbscript):#i', $val)) $val = $f['default'];
        } elseif ($f['type'] === 'text') {
            $val = trim(preg_replace('/\s*\R\s*/', ' ', $val));
        } else {
            $val = trim(str_replace("\r\n", "\n", $val));
        }
        $save->execute([$k, mb_substr($val, 0, 20000)]);
    }
    flash($errors ? implode(' ', $errors) : 'Saved. The website is updated.', $errors ? 'err' : 'ok');
    header('Location: content.php?g=' . $gi);
    exit;
}

page_start($group['name'], "g$gi");
?>
<form method="post" enctype="multipart/form-data" class="card form">
    <?= csrf_field() ?>
    <?php foreach ($group['fields'] as $f):
        $k = $f['key']; $name = str_replace('.', '_', $k); $v = $current[$k] ?? ''; ?>
        <div class="row">
            <label for="f-<?= h($name) ?>"><?= h($f['label']) ?></label>
            <?php if ($f['type'] === 'image'): ?>
                <div class="imgrow">
                    <img src="<?= h(admin_img($v)) ?>" alt="" class="thumb">
                    <div>
                        <input type="file" name="file[<?= h($name) ?>]" accept="image/jpeg,image/png,image/webp,image/gif">
                        <input id="f-<?= h($name) ?>" name="f[<?= h($name) ?>]" value="<?= h($v) ?>" placeholder="…or paste an image address">
                        <label class="check"><input type="checkbox" name="reset[<?= h($name) ?>]" value="1"> Restore the original picture</label>
                    </div>
                </div>
            <?php elseif ($f['type'] === 'textarea'): ?>
                <textarea id="f-<?= h($name) ?>" name="f[<?= h($name) ?>]" rows="<?= max(3, min(8, (int) ceil(mb_strlen($v) / 90) + 1)) ?>"><?= h($v) ?></textarea>
            <?php elseif ($f['type'] === 'title'): ?>
                <textarea id="f-<?= h($name) ?>" name="f[<?= h($name) ?>]" rows="<?= substr_count($v, "\n") + 2 ?>"><?= h($v) ?></textarea>
            <?php else: ?>
                <input id="f-<?= h($name) ?>" name="f[<?= h($name) ?>]" value="<?= h($v) ?>">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <div class="bar"><button class="btn">Save changes</button> <a href="../index.php" target="_blank" rel="noopener" class="btn ghost">View website ↗</a></div>
</form>
<?php page_end();
