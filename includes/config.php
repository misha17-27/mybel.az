<?php
/**
 * config.php — konfiqurasiya + məzmun yükləyicisi.
 * Məzmun /data/*.json fayllarından oxunur (admin panel redaktə edir).
 * Fayllar yoxdursa aşağıdakı default dəyərlərlə avtomatik yaradılır (seed).
 */
require_once __DIR__ . '/store.php';

define('IMG', '/assets/img/demo/');

// ---------- köməkçi mətn generatoru (seed üçün) ----------
function ph_text($n = 1) {
    $p = 'MYBEL Concept olaraq hər layihəyə fərdi yanaşırıq. Materialın seçimindən quraşdırmaya '
       . 'qədər bütün mərhələləri öz komandamızla icra edir, uzunömürlü və estetik nəticə təqdim edirik. '
       . 'Məkanın funksionallığını qorumaqla müasir dizayn prinsiplərini birləşdiririk.';
    return implode(' ', array_fill(0, max(1, $n), $p));
}

// ---------- DEFAULT: sayt parametrləri ----------
$DEF_SETTINGS = [
    'name'        => 'MYBEL Concept',
    'legal'       => 'MYBEL Concept MMC',
    'tagline'     => 'Premium mebel və interyer həlləri',
    'description' => 'MYBEL Concept — restoran, otel və fərdi evlər üçün fərdi dizayn mebel istehsalı. '
                   . 'Mətbəx mebeli, restoran masaları, otel otaqları üçün tam interyer həlləri.',
    'url'         => 'https://mybel.az',
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
        'youtube'   => '',
        'x'         => '',
    ],
    'work_hours'  => 'B.e – Şənbə: 09:00 – 18:00',
    'hero'        => [
        'eyebrow' => 'Premium mebel & interyer',
        'title'   => 'Məkanınıza dəyər qatan fərdi mebel həlləri',
        'lead'    => 'Restoran, otel və fərdi evlər üçün layihələndirmədən quraşdırmaya qədər tam interyer və mebel istehsalı.',
    ],
    'about'       => [
        'eyebrow' => 'Şirkət haqqında',
        'title'   => 'Keyfiyyət və dizaynı bir araya gətiririk',
        'text'    => ph_text(1),
        'video'   => '',   // YouTube/Vimeo linki və ya .mp4 faylı (admin paneldən)
    ],
    // Ana səhifə bölmə başlıqları
    'home'        => [
        'projects_eyebrow' => 'Layihələr',
        'projects_title'   => 'Seçilmiş işlərimiz',
        'projects_desc'    => 'Restoran, otel və fərdi evlər üzrə tamamladığımız bəzi layihələr.',
        'services_eyebrow' => 'Xidmətlər',
        'services_title'   => 'Nə təklif edirik',
        'clients_eyebrow'  => 'Müştərilər',
        'clients_title'    => 'Bizə etibar edənlər',
        'cta_title'        => 'Layihəniz üçün təklif alın',
        'cta_text'         => 'İdeyanızı bizimlə bölüşün — komandamız ölçü, dizayn və qiymət təklifini hazırlasın.',
        'cta_btn'          => 'Sifariş ver',
    ],
    // "Şirkət haqqında" səhifəsi
    'about_page'  => [
        'lead'           => 'MYBEL Concept — dizayn, keyfiyyət və dəqiqliyi birləşdirən mebel istehsalçısı.',
        'intro_eyebrow'  => 'Kimik biz',
        'intro_title'    => 'İdeyanı reallığa çeviririk',
        'intro_text'     => ph_text(1) . "\n\n" . ph_text(1),
        'mission_title'  => 'Hər detala önəm veririk',
        'mission_text'   => ph_text(1),
        'approach_title' => 'Layihələndirmədən quraşdırmaya',
        'approach_text'  => ph_text(1),
        'stats'          => [
            ['num' => '150+', 'label' => 'Tamamlanmış layihə'],
            ['num' => '12',   'label' => 'İl təcrübə'],
            ['num' => '40+',  'label' => 'Komanda üzvü'],
            ['num' => '98%',  'label' => 'Məmnun müştəri'],
        ],
    ],
    'seo'         => [
        'home_title' => 'MYBEL Concept — Premium mebel və interyer həlləri | Bakı',
        'home_desc'  => 'MYBEL Concept — restoran, otel və fərdi evlər üçün fərdi dizayn mebel istehsalı. Mətbəx mebeli, restoran masaları, otel otaqları üçün tam interyer həlləri.',
        'og_image'   => '/assets/img/logo.png',
        'robots'     => 'index',
    ],
    'security'    => [
        'turnstile_enabled' => false,
        'turnstile_site'    => '',
        'turnstile_secret'  => '',
    ],
    'smtp'        => [
        'host' => '', 'port' => 587, 'enc' => 'tls',
        'user' => '', 'pass' => '', 'from' => '', 'from_name' => 'MYBEL Concept',
    ],
];

