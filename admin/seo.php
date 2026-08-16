<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/upload.php';
require_login();
$s = load_json('settings', []);
$seo = $s['seo'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $og = $seo['og_image'] ?? '/assets/img/logo.png';
    $err = null; $up = upload_image($_FILES['og_file'] ?? [], $err);
    if ($err) { flash($err, 'error'); redirect('/admin/seo.php'); }
    if ($up) $og = $up; elseif (trim($_POST['og_url'] ?? '') !== '') $og = trim($_POST['og_url']);
    $s['seo'] = [
        'home_title' => trim($_POST['home_title'] ?? ''),
        'home_desc'  => trim($_POST['home_desc'] ?? ''),
        'og_image'   => $og,
        'robots'     => ($_POST['robots'] ?? 'index') === 'noindex' ? 'noindex' : 'index',
    ];
    save_json('settings', $s);
    flash(t('o_saved'));
    redirect('/admin/seo.php');
}

$PAGE_TITLE = t('n_seo');
$ACTIVE = 'seo';
require __DIR__ . '/includes/layout_top.php';
?>
<form method="post" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <div class="card">
    <h2><?= e(t('o_title')) ?></h2>
    <p class="hint"><?= e(t('o_h')) ?></p>
    <div class="field"><label><?= e(t('o_mt')) ?></label><input type="text" name="home_title" value="<?= e($seo['home_title']??'') ?>"></div>
    <div class="field"><label><?= e(t('o_md')) ?></label><textarea name="home_desc" style="min-height:80px"><?= e($seo['home_desc']??'') ?></textarea></div>
    <div class="field">
      <label><?= e(t('o_og')) ?></label>
      <?php if (!empty($seo['og_image'])): ?><img class="thumb" style="width:160px;height:84px;object-fit:contain;background:#111;margin-bottom:.5rem" src="<?= e($seo['og_image']) ?>" alt=""><?php endif; ?>
      <input type="file" name="og_file" accept="image/*">
      <input type="text" name="og_url" placeholder="<?= e(t('o_or')) ?>" style="margin-top:.5rem">
    </div>
    <div class="field"><label><?= e(t('o_vis')) ?></label>
      <select name="robots">
        <option value="index" <?= ($seo['robots']??'index')==='index'?'selected':'' ?>><?= e(t('o_open')) ?></option>
        <option value="noindex" <?= ($seo['robots']??'')==='noindex'?'selected':'' ?>><?= e(t('o_closed')) ?></option>
      </select>
    </div>
    <button class="btn" type="submit"><?= e(t('save')) ?></button>
  </div>
</form>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
