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
        'video'   => trim($_POST['about_video'] ?? ''),
    ];
    save_json('settings', $s);
    flash(t('t_saved'));
    redirect('/admin/texts.php');
}

$PAGE_TITLE = t('t_title');
$ACTIVE = 'texts';
require __DIR__ . '/includes/layout_top.php';
$hero = $s['hero'] ?? []; $about = $s['about'] ?? [];
?>
<form method="post">
  <?= csrf_field() ?>
  <div class="card">
    <h2><?= e(t('t_common')) ?></h2>
    <div class="row row-2">
      <div class="field"><label><?= e(t('name')) ?></label><input type="text" name="name" value="<?= e($s['name']??'') ?>"></div>
      <div class="field"><label><?= e(t('t_legal')) ?></label><input type="text" name="legal" value="<?= e($s['legal']??'') ?>"></div>
    </div>
    <div class="field"><label><?= e(t('t_slogan')) ?></label><input type="text" name="tagline" value="<?= e($s['tagline']??'') ?>"></div>
    <div class="field"><label><?= e(t('t_shortdesc')) ?></label><textarea name="description" style="min-height:70px"><?= e($s['description']??'') ?></textarea></div>
  </div>

  <div class="card">
    <h2><?= e(t('t_hero')) ?></h2>
    <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="hero_eyebrow" value="<?= e($hero['eyebrow']??'') ?>"></div>
    <div class="field"><label><?= e(t('t_hero_title')) ?></label><textarea name="hero_title" style="min-height:70px"><?= e($hero['title']??'') ?></textarea></div>
    <div class="field"><label><?= e(t('t_hero_lead')) ?></label><textarea name="hero_lead" style="min-height:70px"><?= e($hero['lead']??'') ?></textarea></div>
  </div>

  <div class="card">
    <h2><?= e(t('t_about')) ?></h2>
    <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="about_eyebrow" value="<?= e($about['eyebrow']??'') ?>"></div>
    <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="about_title" value="<?= e($about['title']??'') ?>"></div>
    <div class="field"><label><?= e(t('t_about_text')) ?></label><textarea name="about_text" style="min-height:130px"><?= e($about['text']??'') ?></textarea></div>
    <div class="field"><label><?= e(t('t_video')) ?></label><input type="text" name="about_video" value="<?= e($about['video']??'') ?>" placeholder="https://youtu.be/... / https://vimeo.com/... / .mp4"><small class="hint" style="display:block;margin-top:.3rem"><?= e(t('t_video_h')) ?></small></div>
  </div>

  <button class="btn" type="submit"><?= e(t('save_all')) ?></button>
</form>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
