<?php
/**
 * <head> — SEO meta, Open Graph, Twitter, JSON-LD, canonical, analytics.
 * Bu fayldan əvvəl bootstrap.php qoşulmalı və $page_* dəyişənləri təyin edilməlidir.
 */
$base = rtrim($SITE['url'], '/');
$seo  = $SITE['seo'] ?? [];
$canonical = $base . $page_url;
$og_image_abs = (strpos($page_image, 'http') === 0) ? $page_image : $base . $page_image;
$favicon = $seo['favicon'] ?: '/assets/img/logo.png';
$noindex = (($seo['robots'] ?? 'index') === 'noindex');

// ---------- JSON-LD ----------
$ld_org = [
    '@type'      => $seo['org_type'] ?: 'Organization',
    '@id'        => $base . '/#organization',
    'name'       => $SITE['legal'] ?: $SITE['name'],
    'url'        => $base . '/',
    'logo'       => ['@type' => 'ImageObject', 'url' => $base . '/assets/img/logo.png'],
    'image'      => $base . ($seo['og_image'] ?: '/assets/img/logo.png'),
    'email'      => $SITE['email'],
    'telephone'  => $SITE['phone'],
    'address'    => ['@type' => 'PostalAddress', 'addressLocality' => 'Bakı', 'addressCountry' => 'AZ'],
    'areaServed' => 'AZ',
    'priceRange' => $seo['price_range'] ?: '$$',
    'sameAs'     => array_values(array_filter($SITE['social'] ?? [])),
];
$ld_site = [
    '@type'      => 'WebSite',
    '@id'        => $base . '/#website',
    'url'        => $base . '/',
    'name'       => $SITE['name'],
    'inLanguage' => $SITE['lang'],
    'publisher'  => ['@id' => $base . '/#organization'],
];
$ld_page = [
    '@type'       => 'WebPage',
    '@id'         => $canonical . '#webpage',
    'url'         => $canonical,
    'name'        => $page_title,
    'description' => $page_desc,
    'inLanguage'  => $SITE['lang'],
    'isPartOf'    => ['@id' => $base . '/#website'],
    'about'       => ['@id' => $base . '/#organization'],
];
$graph = [$ld_org, $ld_site, $ld_page];
if (!empty($breadcrumbs)) {
    $items = [];
    foreach ($breadcrumbs as $i => $b) {
        $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $b['name'], 'item' => $base . $b['url']];
    }
    $graph[] = ['@type' => 'BreadcrumbList', '@id' => $canonical . '#breadcrumb', 'itemListElement' => $items];
}
$ld = ['@context' => 'https://schema.org', '@graph' => $graph];
?>
<!doctype html>
<html lang="<?= e($SITE['lang']) ?>" data-theme="<?= e($theme_key) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#c75b2a">

    <title><?= e($page_title) ?></title>
    <meta name="description" content="<?= e($page_desc) ?>">
    <?php if (!empty($seo['keywords'])): ?><meta name="keywords" content="<?= e($seo['keywords']) ?>">
    <?php endif; ?>
    <meta name="robots" content="<?= $noindex ? 'noindex, nofollow' : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' ?>">
    <?php if (!empty($seo['gsc_verify'])): ?><meta name="google-site-verification" content="<?= e($seo['gsc_verify']) ?>">
    <?php endif; ?>
    <link rel="canonical" href="<?= e($canonical) ?>">
    <link rel="alternate" hreflang="az" href="<?= e($canonical) ?>">
    <link rel="alternate" hreflang="x-default" href="<?= e($canonical) ?>">
    <meta name="author" content="<?= e($SITE['legal'] ?: $SITE['name']) ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="<?= e($page_type) ?>">
    <meta property="og:site_name" content="<?= e($SITE['name']) ?>">
    <meta property="og:locale" content="<?= e($SITE['locale']) ?>">
    <meta property="og:title" content="<?= e($page_title) ?>">
    <meta property="og:description" content="<?= e($page_desc) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e($og_image_abs) ?>">
    <meta property="og:image:alt" content="<?= e($page_title) ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($page_title) ?>">
    <meta name="twitter:description" content="<?= e($page_desc) ?>">
    <meta name="twitter:image" content="<?= e($og_image_abs) ?>">

    <!-- Favicon -->
    <link rel="icon" href="<?= e($favicon) ?>" sizes="any">
    <link rel="apple-touch-icon" href="<?= e($favicon) ?>">

    <!-- Fontlar -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Stil -->
    <link rel="stylesheet" href="<?= e(asset('/assets/css/base.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('/assets/css/theme-' . $theme_key . '.css')) ?>">

    <script type="application/ld+json"><?= json_encode($ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>

    <?php if (!empty($seo['ga_id']) && !$noindex): ?>
    <!-- Google Analytics (GA4) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($seo['ga_id']) ?>"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= e($seo['ga_id']) ?>');</script>
    <?php endif; ?>
</head>
<body class="section-<?= e($current_section) ?>">
<a class="skip-link" href="#main">Əsas məzmuna keç</a>
