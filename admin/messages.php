<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();
$messages = load_json('messages', []);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';
    if ($action === 'delete') {
        $messages = array_values(array_filter($messages, fn($m) => $m['id'] !== $id));
        flash(t('m_deleted'));
    } elseif ($action === 'toggle') {
        foreach ($messages as &$m) if ($m['id'] === $id) $m['read'] = empty($m['read']);
    } elseif ($action === 'read_all') {
        foreach ($messages as &$m) $m['read'] = true;
        flash(t('m_readall_done'));
    }
    save_json('messages', $messages);
    redirect('/admin/messages.php');
}

$PAGE_TITLE = t('m_title');
$ACTIVE = 'messages';
require __DIR__ . '/includes/layout_top.php';
$unread = count(array_filter($messages, fn($m)=>empty($m['read'])));
?>
<div class="card">
  <div class="item-head">
    <div><h2><?= e(t('m_head')) ?></h2><p class="hint" style="margin:0"><?= e(t('m_total')) ?> <?= count($messages) ?>. <?= e(t('m_unread')) ?> <?= $unread ?>.</p></div>
    <?php if ($messages): ?>
    <form method="post" style="margin:0"><?= csrf_field() ?><input type="hidden" name="action" value="read_all">
      <button class="btn btn-outline btn-sm"><?= e(t('m_readall')) ?></button></form>
    <?php endif; ?>
  </div>
</div>

<?php if (!$messages): ?>
  <div class="card"><p class="muted"><?= e(t('m_none')) ?></p></div>
<?php else: foreach ($messages as $m): ?>
  <div class="card" style="border-left:4px solid <?= empty($m['read'])?'var(--brand)':'var(--line)' ?>">
    <div class="item-head">
      <div>
        <strong><?= e($m['name']) ?></strong>
        <?php if (empty($m['read'])): ?><span class="badge badge-new"><?= e(t('m_new')) ?></span><?php endif; ?>
        <div class="muted" style="font-size:.82rem"><?= e($m['date']??'') ?> · IP: <?= e($m['ip']??'') ?></div>
      </div>
      <div class="inline" style="gap:.4rem">
        <form method="post" style="margin:0"><?= csrf_field() ?><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= e($m['id']) ?>">
          <button class="btn btn-outline btn-sm"><?= empty($m['read'])?e(t('m_read')):e(t('m_unreadbtn')) ?></button></form>
        <form method="post" data-confirm="<?= e(t('m_confirm')) ?>" style="margin:0"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($m['id']) ?>">
          <button class="btn btn-danger btn-sm"><?= e(t('delete')) ?></button></form>
      </div>
    </div>
    <div class="muted" style="font-size:.88rem;margin-bottom:.5rem">
      <?php if(!empty($m['phone'])): ?><?= e(t('m_phone')) ?> <?= e($m['phone']) ?> · <?php endif; ?>
      <?php if(!empty($m['email'])): ?><?= e(t('email')) ?>: <a href="mailto:<?= e($m['email']) ?>"><?= e($m['email']) ?></a><?php endif; ?>
    </div>
    <div style="background:var(--bg);border:1px solid var(--line);border-radius:8px;padding:.7rem .9rem"><?= nl2br(e($m['message']??'')) ?></div>
  </div>
<?php endforeach; endif; ?>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
