<?php
require_once __DIR__ . '/includes/bootstrap.php';
if (is_logged_in()) redirect('/admin/');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (!empty($_POST['website'])) {              // honeypot
        $error = 'Xəta.';
    } elseif (login_attempts_left() <= 0) {
        $error = t('login_many');
    } elseif (turnstile_active($SITE) && !turnstile_verify($SITE['security']['turnstile_secret'], $_POST['cf-turnstile-response'] ?? null, $_SERVER['REMOTE_ADDR'] ?? null)) {
        $error = t('login_robot');
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
            $error = t('login_bad') . ' ' . login_attempts_left();
        }
    }
}
?><!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e(t('login_title')) ?> — MYBEL</title>
<link rel="icon" href="/assets/img/logo.png">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/admin/assets/admin.css?v=2">
<?php if (turnstile_active($SITE)): ?><script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script><?php endif; ?>
</head>
<body>
<div class="login-wrap">
  <form class="login-card" method="post" action="/admin/login.php" novalidate>
    <img class="logo" src="/assets/img/logo.png" alt="MYBEL Concept">
    <h1><?= e(t('login_title')) ?></h1>
    <p class="sub"><?= e(t('login_sub')) ?></p>
    <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
    <?= csrf_field() ?>
    <div class="field">
      <label for="email"><?= e(t('email')) ?></label>
      <input type="email" id="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" autocomplete="username" required>
    </div>
    <div class="field">
      <label for="password"><?= e(t('password')) ?></label>
      <input type="password" id="password" name="password" autocomplete="current-password" required>
    </div>
    <input type="text" name="website" style="position:absolute;left:-9999px" tabindex="-1" aria-hidden="true">
    <?php if (turnstile_active($SITE)): ?>
      <div class="field"><div class="cf-turnstile" data-sitekey="<?= e($SITE['security']['turnstile_site']) ?>"></div></div>
    <?php endif; ?>
    <button type="submit" class="btn"><?= e(t('login_btn')) ?></button>
    <div style="text-align:center;margin-top:1.2rem">
      <span class="lang-switch">
        <?php foreach ($ADMIN_LANGS as $code => $label): ?>
          <a href="/admin/login.php?lang=<?= e($code) ?>" class="<?= $ADMIN_LANG===$code?'on':'' ?>"><?= e($label) ?></a>
        <?php endforeach; ?>
      </span>
    </div>
  </form>
</div>
</body>
</html>
