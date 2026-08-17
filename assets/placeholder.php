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

// ---- Demo brend loqosu (müştərilər üçün, c=0) ----
if ($c === 0) {
    $names  = ['Aster','Novadek','Lumen','Kredo','Marin','Qafqaz','Elite','Vega','Oria','Balans'];
    $colors = ['#c75b2a','#2f7d74','#3a5a99','#8a4fbf','#c0392b','#2c3e50','#16a085','#d68910','#5d6d7e','#117864'];
    if (preg_match('/\d+/', $t, $mm)) { $i = (int)$mm[0] - 1; } else { $i = crc32($t); }
    $i = (($i % 10) + 10) % 10;
    $name  = $names[$i];
    $color = $colors[$i];
    $shape = $i % 5;
    $cx = 34; $cy = $h / 2; $r = 20;
    switch ($shape) {
        case 0: $mark = '<circle cx="'.$cx.'" cy="'.$cy.'" r="'.$r.'" fill="'.$color.'"/>'; break;
        case 1: $mark = '<rect x="'.($cx-$r).'" y="'.($cy-$r).'" width="'.($r*2).'" height="'.($r*2).'" rx="6" fill="'.$color.'"/>'; break;
        case 2: $mark = '<polygon points="'.$cx.','.($cy-$r).' '.($cx+$r).','.($cy+$r).' '.($cx-$r).','.($cy+$r).'" fill="'.$color.'"/>'; break;
        case 3: $mark = '<polygon points="'.$cx.','.($cy-$r).' '.($cx+$r).','.$cy.' '.$cx.','.($cy+$r).' '.($cx-$r).','.$cy.'" fill="'.$color.'"/>'; break;
        default: $mark = '<circle cx="'.$cx.'" cy="'.$cy.'" r="'.$r.'" fill="none" stroke="'.$color.'" stroke-width="6"/><circle cx="'.$cx.'" cy="'.$cy.'" r="7" fill="'.$color.'"/>';
    }
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="'.$w.'" height="'.$h.'" viewBox="0 0 '.$w.' '.$h.'" role="img" aria-label="'.htmlspecialchars($name, ENT_QUOTES).'">';
    echo $mark;
    echo '<text x="66" y="'.($cy).'" dy=".33em" fill="#222" font-family="Arial, Helvetica, sans-serif" font-size="26" font-weight="700" letter-spacing="0.5">'.htmlspecialchars($name, ENT_QUOTES).'</text>';
    echo '</svg>';
    exit;
}

echo '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $h . '" viewBox="0 0 ' . $w . ' ' . $h . '" role="img" aria-label="' . htmlspecialchars($label, ENT_QUOTES) . '">';
echo '<rect width="100%" height="100%" fill="' . $bg . '"/>';
// dekorativ diaqonal xətt
echo '<line x1="0" y1="' . $h . '" x2="' . $w . '" y2="0" stroke="' . $fg . '" stroke-width="1" opacity="0.25"/>';
echo '<text x="50%" y="50%" dy=".35em" text-anchor="middle" fill="' . $fg . '" '
   . 'font-family="Arial, Helvetica, sans-serif" font-size="' . $fontSize . '" font-weight="600" letter-spacing="1">'
   . htmlspecialchars($label, ENT_QUOTES) . '</text>';
echo '</svg>';
