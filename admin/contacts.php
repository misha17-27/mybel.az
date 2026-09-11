<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();
$s = load_json('settings', []);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $phoneLines = preg_split('/\r\n|\r|\n/', (string)($_POST['phones'] ?? ''));
    $phones = array_values(array_filter(array_map('trim', $phoneLines), fn($v) => $v !== ''));
    $s['phones']    = $phones;
    $s['phone']     = $phones[0] ?? '';
    $s['phone_raw'] = preg_replace('/[^\d+]/', '', $phones[0] ?? '');
    $s['email']     = trim($_POST['email'] ?? '');
    $s['address']   = trim($_POST['address'] ?? '');
    $s['work_hours']= trim($_POST['work_hours'] ?? '');
    $s['map']       = trim($_POST['map'] ?? '');
    $wa = preg_replace('/\D/', '', $_POST['whatsapp'] ?? '');
    $s['social'] = [
        'instagram' => trim($_POST['instagram'] ?? ''),
        'facebook'  => trim($_POST['facebook'] ?? ''),
        'whatsapp'  => $wa ? 'https://wa.me/' . $wa : '',
        'youtube'   => trim($_POST['youtube'] ?? ''),
        'x'         => trim($_POST['x'] ?? ''),
    ];
    save_json('settings', $s);
    flash(t('k_saved'));
    redirect('/admin/contacts.php');
}

$PAGE_TITLE = t('k_title');
$ACTIVE = 'contacts';
require __DIR__ . '/includes/layout_top.php';
$soc = $SITE['social'] ?? [];
$waNum = preg_replace('/\D/', '', $soc['whatsapp'] ?? '');
$phonesVal = implode("\n", !empty($SITE['phones']) ? $SITE['phones'] : array_filter([$SITE['phone'] ?? '']));
?>
<form method="post">
  <?= csrf_field() ?>
  <div class="card">
    <h2><?= e(t('k_on_site')) ?></h2>
    <div class="field"><label><?= e(t('k_phone')) ?></label><textarea name="phones" style="min-height:82px" placeholder="+994 99 285 87 78"><?= e($phonesVal) ?></textarea><small class="hint" style="display:block;margin-top:.3rem"><?= e(t('k_phone_h')) ?></small></div>
    <div class="row row-2">
      <div class="field"><label><?= e(t('email')) ?></label><input type="email" name="email" value="<?= e($SITE['email']??'') ?>"></div>
      <div class="field"><label><?= e(t('k_hours')) ?></label><input type="text" name="work_hours" value="<?= e($SITE['work_hours']??'') ?>"></div>
    </div>
    <div class="field"><label><?= e(t('k_addr')) ?></label><input type="text" name="address" value="<?= e($SITE['address']??'') ?>"></div>
    <div class="field"><label><?= e(t('k_map')) ?></label><input type="text" name="map" value="<?= e($SITE['map']??'') ?>"></div>
  </div>

  <div class="card">
    <h2><?= e(t('k_social')) ?></h2>
    <p class="hint"><?= e(t('k_social_h')) ?></p>
    <div class="field"><label><?= e(t('k_wa')) ?></label><input type="text" name="whatsapp" value="<?= e($waNum) ?>" placeholder="994500000000"></div>
    <div class="row row-2">
      <div class="field"><label>Instagram</label><input type="url" name="instagram" value="<?= e($soc['instagram']??'') ?>"></div>
      <div class="field"><label>Facebook</label><input type="url" name="facebook" value="<?= e($soc['facebook']??'') ?>"></div>
    </div>
    <div class="row row-2">
      <div class="field"><label>YouTube</label><input type="url" name="youtube" value="<?= e($soc['youtube']??'') ?>" placeholder="https://youtube.com/@..."></div>
      <div class="field"><label>X (Twitter)</label><input type="url" name="x" value="<?= e($soc['x']??'') ?>" placeholder="https://x.com/..."></div>
    </div>
  </div>
  <button class="btn" type="submit"><?= e(t('save')) ?></button>
</form>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
