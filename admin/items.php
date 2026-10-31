<?php
require __DIR__ . '/_boot.php';
require_login();

$lists = content_def()['lists'];
$type = (string) ($_GET['t'] ?? '');
if (!isset($lists[$type])) { header('Location: index.php'); exit; }
$list = $lists[$type];
$pdo = db();
$self = 'items.php?t=' . urlencode($type);

$fetch = function (int $id) use ($pdo, $type) {
    $s = $pdo->prepare('SELECT * FROM items WHERE id = ? AND type = ?');
    $s->execute([$id, $type]);
    return $s->fetch() ?: null;
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $action = (string) ($_POST['action'] ?? '');
    $id = (int) ($_POST['id'] ?? 0);

    if ($action === 'save') {
        $data = [];
        foreach ($list['fields'] as $f) {
            $v = (string) ($_POST['f'][$f['key']] ?? '');
            $data[$f['key']] = $f['type'] === 'checkbox' ? (isset($_POST['f'][$f['key']]) ? '1' : '0')
                : ($f['type'] === 'textarea' ? trim(str_replace("\r\n", "\n", $v)) : trim(preg_replace('/\s*\R\s*/', ' ', $v)));
            if ($f['key'] === 'url' && preg_match('#^\s*(javascript|data|vbscript):#i', $data['url'])) $data['url'] = '#';
        }
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        $active = isset($_POST['active']) ? 1 : 0;
        if ($id && $fetch($id)) {
            $pdo->prepare('UPDATE items SET data = ?, active = ? WHERE id = ?')->execute([$json, $active, $id]);
        } else {
            $max = (int) $pdo->query('SELECT COALESCE(MAX(sort_order), 0) FROM items WHERE type = ' . $pdo->quote($type))->fetchColumn();
            $pdo->prepare('INSERT INTO items (type, sort_order, active, data) VALUES (?, ?, ?, ?)')->execute([$type, $max + 10, $active, $json]);
        }
        flash('Saved. The website is updated.');
    } elseif ($action === 'delete' && $id && $fetch($id)) {
        $pdo->prepare('DELETE FROM items WHERE id = ?')->execute([$id]);
        flash('Deleted.');
    } elseif (($action === 'up' || $action === 'down') && $id) {
        // swap with the neighbour in the visible order, then renumber so ties never get stuck
        $rows = $pdo->prepare('SELECT id FROM items WHERE type = ? ORDER BY sort_order, id');
        $rows->execute([$type]);
        $ids = array_map('intval', array_column($rows->fetchAll(), 'id'));
        $pos = array_search($id, $ids, true);
        $swap = $action === 'up' ? $pos - 1 : $pos + 1;
        if ($pos !== false && isset($ids[$swap])) { [$ids[$pos], $ids[$swap]] = [$ids[$swap], $ids[$pos]]; }
        $upd = $pdo->prepare('UPDATE items SET sort_order = ? WHERE id = ?');
        foreach ($ids as $n => $i) $upd->execute([($n + 1) * 10, $i]);
    }
    header('Location: ' . $self);
    exit;
}

$editing = null; $isNew = isset($_GET['new']);
if (isset($_GET['edit'])) $editing = $fetch((int) $_GET['edit']);

if ($editing || $isNew):
    $data = $editing ? (json_decode($editing['data'], true) ?: []) : [];
    page_start(($editing ? 'Edit ' : 'Add ') . $list['singular'], "l$type");
    ?>
    <form method="post" class="card form">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="id" value="<?= $editing ? (int) $editing['id'] : 0 ?>">
        <?php foreach ($list['fields'] as $f): $v = $data[$f['key']] ?? ''; $n = 'f[' . h($f['key']) . ']'; ?>
            <div class="row">
                <?php if ($f['type'] === 'checkbox'): ?>
                    <label class="check"><input type="checkbox" name="<?= $n ?>" value="1" <?= $v === '1' ? 'checked' : '' ?>> <?= h($f['label']) ?></label>
                <?php else: ?>
                    <label><?= h($f['label']) ?></label>
                    <?php if ($f['type'] === 'textarea'): ?>
                        <textarea name="<?= $n ?>" rows="<?= $f['key'] === 'features' ? 12 : 4 ?>"><?= h($v) ?></textarea>
                    <?php else: ?>
                        <input name="<?= $n ?>" value="<?= h($v) ?>">
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <div class="row"><label class="check"><input type="checkbox" name="active" value="1" <?= !$editing || $editing['active'] ? 'checked' : '' ?>> Show on the website</label></div>
        <div class="bar"><button class="btn">Save</button> <a class="btn ghost" href="<?= h($self) ?>">Cancel</a></div>
    </form>
    <?php
    page_end();
    exit;
endif;

$rows = $pdo->prepare('SELECT * FROM items WHERE type = ? ORDER BY sort_order, id');
$rows->execute([$type]);
$rows = $rows->fetchAll();
page_start($list['label'], "l$type");
?>
<p><a class="btn" href="<?= h($self) ?>&new=1">+ Add <?= h($list['singular']) ?></a></p>
<div class="card">
<?php if (!$rows): ?><p class="muted">Nothing here yet.</p><?php endif; ?>
<table class="tbl">
    <?php foreach ($rows as $i => $r): $d = json_decode($r['data'], true) ?: []; ?>
        <tr class="<?= $r['active'] ? '' : 'off' ?>">
            <td class="grow"><b><?= h($d[$list['titleField']] ?? '(untitled)') ?></b><?= $r['active'] ? '' : ' <span class="tag">hidden</span>' ?></td>
            <td class="act">
                <form method="post" class="inline"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                    <button name="action" value="up" class="mini" <?= $i === 0 ? 'disabled' : '' ?> title="Move up">↑</button>
                    <button name="action" value="down" class="mini" <?= $i === count($rows) - 1 ? 'disabled' : '' ?> title="Move down">↓</button>
                    <a class="mini" href="<?= h($self) ?>&edit=<?= (int) $r['id'] ?>">Edit</a>
                    <button name="action" value="delete" class="mini danger" onclick="return confirm('Delete this <?= h($list['singular']) ?>?')">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
<?php page_end();