// ---------- DEFAULT: layihələr ----------
$DEF_PROJECTS = [
    ['id'=>'p1','slug'=>'panorama-restoran','title'=>'Panorama Restoran','category'=>'restoranlar','location'=>'Bakı','year'=>'2024','show'=>true,'order'=>0,
     'excerpt'=>'Şəhər mənzərəsinə açılan restoran üçün tam mebel və bar zonası həlli.',
     'cover'=>IMG.'restaurant-dark.jpg','gallery'=>[IMG.'restaurant-dark.jpg',IMG.'lounge-designer.jpg',IMG.'corner-orange.jpg'],
     'body'=>'<p>'.ph_text(2).'</p><p>'.ph_text(1).'</p>'],
    ['id'=>'p2','slug'=>'seaside-boutique-otel','title'=>'Seaside Boutique Otel','category'=>'oteller','location'=>'Qəbələ','year'=>'2023','show'=>true,'order'=>1,
     'excerpt'=>'Butik otelin lobbi və 40 otağı üçün vahid konseptual mebel dizaynı.',
     'cover'=>IMG.'resort-terrace.jpg','gallery'=>[IMG.'resort-terrace.jpg',IMG.'living-luxury.jpg',IMG.'hotel-room.jpg'],
     'body'=>'<p>'.ph_text(2).'</p><p>'.ph_text(1).'</p>'],
    ['id'=>'p3','slug'=>'white-villa','title'=>'White Villa','category'=>'ferdi-evler','location'=>'Şüvəlan','year'=>'2024','show'=>true,'order'=>2,
     'excerpt'=>'Fərdi ev üçün mətbəx, qonaq otağı və yataq otaqlarının tam təchizatı.',
     'cover'=>IMG.'house-exterior.jpg','gallery'=>[IMG.'house-exterior.jpg',IMG.'living-openplan.jpg',IMG.'living-yellow.jpg'],
     'body'=>'<p>'.ph_text(2).'</p><p>'.ph_text(1).'</p>'],
    ['id'=>'p4','slug'=>'old-city-brasserie','title'=>'Old City Brasserie','category'=>'restoranlar','location'=>'İçərişəhər','year'=>'2022','show'=>true,'order'=>3,
     'excerpt'=>'Tarixi məkanda müasir brasserie üçün masa və oturacaq həlləri.',
     'cover'=>IMG.'lounge-designer.jpg','gallery'=>[IMG.'lounge-designer.jpg',IMG.'restaurant-dark.jpg',IMG.'living-cozy.jpg'],
     'body'=>'<p>'.ph_text(2).'</p><p>'.ph_text(1).'</p>'],
    ['id'=>'p5','slug'=>'grand-plaza-hotel','title'=>'Grand Plaza Hotel','category'=>'oteller','location'=>'Bakı','year'=>'2023','show'=>true,'order'=>4,
     'excerpt'=>'5 ulduzlu otelin prezident suit və ümumi zonaları üçün mebel.',
     'cover'=>IMG.'hotel-room.jpg','gallery'=>[IMG.'hotel-room.jpg',IMG.'living-luxury.jpg',IMG.'resort-terrace.jpg'],
     'body'=>'<p>'.ph_text(2).'</p><p>'.ph_text(1).'</p>'],
    ['id'=>'p6','slug'=>'green-house','title'=>'Green House','category'=>'ferdi-evler','location'=>'Mərdəkan','year'=>'2021','show'=>true,'order'=>5,
     'excerpt'=>'Bağ evi üçün təbii ağacdan hazırlanmış mətbəx və terras mebeli.',
     'cover'=>IMG.'living-cozy.jpg','gallery'=>[IMG.'living-cozy.jpg',IMG.'kitchen-apartment.jpg',IMG.'sofa-leather.jpg'],
     'body'=>'<p>'.ph_text(2).'</p><p>'.ph_text(1).'</p>'],
];

