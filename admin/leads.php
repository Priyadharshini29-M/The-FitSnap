<?php
require __DIR__ . '/_boot.php';
require dirname(__DIR__) . '/lib/sheets.php';
require_login();
$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    $a = (string) ($_POST['action'] ?? '');
    if ($a === 'delete' && $id) $pdo->prepare('DELETE FROM leads WHERE id = ?')->execute([$id]);
    if ($a === 'read' && $id) $pdo->prepare('UPDATE leads SET is_read = 1 WHERE id = ?')->execute([$id]);
    if ($a === 'readall') $pdo->exec('UPDATE leads SET is_read = 1');
    if ($a === 'sync') {
        if (sheet_url() === '') {
            flash('Add the Google Apps Script address first (Google Sheet in the left menu).', 'err');
        } else {
            $ok = 0; $fail = 0;
            $mark = $pdo->prepare('UPDATE leads SET sheet_synced = 1 WHERE id = ?');
            foreach ($pdo->query('SELECT * FROM leads WHERE sheet_synced = 0 ORDER BY id LIMIT 200')->fetchAll() as $r) {
                if (sheet_push($r)) { $mark->execute([$r['id']]); $ok++; } else { $fail++; }
            }
            flash($fail ? "Sent $ok to the sheet, $fail failed. Try again later." : "Sent $ok sign-up(s) to the Google Sheet.", $fail ? 'err' : 'ok');
        }
    }
    header('Location: leads.php');
    exit;
}

if (isset($_GET['csv'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="signups-' . date('Y-m-d') . '.csv"');
    $out = fopen('php://output', 'w');
    fwrite($out, "\xEF\xBB\xBF");
    $cols = ['created_at', 'source', 'first_name', 'last_name', 'email', 'phone', 'company', 'shop_url'];
    fputcsv($out, $cols);
    foreach ($pdo->query('SELECT * FROM leads ORDER BY id DESC') as $r) {
        // stop spreadsheet formulas in user-supplied text
        fputcsv($out, array_map(fn($c) => preg_match('/^[=+\-@\t\r]/', (string) $r[$c]) ? "'" . $r[$c] : $r[$c], $cols));
    }
    exit;
}

$page = max(1, (int) ($_GET['p'] ?? 1));
$per = 50;
$total = (int) $pdo->query('SELECT COUNT(*) FROM leads')->fetchColumn();
$unsent = (int) $pdo->query('SELECT COUNT(*) FROM leads WHERE sheet_synced = 0')->fetchColumn();
$rows = $pdo->query('SELECT * FROM leads ORDER BY id DESC LIMIT ' . $per . ' OFFSET ' . (($page - 1) * $per))->fetchAll();

page_start('Sign-ups', 'leads');
?>
<p>
    <a class="btn" href="leads.php?csv=1">Download as spreadsheet (CSV)</a>
    <form method="post" class="inline"><?= csrf_field() ?><button class="btn ghost" name="action" value="readall">Mark all as read</button></form>
    <form method="post" class="inline"><?= csrf_field() ?><button class="btn ghost" name="action" value="sync">Send unsent to Google Sheet<?= $unsent ? " ($unsent)" : '' ?></button></form>
</p>
<div class="card" style="overflow:auto">
<?php if (!$rows): ?><p class="muted">No sign-ups yet. They appear here when someone uses the "Get access" form or the newsletter box.</p><?php endif; ?>
<table class="tbl wide">
    <?php if ($rows): ?><tr><th>When</th><th>From</th><th>Name</th><th>Email</th><th>Phone</th><th>Company</th><th>Shop</th><th>Sheet</th><th></th></tr><?php endif; ?>
    <?php foreach ($rows as $r): ?>
        <tr class="<?= $r['is_read'] ? '' : 'new' ?>">
            <td><?= h($r['created_at']) ?></td>
            <td><?= h($r['source'] === 'newsletter' ? 'Newsletter' : 'Access form') ?></td>
            <td><?= h(trim($r['first_name'] . ' ' . $r['last_name'])) ?></td>
            <td><a href="mailto:<?= h($r['email']) ?>"><?= h($r['email']) ?></a></td>
            <td><?= h($r['phone']) ?></td>
            <td><?= h($r['company']) ?></td>
            <td><?= h($r['shop_url']) ?></td>
            <td><?= $r['sheet_synced'] ? '<span style="color:#067647">Sent</span>' : '<span class="muted">Not sent</span>' ?></td>
            <td class="act"><form method="post" class="inline"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                <?php if (!$r['is_read']): ?><button class="mini" name="action" value="read">Mark read</button><?php endif; ?>
                <button class="mini danger" name="action" value="delete" onclick="return confirm('Delete this sign-up?')">Delete</button></form></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
<?php if ($total > $per): ?>
    <p class="pager">
        <?php if ($page > 1): ?><a class="btn ghost" href="leads.php?p=<?= $page - 1 ?>">← Newer</a><?php endif; ?>
        <?php if ($page * $per < $total): ?><a class="btn ghost" href="leads.php?p=<?= $page + 1 ?>">Older →</a><?php endif; ?>
    </p>
<?php endif;
page_end();
