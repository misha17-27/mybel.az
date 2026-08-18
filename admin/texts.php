<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();
$s = load_json('settings', []);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $s['name']        = trim($_POST['name'] ?? $s['name']);
    $s['legal']       = trim($_POST['legal'] ?? '');
    $s['tagline']     = trim($_POST['tagline'] ?? '');
    $s['description'] = trim($_POST['description'] ?? '');
    save_json('settings', $s);
    flash(t('t_saved'));
    redirect('/admin/texts.php');
}

$PAGE_TITLE = t('t_title');
$ACTIVE = 'texts';
require __DIR__ . '/includes/layout_top.php';
?>
<form method="post">
  <?= csrf_field() ?>
  <div class="card">
    <h2><?= e(t('t_common')) ?></h2>
    <p class="hint"><?= e(t('t_common_h')) ?></p>
    <div class="row row-2">
      <div class="field"><label><?= e(t('name')) ?></label><input type="text" name="name" value="<?= e($s['name']??'') ?>"></div>
      <div class="field"><label><?= e(t('t_legal')) ?></label><input type="text" name="legal" value="<?= e($s['legal']??'') ?>"></div>
    </div>
    <div class="field"><label><?= e(t('t_slogan')) ?></label><input type="text" name="tagline" value="<?= e($s['tagline']??'') ?>"></div>
    <div class="field"><label><?= e(t('t_shortdesc')) ?></label><textarea name="description" style="min-height:80px"><?= e($s['description']??'') ?></textarea></div>
  </div>
  <button class="btn" type="submit"><?= e(t('save_all')) ?></button>
</form>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
