<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();
$s = load_json('settings', []);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $s['phone']     = trim($_POST['phone'] ?? '');
    $s['phone_raw'] = preg_replace('/[^\d+]/', '', $_POST['phone'] ?? '');
    $s['email']     = trim($_POST['email'] ?? '');
    $s['address']   = trim($_POST['address'] ?? '');
    $s['work_hours']= trim($_POST['work_hours'] ?? '');
    $s['map']       = trim($_POST['map'] ?? '');
    $wa = preg_replace('/\D/', '', $_POST['whatsapp'] ?? '');
    $s['social'] = [
        'instagram' => trim($_POST['instagram'] ?? ''),
        'facebook'  => trim($_POST['facebook'] ?? ''),
        'whatsapp'  => $wa ? 'https://wa.me/' . $wa : '',
    ];
    save_json('settings', $s);
    flash('Контакты сохранены.');
    redirect('/admin/contacts.php');
}

$PAGE_TITLE = 'Контакты и соцсети';
$ACTIVE = 'contacts';
require __DIR__ . '/includes/layout_top.php';
$soc = $s['social'] ?? [];
$waNum = preg_replace('/\D/', '', $soc['whatsapp'] ?? '');
?>
<form method="post">
  <?= csrf_field() ?>
  <div class="card">
    <h2>Контакты на сайте</h2>
    <div class="row row-2">
      <div class="field"><label>Телефон</label><input type="text" name="phone" value="<?= e($s['phone']??'') ?>"></div>
      <div class="field"><label>E-mail</label><input type="email" name="email" value="<?= e($s['email']??'') ?>"></div>
    </div>
    <div class="row row-2">
      <div class="field"><label>Адрес</label><input type="text" name="address" value="<?= e($s['address']??'') ?>"></div>
      <div class="field"><label>Часы работы</label><input type="text" name="work_hours" value="<?= e($s['work_hours']??'') ?>"></div>
    </div>
    <div class="field"><label>Карта (ссылка для встраивания, embed)</label><input type="text" name="map" value="<?= e($s['map']??'') ?>"></div>
  </div>

  <div class="card">
    <h2>WhatsApp и соцсети</h2>
    <p class="hint">WhatsApp: только цифры номера. Соцсети — полные ссылки (пустые не показываются).</p>
    <div class="field"><label>Номер WhatsApp</label><input type="text" name="whatsapp" value="<?= e($waNum) ?>" placeholder="994500000000"></div>
    <div class="row row-2">
      <div class="field"><label>Instagram</label><input type="url" name="instagram" value="<?= e($soc['instagram']??'') ?>"></div>
      <div class="field"><label>Facebook</label><input type="url" name="facebook" value="<?= e($soc['facebook']??'') ?>"></div>
    </div>
  </div>
  <button class="btn" type="submit">Сохранить</button>
</form>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
