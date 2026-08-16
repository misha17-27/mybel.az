<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();

$projects = load_json('projects', []);
$areas    = load_json('areas', []);
$services = load_json('services', []);
$clients  = load_json('clients', []);
$messages = load_json('messages', []);
$unread   = count(array_filter($messages, fn($m) => empty($m['read'])));

$PAGE_TITLE = t('n_dashboard');
$ACTIVE = 'dashboard';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="grid grid-4" style="margin-bottom:1.5rem">
  <div class="stat"><div class="num"><?= count($projects) ?></div><div class="lbl"><?= e(t('d_projects')) ?></div></div>
  <div class="stat"><div class="num"><?= count($areas) ?></div><div class="lbl"><?= e(t('d_areas')) ?></div></div>
  <div class="stat"><div class="num"><?= count($services) ?></div><div class="lbl"><?= e(t('d_services')) ?></div></div>
  <div class="stat"><div class="num"><?= $unread ?></div><div class="lbl"><?= e(t('d_new')) ?></div></div>
</div>

<div class="grid grid-2">
  <div class="card">
    <h2><?= e(t('d_quick')) ?></h2>
    <p class="hint"><?= e(t('d_quick_h')) ?></p>
    <div class="inline" style="flex-wrap:wrap;gap:.6rem">
      <a href="/admin/projects.php" class="btn"><?= e(t('d_addproj')) ?></a>
      <a href="/admin/texts.php" class="btn btn-outline"><?= e(t('d_edittext')) ?></a>
      <a href="/admin/clients.php" class="btn btn-outline"><?= e(t('n_clients')) ?></a>
      <a href="/admin/messages.php" class="btn btn-outline"><?= e(t('n_messages')) ?><?php if($unread):?> <span class="badge badge-new"><?= $unread ?></span><?php endif;?></a>
    </div>
  </div>
  <div class="card">
    <h2><?= e(t('d_pub')) ?></h2>
    <p class="hint"><?= e(t('d_pub_h')) ?></p>
    <div class="inline" style="flex-wrap:wrap;gap:.6rem">
      <a href="/" target="_blank" class="btn btn-outline"><?= e(t('d_home')) ?> ↗</a>
      <a href="/layiheler/" target="_blank" class="btn btn-outline"><?= e(t('n_projects')) ?> ↗</a>
      <a href="/elaqe/" target="_blank" class="btn btn-outline"><?= e(t('d_contacts')) ?> ↗</a>
    </div>
  </div>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
