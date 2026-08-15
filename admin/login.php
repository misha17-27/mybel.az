<?php
require_once __DIR__ . '/includes/bootstrap.php';
if (is_logged_in()) redirect('/admin/');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (!empty($_POST['website'])) {              // honeypot
        $error = 'Xəta.';
    } elseif (login_attempts_left() <= 0) {
        $error = 'Слишком много попыток. Попробуйте через 15 минут.';
    } elseif (turnstile_active($SITE) && !turnstile_verify($SITE['security']['turnstile_secret'], $_POST['cf-turnstile-response'] ?? null, $_SERVER['REMOTE_ADDR'] ?? null)) {
        $error = 'Подтвердите, что вы не робот.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $pass  = (string)($_POST['password'] ?? '');
        $u = find_user_by_email($email);
        if ($u && ($u['active'] ?? true) && password_verify($pass, $u['pass'])) {
            // login uğurlu
            session_regenerate_id(true);
            $_SESSION['uid'] = $u['id'];
            login_clear();
            // son giriş vaxtını yenilə
            $users = all_users();
            foreach ($users as &$x) if ($x['id'] === $u['id']) $x['last'] = date('Y-m-d H:i');
            save_json('users', $users);
            redirect('/admin/');
        } else {
            login_record_fail();
            $error = 'Неверный e-mail или пароль. Осталось попыток: ' . login_attempts_left();
        }
    }
}
?><!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Вход в панель — MYBEL</title>
<link rel="icon" href="/assets/img/logo.png">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/admin/assets/admin.css?v=2">
<?php if (turnstile_active($SITE)): ?><script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script><?php endif; ?>
</head>
<body>
<div class="login-wrap">
  <form class="login-card" method="post" action="/admin/login.php" novalidate>
    <img class="logo" src="/assets/img/logo.png" alt="MYBEL Concept">
    <h1>Вход в панель</h1>
    <p class="sub">Управление контентом сайта</p>
    <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
    <?= csrf_field() ?>
    <div class="field">
      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" autocomplete="username" required>
    </div>
    <div class="field">
      <label for="password">Пароль</label>
      <input type="password" id="password" name="password" autocomplete="current-password" required>
    </div>
    <input type="text" name="website" style="position:absolute;left:-9999px" tabindex="-1" aria-hidden="true">
    <?php if (turnstile_active($SITE)): ?>
      <div class="field"><div class="cf-turnstile" data-sitekey="<?= e($SITE['security']['turnstile_site']) ?>"></div></div>
    <?php endif; ?>
    <button type="submit" class="btn">Войти</button>
  </form>
</div>
</body>
</html>
