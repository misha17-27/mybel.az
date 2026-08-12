<?php
/**
 * MYBEL CONCEPT — sayt konfiqurasiyası və məzmun (content) qatı.
 * Bütün mətnlər və siyahılar burada saxlanılır ki, redaktə bir yerdən aparılsın.
 * Demo şəkillər: /assets/img/demo/... (real fotolarla əvəz etmək üçün fayl yolunu dəyişin).
 */

define('IMG', '/assets/img/demo/');

// ---- Sayt haqqında ümumi məlumat (SEO və footer üçün) ----
$SITE = [
    'name'        => 'MYBEL Concept',
    'legal'       => 'MYBEL Concept MMC',
    'tagline'     => 'Premium mebel və interyer həlləri',
    'description' => 'MYBEL Concept — restoran, otel və fərdi evlər üçün fərdi dizayn mebel istehsalı. '
                   . 'Mətbəx mebeli, restoran masaları, otel otaqları üçün tam interyer həlləri.',
    'url'         => 'https://mybel.az',        // canonical domen
    'locale'      => 'az_AZ',
    'lang'        => 'az',
    'phone'       => '+994 50 000 00 00',
    'phone_raw'   => '+994500000000',
    'email'       => 'info@mybel.az',
    'address'     => 'Bakı, Azərbaycan',
    'map'         => 'https://www.google.com/maps?q=Baku,+Azerbaijan&output=embed',
    'social'      => [
        'instagram' => 'https://instagram.com/',
        'facebook'  => 'https://facebook.com/',
        'whatsapp'  => 'https://wa.me/994500000000',
    ],
    'work_hours'  => 'B.e – Şənbə: 09:00 – 18:00',
];

// ---- Kateqoriyalar (layihələr və fəaliyyət sahələri üçün ortaq) ----
$CATEGORIES = [
    'restoranlar' => 'Restoranlar',
    'oteller'     => 'Otellər',
    'ferdi-evler' => 'Fərdi evlər',
];

/**
 * Uzun placeholder mətn (Azərbaycan dilində "lorem ipsum" əvəzi).
 */
function ph_text($n = 1) {
    $p = 'MYBEL Concept olaraq hər layihəyə fərdi yanaşırıq. Materialın seçimindən quraşdırmaya '
       . 'qədər bütün mərhələləri öz komandamızla icra edir, uzunömürlü və estetik nəticə təqdim edirik. '
       . 'Məkanın funksionallığını qorumaqla müasir dizayn prinsiplərini birləşdiririk.';
    return implode(' ', array_fill(0, max(1, $n), $p));
}

// ---- LAYİHƏLƏR (tamamlanmış işlər) ----
$PROJECTS = [
    [
        'slug'     => 'panorama-restoran',
        'title'    => 'Panorama Restoran',
        'category' => 'restoranlar',
        'location' => 'Bakı',
        'year'     => '2024',
        'excerpt'  => 'Şəhər mənzərəsinə açılan restoran üçün tam mebel və bar zonası həlli.',
        'cover'    => IMG . 'restaurant-dark.jpg',
        'gallery'  => [IMG . 'restaurant-dark.jpg', IMG . 'lounge-designer.jpg', IMG . 'corner-orange.jpg'],
        'body'     => '<p>' . ph_text(2) . '</p><p>' . ph_text(1) . '</p>',
    ],
    [
        'slug'     => 'seaside-boutique-otel',
        'title'    => 'Seaside Boutique Otel',
        'category' => 'oteller',
        'location' => 'Qəbələ',
        'year'     => '2023',
        'excerpt'  => 'Butik otelin lobbi və 40 otağı üçün vahid konseptual mebel dizaynı.',
        'cover'    => IMG . 'resort-terrace.jpg',
        'gallery'  => [IMG . 'resort-terrace.jpg', IMG . 'living-luxury.jpg', IMG . 'hotel-room.jpg'],
        'body'     => '<p>' . ph_text(2) . '</p><p>' . ph_text(1) . '</p>',
    ],
    [
        'slug'     => 'white-villa',
        'title'    => 'White Villa',
        'category' => 'ferdi-evler',
        'location' => 'Şüvəlan',
        'year'     => '2024',
        'excerpt'  => 'Fərdi ev üçün mətbəx, qonaq otağı və yataq otaqlarının tam təchizatı.',
        'cover'    => IMG . 'house-exterior.jpg',
        'gallery'  => [IMG . 'house-exterior.jpg', IMG . 'living-openplan.jpg', IMG . 'living-yellow.jpg'],
        'body'     => '<p>' . ph_text(2) . '</p><p>' . ph_text(1) . '</p>',
    ],
    [
        'slug'     => 'old-city-brasserie',
        'title'    => 'Old City Brasserie',
        'category' => 'restoranlar',
        'location' => 'İçərişəhər',
        'year'     => '2022',
        'excerpt'  => 'Tarixi məkanda müasir brasserie üçün masa və oturacaq həlləri.',
        'cover'    => IMG . 'lounge-designer.jpg',
        'gallery'  => [IMG . 'lounge-designer.jpg', IMG . 'restaurant-dark.jpg', IMG . 'living-cozy.jpg'],
        'body'     => '<p>' . ph_text(2) . '</p><p>' . ph_text(1) . '</p>',
    ],
    [
        'slug'     => 'grand-plaza-hotel',
        'title'    => 'Grand Plaza Hotel',
        'category' => 'oteller',
        'location' => 'Bakı',
        'year'     => '2023',
        'excerpt'  => '5 ulduzlu otelin prezident suit və ümumi zonaları üçün mebel.',
        'cover'    => IMG . 'hotel-room.jpg',
        'gallery'  => [IMG . 'hotel-room.jpg', IMG . 'living-luxury.jpg', IMG . 'resort-terrace.jpg'],
        'body'     => '<p>' . ph_text(2) . '</p><p>' . ph_text(1) . '</p>',
    ],
    [
        'slug'     => 'green-house',
        'title'    => 'Green House',
        'category' => 'ferdi-evler',
        'location' => 'Mərdəkan',
        'year'     => '2021',
        'excerpt'  => 'Bağ evi üçün təbii ağacdan hazırlanmış mətbəx və terras mebeli.',
        'cover'    => IMG . 'living-cozy.jpg',
        'gallery'  => [IMG . 'living-cozy.jpg', IMG . 'kitchen-apartment.jpg', IMG . 'sofa-leather.jpg'],
        'body'     => '<p>' . ph_text(2) . '</p><p>' . ph_text(1) . '</p>',
    ],
];

