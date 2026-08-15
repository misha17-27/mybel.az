<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/upload.php';
require_login();

$projects = load_json('projects', []);

/* ---------------- POST ---------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $projects = array_values(array_filter($projects, fn($p) => $p['id'] !== $id));
        save_json('projects', $projects);
        flash('Проект удалён.');
        redirect('/admin/projects.php');
    }

    if ($action === 'save') {
        $id = $_POST['id'] ?? '';
        $idx = null;
        foreach ($projects as $i => $p) if ($p['id'] === $id) $idx = $i;

        $title = trim($_POST['title'] ?? '');
        if ($title === '') { flash('Заголовок обязателен.', 'error'); redirect('/admin/projects.php'); }

        $slug = trim($_POST['slug'] ?? '');
        $slug = $slug !== '' ? slugify($slug) : slugify($title);

        // cover: yeni yükləmə > URL sahəsi > köhnə
        $cover = $projects[$idx]['cover'] ?? '';
        $err = null;
        $up = upload_image($_FILES['cover_file'] ?? [], $err);
        if ($err) { flash($err, 'error'); redirect('/admin/projects.php?edit=' . $id); }
        if ($up) $cover = $up;
        elseif (trim($_POST['cover_url'] ?? '') !== '') $cover = trim($_POST['cover_url']);

        // qalereya: köhnədən silinməyənlər + yeni yüklənənlər + URL sətri
        $gallery = [];
        $existing = $projects[$idx]['gallery'] ?? [];
        $remove = $_POST['gal_remove'] ?? [];
        foreach ($existing as $g) if (!in_array($g, $remove, true)) $gallery[] = $g;
        if (!empty($_FILES['gallery_files']['name'][0])) {
            foreach ($_FILES['gallery_files']['name'] as $k => $nm) {
                $one = ['name'=>$nm,'type'=>$_FILES['gallery_files']['type'][$k],'tmp_name'=>$_FILES['gallery_files']['tmp_name'][$k],'error'=>$_FILES['gallery_files']['error'][$k],'size'=>$_FILES['gallery_files']['size'][$k]];
                $e2 = null; $gu = upload_image($one, $e2);
                if ($gu) $gallery[] = $gu;
            }
        }
        foreach (preg_split('/\s+/', trim($_POST['gallery_urls'] ?? '')) as $u) {
            if ($u !== '') $gallery[] = $u;
        }

        $data = [
            'id'       => $id ?: new_id(),
            'slug'     => $slug,
            'title'    => $title,
            'category' => $_POST['category'] ?? 'restoranlar',
            'location' => trim($_POST['location'] ?? ''),
            'year'     => trim($_POST['year'] ?? ''),
            'order'    => (int)($_POST['order'] ?? 0),
            'show'     => isset($_POST['show']),
            'excerpt'  => trim($_POST['excerpt'] ?? ''),
            'body'     => trim($_POST['body'] ?? ''),
            'cover'    => $cover,
            'gallery'  => $gallery,
        ];
        if ($idx === null) $projects[] = $data; else $projects[$idx] = $data;
        // sıralama saxla
        usort($projects, fn($a,$b) => ($a['order']??0) <=> ($b['order']??0));
        save_json('projects', $projects);
        flash('Проект сохранён.');
        redirect('/admin/projects.php');
    }
}

/* ---------------- Görünüş ---------------- */
$editing = null;
if (isset($_GET['new'])) {
    $editing = ['id'=>'','slug'=>'','title'=>'','category'=>'restoranlar','location'=>'','year'=>'','order'=>count($projects),'show'=>true,'excerpt'=>'','body'=>'','cover'=>'','gallery'=>[]];
} elseif (isset($_GET['edit'])) {
    foreach ($projects as $p) if ($p['id'] === $_GET['edit']) $editing = $p;
}

$PAGE_TITLE = 'Проекты';
$ACTIVE = 'projects';
require __DIR__ . '/includes/layout_top.php';
?>
<?php if ($editing !== null): ?>
  <!-- ===== FORMA ===== -->
  <div class="card">
    <div class="item-head">
      <h2><?= $editing['id'] ? 'Редактировать проект' : 'Новый проект' ?></h2>
      <a href="/admin/projects.php" class="btn btn-outline btn-sm">← К списку</a>
    </div>
    <form method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="id" value="<?= e($editing['id']) ?>">

      <div class="row row-2">
        <div class="field"><label>Заголовок *</label><input type="text" name="title" value="<?= e($editing['title']) ?>" required></div>
        <div class="field"><label>Slug (URL, необязательно)</label><input type="text" name="slug" value="<?= e($editing['slug']) ?>" placeholder="авто из заголовка"></div>
      </div>
      <div class="row row-3">
        <div class="field"><label>Категория</label>
          <select name="category">
            <?php foreach ($CATEGORIES as $k=>$v): ?><option value="<?= e($k) ?>" <?= $editing['category']===$k?'selected':'' ?>><?= e($v) ?></option><?php endforeach; ?>
          </select>
        </div>
        <div class="field"><label>Локация</label><input type="text" name="location" value="<?= e($editing['location']) ?>"></div>
        <div class="field"><label>Год</label><input type="text" name="year" value="<?= e($editing['year']) ?>"></div>
      </div>
      <div class="row row-2">
        <div class="field"><label>Порядок (меньше = выше)</label><input type="number" name="order" value="<?= (int)$editing['order'] ?>"></div>
        <div class="field"><label>&nbsp;</label><label class="check"><input type="checkbox" name="show" <?= ($editing['show']??true)?'checked':'' ?>> Показывать на сайте</label></div>
      </div>
      <div class="field"><label>Краткое описание (в карточке)</label><textarea name="excerpt" style="min-height:70px"><?= e($editing['excerpt']) ?></textarea></div>
      <div class="field"><label>Полный текст (можно HTML: &lt;p&gt;, &lt;br&gt;)</label><textarea name="body" style="min-height:150px"><?= e($editing['body']) ?></textarea></div>

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
  <!-- ===== SİYAHI ===== -->
  <div class="card">
    <div class="item-head">
      <div><h2>Все проекты</h2><p class="hint" style="margin:0">Порядок и видимость управляются в карточке проекта.</p></div>
      <a href="/admin/projects.php?new=1" class="btn">+ Новый проект</a>
    </div>
    <table>
      <thead><tr><th>Фото</th><th>Название</th><th>Категория</th><th>Год</th><th>Порядок</th><th>Показ</th><th></th></tr></thead>
      <tbody>
      <?php usort($projects, fn($a,$b)=>($a['order']??0)<=>($b['order']??0)); ?>
      <?php foreach ($projects as $p): ?>
        <tr>
          <td><img class="thumb" src="<?= e($p['cover']) ?>" alt=""></td>
          <td><strong><?= e($p['title']) ?></strong><br><span class="muted" style="font-size:.8rem">/<?= e($p['slug']) ?>/</span></td>
          <td><span class="tag"><?= e(cat_name($p['category'])) ?></span></td>
          <td><?= e($p['year']) ?></td>
          <td><?= (int)($p['order']??0) ?></td>
          <td><?= ($p['show']??true) ? '✅' : '—' ?></td>
          <td class="inline" style="gap:.4rem">
            <a href="/admin/projects.php?edit=<?= e($p['id']) ?>" class="btn btn-outline btn-sm">Изменить</a>
            <form method="post" data-confirm="Удалить проект «<?= e($p['title']) ?>»?" style="margin:0">
              <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($p['id']) ?>">
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
