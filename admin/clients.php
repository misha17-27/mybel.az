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
        flash('Клиент удалён.');
        redirect('/admin/clients.php');
    }
    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $err = null; $logo = upload_image($_FILES['logo_file'] ?? [], $err);
        if ($err) { flash($err, 'error'); redirect('/admin/clients.php'); }
        if (!$logo) $logo = trim($_POST['logo_url'] ?? '');
        if ($name === '' && !$logo) { flash('Укажите название или логотип.', 'error'); redirect('/admin/clients.php'); }
        $clients[] = ['id'=>new_id(),'name'=>$name ?: 'Müştəri','logo'=>$logo,'link'=>trim($_POST['link']??''),'order'=>(int)($_POST['order']??count($clients)),'show'=>true];
        save_json('clients', $clients);
        flash('Клиент добавлен.');
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
        flash('Изменения сохранены.');
        redirect('/admin/clients.php');
    }
}

usort($clients, fn($a,$b)=>($a['order']??0)<=>($b['order']??0));
$PAGE_TITLE = 'Клиенты';
$ACTIVE = 'clients';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card">
  <h2>Добавить клиента</h2>
  <p class="hint">Лучше всего — логотип на прозрачном фоне (PNG/SVG). До 3 МБ.</p>
  <form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?><input type="hidden" name="action" value="add">
    <div class="row row-3">
      <div class="field"><label>Название</label><input type="text" name="name" placeholder="Например: SAP"></div>
      <div class="field"><label>Ссылка (необязательно)</label><input type="url" name="link" placeholder="https://..."></div>
      <div class="field"><label>Порядок</label><input type="number" name="order" value="<?= count($clients) ?>"></div>
    </div>
    <div class="row row-2">
      <div class="field"><label>Файл логотипа</label><input type="file" name="logo_file" accept="image/*"></div>
      <div class="field"><label>или ссылка на логотип</label><input type="text" name="logo_url" placeholder="https://..."></div>
    </div>
    <button class="btn" type="submit">Добавить клиента</button>
  </form>
</div>

<div class="card">
  <div class="item-head"><h2>Список клиентов</h2><p class="hint" style="margin:0">Логотипы показываются бегущей лентой. Порядок — по числу.</p></div>
  <form method="post">
    <?= csrf_field() ?><input type="hidden" name="action" value="save_all">
    <table>
      <thead><tr><th>Лого</th><th>Название</th><th>Ссылка</th><th>Порядок</th><th>Показ</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($clients as $c): ?>
        <tr>
          <td><input type="hidden" name="id[]" value="<?= e($c['id']) ?>"><img class="thumb" style="object-fit:contain;background:#fff" src="<?= e($c['logo']) ?>" alt=""></td>
          <td><input type="text" name="name[<?= e($c['id']) ?>]" value="<?= e($c['name']) ?>"></td>
          <td><input type="url" name="link[<?= e($c['id']) ?>]" value="<?= e($c['link']??'') ?>" placeholder="https://..."></td>
          <td style="width:90px"><input type="number" name="order[<?= e($c['id']) ?>]" value="<?= (int)($c['order']??0) ?>"></td>
          <td><label class="check"><input type="checkbox" name="show[<?= e($c['id']) ?>]" <?= ($c['show']??true)?'checked':'' ?>></label></td>
          <td>
            <button formaction="/admin/clients.php" class="btn btn-outline btn-sm" type="submit">Сохранить</button>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <div style="margin-top:1rem"><button class="btn" type="submit">Сохранить всё</button></div>
  </form>

  <div style="margin-top:1rem">
    <?php foreach ($clients as $c): ?>
      <form method="post" data-confirm="Удалить «<?= e($c['name']) ?>»?" style="display:inline-block;margin:.2rem">
        <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($c['id']) ?>">
        <button class="btn btn-danger btn-sm">✕ <?= e($c['name']) ?></button>
      </form>
    <?php endforeach; ?>
  </div>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
