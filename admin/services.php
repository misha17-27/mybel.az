<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();

$services = load_json('services', []);
$ICONS = ['kitchen'=>'Кухня','table'=>'Стол','bed'=>'Кровать','wardrobe'=>'Шкаф','sofa'=>'Диван','design'=>'Дизайн'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $services = array_values(array_filter($services, fn($s) => $s['id'] !== $id));
        save_json('services', $services);
        flash('Услуга удалена.');
        redirect('/admin/services.php');
    }
    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        if ($title !== '') {
            $services[] = ['id'=>new_id(),'icon'=>$_POST['icon']??'design','title'=>$title,'desc'=>trim($_POST['desc']??''),'order'=>count($services),'show'=>true];
            save_json('services', $services);
            flash('Услуга добавлена.');
        }
        redirect('/admin/services.php');
    }
    if ($action === 'save_all') {
        $ids = $_POST['id'] ?? [];
        $out = [];
        foreach ($ids as $id) {
            $out[] = [
                'id'    => $id,
                'icon'  => $_POST['icon'][$id] ?? 'design',
                'title' => trim($_POST['title'][$id] ?? ''),
                'desc'  => trim($_POST['desc'][$id] ?? ''),
                'order' => (int)($_POST['order'][$id] ?? 0),
                'show'  => isset($_POST['show'][$id]),
            ];
        }
        usort($out, fn($a,$b)=>$a['order']<=>$b['order']);
        save_json('services', $out);
        flash('Изменения сохранены.');
        redirect('/admin/services.php');
    }
}

usort($services, fn($a,$b)=>($a['order']??0)<=>($b['order']??0));
$PAGE_TITLE = 'Услуги';
$ACTIVE = 'services';
require __DIR__ . '/includes/layout_top.php';
?>
<div class="card">
  <h2>Добавить услугу</h2>
  <form method="post">
    <?= csrf_field() ?><input type="hidden" name="action" value="add">
    <div class="row row-3">
      <div class="field"><label>Название</label><input type="text" name="title" required></div>
      <div class="field"><label>Иконка</label><select name="icon"><?php foreach($ICONS as $k=>$v):?><option value="<?= e($k)?>"><?= e($v)?></option><?php endforeach;?></select></div>
      <div class="field"><label>&nbsp;</label><button class="btn" type="submit">+ Добавить</button></div>
    </div>
    <div class="field"><label>Описание</label><input type="text" name="desc"></div>
  </form>
</div>

<div class="card">
  <div class="item-head"><h2>Все услуги</h2></div>
  <form method="post">
    <?= csrf_field() ?><input type="hidden" name="action" value="save_all">
    <?php foreach ($services as $s): ?>
      <div class="item-card">
        <input type="hidden" name="id[]" value="<?= e($s['id']) ?>">
        <div class="row row-3">
          <div class="field"><label>Название</label><input type="text" name="title[<?= e($s['id']) ?>]" value="<?= e($s['title']) ?>"></div>
          <div class="field"><label>Иконка</label>
            <select name="icon[<?= e($s['id']) ?>]"><?php foreach($ICONS as $k=>$v):?><option value="<?= e($k)?>" <?= ($s['icon']??'')===$k?'selected':''?>><?= e($v)?></option><?php endforeach;?></select>
          </div>
          <div class="field"><label>Порядок</label><input type="number" name="order[<?= e($s['id']) ?>]" value="<?= (int)($s['order']??0) ?>"></div>
        </div>
        <div class="field"><label>Описание</label><input type="text" name="desc[<?= e($s['id']) ?>]" value="<?= e($s['desc']) ?>"></div>
        <div class="inline">
          <label class="check"><input type="checkbox" name="show[<?= e($s['id']) ?>]" <?= ($s['show']??true)?'checked':'' ?>> Показывать</label>
          <span class="right"></span>
        </div>
      </div>
    <?php endforeach; ?>
    <div class="inline" style="gap:.6rem">
      <button class="btn" type="submit">Сохранить всё</button>
    </div>
  </form>

  <div style="margin-top:1rem">
    <?php foreach ($services as $s): ?>
      <form method="post" data-confirm="Удалить «<?= e($s['title']) ?>»?" style="display:inline-block;margin:.2rem">
        <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($s['id']) ?>">
        <button class="btn btn-danger btn-sm">✕ <?= e($s['title']) ?></button>
      </form>
    <?php endforeach; ?>
  </div>
</div>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
