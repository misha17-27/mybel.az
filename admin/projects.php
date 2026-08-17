<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/upload.php';
require_login();

$projects = load_json('projects', []);
$services = load_json('services', []);

/* ---------------- POST ---------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $projects = array_values(array_filter($projects, fn($p) => $p['id'] !== $id));
        save_json('projects', $projects);
        flash(t('p_deleted'));
        redirect('/admin/projects.php');
    }

    if ($action === 'save') {
        $id = $_POST['id'] ?? '';
        $idx = null;
        foreach ($projects as $i => $p) if ($p['id'] === $id) $idx = $i;

        $title = trim($_POST['title'] ?? '');
        if ($title === '') { flash(t('p_need_title'), 'error'); redirect('/admin/projects.php'); }

        $slug = trim($_POST['slug'] ?? '');
        $slug = $slug !== '' ? slugify($slug) : slugify($title);

        $cover = $projects[$idx]['cover'] ?? '';
        $err = null;
        $up = upload_image($_FILES['cover_file'] ?? [], $err);
        if ($err) { flash($err, 'error'); redirect('/admin/projects.php?edit=' . $id); }
        if ($up) $cover = $up;
        elseif (trim($_POST['cover_url'] ?? '') !== '') $cover = trim($_POST['cover_url']);

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
        usort($projects, fn($a,$b) => ($a['order']??0) <=> ($b['order']??0));
        save_json('projects', $projects);

        // Layihə tərəfindən seçilmiş xidmətləri sinxronlaşdır (services.json)
        $pid = $data['id'];
        $sel = $_POST['services'] ?? [];
        $services = load_json('services', []);
        foreach ($services as &$sv) {
            $list = $sv['projects'] ?? [];
            $has = in_array($pid, $list, true);
            $want = in_array($sv['id'], $sel, true);
            if ($want && !$has) $list[] = $pid;
            if (!$want && $has) $list = array_values(array_filter($list, fn($x) => $x !== $pid));
            $sv['projects'] = array_values($list);
        }
        unset($sv);
        save_json('services', $services);

        flash(t('p_saved'));
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

$PAGE_TITLE = t('n_projects');
$ACTIVE = 'projects';
require __DIR__ . '/includes/layout_top.php';
?>
<?php if ($editing !== null): ?>
  <div class="card">
    <div class="item-head">
      <h2><?= $editing['id'] ? e(t('p_edit')) : e(t('p_new')) ?></h2>
      <a href="/admin/projects.php" class="btn btn-outline btn-sm">← <?= e(t('back_list')) ?></a>
    </div>
    <form method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="id" value="<?= e($editing['id']) ?>">

      <div class="row row-2">
        <div class="field"><label><?= e(t('title_f')) ?> *</label><input type="text" name="title" value="<?= e($editing['title']) ?>" required></div>
        <div class="field"><label><?= e(t('p_slug')) ?></label><input type="text" name="slug" value="<?= e($editing['slug']) ?>" placeholder="<?= e(t('p_slug_ph')) ?>"></div>
      </div>
      <div class="row row-3">
        <div class="field"><label><?= e(t('p_cat')) ?></label>
          <select name="category">
            <?php foreach ($CATEGORIES as $k=>$v): ?><option value="<?= e($k) ?>" <?= $editing['category']===$k?'selected':'' ?>><?= e($v) ?></option><?php endforeach; ?>
          </select>
        </div>
        <div class="field"><label><?= e(t('p_loc')) ?></label><input type="text" name="location" value="<?= e($editing['location']) ?>"></div>
        <div class="field"><label><?= e(t('p_year')) ?></label><input type="text" name="year" value="<?= e($editing['year']) ?>"></div>
      </div>
      <div class="row row-2">
        <div class="field"><label><?= e(t('p_order_hint')) ?></label><input type="number" name="order" value="<?= (int)$editing['order'] ?>"></div>
        <div class="field"><label>&nbsp;</label><label class="check"><input type="checkbox" name="show" <?= ($editing['show']??true)?'checked':'' ?>> <?= e(t('show_site')) ?></label></div>
      </div>
      <div class="field"><label><?= e(t('p_excerpt')) ?></label><textarea name="excerpt" style="min-height:70px"><?= e($editing['excerpt']) ?></textarea></div>
      <div class="field"><label><?= e(t('p_body')) ?></label><textarea name="body" style="min-height:150px"><?= e($editing['body']) ?></textarea></div>

      <?php $linkedServices = []; foreach ($services as $sv) if (in_array($editing['id'], $sv['projects'] ?? [], true)) $linkedServices[] = $sv['id']; ?>
      <div class="field">
        <label><?= e(t('p_services')) ?></label>
        <p class="hint" style="margin-top:0"><?= e(t('p_services_h')) ?></p>
        <div class="inline" style="flex-wrap:wrap;gap:.5rem">
          <?php foreach ($services as $sv): ?>
            <label class="check" style="border:1px solid var(--line);border-radius:8px;padding:.45rem .7rem">
              <input type="checkbox" name="services[]" value="<?= e($sv['id']) ?>" <?= in_array($sv['id'],$linkedServices,true)?'checked':'' ?>>
              <?= e($sv['title']) ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="field">
        <label><?= e(t('p_cover')) ?></label>
        <?php if ($editing['cover']): ?><img class="thumb" style="width:120px;height:80px;margin-bottom:.5rem" src="<?= e($editing['cover']) ?>" alt=""><?php endif; ?>
        <input type="file" name="cover_file" accept="image/*">
        <input type="text" name="cover_url" placeholder="<?= e(t('p_or_url')) ?>" style="margin-top:.5rem">
      </div>

      <div class="field">
        <label><?= e(t('p_gallery')) ?></label>
        <?php if (!empty($editing['gallery'])): ?>
          <div class="inline" style="flex-wrap:wrap;gap:.8rem;margin-bottom:.6rem">
            <?php foreach ($editing['gallery'] as $g): ?>
              <label class="check" style="flex-direction:column;align-items:flex-start;gap:.3rem">
                <img class="thumb" src="<?= e($g) ?>" alt="">
                <span class="muted" style="font-size:.75rem"><input type="checkbox" name="gal_remove[]" value="<?= e($g) ?>"> <?= e(t('p_remove')) ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <input type="file" name="gallery_files[]" accept="image/*" multiple>
        <input type="text" name="gallery_urls" placeholder="<?= e(t('p_or_urls')) ?>" style="margin-top:.5rem">
      </div>

      <button class="btn" type="submit"><?= e(t('save')) ?></button>
    </form>
  </div>

<?php else: ?>
  <div class="card">
    <div class="item-head">
      <div><h2><?= e(t('p_all')) ?></h2><p class="hint" style="margin:0"><?= e(t('p_all_h')) ?></p></div>
      <a href="/admin/projects.php?new=1" class="btn"><?= e(t('p_new_btn')) ?></a>
    </div>
    <table>
      <thead><tr><th><?= e(t('photo')) ?></th><th><?= e(t('name')) ?></th><th><?= e(t('p_cat')) ?></th><th><?= e(t('p_year')) ?></th><th><?= e(t('order')) ?></th><th><?= e(t('show')) ?></th><th></th></tr></thead>
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
            <a href="/admin/projects.php?edit=<?= e($p['id']) ?>" class="btn btn-outline btn-sm"><?= e(t('edit')) ?></a>
            <form method="post" data-confirm="<?= e(t('p_confirm')) ?>" style="margin:0">
              <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($p['id']) ?>">
              <button class="btn btn-danger btn-sm"><?= e(t('delete')) ?></button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
