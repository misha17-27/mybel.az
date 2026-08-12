<?php
/**
 * export.php — 3 dizayn versiyasını STATİK, tək-fayl HTML kimi ixrac edir (показ üçün).
 * İşə salınmadan əvvəl lokal server qalxmalıdır:
 *   php -S 127.0.0.1:8123 -t D:\mybel.az D:\mybel.az\router.php
 * Sonra: php D:\mybel.az\export.php
 */
$themes = [1 => 'klassik', 2 => 'modern', 3 => 'minimal'];
$css_key = [1 => 'classic', 2 => 'modern', 3 => 'minimal'];
$server  = 'http://127.0.0.1:8123';
$dir     = __DIR__;

// placeholder.php ilə eyni SVG generatoru
function svg_placeholder($w, $h, $t, $c) {
    $w = max(16, min(3000, (int)$w));
    $h = max(16, min(3000, (int)$h));
    $schemes = [0 => ['#f4f4f4', '#9aa0a6'], 1 => ['#2a2724', '#c75b2a'], 2 => ['#c75b2a', '#ffffff'], 3 => ['#1b1b1b', '#e0a06a']];
    [$bg, $fg] = $schemes[$c] ?? $schemes[1];
    $label = $t !== '' ? $t : ($w . '×' . $h);
    $fs = max(14, min($w, $h) / 12);
    $s  = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $h . '" viewBox="0 0 ' . $w . ' ' . $h . '">';
    $s .= '<rect width="100%" height="100%" fill="' . $bg . '"/>';
    $s .= '<line x1="0" y1="' . $h . '" x2="' . $w . '" y2="0" stroke="' . $fg . '" stroke-width="1" opacity="0.25"/>';
    $s .= '<text x="50%" y="50%" dy=".35em" text-anchor="middle" fill="' . $fg . '" font-family="Arial, sans-serif" font-size="' . $fs . '" font-weight="600" letter-spacing="1">' . htmlspecialchars($label, ENT_QUOTES) . '</text>';
    $s .= '</svg>';
    return $s;
}

$logoData = 'data:image/png;base64,' . base64_encode(file_get_contents($dir . '/assets/img/logo.png'));

foreach ($themes as $n => $key) {
    $html = @file_get_contents($server . '/?theme=' . $n);
    if ($html === false) { fwrite(STDERR, "Server cavab vermir — əvvəlcə php -S ... işə salın\n"); exit(1); }

    // 1) CSS-i inline et
    $baseCss  = file_get_contents($dir . '/assets/css/base.css');
    $themeCss = file_get_contents($dir . '/assets/css/theme-' . $css_key[$n] . '.css');
    $html = preg_replace('#\s*<link rel="stylesheet" href="/assets/css/[^"]+">#', '', $html);
    $html = str_replace('</head>', "<style>\n{$baseCss}\n{$themeCss}\n</style>\n</head>", $html);

    // 2) JS-i inline et
    $js = file_get_contents($dir . '/assets/js/main.js');
    $html = preg_replace('#<script src="/assets/js/main\.js[^"]*" defer></script>#', "<script>\n{$js}\n</script>", $html);

    // 3) placeholder şəkilləri -> data URI
    $html = preg_replace_callback('#/assets/placeholder\.php\?([^"\'\s)]+)#', function ($m) {
        parse_str(html_entity_decode($m[1], ENT_QUOTES), $q);
        $svg = svg_placeholder($q['w'] ?? 800, $q['h'] ?? 600, $q['t'] ?? '', (int)($q['c'] ?? 1));
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }, $html);

    // 3b) demo fotoları -> data URI (tək-fayl saxlamaq üçün)
    $html = preg_replace_callback('#/assets/img/demo/[a-z0-9._-]+\.(?:jpe?g|png|webp)#i', function ($m) use ($dir) {
        $f = $dir . $m[0];
        if (!is_file($f)) return $m[0];
        $ext  = strtolower(pathinfo($f, PATHINFO_EXTENSION));
        $mime = $ext === 'png' ? 'image/png' : ($ext === 'webp' ? 'image/webp' : 'image/jpeg');
        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($f));
    }, $html);

    // 4) loqo -> data URI
    $html = str_replace('"/assets/img/logo.png"', '"' . $logoData . '"', $html);

    // 5) tema seçici paneli sil (hər fayl artıq ayrıca versiyadır)
    $html = preg_replace('#<div class="theme-switcher".*?</div>\s*#s', '', $html);

    // 6) versiya nişanı əlavə et (yuxarı künc)
    $badge = '<div style="position:fixed;left:16px;bottom:16px;z-index:300;background:#c75b2a;color:#fff;'
           . 'padding:.5rem .9rem;border-radius:999px;font:600 13px Manrope,sans-serif;box-shadow:0 8px 24px rgba(0,0,0,.25)">'
           . 'Versiya ' . $n . ' — ' . ucfirst($key) . '</div>';
    $html = str_replace('</body>', $badge . "\n</body>", $html);

    $out = $dir . '/mybel-versiya-' . $n . '-' . $key . '.html';
    file_put_contents($out, $html);
    $left = substr_count($html, 'placeholder.php');
    echo "OK: mybel-versiya-{$n}-{$key}.html  (" . round(strlen($html) / 1024) . " KB, qalan placeholder.php: {$left})\n";
}
