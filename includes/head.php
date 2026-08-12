<?php
/**
 * <head> — SEO meta, Open Graph, JSON-LD, canonical, tema CSS.
 * Bu fayldan əvvəl bootstrap.php qoşulmalı və $page_* dəyişənləri təyin edilməlidir.
 */
$canonical = rtrim($SITE['url'], '/') . $page_url;
$og_image_abs = (strpos($page_image, 'http') === 0)
    ? $page_image
    : rtrim($SITE['url'], '/') . $page_image;

// JSON-LD: Organization
$ld_org = [
    '@type' => 'Organization',
    '@id'   => rtrim($SITE['url'], '/') . '/#organization',
    'name'  => $SITE['legal'],
    'url'   => rtrim($SITE['url'], '/') . '/',
    'logo'  => rtrim($SITE['url'], '/') . '/assets/img/logo.png',
    'email' => $SITE['email'],
    'telephone' => $SITE['phone'],
    'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Bakı', 'addressCountry' => 'AZ'],
    'sameAs' => array_values($SITE['social']),
];
// JSON-LD: WebPage
$ld_page = [
    '@type' => 'WebPage',
    '@id'   => $canonical . '#webpage',
    'url'   => $canonical,
    'name'  => $page_title,
    'description' => $page_desc,
    'inLanguage'  => $SITE['lang'],
    'isPartOf'    => ['@id' => rtrim($SITE['url'], '/') . '/#website'],
];
$graph = [$ld_org, $ld_page];
// JSON-LD: BreadcrumbList
if (!empty($breadcrumbs)) {
    $items = [];
    foreach ($breadcrumbs as $i => $b) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $b['name'],
            'item'     => rtrim($SITE['url'], '/') . $b['url'],
        ];
    }
    $graph[] = ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
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
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="<?= e($canonical) ?>">
    <link rel="alternate" hreflang="az" href="<?= e($canonical) ?>">
    <link rel="alternate" hreflang="x-default" href="<?= e($canonical) ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="<?= e($page_type) ?>">
    <meta property="og:site_name" content="<?= e($SITE['name']) ?>">
    <meta property="og:locale" content="<?= e($SITE['locale']) ?>">
    <meta property="og:title" content="<?= e($page_title) ?>">
    <meta property="og:description" content="<?= e($page_desc) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e($og_image_abs) ?>">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Favicon -->
    <link rel="icon" href="/assets/img/logo.png" sizes="any">
    <link rel="apple-touch-icon" href="/assets/img/logo.png">

    <!-- Fontlar -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Stil: ortaq baza + aktiv tema -->
    <link rel="stylesheet" href="<?= e(asset('/assets/css/base.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('/assets/css/theme-' . $theme_key . '.css')) ?>">

    <script type="application/ld+json"><?= json_encode($ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
</head>
<body class="section-<?= e($current_section) ?>">
<a class="skip-link" href="#main">Əsas məzmuna keç</a>
