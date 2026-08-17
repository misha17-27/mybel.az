<?php
/**
 * Bootstrap — hər səhifənin başında qoşulur.
 * Konfiqurasiyanı yükləyir və aktiv dizayn temasını (1/2/3) təyin edir.
 */
require __DIR__ . '/config.php';
require __DIR__ . '/icons.php';

// ---- Dizayn temaları (3 versiya) ----
$THEMES = [
    1 => ['key' => 'classic', 'name' => 'Klassik'],
    2 => ['key' => 'modern',  'name' => 'Modern'],
    3 => ['key' => 'minimal', 'name' => 'Minimal'],
];

// Təsdiqlənmiş dizayn: Versiya 2 (Modern). ?theme= yalnız daxili önizləmə üçün saxlanılır.
$theme = 2;
if (isset($_GET['theme']) && isset($THEMES[(int)$_GET['theme']])) {
    $theme = (int)$_GET['theme'];
}
$theme_key = $THEMES[$theme]['key'];

// ---- SEO üçün standart dəyərlər (səhifələr override edə bilər) ----
$page_title = $SITE['name'] . ' — ' . $SITE['tagline'];
$page_desc  = $SITE['description'];
$page_url   = '/';                 // kanonik üçün nisbi yol
$page_type  = 'website';
$page_image = '/assets/img/logo.png';
$breadcrumbs = [];                 // [['name'=>..,'url'=>..], ...]

/** Aktiv naviqasiya bəndini işarələmək üçün cari bölmə */
$current_section = $current_section ?? '';
