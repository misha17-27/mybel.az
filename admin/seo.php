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
    flash('SEO сохранено.');
    redirect('/admin/seo.php');
}

$PAGE_TITLE = 'SEO';
$ACTIVE = 'seo';
require __DIR__ . '/includes/layout_top.php';
?>
<form method="post" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <div class="card">
    <h2>Поисковая оптимизация</h2>
    <p class="hint">Эти данные видят Google и соцсети при отправке ссылки.</p>
    <div class="field"><label>Заголовок главной (Title, 50–60 символов)</label><input type="text" name="home_title" value="<?= e($seo['home_title']??'') ?>"></div>
    <div class="field"><label>Описание (Description, 140–160 символов)</label><textarea name="home_desc" style="min-height:80px"><?= e($seo['home_desc']??'') ?></textarea></div>
    <div class="field">
      <label>Картинка для соцсетей (1200×630)</label>
      <?php if (!empty($seo['og_image'])): ?><img class="thumb" style="width:160px;height:84px;object-fit:contain;background:#111;margin-bottom:.5rem" src="<?= e($seo['og_image']) ?>" alt=""><?php endif; ?>
      <input type="file" name="og_file" accept="image/*">
      <input type="text" name="og_url" placeholder="или ссылка /assets/... или https://..." style="margin-top:.5rem">
    </div>
    <div class="field"><label>Видимость в поиске</label>
      <select name="robots">
        <option value="index" <?= ($seo['robots']??'index')==='index'?'selected':'' ?>>Открыт для поисковиков</option>
        <option value="noindex" <?= ($seo['robots']??'')==='noindex'?'selected':'' ?>>Закрыт (noindex)</option>
      </select>
    </div>
    <button class="btn" type="submit">Сохранить</button>
  </div>
</form>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
