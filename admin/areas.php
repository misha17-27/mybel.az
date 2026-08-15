<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/upload.php';
require_login();

$areas = load_json('areas', []);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $areas = array_values(array_filter($areas, fn($a) => $a['id'] !== $id));
        save_json('areas', $areas);
        flash('Сфера удалена.');
        redirect('/admin/areas.php');
    }
    if ($action === 'save') {
        $id = $_POST['id'] ?? '';
        $idx = null;
        foreach ($areas as $i => $a) if ($a['id'] === $id) $idx = $i;
        $title = trim($_POST['title'] ?? '');
        if ($title === '') { flash('Заголовок обязателен.', 'error'); redirect('/admin/areas.php'); }
        $slug = trim($_POST['slug'] ?? '');
        $slug = $slug !== '' ? slugify($slug) : slugify($title);

        $cover = $areas[$idx]['cover'] ?? '';
        $err = null; $up = upload_image($_FILES['cover_file'] ?? [], $err);
        if ($err) { flash($err, 'error'); redirect('/admin/areas.php?edit=' . $id); }
        if ($up) $cover = $up; elseif (trim($_POST['cover_url'] ?? '') !== '') $cover = trim($_POST['cover_url']);

        $gallery = [];
        $existing = $areas[$idx]['gallery'] ?? [];
        $remove = $_POST['gal_remove'] ?? [];
        foreach ($existing as $g) if (!in_array($g, $remove, true)) $gallery[] = $g;
        if (!empty($_FILES['gallery_files']['name'][0])) {
            foreach ($_FILES['gallery_files']['name'] as $k => $nm) {
                $one = ['name'=>$nm,'type'=>$_FILES['gallery_files']['type'][$k],'tmp_name'=>$_FILES['gallery_files']['tmp_name'][$k],'error'=>$_FILES['gallery_files']['error'][$k],'size'=>$_FILES['gallery_files']['size'][$k]];
                $e2=null; $gu = upload_image($one, $e2); if ($gu) $gallery[] = $gu;
            }
        }
        foreach (preg_split('/\s+/', trim($_POST['gallery_urls'] ?? '')) as $u) if ($u !== '') $gallery[] = $u;

        $data = [
            'id'=>$id ?: new_id(), 'slug'=>$slug, 'title'=>$title,
            'order'=>(int)($_POST['order'] ?? 0), 'show'=>isset($_POST['show']),
            'excerpt'=>trim($_POST['excerpt'] ?? ''), 'body'=>trim($_POST['body'] ?? ''),
            'cover'=>$cover, 'gallery'=>$gallery,
        ];
        if ($idx === null) $areas[] = $data; else $areas[$idx] = $data;
        usort($areas, fn($a,$b)=>($a['order']??0)<=>($b['order']??0));
        save_json('areas', $areas);
        flash('Сфера сохранена.');
        redirect('/admin/areas.php');
    }
}

$editing = null;
if (isset($_GET['new'])) $editing = ['id'=>'','slug'=>'','title'=>'','order'=>count($areas),'show'=>true,'excerpt'=>'','body'=>'','cover'=>'','gallery'=>[]];
elseif (isset($_GET['edit'])) foreach ($areas as $a) if ($a['id'] === $_GET['edit']) $editing = $a;

$PAGE_TITLE = 'Сферы деятельности';
$ACTIVE = 'areas';
require __DIR__ . '/includes/layout_top.php';
?>
<?php if ($editing !== null): ?>
  <div class="card">
    <div class="item-head">
      <h2><?= $editing['id'] ? 'Редактировать сферу' : 'Новая сфера' ?></h2>
      <a href="/admin/areas.php" class="btn btn-outline btn-sm">← К списку</a>
    </div>
    <form method="post" enctype="multipart/form-data">
      <?= csrf_field() ?><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= e($editing['id']) ?>">
      <div class="row row-2">
        <div class="field"><label>Заголовок *</label><input type="text" name="title" value="<?= e($editing['title']) ?>" required></div>
        <div class="field"><label>Slug (URL, необязательно)</label><input type="text" name="slug" value="<?= e($editing['slug']) ?>" placeholder="авто из заголовка"></div>
      </div>
      <div class="row row-2">
        <div class="field"><label>Порядок</label><input type="number" name="order" value="<?= (int)$editing['order'] ?>"></div>
        <div class="field"><label>&nbsp;</label><label class="check"><input type="checkbox" name="show" <?= ($editing['show']??true)?'checked':'' ?>> Показывать на сайте</label></div>
      </div>
      <div class="field"><label>Краткое описание</label><textarea name="excerpt" style="min-height:70px"><?= e($editing['excerpt']) ?></textarea></div>
      <div class="field"><label>Полный текст (HTML разрешён)</label><textarea name="body" style="min-height:150px"><?= e($editing['body']) ?></textarea></div>
      <div class="field">
        <label>Обложка</label>
        <?php if ($editing['cover']): ?><img class="thumb" style="width:120px;height:80px;margin-bottom:.5rem" src="<?= e($editing['cover']) ?>" alt=""><?php endif; ?>
        <input type="file" name="cover_file" accept="image/*">
        <input type="text" name="cover_url" placeholder="или ссылка https://..." style="margin-top:.5rem">
      </div>
      <div class="field">
        <label>Галерея</label>
        <?php if (!empty($editing['gallery'])): ?>
          <div class="inline" style="flex-wrap:wrap;gap:.8rem;margin-bottom:.6rem">
            <?php foreach ($editing['gallery'] as $g): ?>
              <label class="check" style="flex-direction:column;align-items:flex-start;gap:.3rem">
                <img class="thumb" src="<?= e($g) ?>" alt="">
                <span class="muted" style="font-size:.75rem"><input type="checkbox" name="gal_remove[]" value="<?= e($g) ?>"> удалить</span>
              </label>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <input type="file" name="gallery_files[]" accept="image/*" multiple>
        <input type="text" name="gallery_urls" placeholder="или ссылки через пробел" style="margin-top:.5rem">
      </div>
      <button class="btn" type="submit">Сохранить</button>
    </form>
  </div>
<?php else: ?>
  <div class="card">
    <div class="item-head">
      <div><h2>Сферы деятельности</h2><p class="hint" style="margin:0">Рестораны, отели, частные дома и т.д.</p></div>
      <a href="/admin/areas.php?new=1" class="btn">+ Новая сфера</a>
    </div>
    <table>
      <thead><tr><th>Фото</th><th>Название</th><th>Порядок</th><th>Показ</th><th></th></tr></thead>
      <tbody>
      <?php usort($areas, fn($a,$b)=>($a['order']??0)<=>($b['order']??0)); ?>
      <?php foreach ($areas as $a): ?>
        <tr>
          <td><img class="thumb" src="<?= e($a['cover']) ?>" alt=""></td>
          <td><strong><?= e($a['title']) ?></strong><br><span class="muted" style="font-size:.8rem">/<?= e($a['slug']) ?>/</span></td>
          <td><?= (int)($a['order']??0) ?></td>
          <td><?= ($a['show']??true) ? '✅' : '—' ?></td>
          <td class="inline" style="gap:.4rem">
            <a href="/admin/areas.php?edit=<?= e($a['id']) ?>" class="btn btn-outline btn-sm">Изменить</a>
            <form method="post" data-confirm="Удалить «<?= e($a['title']) ?>»?" style="margin:0">
              <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($a['id']) ?>">
              <button class="btn btn-danger btn-sm">Удалить</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
