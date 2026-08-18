<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/upload.php';
require_login();
$s = load_json('settings', []);
$seo = $s['seo'] ?? [];

$ORG_TYPES = ['FurnitureStore','HomeGoodsStore','Store','LocalBusiness','Organization'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    // OG şəkil
    $og = $seo['og_image'] ?? '/assets/img/logo.png';
    $err = null; $up = upload_image($_FILES['og_file'] ?? [], $err);
    if ($err) { flash($err, 'error'); redirect('/admin/seo.php'); }
    if ($up) $og = $up; elseif (trim($_POST['og_url'] ?? '') !== '') $og = trim($_POST['og_url']);
    // Favicon
    $fav = $seo['favicon'] ?? '/assets/img/logo.png';
    $e2 = null; $upf = upload_image($_FILES['favicon_file'] ?? [], $e2);
    if ($e2) { flash($e2, 'error'); redirect('/admin/seo.php'); }
    if ($upf) $fav = $upf; elseif (trim($_POST['favicon_url'] ?? '') !== '') $fav = trim($_POST['favicon_url']);

    $s['seo'] = [
        'home_title'  => $seo['home_title'] ?? '',   // artıq "Səhifələr" bölməsində
        'home_desc'   => $seo['home_desc'] ?? '',
        'og_image'    => $og,
        'favicon'     => $fav,
        'robots'      => ($_POST['robots'] ?? 'index') === 'noindex' ? 'noindex' : 'index',
        'keywords'    => trim($_POST['keywords'] ?? ''),
        'ga_id'       => trim($_POST['ga_id'] ?? ''),
        'gsc_verify'  => trim($_POST['gsc_verify'] ?? ''),
        'org_type'    => in_array($_POST['org_type'] ?? '', $ORG_TYPES, true) ? $_POST['org_type'] : 'FurnitureStore',
        'price_range' => trim($_POST['price_range'] ?? '$$'),
    ];
    save_json('settings', $s);
    flash(t('o_saved'));
    redirect('/admin/seo.php');
}

$PAGE_TITLE = t('n_seo');
$ACTIVE = 'seo';
require __DIR__ . '/includes/layout_top.php';
$seo = $SITE['seo'];
?>
<form method="post" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <div class="card">
    <h2><?= e(t('o_title')) ?></h2>
    <p class="hint"><?= e(t('o_h')) ?></p>
    <div class="alert" style="background:var(--brand-soft);color:var(--brand-dark);border:1px solid #eecfbf"><?= e(t('o_home_note')) ?> <a href="/admin/pages.php" style="text-decoration:underline"><?= e(t('n_pages')) ?> →</a></div>
    <div class="field"><label><?= e(t('o_keywords')) ?></label><input type="text" name="keywords" value="<?= e($seo['keywords']??'') ?>"><small class="hint" style="display:block;margin-top:.3rem"><?= e(t('o_keywords_h')) ?></small></div>
    <div class="field"><label><?= e(t('o_vis')) ?></label>
      <select name="robots">
        <option value="index" <?= ($seo['robots']??'index')==='index'?'selected':'' ?>><?= e(t('o_open')) ?></option>
        <option value="noindex" <?= ($seo['robots']??'')==='noindex'?'selected':'' ?>><?= e(t('o_closed')) ?></option>
      </select>
    </div>
  </div>

  <div class="card">
    <h2><?= e(t('o_images')) ?></h2>
    <div class="row row-2">
      <div class="field">
        <label><?= e(t('o_og')) ?></label>
        <?php if (!empty($seo['og_image'])): ?><img class="thumb" style="width:160px;height:84px;object-fit:contain;background:#111;margin-bottom:.5rem" src="<?= e($seo['og_image']) ?>" alt=""><?php endif; ?>
        <input type="file" name="og_file" accept="image/*">
        <input type="text" name="og_url" placeholder="<?= e(t('o_or')) ?>" style="margin-top:.5rem">
      </div>
      <div class="field">
        <label><?= e(t('o_favicon')) ?></label>
        <?php if (!empty($seo['favicon'])): ?><img class="thumb" style="width:48px;height:48px;object-fit:contain;margin-bottom:.5rem" src="<?= e($seo['favicon']) ?>" alt=""><?php endif; ?>
        <input type="file" name="favicon_file" accept="image/*">
        <input type="text" name="favicon_url" placeholder="<?= e(t('o_or')) ?>" style="margin-top:.5rem">
      </div>
    </div>
  </div>

  <div class="card">
    <h2><?= e(t('o_biz')) ?></h2>
    <p class="hint"><?= e(t('o_biz_h')) ?></p>
    <div class="row row-2">
      <div class="field"><label><?= e(t('o_orgtype')) ?></label>
        <select name="org_type">
          <?php foreach ($ORG_TYPES as $ot): ?><option value="<?= e($ot) ?>" <?= ($seo['org_type']??'')===$ot?'selected':'' ?>><?= e($ot) ?></option><?php endforeach; ?>
        </select>
      </div>
      <div class="field"><label><?= e(t('o_price')) ?></label><input type="text" name="price_range" value="<?= e($seo['price_range']??'$$') ?>" placeholder="$$"></div>
    </div>
  </div>

  <div class="card">
    <h2><?= e(t('o_analytics')) ?></h2>
    <div class="field"><label><?= e(t('o_ga')) ?></label><input type="text" name="ga_id" value="<?= e($seo['ga_id']??'') ?>" placeholder="G-XXXXXXXXXX"><small class="hint" style="display:block;margin-top:.3rem"><?= e(t('o_ga_h')) ?></small></div>
    <div class="field"><label><?= e(t('o_gsc')) ?></label><input type="text" name="gsc_verify" value="<?= e($seo['gsc_verify']??'') ?>"><small class="hint" style="display:block;margin-top:.3rem"><?= e(t('o_gsc_h')) ?></small></div>
  </div>

  <button class="btn" type="submit"><?= e(t('save_all')) ?></button>
</form>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
