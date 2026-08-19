<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/includes/mailer.php';
if (is_logged_in()) redirect('/admin/');

$sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (empty($_POST['website'])) {                       // honeypot
        $email = trim($_POST['email'] ?? '');
        $u = ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) ? find_user_by_email($email) : null;
        if ($u && ($u['active'] ?? true)) {
            $token = create_reset_token($u['id']);
            $link = rtrim($SITE['url'], '/') . '/admin/reset.php?token=' . $token;
            $err = null;
            @send_site_mail($u['email'], t('reset_subj'), t('reset_body') . "\n\n" . $link, $err);
        }
    }
    $sent = true;   // həmişə neytral cavab (user enumeration olmasın)
}
?><!doctype html>
<html lang="<?= e($ADMIN_LANG) ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e(t('forgot_title')) ?> — MYBEL</title>
<link rel="icon" href="/assets/img/logo.png">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/admin/assets/admin.css?v=3">
</head>
<body>
<div class="login-wrap">
  <form class="login-card" method="post" action="/admin/forgot.php" novalidate>
    <img class="logo" src="/assets/img/logo.png" alt="MYBEL Concept">
    <h1><?= e(t('forgot_title')) ?></h1>
    <p class="sub"><?= e(t('forgot_sub')) ?></p>
    <?php if ($sent): ?>
      <div class="alert alert-success"><?= e(t('forgot_sent')) ?></div>
    <?php else: ?>
      <?= csrf_field() ?>
      <div class="field">
        <label for="email"><?= e(t('forgot_email')) ?></label>
        <input type="email" id="email" name="email" autocomplete="email" required>
      </div>
      <input type="text" name="website" style="position:absolute;left:-9999px" tabindex="-1" aria-hidden="true">
      <button type="submit" class="btn"><?= e(t('forgot_send')) ?></button>
    <?php endif; ?>
    <div style="text-align:center;margin-top:1.2rem"><a href="/admin/login.php" style="font-size:.85rem;color:var(--brand)"><?= e(t('forgot_back')) ?></a></div>
  </form>
</div>
</body>
</html>
