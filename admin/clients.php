<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/upload.php';
require_login();

$clients = load_json('clients', []);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $clients = array_values(array_filter($clients, fn($c) => $c['id'] !== $id));
        save_json('clients', $clients);
        flash(t('c_deleted'));
        redirect('/admin/clients.php');
    }
    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $err = null; $logo = upload_image($_FILES['logo_file'] ?? [], $err);
        if ($err) { flash($err, 'error'); redirect('/admin/clients.php'); }
        if (!$logo) $logo = trim($_POST['logo_url'] ?? '');
        if ($name === '' && !$logo) { flash(t('c_need'), 'error'); redirect('/admin/clients.php'); }
        $clients[] = ['id'=>new_id(),'name'=>$name ?: 'Müştəri','logo'=>$logo,'link'=>trim($_POST['link']??''),'order'=>(int)($_POST['order']??count($clients)),'show'=>true];
        save_json('clients', $clients);
        flash(t('c_added'));
        redirect('/admin/clients.php');
    }
    if ($action === 'save_all') {
        $ids = $_POST['id'] ?? [];
        $byId = [];
        foreach ($clients as $c) $byId[$c['id']] = $c;
        $out = [];
        foreach ($ids as $id) {
            if (!isset($byId[$id])) continue;
            $c = $byId[$id];
            $c['name']  = trim($_POST['name'][$id] ?? $c['name']);
            $c['link']  = trim($_POST['link'][$id] ?? '');
            $c['order'] = (int)($_POST['order'][$id] ?? 0);
            $c['show']  = isset($_POST['show'][$id]);
            $out[] = $c;
        }
        usort($out, fn($a,$b)=>$a['order']<=>$b['order']);
        save_json('clients', $out);
        flash(t('saved'));
        redirect('/admin/clients.php');
    }
}

usort($clients, fn($a,$b)=>($a['order']??0)<=>($b['order']??0));
$PAGE_TITLE = t('c_title');
$ACTIVE = 'clients';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card">
  <h2><?= e(t('c_add')) ?></h2>
  <p class="hint"><?= e(t('c_add_h')) ?></p>
  <form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?><input type="hidden" name="action" value="add">
    <div class="row row-3">
      <div class="field"><label><?= e(t('name')) ?></label><input type="text" name="name" placeholder="SAP"></div>
      <div class="field"><label><?= e(t('c_link')) ?></label><input type="url" name="link" placeholder="https://..."></div>
      <div class="field"><label><?= e(t('order')) ?></label><input type="number" name="order" value="<?= count($clients) ?>"></div>
    </div>
    <div class="row row-2">
      <div class="field"><label><?= e(t('c_logo_file')) ?></label><input type="file" name="logo_file" accept="image/*"></div>
      <div class="field"><label><?= e(t('c_logo_url')) ?></label><input type="text" name="logo_url" placeholder="https://..."></div>
    </div>
    <button class="btn" type="submit"><?= e(t('c_add_btn')) ?></button>
  </form>
</div>

<div class="card">
  <div class="item-head"><h2><?= e(t('c_list')) ?></h2><p class="hint" style="margin:0"><?= e(t('c_list_h')) ?></p></div>
  <form method="post">
    <?= csrf_field() ?><input type="hidden" name="action" value="save_all">
    <table>
      <thead><tr><th><?= e(t('c_logo')) ?></th><th><?= e(t('name')) ?></th><th><?= e(t('c_link')) ?></th><th><?= e(t('order')) ?></th><th><?= e(t('show')) ?></th><th></th></tr></thead>
      <tbody>
      <?php foreach ($clients as $c): ?>
        <tr>
          <td><input type="hidden" name="id[]" value="<?= e($c['id']) ?>"><img class="thumb" style="object-fit:contain;background:#fff" src="<?= e($c['logo']) ?>" alt=""></td>
          <td><input type="text" name="name[<?= e($c['id']) ?>]" value="<?= e($c['name']) ?>"></td>
          <td><input type="url" name="link[<?= e($c['id']) ?>]" value="<?= e($c['link']??'') ?>" placeholder="https://..."></td>
          <td style="width:90px"><input type="number" name="order[<?= e($c['id']) ?>]" value="<?= (int)($c['order']??0) ?>"></td>
          <td><label class="check"><input type="checkbox" name="show[<?= e($c['id']) ?>]" <?= ($c['show']??true)?'checked':'' ?>></label></td>
          <td><button class="btn btn-outline btn-sm" type="submit"><?= e(t('save')) ?></button></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <div style="margin-top:1rem"><button class="btn" type="submit"><?= e(t('save_all')) ?></button></div>
  </form>

  <div style="margin-top:1rem">
    <?php foreach ($clients as $c): ?>
      <form method="post" data-confirm="<?= e(t('delete')) ?>?" style="display:inline-block;margin:.2rem">
        <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($c['id']) ?>">
        <button class="btn btn-danger btn-sm">✕ <?= e($c['name']) ?></button>
      </form>
    <?php endforeach; ?>
  </div>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
