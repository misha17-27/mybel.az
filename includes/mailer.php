<?php
/**
 * mailer.php — SMTP vasitəsilə məktub göndərmə (kitabxanasız, xam soketlə).
 * SMTP konfiqurasiyası yoxdursa mail() funksiyasına keçir.
 */

function mime_b($s) { return '=?UTF-8?B?' . base64_encode($s) . '?='; }

/** Aşağı səviyyəli SMTP göndərici. Uğurda true. */
function smtp_send(array $cfg, string $to, string $subject, string $body, ?string &$err = null): bool {
    $host = trim($cfg['host'] ?? '');
    $port = (int)($cfg['port'] ?? 587);
    $enc  = $cfg['enc'] ?? 'tls';
    $user = $cfg['user'] ?? '';
    $pass = $cfg['pass'] ?? '';
    $from = trim($cfg['from'] ?? '') ?: $user;
    $fromName = $cfg['from_name'] ?? '';

    if ($host === '' || $from === '') { $err = 'SMTP tam konfiqurasiya olunmayıb.'; return false; }

    $transport = ($enc === 'ssl') ? "ssl://$host" : "tcp://$host";
    $ctx = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
    $fp = @stream_socket_client("$transport:$port", $errno, $errstr, 15, STREAM_CLIENT_CONNECT, $ctx);
    if (!$fp) { $err = "Bağlantı: $errstr ($errno)"; return false; }
    stream_set_timeout($fp, 15);

    $read = function () use ($fp) {
        $data = '';
        while (($line = fgets($fp, 515)) !== false) {
            $data .= $line;
            if (strlen($line) >= 4 && $line[3] === ' ') break;
        }
        return $data;
    };
    $cmd = function ($c) use ($fp, $read) { fwrite($fp, $c . "\r\n"); return $read(); };
    $ok = fn($r, $code) => strpos($r, (string)$code) === 0;

    $read(); // greeting
    $ehloName = $_SERVER['SERVER_NAME'] ?? 'localhost';
    $cmd("EHLO $ehloName");

    if ($enc === 'tls') {
        $r = $cmd('STARTTLS');
        if (!$ok($r, 220)) { $err = "STARTTLS: $r"; fclose($fp); return false; }
        $crypto = STREAM_CRYPTO_METHOD_TLS_CLIENT;
        if (defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT')) $crypto |= STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
        if (!stream_socket_enable_crypto($fp, true, $crypto)) { $err = 'TLS başlatılmadı.'; fclose($fp); return false; }
        $cmd("EHLO $ehloName");
    }

    if ($user !== '') {
        $r = $cmd('AUTH LOGIN');
        if (!$ok($r, 334)) { $err = "AUTH: $r"; fclose($fp); return false; }
        $r = $cmd(base64_encode($user));
        if (!$ok($r, 334)) { $err = "AUTH user: $r"; fclose($fp); return false; }
        $r = $cmd(base64_encode($pass));
        if (!$ok($r, 235)) { $err = 'Giriş məlumatları yanlışdır.'; fclose($fp); return false; }
    }

    $r = $cmd("MAIL FROM:<$from>");
    if (!$ok($r, 250)) { $err = "MAIL FROM: $r"; fclose($fp); return false; }
    $r = $cmd("RCPT TO:<$to>");
    if (!$ok($r, 250) && !$ok($r, 251)) { $err = "RCPT TO: $r"; fclose($fp); return false; }
    $r = $cmd('DATA');
    if (!$ok($r, 354)) { $err = "DATA: $r"; fclose($fp); return false; }

    $headers  = 'From: ' . ($fromName !== '' ? mime_b($fromName) . " <$from>" : "<$from>") . "\r\n";
    $headers .= "To: <$to>\r\n";
    $headers .= 'Subject: ' . mime_b($subject) . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit\r\n";
    $headers .= 'Date: ' . date('r') . "\r\n";

    // CRLF normallaşdırma + dot-stuffing
    $bodyOut = str_replace("\r\n", "\n", $body);
    $bodyOut = str_replace("\n", "\r\n", $bodyOut);
    $bodyOut = preg_replace('/^\./m', '..', $bodyOut);

    fwrite($fp, $headers . "\r\n" . $bodyOut . "\r\n.\r\n");
    $r = $read();
    if (!$ok($r, 250)) { $err = "Göndərmə: $r"; fclose($fp); return false; }
    $cmd('QUIT');
    fclose($fp);
    return true;
}

/** Sayt konfiqurasiyasına görə göndər (SMTP varsa SMTP, yoxsa mail()). */
function send_site_mail(string $to, string $subject, string $body, ?string &$err = null): bool {
    global $SITE;
    $cfg = $SITE['smtp'] ?? [];
    if (!empty($cfg['host'])) {
        return smtp_send($cfg, $to, $subject, $body, $err);
    }
    // fallback: mail()
    $from = trim($cfg['from'] ?? '') ?: ($SITE['email'] ?? '');
    $headers  = 'From: ' . (!empty($cfg['from_name']) ? mime_b($cfg['from_name']) . " <$from>" : "<$from>") . "\r\n";
    $headers .= "MIME-Version: 1.0\r\nContent-Type: text/plain; charset=UTF-8\r\n";
    $ok = @mail($to, mime_b($subject), $body, $headers);
    if (!$ok) $err = 'mail() göndərə bilmədi (SMTP tövsiyə olunur).';
    return $ok;
}
