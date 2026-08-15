<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();
$me = current_user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $users = all_users();
    $name = trim($_POST['name'] ?? $me['name']);
    $cur  = (string)($_POST['current'] ?? '');
    $new  = (string)($_POST['newpass'] ?? '');
    $rep  = (string)($_POST['repeat'] ?? '');
    $changePass = ($new !== '' || $cur !== '' || $rep !== '');

    if ($changePass) {
        if (!password_verify($cur, $me['pass'])) { flash('Текущий пароль неверный.', 'error'); redirect('/admin/profile.php'); }
        if (strlen($new) < 8) { flash('Новый пароль — минимум 8 символов.', 'error'); redirect('/admin/profile.php'); }
        if ($new !== $rep) { flash('Пароли не совпадают.', 'error'); redirect('/admin/profile.php'); }
    }
    foreach ($users as &$u) {
        if ($u['id'] === $me['id']) {
            $u['name'] = $name ?: $u['name'];
            if ($changePass) $u['pass'] = password_hash($new, PASSWORD_DEFAULT);
        }
    }
    save_json('users', $users);
    flash('Профиль обновлён.');
    redirect('/admin/profile.php');
}

$PAGE_TITLE = 'Мой профиль';
$ACTIVE = 'profile';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card" style="max-width:520px">
  <h2>Профиль</h2>
  <p class="hint">E-mail (логин): <strong><?= e($me['email']) ?></strong> · роль: <span class="badge"><?= $me['role']==='admin'?'Администратор':'Редактор' ?></span></p>
  <form method="post">
    <?= csrf_field() ?>
    <div class="field"><label>Имя</label><input type="text" name="name" value="<?= e($me['name']) ?>"></div>
    <h2 style="font-size:1rem;margin-top:1rem">Смена пароля</h2>
    <p class="hint">Заполните, только если хотите изменить пароль.</p>
    <div class="field"><label>Текущий пароль</label><input type="password" name="current" autocomplete="current-password"></div>
    <div class="row row-2">
      <div class="field"><label>Новый пароль</label><input type="password" name="newpass" autocomplete="new-password"></div>
      <div class="field"><label>Повторите</label><input type="password" name="repeat" autocomplete="new-password"></div>
    </div>
    <button class="btn" type="submit">Сохранить</button>
  </form>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
