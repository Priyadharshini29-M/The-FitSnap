<?php
/** Receives the "Get access" form and the newsletter box, stores them in MySQL and copies them to the Google Sheet. */
require __DIR__ . '/lib/bootstrap.php';
require __DIR__ . '/lib/sheets.php';

function field(string $k, int $max): string { return mb_substr(trim((string) ($_POST[$k] ?? '')), 0, $max); }

/** Send the answer now, then keep working so the visitor never waits on Google. */
function reply(int $code, array $body, ?callable $after = null): void
{
    $json = json_encode($body);
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    if ($after) {
        ignore_user_abort(true);
        header('Content-Length: ' . strlen($json));
        header('Connection: close');
    }
    echo $json;
    if ($after) {
        while (ob_get_level() > 0) ob_end_flush();
        if (function_exists('fastcgi_finish_request')) fastcgi_finish_request(); else flush();
        $after();
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') reply(405, ['ok' => false]);

$source = field('source', 30);
if (!in_array($source, ['access-form', 'newsletter'], true)) reply(400, ['ok' => false, 'error' => 'bad_source']);

$email = field('email', 200);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) reply(422, ['ok' => false, 'error' => 'bad_email']);

$row = [
    'first_name' => field('firstName', 100), 'last_name' => field('lastName', 100),
    'phone' => field('phone', 40), 'company' => field('company', 200), 'shop_url' => field('shopUrl', 300),
];
if ($source === 'access-form' && ($row['first_name'] === '' || $row['company'] === '')) reply(422, ['ok' => false, 'error' => 'missing_fields']);

$ip = substr((string) ($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
try {
    $pdo = db();
    $recent = $pdo->prepare('SELECT COUNT(*) FROM leads WHERE ip = ? AND created_at > (NOW() - INTERVAL 10 MINUTE)');
    $recent->execute([$ip]);
    if ((int) $recent->fetchColumn() >= 10) reply(429, ['ok' => false, 'error' => 'too_many']);

    $pdo->prepare('INSERT INTO leads (source, first_name, last_name, phone, company, shop_url, email, ip, user_agent) VALUES (?,?,?,?,?,?,?,?,?)')
        ->execute([$source, $row['first_name'], $row['last_name'], $row['phone'], $row['company'], $row['shop_url'], $email, $ip, substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255)]);
    $id = (int) $pdo->lastInsertId();
    $lead = $row + ['email' => $email, 'source' => $source, 'created_at' => date('Y-m-d H:i:s')];

    reply(200, ['ok' => true], function () use ($pdo, $id, $lead) {
        if (sheet_url() !== '' && sheet_push($lead)) {
            $pdo->prepare('UPDATE leads SET sheet_synced = 1 WHERE id = ?')->execute([$id]);
        }
    });
} catch (PDOException $e) {
    error_log('[brix] lead save failed: ' . $e->getMessage());
    reply(500, ['ok' => false, 'error' => 'server']);
}
