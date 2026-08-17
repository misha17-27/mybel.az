<?php
/**
 * Yalnız LOKAL sınaq üçün router (php -S localhost:8000 router.php).
 * Real serverdə (Apache) bu fayl istifadə olunmur — .htaccess işləyir.
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Təhlükəsizlik: məlumat və daxili qovluqlara birbaşa girişi blokla
if (preg_match('#^/(data|includes|admin/includes)(/|$)#', $uri) || basename($uri) === '.htaccess') {
    http_response_code(403);
    echo 'Forbidden';
    return true;
}

// Təmiz detal URL-ləri
if (preg_match('#^/layiheler/([a-z0-9\-]+)/?$#', $uri, $m)) {
    $_GET['slug'] = $m[1];
    require __DIR__ . '/layiheler/detay.php';
    return true;
}
if (preg_match('#^/xidmetler/([a-z0-9\-]+)/?$#', $uri, $m)) {
    $_GET['slug'] = $m[1];
    require __DIR__ . '/xidmetler/detay.php';
    return true;
}
if ($uri === '/sitemap.xml') { require __DIR__ . '/sitemap.php'; return true; }

// Mövcud real fayl (assets, placeholder.php, css, js...)
$file = __DIR__ . $uri;
if ($uri !== '/' && file_exists($file) && !is_dir($file)) {
    return false; // daxili serverə ötür
}
// Qovluq -> index.php
if (is_dir($file)) {
    $idx = rtrim($file, '/') . '/index.php';
    if (file_exists($idx)) { require $idx; return true; }
}
if ($uri === '/') { require __DIR__ . '/index.php'; return true; }

// 404
http_response_code(404);
require __DIR__ . '/404.php';
return true;
