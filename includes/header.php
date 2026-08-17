<?php
/**
 * Sayt başlığı — loqo, əsas naviqasiya, mobil menyu və tema seçici (önizləmə).
 */
$nav = [
    ''           => ['Ana səhifə',        '/'],
    'haqqimizda' => ['Şirkət haqqında',   '/haqqimizda/'],
    'layiheler'  => ['Layihələr',         '/layiheler/'],
    'xidmetler'  => ['Xidmətlər',         '/xidmetler/'],
    'musteriler' => ['Müştərilər',        '/musteriler/'],
    'elaqe'      => ['Əlaqə',             '/elaqe/'],
];

// Tema seçici linkləri (cari yolu qoruyaraq)
$path = strtok($_SERVER['REQUEST_URI'], '?');
function theme_link($path, $n) {
    $sep = (strpos($path, '?') === false) ? '?' : '&';
    return e($path . $sep . 'theme=' . $n);
}
?>
<header class="site-header" id="siteHeader">
    <div class="container header-inner">
        <a class="brand" href="/" aria-label="<?= e($SITE['name']) ?> — ana səhifə">
            <img src="/assets/img/logo.png" alt="<?= e($SITE['name']) ?> loqo" width="120" height="113" class="brand-logo">
        </a>

        <nav class="main-nav" aria-label="Əsas menyu">
            <button class="nav-toggle" aria-expanded="false" aria-controls="navList" aria-label="Menyunu aç">
                <span></span><span></span><span></span>
            </button>
            <ul class="nav-list" id="navList">
                <li class="nav-m-head">
                    <a href="/" class="nav-m-logo" aria-label="<?= e($SITE['name']) ?>"><img src="/assets/img/logo.png" alt="<?= e($SITE['name']) ?>" width="110" height="104"></a>
                    <button class="nav-close" id="navClose" aria-label="Menyunu bağla">&times;</button>
                </li>
                <?php foreach ($nav as $key => [$label, $href]): ?>
                    <li>
                        <a href="<?= e($href) ?>"<?= $current_section === $key ? ' aria-current="page"' : '' ?>><?= e($label) ?></a>
                    </li>
                <?php endforeach; ?>
                <li class="nav-m-socials"><?= social_links($SITE) ?></li>
            </ul>
        </nav>
    </div>
</header>

<main id="main">
