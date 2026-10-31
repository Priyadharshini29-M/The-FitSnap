<?php
/**
 * Content helpers used by index.php.
 * Every value comes from MySQL; if the database is unreachable the original
 * text from data/content.json is used, so the public site never goes blank.
 */

function h($v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function content_def(): array
{
    static $def;
    return $def ??= json_decode(file_get_contents(dirname(__DIR__) . '/data/content.json'), true);
}

/** key => default value, for every editable field */
function setting_defaults(): array
{
    static $d;
    if ($d === null) {
        $d = [];
        foreach (content_def()['groups'] as $g) foreach ($g['fields'] as $f) $d[$f['key']] = $f['default'];
    }
    return $d;
}

function settings(): array
{
    static $s;
    if ($s !== null) return $s;
    $s = setting_defaults();
    try {
        foreach (db()->query('SELECT skey, svalue FROM settings') as $r) $s[$r['skey']] = $r['svalue'];
    } catch (Throwable $e) { /* keep defaults */ }
    return $s;
}

function setting(string $key): string
{
    return (string) (settings()[$key] ?? '');
}

/** escaped plain text */
function e(string $key): string
{
    return h(setting($key));
}

/** heading: *word* becomes the italic accent, a new line becomes <br> */
function ttl(string $key, string $accent = 'serif-italic font-normal text-primary-container'): string
{
    $out = h(setting($key));
    $out = preg_replace('/\*([^*\n]+)\*/', '<span class="' . h($accent) . '">$1</span>', $out);
    return nl2br($out, false);
}

/** image / link path */
function img(string $key): string
{
    return h(setting($key));
}

/** rows of a list (faqs, plans, ...) as arrays, in the admin-defined order */
function items(string $type): array
{
    static $cache = [];
    if (isset($cache[$type])) return $cache[$type];
    try {
        $st = db()->prepare('SELECT data FROM items WHERE type = ? AND active = 1 ORDER BY sort_order, id');
        $st->execute([$type]);
        return $cache[$type] = array_map(fn($r) => json_decode($r['data'], true) ?: [], $st->fetchAll());
    } catch (Throwable $e) {
        return $cache[$type] = content_def()['lists'][$type]['items'] ?? [];
    }
}

function lines(string $text): array
{
    return array_values(array_filter(array_map('trim', preg_split('/\R/', $text)), 'strlen'));
}

function initials(string $name): string
{
    $out = '';
    foreach (preg_split('/\s+/', trim($name)) as $w) {
        if ($w !== '' && mb_strlen($out) < 2) $out .= mb_strtoupper(mb_substr($w, 0, 1));
    }
    return $out;
}
