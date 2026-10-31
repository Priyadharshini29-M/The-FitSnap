<?php
/**
 * Forwards a lead to a Google Sheet through a Google Apps Script web app.
 * The URL is set in the admin (Google Sheet > Web app address). Returns true when Google accepted it.
 */
function sheet_url(): string
{
    $u = trim(setting('sheet.webhook'));
    return preg_match('#^https://script\.google(usercontent)?\.com/#', $u) ? $u : '';
}

function sheet_push(array $lead): bool
{
    $url = sheet_url();
    if ($url === '' || !function_exists('curl_init')) return false;
    $body = http_build_query([
        'firstName'   => $lead['first_name'] ?? '',
        'lastName'    => $lead['last_name'] ?? '',
        'phone'       => $lead['phone'] ?? '',
        'company'     => $lead['company'] ?? '',
        'shopUrl'     => $lead['shop_url'] ?? '',
        'email'       => $lead['email'] ?? '',
        'source'      => $lead['source'] ?? '',
        'submittedAt' => $lead['created_at'] ?? date('Y-m-d H:i:s'),
    ]);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,   // Apps Script answers with a redirect
        CURLOPT_MAXREDIRS => 4,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
    ]);
    $resp = (string) curl_exec($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    $err = curl_error($ch);
    curl_close($ch);
    // Apps Script answers 200 even when the script crashes, but then the body is an HTML error page
    if ($code !== 200 || ltrim($resp) === '' || $resp[0] === '<' || stripos($resp, 'error') !== false && stripos($resp, 'ok') === false) {
        error_log('[brix] sheet push failed: HTTP ' . $code . ' ' . $err . ' ' . substr(strip_tags($resp), 0, 200));
        return false;
    }
    return true;
}
