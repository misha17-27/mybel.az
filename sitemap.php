<?php
/** Dinamik XML sitemap — bütün statik və dinamik URL-ləri sadalayır. */
require __DIR__ . '/includes/config.php';
header('Content-Type: application/xml; charset=utf-8');

$base = rtrim($SITE['url'], '/');
$urls = [
    ['/', '1.0', 'weekly'],
    ['/haqqimizda/', '0.7', 'monthly'],
    ['/layiheler/', '0.9', 'weekly'],
    ['/xidmetler/', '0.8', 'monthly'],
    ['/musteriler/', '0.5', 'monthly'],
    ['/elaqe/', '0.6', 'yearly'],
];
foreach ($PROJECTS as $p) $urls[] = ['/layiheler/' . $p['slug'] . '/', '0.7', 'monthly'];
foreach ($SERVICES as $s) $urls[] = ['/xidmetler/' . service_slug($s) . '/', '0.6', 'monthly'];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as [$loc, $pri, $freq]) {
    echo "  <url>\n";
    echo "    <loc>" . htmlspecialchars($base . $loc, ENT_QUOTES) . "</loc>\n";
    echo "    <changefreq>$freq</changefreq>\n";
    echo "    <priority>$pri</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>';
