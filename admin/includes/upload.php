<?php
/** Şəkil yükləmə köməkçisi. */
function uploads_dir(): string { return dirname(__DIR__, 2) . '/assets/uploads'; }

/**
 * Tək şəkli yükləyir. Uğurda web yolu ('/assets/uploads/xxx.jpg'), əks halda null qaytarır.
 * $err referansına səhv mətni yazılır.
 */
function upload_image(array $file, ?string &$err = null): ?string {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
    if (($file['error'] ?? 1) !== UPLOAD_ERR_OK) { $err = 'Yükləmə xətası.'; return null; }
    if ($file['size'] > 3 * 1024 * 1024) { $err = 'Fayl 3 MB-dan böyükdür.'; return null; }

    $allow = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','image/gif'=>'gif','image/svg+xml'=>'svg'];
    $mime = '';
    if (function_exists('finfo_open')) {
        $fi = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($fi, $file['tmp_name']);
        finfo_close($fi);
    }
    // SVG bəzən text/plain kimi görünür — genişlənməyə görə də yoxla
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($mime === 'image/svg+xml' || ($ext === 'svg' && strpos((string)$mime, 'xml') !== false) || ($ext === 'svg' && $mime === 'text/plain')) {
        $mime = 'image/svg+xml';
    }
    if (!isset($allow[$mime])) { $err = 'Yalnız JPG, PNG, WEBP, GIF və ya SVG.'; return null; }

    $dir = uploads_dir();
    if (!is_dir($dir)) @mkdir($dir, 0775, true);
    $name = date('Ymd') . '-' . bin2hex(random_bytes(5)) . '.' . $allow[$mime];
    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) {
        // lokal test (php -S) üçün ehtiyat
        if (!@rename($file['tmp_name'], $dir . '/' . $name)) { $err = 'Fayl saxlanmadı.'; return null; }
    }
    return '/assets/uploads/' . $name;
}
