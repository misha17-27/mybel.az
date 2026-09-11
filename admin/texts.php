<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();
$s = load_json('settings', []);
$EL = $ADMIN_LANG; $IS_TR = ($EL !== 'az');   // AZ = baza, RU/EN = tərcümə

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if ($IS_TR) {
        $td = content_tr_data();
        $ts = $td[$EL]['settings'] ?? [];
        $ts['legal']       = trim($_POST['legal'] ?? '');
        $ts['tagline']     = trim($_POST['tagline'] ?? '');
        $ts['description'] = trim($_POST['description'] ?? '');
        $td[$EL]['settings'] = $ts;
        content_tr_save($td);
    } else {
        $s['name']        = trim($_POST['name'] ?? $s['name']);
        $s['legal']       = trim($_POST['legal'] ?? '');
        $s['tagline']     = trim($_POST['tagline'] ?? '');
        $s['description'] = trim($_POST['description'] ?? '');
        save_json('settings', $s);
    }
    flash(t('t_saved'));
    redirect('/admin/texts.php');
}

// göstəriləcək dəyərlər — RU/EN olduqda tərcümə (baza üstündən)
$dLegal = $s['legal'] ?? ''; $dTag = $s['tagline'] ?? ''; $dDesc = $s['description'] ?? '';
if ($IS_TR) {
    $tm = content_tr_merged()[$EL]['settings'] ?? [];
    if (!empty($tm['legal']))       $dLegal = $tm['legal'];
    if (!empty($tm['tagline']))     $dTag   = $tm['tagline'];
    if (!empty($tm['description'])) $dDesc  = $tm['description'];
}

$PAGE_TITLE = t('t_title');
$ACTIVE = 'texts';
require __DIR__ . '/includes/layout_top.php';
?>
<form method="post">
  <?= csrf_field() ?>
  <?php if ($IS_TR): ?><div class="card" style="border:1px solid var(--brand)"><p class="hint" style="margin:0"><?= e(t('tr_note')) ?> — <?= strtoupper($EL) ?></p></div><?php endif; ?>
  <div class="card">
    <h2><?= e(t('t_common')) ?></h2>
    <p class="hint"><?= e(t('t_common_h')) ?></p>
    <div class="row row-2">
      <?php if (!$IS_TR): ?><div class="field"><label><?= e(t('name')) ?></label><input type="text" name="name" value="<?= e($s['name']??'') ?>"></div><?php endif; ?>
      <div class="field"><label><?= e(t('t_legal')) ?></label><input type="text" name="legal" value="<?= e($dLegal) ?>"></div>
    </div>
    <div class="field"><label><?= e(t('t_slogan')) ?></label><input type="text" name="tagline" value="<?= e($dTag) ?>"></div>
    <div class="field"><label><?= e(t('t_shortdesc')) ?></label><textarea name="description" style="min-height:80px"><?= e($dDesc) ?></textarea></div>
  </div>
  <button class="btn" type="submit"><?= e(t('save_all')) ?></button>
</form>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
