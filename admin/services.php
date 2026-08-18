<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();

$services = load_json('services', []);
$projects = load_json('projects', []);
usort($projects, fn($a,$b)=>($a['order']??0)<=>($b['order']??0));
$ICONS = ['kitchen'=>t('ic_kitchen'),'table'=>t('ic_table'),'bed'=>t('ic_bed'),'wardrobe'=>t('ic_wardrobe'),'sofa'=>t('ic_sofa'),'design'=>t('ic_design')];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $services = array_values(array_filter($services, fn($s) => $s['id'] !== $id));
        save_json('services', $services);
        flash(t('s_deleted'));
        redirect('/admin/services.php');
    }

    if ($action === 'save') {
        $id = $_POST['id'] ?? '';
        $idx = null;
        foreach ($services as $i => $s) if ($s['id'] === $id) $idx = $i;
        $title = trim($_POST['title'] ?? '');
        if ($title === '') { flash(t('p_need_title'), 'error'); redirect('/admin/services.php'); }
        $slug = trim($_POST['slug'] ?? '');
        $slug = $slug !== '' ? slugify($slug) : slugify($title);

        $data = [
            'id'       => $id ?: new_id(),
            'slug'     => $slug,
            'icon'     => in_array($_POST['icon'] ?? '', array_keys($ICONS), true) ? $_POST['icon'] : 'design',
            'title'    => $title,
            'desc'     => trim($_POST['desc'] ?? ''),
            'body'     => trim($_POST['body'] ?? ''),
            'projects' => array_values($_POST['projects'] ?? []),
            'order'    => (int)($_POST['order'] ?? 0),
            'show'     => isset($_POST['show']),
            'seo_title'=> trim($_POST['seo_title'] ?? ''),
            'seo_desc' => trim($_POST['seo_desc'] ?? ''),
        ];
        if ($idx === null) $services[] = $data; else $services[$idx] = $data;
        usort($services, fn($a,$b)=>($a['order']??0)<=>($b['order']??0));
        save_json('services', $services);
        flash(t('s_saved'));
        redirect('/admin/services.php');
    }
}

$editing = null;
if (isset($_GET['new'])) $editing = ['id'=>'','slug'=>'','icon'=>'design','title'=>'','desc'=>'','body'=>'','projects'=>[],'order'=>count($services),'show'=>true];
elseif (isset($_GET['edit'])) foreach ($services as $s) if ($s['id'] === $_GET['edit']) $editing = $s;

usort($services, fn($a,$b)=>($a['order']??0)<=>($b['order']??0));
$PAGE_TITLE = t('s_title');
$ACTIVE = 'services';
require __DIR__ . '/includes/layout_top.php';
?>
<?php if ($editing !== null): $linked = $editing['projects'] ?? []; ?>
  <div class="card">
    <div class="item-head">
      <h2><?= $editing['id'] ? e(t('s_edit')) : e(t('s_new')) ?></h2>
      <a href="/admin/services.php" class="btn btn-outline btn-sm">← <?= e(t('back_list')) ?></a>
    </div>
    <form method="post">
      <?= csrf_field() ?><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= e($editing['id']) ?>">
      <div class="row row-3">
        <div class="field"><label><?= e(t('title_f')) ?> *</label><input type="text" name="title" value="<?= e($editing['title']) ?>" required></div>
        <div class="field"><label><?= e(t('s_icon')) ?></label><select name="icon"><?php foreach($ICONS as $k=>$v):?><option value="<?= e($k)?>" <?= ($editing['icon']??'')===$k?'selected':''?>><?= e($v)?></option><?php endforeach;?></select></div>
        <div class="field"><label><?= e(t('order')) ?></label><input type="number" name="order" value="<?= (int)($editing['order']??0) ?>"></div>
      </div>
      <div class="field"><label><?= e(t('p_slug')) ?></label><input type="text" name="slug" value="<?= e($editing['slug']??'') ?>" placeholder="<?= e(t('p_slug_ph')) ?>"></div>
      <div class="field"><label><?= e(t('s_short')) ?></label><input type="text" name="desc" value="<?= e($editing['desc']??'') ?>"></div>
      <div class="field"><label><?= e(t('s_body')) ?></label><textarea name="body" class="richtext" style="min-height:130px"><?= e($editing['body']??'') ?></textarea></div>
      <div class="field"><label class="check"><input type="checkbox" name="show" <?= ($editing['show']??true)?'checked':'' ?>> <?= e(t('show_site')) ?></label></div>

      <div class="field">
        <label><?= e(t('s_link')) ?></label>
        <p class="hint" style="margin-top:0"><?= e(t('s_link_h')) ?></p>
        <?php if (empty($projects)): ?>
          <p class="muted"><?= e(t('s_noproj')) ?></p>
        <?php else: ?>
          <div class="grid" style="grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:.5rem">
            <?php foreach ($projects as $p): ?>
              <label class="check" style="border:1px solid var(--line);border-radius:8px;padding:.5rem .7rem">
                <input type="checkbox" name="projects[]" value="<?= e($p['id']) ?>" <?= in_array($p['id'],$linked,true)?'checked':'' ?>>
                <img class="thumb" style="width:36px;height:26px" src="<?= e($p['cover']) ?>" alt="">
                <span style="font-size:.85rem"><?= e($p['title']) ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <h3 style="margin:1.4rem 0 .3rem"><?= e(t('pg_seo')) ?></h3>
      <p class="hint" style="margin-top:0"><?= e(t('pg_seo_h')) ?></p>
      <div class="field"><label><?= e(t('pg_seo_title')) ?></label><input type="text" name="seo_title" value="<?= e($editing['seo_title'] ?? '') ?>" maxlength="70"></div>
      <div class="field"><label><?= e(t('pg_seo_desc')) ?></label><textarea name="seo_desc" style="min-height:70px" maxlength="180"><?= e($editing['seo_desc'] ?? '') ?></textarea></div>

      <button class="btn" type="submit"><?= e(t('save')) ?></button>
    </form>
  </div>
<?php else: ?>
  <div class="card">
    <div class="item-head">
      <div><h2><?= e(t('s_all')) ?></h2><p class="hint" style="margin:0"><?= e(t('s_all_h')) ?></p></div>
      <a href="/admin/services.php?new=1" class="btn"><?= e(t('s_new_btn')) ?></a>
    </div>
    <table>
      <thead><tr><th><?= e(t('name')) ?></th><th><?= e(t('s_link')) ?></th><th><?= e(t('order')) ?></th><th><?= e(t('show')) ?></th><th></th></tr></thead>
      <tbody>
      <?php foreach ($services as $s): ?>
        <tr>
          <td><strong><?= e($s['title']) ?></strong><br><span class="muted" style="font-size:.8rem">/<?= e(service_slug($s)) ?>/</span></td>
          <td><?= count($s['projects'] ?? []) ?></td>
          <td><?= (int)($s['order']??0) ?></td>
          <td><?= ($s['show']??true) ? '✅' : '—' ?></td>
          <td class="inline" style="gap:.4rem">
            <a href="/admin/services.php?edit=<?= e($s['id']) ?>" class="btn btn-outline btn-sm"><?= e(t('edit')) ?></a>
            <form method="post" data-confirm="<?= e(t('delete')) ?>?" style="margin:0">
              <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($s['id']) ?>">
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