// ---------- DEFAULT: fəaliyyət sahələri ----------
$DEF_AREAS = [
    ['id'=>'a1','slug'=>'restoranlar','title'=>'Restoranlar','show'=>true,'order'=>0,
     'excerpt'=>'Restoran, kafe və barlar üçün tam interyer və mebel həlləri.',
     'cover'=>IMG.'restaurant-dark.jpg','gallery'=>[IMG.'restaurant-dark.jpg',IMG.'lounge-designer.jpg'],
     'body'=>'<p>'.ph_text(2).'</p><p>'.ph_text(1).'</p>'],
    ['id'=>'a2','slug'=>'oteller','title'=>'Otellər','show'=>true,'order'=>1,
     'excerpt'=>'Otel otaqları, lobbi və ümumi zonalar üçün vahid konseptual dizayn.',
     'cover'=>IMG.'living-luxury.jpg','gallery'=>[IMG.'living-luxury.jpg',IMG.'hotel-room.jpg'],
     'body'=>'<p>'.ph_text(2).'</p><p>'.ph_text(1).'</p>'],
    ['id'=>'a3','slug'=>'ferdi-evler','title'=>'Fərdi evlər','show'=>true,'order'=>2,
     'excerpt'=>'Mənzil və villalar üçün mətbəx, qarderob və fərdi mebel istehsalı.',
     'cover'=>IMG.'apartment-blue.jpg','gallery'=>[IMG.'apartment-blue.jpg',IMG.'living-neutral.jpg'],
     'body'=>'<p>'.ph_text(2).'</p><p>'.ph_text(1).'</p>'],
];

// ---------- DEFAULT: xidmətlər ----------
$DEF_SERVICES = [
    ['id'=>'s1','slug'=>'metbex-mebeli','icon'=>'kitchen','title'=>'Mətbəx mebeli','desc'=>'Fərdi ölçülü, müasir və klassik mətbəx dəstləri.','body'=>'','projects'=>[],'show'=>true,'order'=>0],
    ['id'=>'s2','slug'=>'restoran-masalari','icon'=>'table','title'=>'Restoran masaları','desc'=>'Davamlı və estetik masa, oturacaq və bar həlləri.','body'=>'','projects'=>[],'show'=>true,'order'=>1],
    ['id'=>'s3','slug'=>'otel-otaqlari','icon'=>'bed','title'=>'Otel otaqları','desc'=>'Otel otaqlarının tam mebel təchizatı və dizaynı.','body'=>'','projects'=>[],'show'=>true,'order'=>2],
    ['id'=>'s4','slug'=>'qarderob-ve-skaflar','icon'=>'wardrobe','title'=>'Qarderob və şkaflar','desc'=>'Fərdi qarderob otaqları və gömmə şkaflar.','body'=>'','projects'=>[],'show'=>true,'order'=>3],
    ['id'=>'s5','slug'=>'yumsaq-mebel','icon'=>'sofa','title'=>'Yumşaq mebel','desc'=>'Divan, kreslo və yumşaq mebelin sifarişlə istehsalı.','body'=>'','projects'=>[],'show'=>true,'order'=>4],
    ['id'=>'s6','slug'=>'interyer-dizayn','icon'=>'design','title'=>'İnteryer dizayn','desc'=>'Layihələndirmə, 3D vizuallaşdırma və məsləhət.','body'=>'','projects'=>[],'show'=>true,'order'=>5],
];

// ---------- DEFAULT: müştərilər ----------
$DEF_CLIENTS = [];
for ($i = 1; $i <= 10; $i++) {
    $DEF_CLIENTS[] = ['id'=>'c'.$i,'name'=>'Müştəri '.$i,'logo'=>'/assets/placeholder.php?w=240&h=120&t=Logo+'.$i.'&c=0','order'=>$i-1,'show'=>true];
}

