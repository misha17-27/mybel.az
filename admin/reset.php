<?php
require_once __DIR__ . '/includes/bootstrap.php';
if (is_logged_in()) redirect('/admin/');

$token = $_POST['token'] ?? $_GET['token'] ?? '';
$u = reset_token_user($token);
$error = ''; $done = false;

if ($u && $_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $new = (string)($_POST['newpass'] ?? '');
    $rep = (string)($_POST['repeat'] ?? '');
    if (strlen($new) < 8) {
        $error = t('reset_short');
    } elseif ($new !== $rep) {
        $error = t('reset_mismatch');
    } else {
        $users = all_users();
        foreach ($users as &$x) if ($x['id'] === $u['id']) $x['pass'] = password_hash($new, PASSWORD_DEFAULT);
        unset($x);
        save_json('users', $users);
        consume_reset_token($token);
        $done = true;
    }
}
?><!doctype html>
<html lang="<?= e($ADMIN_LANG) ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e(t('reset_title')) ?> — MYBEL</title>
<link rel="icon" href="/assets/img/logo.png">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/admin/assets/admin.css?v=3">
</head>
<body>
<div class="login-wrap">
  <form class="login-card" method="post" action="/admin/reset.php" novalidate>
    <img class="logo" src="/assets/img/logo.png" alt="MYBEL Concept">
    <h1><?= e(t('reset_title')) ?></h1>
    <?php if ($done): ?>
      <div class="alert alert-success"><?= e(t('reset_done')) ?></div>
      <a class="btn" href="/admin/login.php" style="display:flex;justify-content:center;margin-top:1rem"><?= e(t('login_btn')) ?></a>
    <?php elseif (!$u): ?>
      <div class="alert alert-error"><?= e(t('reset_bad')) ?></div>
      <div style="text-align:center;margin-top:1rem"><a href="/admin/forgot.php" style="color:var(--brand)"><?= e(t('forgot_title')) ?></a></div>
    <?php else: ?>
      <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
      <?= csrf_field() ?>
      <input type="hidden" name="token" value="<?= e($token) ?>">
      <div class="field">
        <label for="newpass"><?= e(t('reset_new')) ?></label>
        <div class="pass-wrap">
          <input type="password" id="newpass" name="newpass" autocomplete="new-password" required minlength="8">
          <button type="button" class="pass-toggle" aria-label="<?= e(t('show_pass')) ?>"
            onclick="var i=document.getElementById('newpass');i.type=i.type==='password'?'text':'password';this.classList.toggle('on')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>
      <div class="field">
        <label for="repeat"><?= e(t('reset_confirm')) ?></label>
        <input type="password" id="repeat" name="repeat" autocomplete="new-password" required minlength="8">
      </div>
      <button type="submit" class="btn"><?= e(t('reset_save')) ?></button>
    <?php endif; ?>
  </form>
</div>
</body>
</html>
