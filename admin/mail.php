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
            'pass'      => $pass !== '' ? $pass : ($smtp['pass'] ?? ''),  // boşdursa köhnəni saxla
            'from'      => trim($_POST['from'] ?? ''),
            'from_name' => trim($_POST['from_name'] ?? ''),
        ];
        save_json('settings', $s);
        flash('Настройки SMTP сохранены.');
        redirect('/admin/mail.php');
    }

    if ($action === 'test') {
        $SITE['smtp'] = $s['smtp'];   // send_site_mail üçün cari konfiqurasiya
        $to = trim($_POST['test_to'] ?? '');
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $testResult = ['ok'=>false,'msg'=>'Укажите корректный e-mail получателя.'];
        } else {
            $err = null;
            $ok = send_site_mail($to, 'Тест — MYBEL Concept', "Это тестовое письмо из админ-панели mybel.az.\nЕсли вы его получили — SMTP настроен верно.", $err);
            $testResult = ['ok'=>$ok,'msg'=>$ok ? 'Письмо отправлено на '.$to : ('Ошибка: '.$err)];
        }
    }
}

$PAGE_TITLE = 'Почта (SMTP)';
$ACTIVE = 'mail';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card">
  <h2>Настройки SMTP</h2>
  <p class="hint">Через SMTP письма (заявки с сайта, тест) доходят надёжнее, чем через стандартную функцию сервера. Если оставить пустым — используется mail().</p>
  <form method="post">
    <?= csrf_field() ?><input type="hidden" name="action" value="save">
    <div class="row row-3">
      <div class="field"><label>SMTP-сервер</label><input type="text" name="host" value="<?= e($smtp['host']) ?>" placeholder="mail.mybel.az"></div>
      <div class="field"><label>Порт</label><input type="number" name="port" value="<?= (int)$smtp['port'] ?>"></div>
      <div class="field"><label>Шифрование</label>
        <select name="enc">
          <option value="tls" <?= $smtp['enc']==='tls'?'selected':'' ?>>STARTTLS (587)</option>
          <option value="ssl" <?= $smtp['enc']==='ssl'?'selected':'' ?>>SSL/TLS (465)</option>
          <option value="none" <?= $smtp['enc']==='none'?'selected':'' ?>>Без шифрования</option>
        </select>
      </div>
    </div>
    <div class="row row-2">
      <div class="field"><label>Пользователь (обычно полный адрес почты)</label><input type="text" name="user" value="<?= e($smtp['user']) ?>" autocomplete="off"></div>
      <div class="field"><label>Пароль</label><input type="password" name="pass" placeholder="<?= !empty($smtp['pass'])?'•••• без изменений':'' ?>" autocomplete="new-password"></div>
    </div>
    <div class="row row-2">
      <div class="field"><label>Адрес отправителя (From)</label><input type="email" name="from" value="<?= e($smtp['from']) ?>" placeholder="info@mybel.az"></div>
      <div class="field"><label>Имя отправителя</label><input type="text" name="from_name" value="<?= e($smtp['from_name']) ?>"></div>
    </div>
    <button class="btn" type="submit">Сохранить</button>
  </form>
</div>

<div class="card">
  <h2>Проверка отправки</h2>
  <p class="hint">Отправим тестовое письмо, чтобы убедиться, что настройки верные. Сначала сохраните настройки.</p>
  <?php if ($testResult): ?>
    <div class="alert alert-<?= $testResult['ok']?'success':'error' ?>"><?= e($testResult['msg']) ?></div>
  <?php endif; ?>
  <form method="post">
    <?= csrf_field() ?><input type="hidden" name="action" value="test">
    <div class="row row-2">
      <div class="field"><label>Адрес получателя</label><input type="email" name="test_to" value="<?= e($smtp['from'] ?: '') ?>" required></div>
      <div class="field"><label>&nbsp;</label><button class="btn" type="submit">Отправить тест</button></div>
    </div>
  </form>
</div>

<div class="card">
  <h2>Где взять данные</h2>
  <p class="muted">В cPanel → <b>Email Accounts</b> → у нужного ящика нажмите <b>Connect Devices</b>. Там указаны сервер, порт и способ шифрования. Пользователь — полный адрес почты, пароль — от этого ящика.</p>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
