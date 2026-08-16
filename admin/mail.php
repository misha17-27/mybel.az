<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/includes/mailer.php';
require_admin();
$s = load_json('settings', []);
$smtp = $s['smtp'] ?? ['host'=>'','port'=>587,'enc'=>'tls','user'=>'','pass'=>'','from'=>'','from_name'=>'MYBEL Concept'];

$testResult = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? 'save';

    if ($action === 'save') {
        $pass = (string)($_POST['pass'] ?? '');
        $s['smtp'] = [
            'host'      => trim($_POST['host'] ?? ''),
            'port'      => (int)($_POST['port'] ?? 587),
            'enc'       => in_array($_POST['enc'] ?? 'tls', ['tls','ssl','none'], true) ? $_POST['enc'] : 'tls',
            'user'      => trim($_POST['user'] ?? ''),
            'pass'      => $pass !== '' ? $pass : ($smtp['pass'] ?? ''),
            'from'      => trim($_POST['from'] ?? ''),
            'from_name' => trim($_POST['from_name'] ?? ''),
        ];
        save_json('settings', $s);
        flash(t('l_saved'));
        redirect('/admin/mail.php');
    }

    if ($action === 'test') {
        $SITE['smtp'] = $s['smtp'];
        $to = trim($_POST['test_to'] ?? '');
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $testResult = ['ok'=>false,'msg'=>t('l_bad_to')];
        } else {
            $err = null;
            $ok = send_site_mail($to, 'Test — MYBEL Concept', "MYBEL Concept admin — test.\nSMTP OK.", $err);
            $testResult = ['ok'=>$ok,'msg'=>$ok ? t('l_sent').' '.$to : (t('l_err').' '.$err)];
        }
    }
}

$PAGE_TITLE = t('n_mail');
$ACTIVE = 'mail';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card">
  <h2><?= e(t('l_title')) ?></h2>
  <p class="hint"><?= e(t('l_h')) ?></p>
  <form method="post">
    <?= csrf_field() ?><input type="hidden" name="action" value="save">
    <div class="row row-3">
      <div class="field"><label><?= e(t('l_host')) ?></label><input type="text" name="host" value="<?= e($smtp['host']) ?>" placeholder="mail.mybel.az"></div>
      <div class="field"><label><?= e(t('l_port')) ?></label><input type="number" name="port" value="<?= (int)$smtp['port'] ?>"></div>
      <div class="field"><label><?= e(t('l_enc')) ?></label>
        <select name="enc">
          <option value="tls" <?= $smtp['enc']==='tls'?'selected':'' ?>><?= e(t('l_tls')) ?></option>
          <option value="ssl" <?= $smtp['enc']==='ssl'?'selected':'' ?>><?= e(t('l_ssl')) ?></option>
          <option value="none" <?= $smtp['enc']==='none'?'selected':'' ?>><?= e(t('l_none')) ?></option>
        </select>
      </div>
    </div>
    <div class="row row-2">
      <div class="field"><label><?= e(t('l_user')) ?></label><input type="text" name="user" value="<?= e($smtp['user']) ?>" autocomplete="off"></div>
      <div class="field"><label><?= e(t('password')) ?></label><input type="password" name="pass" placeholder="<?= !empty($smtp['pass'])?e(t('unchanged')):'' ?>" autocomplete="new-password"></div>
    </div>
    <div class="row row-2">
      <div class="field"><label><?= e(t('l_from')) ?></label><input type="email" name="from" value="<?= e($smtp['from']) ?>" placeholder="info@mybel.az"></div>
      <div class="field"><label><?= e(t('l_fromname')) ?></label><input type="text" name="from_name" value="<?= e($smtp['from_name']) ?>"></div>
    </div>
    <button class="btn" type="submit"><?= e(t('save')) ?></button>
  </form>
</div>

<div class="card">
  <h2><?= e(t('l_test')) ?></h2>
  <p class="hint"><?= e(t('l_test_h')) ?></p>
  <?php if ($testResult): ?>
    <div class="alert alert-<?= $testResult['ok']?'success':'error' ?>"><?= e($testResult['msg']) ?></div>
  <?php endif; ?>
  <form method="post">
    <?= csrf_field() ?><input type="hidden" name="action" value="test">
    <div class="row row-2">
      <div class="field"><label><?= e(t('l_to')) ?></label><input type="email" name="test_to" value="<?= e($smtp['from'] ?: '') ?>" required></div>
      <div class="field"><label>&nbsp;</label><button class="btn" type="submit"><?= e(t('l_send')) ?></button></div>
    </div>
  </form>
</div>

<div class="card">
  <h2><?= e(t('l_where')) ?></h2>
  <p class="muted"><?= e(t('l_where_h')) ?></p>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
