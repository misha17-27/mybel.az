<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();

$projects = load_json('projects', []);
$areas    = load_json('areas', []);
$services = load_json('services', []);
$clients  = load_json('clients', []);
$messages = load_json('messages', []);
$unread   = count(array_filter($messages, fn($m) => empty($m['read'])));

$PAGE_TITLE = 'Обзор';
$ACTIVE = 'dashboard';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="grid grid-4" style="margin-bottom:1.5rem">
  <div class="stat"><div class="num"><?= count($projects) ?></div><div class="lbl">проектов</div></div>
  <div class="stat"><div class="num"><?= count($areas) ?></div><div class="lbl">сфер деятельности</div></div>
  <div class="stat"><div class="num"><?= count($services) ?></div><div class="lbl">услуг</div></div>
  <div class="stat"><div class="num"><?= $unread ?></div><div class="lbl">новых заявок</div></div>
</div>

<div class="grid grid-2">
  <div class="card">
    <h2>Быстрые действия</h2>
    <p class="hint">С чего обычно начинают.</p>
    <div class="inline" style="flex-wrap:wrap;gap:.6rem">
      <a href="/admin/projects.php" class="btn">Добавить проект</a>
      <a href="/admin/texts.php" class="btn btn-outline">Редактировать тексты</a>
      <a href="/admin/clients.php" class="btn btn-outline">Клиенты</a>
      <a href="/admin/messages.php" class="btn btn-outline">Заявки с сайта<?php if($unread):?> <span class="badge badge-new"><?= $unread ?></span><?php endif;?></a>
    </div>
  </div>
  <div class="card">
    <h2>Публикация</h2>
    <p class="hint">Изменения сохраняются сразу и сайт отдаёт их без пересборки.</p>
    <div class="inline" style="flex-wrap:wrap;gap:.6rem">
      <a href="/" target="_blank" class="btn btn-outline">Главная ↗</a>
      <a href="/layiheler/" target="_blank" class="btn btn-outline">Проекты ↗</a>
      <a href="/elaqe/" target="_blank" class="btn btn-outline">Контакты ↗</a>
    </div>
  </div>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
