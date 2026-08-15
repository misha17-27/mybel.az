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
    $s['hero'] = [
        'eyebrow' => trim($_POST['hero_eyebrow'] ?? ''),
        'title'   => trim($_POST['hero_title'] ?? ''),
        'lead'    => trim($_POST['hero_lead'] ?? ''),
    ];
    $s['about'] = [
        'eyebrow' => trim($_POST['about_eyebrow'] ?? ''),
        'title'   => trim($_POST['about_title'] ?? ''),
        'text'    => trim($_POST['about_text'] ?? ''),
    ];
    save_json('settings', $s);
    flash('Тексты сохранены. Сайт обновится сразу.');
    redirect('/admin/texts.php');
}

$PAGE_TITLE = 'Тексты сайта';
$ACTIVE = 'texts';
require __DIR__ . '/includes/layout_top.php';
$hero = $s['hero'] ?? []; $about = $s['about'] ?? [];
?>
<form method="post">
  <?= csrf_field() ?>
  <div class="card">
    <h2>Общие</h2>
    <div class="row row-2">
      <div class="field"><label>Название</label><input type="text" name="name" value="<?= e($s['name']??'') ?>"></div>
      <div class="field"><label>Юр. название (футер)</label><input type="text" name="legal" value="<?= e($s['legal']??'') ?>"></div>
    </div>
    <div class="field"><label>Слоган</label><input type="text" name="tagline" value="<?= e($s['tagline']??'') ?>"></div>
    <div class="field"><label>Короткое описание (футер/SEO fallback)</label><textarea name="description" style="min-height:70px"><?= e($s['description']??'') ?></textarea></div>
  </div>

  <div class="card">
    <h2>Главный экран (Hero)</h2>
    <div class="field"><label>Надзаголовок</label><input type="text" name="hero_eyebrow" value="<?= e($hero['eyebrow']??'') ?>"></div>
    <div class="field"><label>Заголовок (перенос строки = новая строка)</label><textarea name="hero_title" style="min-height:70px"><?= e($hero['title']??'') ?></textarea></div>
    <div class="field"><label>Подзаголовок</label><textarea name="hero_lead" style="min-height:70px"><?= e($hero['lead']??'') ?></textarea></div>
  </div>

  <div class="card">
    <h2>Блок «О компании» (на главной)</h2>
    <div class="field"><label>Надзаголовок</label><input type="text" name="about_eyebrow" value="<?= e($about['eyebrow']??'') ?>"></div>
    <div class="field"><label>Заголовок</label><input type="text" name="about_title" value="<?= e($about['title']??'') ?>"></div>
    <div class="field"><label>Текст (пустая строка = новый абзац)</label><textarea name="about_text" style="min-height:130px"><?= e($about['text']??'') ?></textarea></div>
  </div>

  <button class="btn" type="submit">Сохранить всё</button>
</form>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
