<?php
/**
 * Sayt başlığı — loqo, əsas naviqasiya, dil keçidi, mobil menyu.
 */
$nav = [
    ''           => [__('nav_home'),     '/'],
    'haqqimizda' => [__('nav_about'),    '/haqqimizda/'],
    'layiheler'  => [__('nav_projects'), '/layiheler/'],
    'xidmetler'  => [__('nav_services'), '/xidmetler/'],
];
if (!empty($SITE['clients_enabled'])) $nav['musteriler'] = [__('nav_clients'), '/musteriler/'];
$nav['elaqe'] = [__('nav_contact'), '/elaqe/'];

// Dil keçidi: cari səhifəni prefikssiz al, hər dil üçün link qur (sorğu sətrini saxla)
$curPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$curPath = preg_replace('#^/(ru|en)(?=/|$)#', '', $curPath);
if ($curPath === '') $curPath = '/';
$curQS = $_SERVER['QUERY_STRING'] ?? '';
ob_start(); ?>
<details class="lang-dd">
    <summary><?= e($PUB_LANGS[$LANG] ?? strtoupper($LANG)) ?><span class="lang-caret"></span></summary>
    <div class="lang-dd-menu">
        <?php foreach ($PUB_LANGS as $lc => $lbl):
            $pfx   = $lc === 'az' ? '' : '/' . $lc;
            $lhref = $pfx . ($curPath === '/' ? '/' : $curPath) . ($curQS !== '' ? '?' . $curQS : ''); ?>
            <a href="<?= e($lhref) ?>"<?= $LANG === $lc ? ' class="is-active"' : '' ?>><?= e($lbl) ?></a>
        <?php endforeach; ?>
    </div>
</details>
<?php $langSwitchHtml = ob_get_clean();
?>
<header class="site-header" id="siteHeader">
    <div class="container header-inner">
        <a class="brand" href="<?= e(u('/')) ?>" aria-label="<?= e($SITE['name']) ?>">
            <img src="/assets/img/logo-gold.png" alt="<?= e($SITE['name']) ?> loqo" width="464" height="138" class="brand-logo">
        </a>

        <nav class="main-nav" aria-label="<?= e(__('main_menu')) ?>">
            <button class="nav-toggle" aria-expanded="false" aria-controls="navList" aria-label="<?= e(__('menu_open')) ?>">
                <span></span><span></span><span></span>
            </button>
            <ul class="nav-list" id="navList">
                <li class="nav-m-head">
                    <a href="<?= e(u('/')) ?>" class="nav-m-logo" aria-label="<?= e($SITE['name']) ?>"><img src="/assets/img/logo-gold.png" alt="<?= e($SITE['name']) ?>" width="464" height="138"></a>
                    <button class="nav-close" id="navClose" aria-label="<?= e(__('menu_close')) ?>">&times;</button>
                </li>
                <?php foreach ($nav as $key => [$label, $href]): ?>
                    <li>
                        <a href="<?= e(u($href)) ?>"<?= $current_section === $key ? ' aria-current="page"' : '' ?>><?= e($label) ?></a>
                    </li>
                <?php endforeach; ?>
                <li class="nav-m-lang"><?= $langSwitchHtml ?></li>
                <li class="nav-m-socials"><?= social_links($SITE) ?></li>
            </ul>
            <div class="header-lang"><?= $langSwitchHtml ?></div>
        </nav>
    </div>
</header>

<main id="main">
