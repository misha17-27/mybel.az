<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_admin();
$s = load_json('settings', []);
$sec = $s['security'] ?? ['turnstile_enabled'=>false,'turnstile_site'=>'','turnstile_secret'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $secret = trim($_POST['turnstile_secret'] ?? '');
    $s['security'] = [
        'turnstile_enabled' => isset($_POST['turnstile_enabled']),
        'turnstile_site'    => trim($_POST['turnstile_site'] ?? ''),
        'turnstile_secret'  => $secret !== '' ? $secret : ($sec['turnstile_secret'] ?? ''),
    ];
    save_json('settings', $s);
    flash(t('x_saved'));
    redirect('/admin/security.php');
}

$PAGE_TITLE = t('n_security');
$ACTIVE = 'security';
require __DIR__ . '/includes/layout_top.php';
$active = !empty($sec['turnstile_enabled']) && !empty($sec['turnstile_site']) && !empty($sec['turnstile_secret']);
?>
<div class="card">
  <div class="item-head">
    <h2><?= e(t('x_title')) ?></h2>
    <span class="badge" style="<?= $active?'background:#e7f6ec;color:#1c7a3e':'' ?>"><?= $active?e(t('x_on')):e(t('x_off')) ?></span>
  </div>
  <p class="hint"><?= e(t('x_h')) ?></p>
  <form method="post">
    <?= csrf_field() ?>
    <div class="field"><label class="check"><input type="checkbox" name="turnstile_enabled" <?= !empty($sec['turnstile_enabled'])?'checked':'' ?>> <?= e(t('x_enable')) ?></label></div>
    <div class="field"><label><?= e(t('x_site')) ?></label><input type="text" name="turnstile_site" value="<?= e($sec['turnstile_site']??'') ?>" placeholder="0x4AAAAAAA..."></div>
    <div class="field"><label><?= e(t('x_secret')) ?></label><input type="password" name="turnstile_secret" placeholder="<?= !empty($sec['turnstile_secret'])?e(t('x_unchanged')):'' ?>" autocomplete="new-password"></div>
    <button class="btn" type="submit"><?= e(t('save')) ?></button>
  </form>
</div>

<div class="card">
  <h2><?= e(t('x_where')) ?></h2>
  <ol class="muted" style="padding-left:1.2rem;line-height:1.9">
    <li><?= e(t('x_w1')) ?></li>
    <li><?= e(t('x_w2')) ?></li>
    <li><?= e(t('x_w3')) ?></li>
    <li><?= e(t('x_w4')) ?></li>
  </ol>
</div>

<div class="card">
  <h2><?= e(t('x_prot')) ?></h2>
  <ul class="muted" style="padding-left:1.2rem;line-height:1.9">
    <li><?= e(t('x_p1')) ?></li>
    <li><?= e(t('x_p2')) ?></li>
    <li><?= e(t('x_p3')) ?></li>
    <li><?= e(t('x_p4')) ?></li>
    <li><?= e(t('x_p5')) ?></li>
  </ul>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
