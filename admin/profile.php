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
        if (!password_verify($cur, $me['pass'])) { flash(t('r_bad_cur'), 'error'); redirect('/admin/profile.php'); }
        if (strlen($new) < 8) { flash(t('r_short'), 'error'); redirect('/admin/profile.php'); }
        if ($new !== $rep) { flash(t('r_nomatch'), 'error'); redirect('/admin/profile.php'); }
    }
    foreach ($users as &$u) {
        if ($u['id'] === $me['id']) {
            $u['name'] = $name ?: $u['name'];
            if ($changePass) $u['pass'] = password_hash($new, PASSWORD_DEFAULT);
        }
    }
    save_json('users', $users);
    flash(t('r_saved'));
    redirect('/admin/profile.php');
}

$PAGE_TITLE = t('r_title');
$ACTIVE = 'profile';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card" style="max-width:520px">
  <h2><?= e(t('r_profile')) ?></h2>
  <p class="hint"><?= e(t('r_login')) ?> <strong><?= e($me['email']) ?></strong> · <?= e(t('r_role')) ?> <span class="badge"><?= $me['role']==='admin'?e(t('u_admin')):e(t('u_editor')) ?></span></p>
  <form method="post">
    <?= csrf_field() ?>
    <div class="field"><label><?= e(t('name')) ?></label><input type="text" name="name" value="<?= e($me['name']) ?>"></div>
    <h2 style="font-size:1rem;margin-top:1rem"><?= e(t('r_chpass')) ?></h2>
    <p class="hint"><?= e(t('r_chpass_h')) ?></p>
    <div class="field"><label><?= e(t('r_cur')) ?></label><input type="password" name="current" autocomplete="current-password"></div>
    <div class="row row-2">
      <div class="field"><label><?= e(t('r_new')) ?></label><input type="password" name="newpass" autocomplete="new-password"></div>
      <div class="field"><label><?= e(t('r_rep')) ?></label><input type="password" name="repeat" autocomplete="new-password"></div>
    </div>
    <button class="btn" type="submit"><?= e(t('save')) ?></button>
  </form>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
