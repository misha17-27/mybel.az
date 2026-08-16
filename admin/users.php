<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_admin();
$users = all_users();
$me = current_user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $email = trim($_POST['email'] ?? '');
        $name  = trim($_POST['name'] ?? '');
        $pass  = (string)($_POST['password'] ?? '');
        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 8) {
            flash(t('u_bad'), 'error');
        } elseif (find_user_by_email($email)) {
            flash(t('u_exists'), 'error');
        } else {
            $users[] = ['id'=>new_id(),'name'=>$name,'email'=>$email,'pass'=>password_hash($pass, PASSWORD_DEFAULT),'role'=>($_POST['role']??'editor')==='admin'?'admin':'editor','active'=>true,'last'=>''];
            save_json('users', $users);
            flash(t('u_added'));
        }
        redirect('/admin/users.php');
    }

    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        if ($id === $me['id']) { flash(t('u_self'), 'error'); redirect('/admin/users.php'); }
        $users = array_values(array_filter($users, fn($u)=>$u['id']!==$id));
        save_json('users', $users);
        flash(t('u_deleted'));
        redirect('/admin/users.php');
    }

    if ($action === 'save_all') {
        $ids = $_POST['id'] ?? [];
        $byId = []; foreach ($users as $u) $byId[$u['id']] = $u;
        $out = [];
        foreach ($ids as $id) {
            if (!isset($byId[$id])) continue;
            $u = $byId[$id];
            $u['name']   = trim($_POST['name'][$id] ?? $u['name']);
            $u['role']   = ($_POST['role'][$id] ?? $u['role']) === 'admin' ? 'admin' : 'editor';
            $u['active'] = isset($_POST['active'][$id]);
            $np = (string)($_POST['newpass'][$id] ?? '');
            if ($np !== '') { if (strlen($np) >= 8) $u['pass'] = password_hash($np, PASSWORD_DEFAULT); }
            $out[] = $u;
        }
        $admins = array_filter($out, fn($u)=>$u['role']==='admin' && $u['active']);
        if (!$admins) { flash(t('u_need_admin'), 'error'); redirect('/admin/users.php'); }
        save_json('users', $out);
        flash(t('saved'));
        redirect('/admin/users.php');
    }
}

$PAGE_TITLE = t('u_title');
$ACTIVE = 'users';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card">
  <h2><?= e(t('u_add')) ?></h2>
  <p class="hint"><?= e(t('u_add_h')) ?></p>
  <form method="post">
    <?= csrf_field() ?><input type="hidden" name="action" value="add">
    <div class="row row-2">
      <div class="field"><label><?= e(t('name')) ?></label><input type="text" name="name" required></div>
      <div class="field"><label><?= e(t('email')) ?></label><input type="email" name="email" required></div>
    </div>
    <div class="row row-2">
      <div class="field"><label><?= e(t('u_pass8')) ?></label><input type="text" name="password" required></div>
      <div class="field"><label><?= e(t('u_role')) ?></label><select name="role"><option value="editor"><?= e(t('u_editor')) ?></option><option value="admin"><?= e(t('u_admin')) ?></option></select></div>
    </div>
    <button class="btn" type="submit"><?= e(t('add')) ?></button>
  </form>
</div>

<div class="card">
  <div class="item-head"><h2><?= e(t('u_all')) ?></h2><p class="hint" style="margin:0"><?= e(t('u_all_h')) ?></p></div>
  <form method="post">
    <?= csrf_field() ?><input type="hidden" name="action" value="save_all">
    <table>
      <thead><tr><th><?= e(t('name')) ?></th><th><?= e(t('email')) ?></th><th><?= e(t('u_role')) ?></th><th><?= e(t('u_newpass')) ?></th><th><?= e(t('u_active')) ?></th><th><?= e(t('u_login')) ?></th><th></th></tr></thead>
      <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><input type="hidden" name="id[]" value="<?= e($u['id']) ?>"><input type="text" name="name[<?= e($u['id']) ?>]" value="<?= e($u['name']) ?>"></td>
          <td><?= e($u['email']) ?><?php if($u['id']===$me['id']):?> <span class="badge"><?= e(t('u_you')) ?></span><?php endif;?></td>
          <td><select name="role[<?= e($u['id']) ?>]"><option value="editor" <?= $u['role']==='editor'?'selected':'' ?>><?= e(t('u_editor')) ?></option><option value="admin" <?= $u['role']==='admin'?'selected':'' ?>><?= e(t('u_admin')) ?></option></select></td>
          <td><input type="text" name="newpass[<?= e($u['id']) ?>]" placeholder="—"></td>
          <td><label class="check"><input type="checkbox" name="active[<?= e($u['id']) ?>]" <?= ($u['active']??true)?'checked':'' ?>></label></td>
          <td class="muted" style="font-size:.8rem"><?= e($u['last']?:'—') ?></td>
          <td>
            <?php if($u['id']!==$me['id']): ?>
            <form method="post" data-confirm="<?= e(t('u_confirm')) ?>" style="margin:0"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($u['id']) ?>"><button class="btn btn-danger btn-sm"><?= e(t('delete')) ?></button></form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <div style="margin-top:1rem"><button class="btn" type="submit"><?= e(t('u_save')) ?></button></div>
  </form>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