// ---------- YÜKLƏ (yoxdursa seed) ----------
$SITE      = load_or_seed('settings', $DEF_SETTINGS);
$PROJECTS  = load_or_seed('projects', $DEF_PROJECTS);
$AREAS     = load_or_seed('areas',    $DEF_AREAS);
$SERVICES  = load_or_seed('services', $DEF_SERVICES);
$CLIENTS   = load_or_seed('clients',  $DEF_CLIENTS);

// köhnə seed-lərdə yeni açarlar olmaya bilər — birləşdir
$SITE = array_replace_recursive($DEF_SETTINGS, $SITE);

// ---------- Kateqoriyalar (statik) ----------
$CATEGORIES = [
    'restoranlar' => 'Restoranlar',
    'oteller'     => 'Otellər',
    'ferdi-evler' => 'Fərdi evlər',
];

// ---------- yalnız görünən + sıralanmış elementlər (publik sayt üçün) ----------
function visible_sorted($list) {
    $list = array_filter($list, fn($x) => ($x['show'] ?? true));
    usort($list, fn($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));
    return array_values($list);
}

// =====================================================================
//  Köməkçi funksiyalar
// =====================================================================
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function asset($path) {
    $full = ($_SERVER['DOCUMENT_ROOT'] ?? __DIR__ . '/..') . $path;
    $v = @filemtime($full) ?: 1;
    return $path . '?v=' . $v;
}

function find_by_slug(array $list, $slug) {
    foreach ($list as $item) {
        if (($item['slug'] ?? null) === $slug) return $item;
    }
    return null;
}

function cat_name($key) {
    global $CATEGORIES;
    return $CATEGORIES[$key] ?? $key;
}

/** Xidmət üçün slug (yoxdursa başlıqdan) */
function service_slug($s) {
    return !empty($s['slug']) ? $s['slug'] : slugify($s['title'] ?? '');
}

/** Xidmətə bağlı görünən layihələr */
function service_projects($service, $allProjects) {
    $ids = $service['projects'] ?? [];
    if (empty($ids)) return [];
    $out = array_filter($allProjects, fn($p) => in_array($p['id'], $ids, true) && ($p['show'] ?? true));
    usort($out, fn($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));
    return array_values($out);
}

/**
 * Video linkindən responsiv embed qaytarır (YouTube/Vimeo/mp4).
 * Boş olarsa boş sətir qaytarır.
 */
function video_embed($url) {
    $url = trim((string)$url);
    if ($url === '') return '';
    if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([\w-]{11})~', $url, $m)) {
        return '<div class="video-frame"><iframe src="https://www.youtube.com/embed/' . e($m[1])
             . '" title="Video" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
    }
    if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
        return '<div class="video-frame"><iframe src="https://player.vimeo.com/video/' . e($m[1])
             . '" title="Video" loading="lazy" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>';
    }
    if (preg_match('~\.(mp4|webm|ogg)(\?.*)?$~i', $url)) {
        return '<div class="video-frame"><video controls preload="metadata"><source src="' . e($url) . '"></video></div>';
    }
    // digər hallar: birbaşa iframe mənbəyi kimi
    return '<div class="video-frame"><iframe src="' . e($url) . '" title="Video" loading="lazy" allowfullscreen></iframe></div>';
}

/** Turnstile aktivdir? (açıq + açarlar var) */
function turnstile_active($SITE): bool {
    $s = $SITE['security'] ?? [];
    return !empty($s['turnstile_enabled']) && !empty($s['turnstile_site']) && !empty($s['turnstile_secret']);
}

/** Turnstile tokenini serverdə yoxla */
function turnstile_verify(string $secret, ?string $token, ?string $ip = null): bool {
    if ($secret === '') return true;      // konfiqurasiya yoxdursa keç
    if (!$token) return false;
    $data = http_build_query(['secret' => $secret, 'response' => $token, 'remoteip' => $ip]);
    $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
    $res = null;
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [CURLOPT_POST => true, CURLOPT_POSTFIELDS => $data, CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 10]);
        $res = curl_exec($ch);
        curl_close($ch);
    } else {
        $ctx = stream_context_create(['http' => ['method' => 'POST', 'header' => 'Content-Type: application/x-www-form-urlencoded', 'content' => $data, 'timeout' => 10]]);
        $res = @file_get_contents($url, false, $ctx);
    }
    if (!$res) return false;
    $j = json_decode($res, true);
    return !empty($j['success']);
}
