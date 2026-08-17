<?php
/** Admin layout — üst hissə. Əvvəldən $PAGE_TITLE və $ACTIVE təyin edilir. */
require_login();
$U = current_user();
$PAGE_TITLE = $PAGE_TITLE ?? 'Панель';
$ACTIVE = $ACTIVE ?? '';

function a_icon($n){
  $p=[
    'home'=>'<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>',
    'text'=>'<line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="14" y2="18"/>',
    'grid'=>'<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>',
    'layers'=>'<polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>',
    'users'=>'<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/>',
    'image'=>'<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>',
    'phone'=>'<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.9.34 1.79.63 2.65a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.42-1.42a2 2 0 0 1 2.11-.45c.86.29 1.75.5 2.65.63A2 2 0 0 1 22 16.92z"/>',
    'mail'=>'<rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="22,6 12,13 2,6"/>',
    'seo'=>'<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
    'user'=>'<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
    'lock'=>'<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
  ];
  return '<svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.($p[$n]??'').'</svg>';
}
$NAV = [
  [t('g_main'), [
    ['dashboard',t('n_dashboard'),'/admin/','home'],
  ]],
  [t('g_content'), [
    ['texts',t('n_texts'),'/admin/texts.php','text'],
    ['projects',t('n_projects'),'/admin/projects.php','grid'],
    ['services',t('n_services'),'/admin/services.php','grid'],
    ['clients',t('n_clients'),'/admin/clients.php','users'],
    ['contacts',t('n_contacts'),'/admin/contacts.php','phone'],
    ['messages',t('n_messages'),'/admin/messages.php','mail'],
  ]],
  [t('g_settings'), [
    ['seo',t('n_seo'),'/admin/seo.php','seo'],
    ['mail',t('n_mail'),'/admin/mail.php','mail'],
    ['security',t('n_security'),'/admin/security.php','lock'],
    ['users',t('n_users'),'/admin/users.php','user'],
    ['profile',t('n_profile'),'/admin/profile.php','user'],
  ]],
];
// dil seçici üçün cari yol (mövcud lang parametri olmadan)
$curPath = strtok($_SERVER['REQUEST_URI'], '?');
$qs = $_GET; unset($qs['lang']);
$baseQs = http_build_query($qs);
$langBase = $curPath . ($baseQs ? "?$baseQs&" : '?');
?><!doctype html>
<html lang="<?= e($ADMIN_LANG) ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e($PAGE_TITLE) ?> — MYBEL admin</title>
<link rel="icon" href="/assets/img/logo.png">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/admin/assets/admin.css?v=3">
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
</head>
<body>
<div class="admin">
  <div class="sidebar-backdrop" id="backdrop"></div>
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand"><img src="/assets/img/logo.png" alt="MYBEL"></div>
    <nav class="sidebar-nav">
      <?php foreach ($NAV as [$group, $items]): ?>
        <?php if (($U['role'] ?? '') !== 'admin' && $group === t('g_settings')) { $items = array_filter($items, fn($i)=>!in_array($i[0],['users','security','mail'],true)); } ?>
        <div class="sidebar-group"><?= e($group) ?></div>
        <?php foreach ($items as [$key,$label,$href,$icon]): ?>
          <a href="<?= e($href) ?>" class="<?= $ACTIVE===$key?'active':'' ?>"><?= a_icon($icon) ?><span><?= e($label) ?></span></a>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </nav>
    <div class="sidebar-foot"><?= e(t('logged_as')) ?><b><?= e($U['name']) ?></b></div>
  </aside>

  <div class="main">
    <div class="topbar">
      <div class="inline">
        <button class="menu-btn" id="menuBtn" aria-label="<?= e(t('menu')) ?>">☰</button>
        <h1><?= e($PAGE_TITLE) ?></h1>
      </div>
      <div class="topbar-actions">
        <span class="lang-switch">
          <?php foreach ($ADMIN_LANGS as $code => $label): ?>
            <a href="<?= e($langBase . 'lang=' . $code) ?>" class="<?= $ADMIN_LANG===$code?'on':'' ?>"><?= e($label) ?></a>
          <?php endforeach; ?>
        </span>
        <a href="/" target="_blank" class="btn btn-outline btn-sm"><?= e(t('open_site')) ?> ↗</a>
        <a href="/admin/logout.php" class="btn btn-sm"><?= e(t('logout')) ?></a>
      </div>
    </div>
    <div class="content">
      <?php foreach (get_flashes() as $f): ?>
        <div class="alert alert-<?= $f['type']==='error'?'error':'success' ?>"><?= e($f['msg']) ?></div>
      <?php endforeach; ?>
