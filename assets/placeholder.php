<?php
/**
 * Sadə SVG placeholder generatoru.
 * İstifadə: /assets/placeholder.php?w=1200&h=800&t=Başlıq&c=1
 * Real şəkillər hazır olduqda bu köməkçi artıq lazım deyil.
 */
$w = max(16, min(3000, (int)($_GET['w'] ?? 800)));
$h = max(16, min(3000, (int)($_GET['h'] ?? 600)));
$t = trim((string)($_GET['t'] ?? ''));
$c = (int)($_GET['c'] ?? 1);

// Rəng palitrası (brend: narıncı + tünd tonlar)
$schemes = [
    0 => ['#f4f4f4', '#9aa0a6'], // müştəri loqosu üçün açıq
    1 => ['#2a2724', '#c75b2a'],
    2 => ['#c75b2a', '#ffffff'],
    3 => ['#1b1b1b', '#e0a06a'],
];
[$bg, $fg] = $schemes[$c] ?? $schemes[1];

$label = $t !== '' ? $t : ($w . '×' . $h);
$fontSize = max(14, min($w, $h) / 12);

header('Content-Type: image/svg+xml; charset=utf-8');
header('Cache-Control: public, max-age=86400');

echo '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $h . '" viewBox="0 0 ' . $w . ' ' . $h . '" role="img" aria-label="' . htmlspecialchars($label, ENT_QUOTES) . '">';
echo '<rect width="100%" height="100%" fill="' . $bg . '"/>';
// dekorativ diaqonal xətt
echo '<line x1="0" y1="' . $h . '" x2="' . $w . '" y2="0" stroke="' . $fg . '" stroke-width="1" opacity="0.25"/>';
echo '<text x="50%" y="50%" dy=".35em" text-anchor="middle" fill="' . $fg . '" '
   . 'font-family="Arial, Helvetica, sans-serif" font-size="' . $fontSize . '" font-weight="600" letter-spacing="1">'
   . htmlspecialchars($label, ENT_QUOTES) . '</text>';
echo '</svg>';
