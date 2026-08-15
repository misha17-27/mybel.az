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
        // boş qoyularsa köhnə secret saxlanılır
        'turnstile_secret'  => $secret !== '' ? $secret : ($sec['turnstile_secret'] ?? ''),
    ];
    save_json('settings', $s);
    flash('Настройки безопасности сохранены.');
    redirect('/admin/security.php');
}

$PAGE_TITLE = 'Безопасность';
$ACTIVE = 'security';
require __DIR__ . '/includes/layout_top.php';
$active = !empty($sec['turnstile_enabled']) && !empty($sec['turnstile_site']) && !empty($sec['turnstile_secret']);
?>
<div class="card">
  <div class="item-head">
    <h2>Cloudflare Turnstile (капча)</h2>
    <span class="badge" style="<?= $active?'background:#e7f6ec;color:#1c7a3e':'' ?>"><?= $active?'включена':'выключена' ?></span>
  </div>
  <p class="hint">Защищает вход в панель и форму на сайте от ботов. Бесплатно, без «разгадывания картинок».</p>
  <form method="post">
    <?= csrf_field() ?>
    <div class="field"><label class="check"><input type="checkbox" name="turnstile_enabled" <?= !empty($sec['turnstile_enabled'])?'checked':'' ?>> Включить Turnstile</label></div>
    <div class="field"><label>Site Key (публичный ключ)</label><input type="text" name="turnstile_site" value="<?= e($sec['turnstile_site']??'') ?>" placeholder="0x4AAAAAAA..."></div>
    <div class="field"><label>Secret Key (секретный ключ)</label><input type="password" name="turnstile_secret" placeholder="<?= !empty($sec['turnstile_secret'])?'•••• без изменений':'' ?>" autocomplete="new-password"></div>
    <button class="btn" type="submit">Сохранить</button>
  </form>
</div>

<div class="card">
  <h2>Где взять ключи</h2>
  <ol class="muted" style="padding-left:1.2rem;line-height:1.9">
    <li>Зайдите на <b>dash.cloudflare.com</b> → раздел <b>Turnstile</b>.</li>
    <li>Нажмите <b>Add widget</b>. Domain — укажите <b>mybel.az</b> (и <b>www.mybel.az</b>).</li>
    <li>Widget Mode — <b>Managed</b>.</li>
    <li>Скопируйте <b>Site Key</b> и <b>Secret Key</b> в поля выше и включите галочку.</li>
  </ol>
</div>

<div class="card">
  <h2>Что уже защищено</h2>
  <ul class="muted" style="padding-left:1.2rem;line-height:1.9">
    <li>Пароли хранятся необратимым хэшем (bcrypt).</li>
    <li>Все формы защищены от CSRF.</li>
    <li>Ограничение попыток входа: 10 за 15 минут с одного IP.</li>
    <li>Скрытая ловушка для ботов (honeypot) в формах.</li>
    <li>Папки данных закрыты от веба; в загрузках запрещено выполнение PHP.</li>
  </ul>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