// ---- FƏALİYYƏT SAHƏLƏRİ (nə ilə məşğul oluruq) ----
$AREAS = [
    [
        'slug'     => 'restoranlar',
        'title'    => 'Restoranlar',
        'excerpt'  => 'Restoran, kafe və barlar üçün tam interyer və mebel həlləri.',
        'cover'    => IMG . 'restaurant-dark.jpg',
        'gallery'  => [IMG . 'restaurant-dark.jpg', IMG . 'lounge-designer.jpg'],
        'body'     => '<p>' . ph_text(2) . '</p><p>' . ph_text(1) . '</p>',
    ],
    [
        'slug'     => 'oteller',
        'title'    => 'Otellər',
        'excerpt'  => 'Otel otaqları, lobbi və ümumi zonalar üçün vahid konseptual dizayn.',
        'cover'    => IMG . 'living-luxury.jpg',
        'gallery'  => [IMG . 'living-luxury.jpg', IMG . 'hotel-room.jpg'],
        'body'     => '<p>' . ph_text(2) . '</p><p>' . ph_text(1) . '</p>',
    ],
    [
        'slug'     => 'ferdi-evler',
        'title'    => 'Fərdi evlər',
        'excerpt'  => 'Mənzil və villalar üçün mətbəx, qarderob və fərdi mebel istehsalı.',
        'cover'    => IMG . 'apartment-blue.jpg',
        'gallery'  => [IMG . 'apartment-blue.jpg', IMG . 'living-neutral.jpg'],
        'body'     => '<p>' . ph_text(2) . '</p><p>' . ph_text(1) . '</p>',
    ],
];

// ---- XİDMƏTLƏR ----
$SERVICES = [
    ['icon' => 'kitchen',  'title' => 'Mətbəx mebeli',       'desc' => 'Fərdi ölçülü, müasir və klassik mətbəx dəstləri.'],
    ['icon' => 'table',    'title' => 'Restoran masaları',   'desc' => 'Davamlı və estetik masa, oturacaq və bar həlləri.'],
    ['icon' => 'bed',      'title' => 'Otel otaqları',       'desc' => 'Otel otaqlarının tam mebel təchizatı və dizaynı.'],
    ['icon' => 'wardrobe', 'title' => 'Qarderob və şkaflar', 'desc' => 'Fərdi qarderob otaqları və gömmə şkaflar.'],
    ['icon' => 'sofa',     'title' => 'Yumşaq mebel',        'desc' => 'Divan, kreslo və yumşaq mebelin sifarişlə istehsalı.'],
    ['icon' => 'design',   'title' => 'İnteryer dizayn',     'desc' => 'Layihələndirmə, 3D vizuallaşdırma və məsləhət.'],
];

// ---- MÜŞTƏRİLƏR (loqolar) ----
$CLIENTS = [];
for ($i = 1; $i <= 10; $i++) {
    $CLIENTS[] = [
        'name' => 'Müştəri ' . $i,
        'logo' => '/assets/placeholder.php?w=240&h=120&t=Logo+' . $i . '&c=0',
    ];
}

// =====================================================================
//  Köməkçi funksiyalar
// =====================================================================
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/** Asset URL + avtomatik keş-busting (fayl dəyişdikcə ?v dəyişir) */
function asset($path) {
    $full = ($_SERVER['DOCUMENT_ROOT'] ?? __DIR__ . '/..') . $path;
    $v = @filemtime($full) ?: 1;
    return $path . '?v=' . $v;
}

/** slug üzrə elementi tapır (layihə və ya fəaliyyət sahəsi) */
function find_by_slug(array $list, $slug) {
    foreach ($list as $item) {
        if ($item['slug'] === $slug) return $item;
    }
    return null;
}

/** Kateqoriya adını qaytarır */
function cat_name($key) {
    global $CATEGORIES;
    return $CATEGORIES[$key] ?? $key;
}
