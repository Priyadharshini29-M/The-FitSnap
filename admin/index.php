<?php
require __DIR__ . '/_boot.php';
require_login();

$leads = ['total' => 0, 'unread' => 0];
try {
    $r = db()->query('SELECT COUNT(*) t, SUM(is_read = 0) u FROM leads')->fetch();
    $leads = ['total' => (int) $r['t'], 'unread' => (int) $r['u']];
} catch (Throwable $e) {}

page_start('Dashboard', 'home');
?>
<p class="muted">Everything you change here updates the live website straight away. Pick a section on the left.</p>

<div class="grid">
    <a class="card tile" href="leads.php"><b><?= $leads['unread'] ?></b><span>new sign-ups<br><small><?= $leads['total'] ?> in total</small></span></a>
    <?php foreach (content_def()['lists'] as $t => $l):
        $c = 0; try { $s = db()->prepare('SELECT COUNT(*) FROM items WHERE type = ?'); $s->execute([$t]); $c = (int) $s->fetchColumn(); } catch (Throwable $e) {} ?>
        <a class="card tile" href="items.php?t=<?= h($t) ?>"><b><?= $c ?></b><span><?= h($l['label']) ?><br><small>add, edit, reorder</small></span></a>
    <?php endforeach; ?>
</div>

<h2>Page sections</h2>
<div class="grid">
    <?php foreach (content_def()['groups'] as $i => $g): ?>
        <a class="card tile" href="content.php?g=<?= $i ?>"><b><?= count($g['fields']) ?></b><span><?= h($g['name']) ?><br><small>fields</small></span></a>
    <?php endforeach; ?>
</div>

<h2>Good to know</h2>
<ul class="muted">
    <li>In headings, put a word between stars to make it the italic accent, e.g. <code>AI virtual *try-on*</code>. A new line becomes a line break.</li>
    <li>To change a picture, choose a new file under the picture. JPG, PNG, WebP or GIF, up to 8 MB.</li>
    <li>The animated product demo in the hero and the AI Studio picture strip are part of the page design and are not edited here.</li>
</ul>
<?php page_end();
