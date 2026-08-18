<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/upload.php';
require_login();
$s = load_json('settings', []);

/** Şəkil: yeni yükləmə > URL sahəsi > köhnə */
function pg_img($fileKey, $urlKey, $current) {
    $err = null; $up = upload_image($_FILES[$fileKey] ?? [], $err);
    if ($up) return $up;
    $url = trim($_POST[$urlKey] ?? '');
    if ($url !== '') return $url;
    return $current;
}

$PAGE_DEFS = [
    'home'       => t('pg_home'),
    'about'      => t('pg_about'),
    'layiheler'  => t('pg_projects'),
    'xidmetler'  => t('pg_services'),
    'musteriler' => t('pg_clients'),
    'elaqe'      => t('pg_contact'),
];

/* ---------------- SAVE ---------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $pg = $_POST['page'] ?? '';

    if ($pg === 'home') {
        $s['hero'] = [
            'eyebrow' => trim($_POST['hero_eyebrow'] ?? ''),
            'title'   => trim($_POST['hero_title'] ?? ''),
            'lead'    => trim($_POST['hero_lead'] ?? ''),
            'image'   => pg_img('hero_image_file', 'hero_image_url', $SITE['hero']['image'] ?? ''),
        ];
        $s['about'] = [
            'eyebrow' => trim($_POST['about_eyebrow'] ?? ''),
            'title'   => trim($_POST['about_title'] ?? ''),
            'text'    => trim($_POST['about_text'] ?? ''),
            'image'   => pg_img('about_image_file', 'about_image_url', $SITE['about']['image'] ?? ''),
        ];
        $s['home'] = [
            'projects_eyebrow' => trim($_POST['h_projects_eyebrow'] ?? ''),
            'projects_title'   => trim($_POST['h_projects_title'] ?? ''),
            'projects_desc'    => trim($_POST['h_projects_desc'] ?? ''),
            'services_eyebrow' => trim($_POST['h_services_eyebrow'] ?? ''),
            'services_title'   => trim($_POST['h_services_title'] ?? ''),
            'clients_eyebrow'  => trim($_POST['h_clients_eyebrow'] ?? ''),
            'clients_title'    => trim($_POST['h_clients_title'] ?? ''),
            'cta_title'        => trim($_POST['h_cta_title'] ?? ''),
            'cta_text'         => trim($_POST['h_cta_text'] ?? ''),
            'cta_btn'          => trim($_POST['h_cta_btn'] ?? ''),
        ];
    } elseif ($pg === 'about') {
        $stats = [];
        foreach (($_POST['stat_num'] ?? []) as $i => $num) {
            $num = trim($num); $lbl = trim($_POST['stat_label'][$i] ?? '');
            if ($num !== '' || $lbl !== '') $stats[] = ['num' => $num, 'label' => $lbl];
        }
        $s['about_page'] = [
            'lead'           => trim($_POST['ap_lead'] ?? ''),
            'image'          => pg_img('ap_image_file', 'ap_image_url', $SITE['about_page']['image'] ?? ''),
            'video'          => trim($_POST['ap_video'] ?? ''),
            'intro_eyebrow'  => trim($_POST['ap_intro_eyebrow'] ?? ''),
            'intro_title'    => trim($_POST['ap_intro_title'] ?? ''),
            'intro_text'     => trim($_POST['ap_intro_text'] ?? ''),
            'mission_title'  => trim($_POST['ap_mission_title'] ?? ''),
            'mission_text'   => trim($_POST['ap_mission_text'] ?? ''),
            'approach_title' => trim($_POST['ap_approach_title'] ?? ''),
            'approach_text'  => trim($_POST['ap_approach_text'] ?? ''),
            'stats'          => $stats,
        ];
    } elseif (in_array($pg, ['layiheler', 'xidmetler', 'musteriler', 'elaqe'], true)) {
        $s['pages'][$pg] = [
            'title'    => trim($_POST['title'] ?? ''),
            'subtitle' => trim($_POST['subtitle'] ?? ''),
        ];
    }
    save_json('settings', $s);
    flash(t('pg_saved'));
    redirect('/admin/pages.php');
}

$editing = $_GET['edit'] ?? null;
if ($editing !== null && !isset($PAGE_DEFS[$editing])) $editing = null;

$PAGE_TITLE = t('n_pages');
$ACTIVE = 'pages';
require __DIR__ . '/includes/layout_top.php';

$hero = $SITE['hero']; $about = $SITE['about']; $home = $SITE['home'];
$ap = $SITE['about_page']; $stats = $ap['stats'] ?? [];
$pages = $SITE['pages'];
?>
<?php if ($editing === null): ?>
  <!-- ===== SİYAHI ===== -->
  <div class="card">
    <div class="item-head"><div><h2><?= e(t('pg_all')) ?></h2><p class="hint" style="margin:0"><?= e(t('pg_all_h')) ?></p></div></div>
    <table>
      <thead><tr><th><?= e(t('pg_col')) ?></th><th></th></tr></thead>
      <tbody>
        <?php foreach ($PAGE_DEFS as $key => $label): ?>
          <tr>
            <td><strong><?= e($label) ?></strong></td>
            <td class="inline" style="gap:.4rem;justify-content:flex-end">
              <a href="/admin/pages.php?edit=<?= e($key) ?>" class="btn btn-outline btn-sm"><?= e(t('edit')) ?></a>
              <a href="<?= $key==='home'?'/':($key==='about'?'/haqqimizda/':'/'.$key.'/') ?>" target="_blank" class="btn btn-outline btn-sm">↗</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

<?php elseif ($editing === 'home'): ?>
  <form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?><input type="hidden" name="page" value="home">
    <div class="item-head"><h2><?= e(t('pg_home')) ?></h2><a href="/admin/pages.php" class="btn btn-outline btn-sm">← <?= e(t('back_list')) ?></a></div>
    <div class="card">
      <h2><?= e(t('t_hero')) ?></h2>
      <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="hero_eyebrow" value="<?= e($hero['eyebrow']) ?>"></div>
      <div class="field"><label><?= e(t('t_hero_title')) ?></label><textarea name="hero_title" style="min-height:70px"><?= e($hero['title']) ?></textarea></div>
      <div class="field"><label><?= e(t('t_hero_lead')) ?></label><textarea name="hero_lead" style="min-height:70px"><?= e($hero['lead']) ?></textarea></div>
      <div class="field">
        <label><?= e(t('pg_image')) ?></label>
        <?php if (!empty($hero['image'])): ?><img class="thumb" style="width:150px;height:80px;margin-bottom:.5rem" src="<?= e($hero['image']) ?>" alt=""><?php endif; ?>
        <input type="file" name="hero_image_file" accept="image/*">
        <input type="text" name="hero_image_url" placeholder="<?= e(t('p_or_url')) ?>" style="margin-top:.5rem">
      </div>
    </div>
    <div class="card">
      <h2><?= e(t('t_about')) ?></h2>
      <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="about_eyebrow" value="<?= e($about['eyebrow']) ?>"></div>
      <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="about_title" value="<?= e($about['title']) ?>"></div>
      <div class="field"><label><?= e(t('t_about_text')) ?></label><textarea name="about_text" class="richtext" style="min-height:110px"><?= e($about['text']) ?></textarea></div>
      <div class="field">
        <label><?= e(t('pg_image')) ?></label>
        <?php if (!empty($about['image'])): ?><img class="thumb" style="width:150px;height:80px;margin-bottom:.5rem" src="<?= e($about['image']) ?>" alt=""><?php endif; ?>
        <input type="file" name="about_image_file" accept="image/*">
        <input type="text" name="about_image_url" placeholder="<?= e(t('p_or_url')) ?>" style="margin-top:.5rem">
      </div>
    </div>
    <div class="card">
      <h2><?= e(t('th_home')) ?></h2>
      <h3 style="margin:.4rem 0"><?= e(t('th_projects')) ?></h3>
      <div class="row row-2">
        <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="h_projects_eyebrow" value="<?= e($home['projects_eyebrow']) ?>"></div>
        <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="h_projects_title" value="<?= e($home['projects_title']) ?>"></div>
      </div>
      <div class="field"><label><?= e(t('th_desc')) ?></label><input type="text" name="h_projects_desc" value="<?= e($home['projects_desc']) ?>"></div>
      <h3 style="margin:.4rem 0"><?= e(t('th_services')) ?></h3>
      <div class="row row-2">
        <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="h_services_eyebrow" value="<?= e($home['services_eyebrow']) ?>"></div>
        <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="h_services_title" value="<?= e($home['services_title']) ?>"></div>
      </div>
      <h3 style="margin:.4rem 0"><?= e(t('th_clients')) ?></h3>
      <div class="row row-2">
        <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="h_clients_eyebrow" value="<?= e($home['clients_eyebrow']) ?>"></div>
        <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="h_clients_title" value="<?= e($home['clients_title']) ?>"></div>
      </div>
      <h3 style="margin:.4rem 0"><?= e(t('th_cta')) ?></h3>
      <div class="row row-2">
        <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="h_cta_title" value="<?= e($home['cta_title']) ?>"></div>
        <div class="field"><label><?= e(t('th_btn')) ?></label><input type="text" name="h_cta_btn" value="<?= e($home['cta_btn']) ?>"></div>
      </div>
      <div class="field"><label><?= e(t('th_desc')) ?></label><input type="text" name="h_cta_text" value="<?= e($home['cta_text']) ?>"></div>
    </div>
    <button class="btn" type="submit"><?= e(t('save_all')) ?></button>
  </form>

<?php elseif ($editing === 'about'): ?>
  <form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?><input type="hidden" name="page" value="about">
    <div class="item-head"><h2><?= e(t('pg_about')) ?></h2><a href="/admin/pages.php" class="btn btn-outline btn-sm">← <?= e(t('back_list')) ?></a></div>
    <div class="card">
      <div class="field"><label><?= e(t('ta_lead')) ?></label><input type="text" name="ap_lead" value="<?= e($ap['lead']) ?>"></div>
      <div class="row row-2">
        <div class="field">
          <label><?= e(t('pg_image')) ?></label>
          <?php if (!empty($ap['image'])): ?><img class="thumb" style="width:150px;height:80px;margin-bottom:.5rem" src="<?= e($ap['image']) ?>" alt=""><?php endif; ?>
          <input type="file" name="ap_image_file" accept="image/*">
          <input type="text" name="ap_image_url" placeholder="<?= e(t('p_or_url')) ?>" style="margin-top:.5rem">
        </div>
        <div class="field">
          <label><?= e(t('t_video')) ?></label>
          <input type="text" name="ap_video" value="<?= e($ap['video'] ?? '') ?>" placeholder="https://youtu.be/... / .mp4">
          <small class="hint" style="display:block;margin-top:.3rem"><?= e(t('t_video_h')) ?></small>
        </div>
      </div>
      <h3 style="margin:.4rem 0"><?= e(t('ta_intro')) ?></h3>
      <div class="row row-2">
        <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="ap_intro_eyebrow" value="<?= e($ap['intro_eyebrow']) ?>"></div>
        <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="ap_intro_title" value="<?= e($ap['intro_title']) ?>"></div>
      </div>
      <div class="field"><label><?= e(t('ta_text')) ?></label><textarea name="ap_intro_text" class="richtext" style="min-height:110px"><?= e($ap['intro_text']) ?></textarea></div>
      <div class="row row-2">
        <div class="field"><label><?= e(t('ta_mission')) ?> — <?= e(t('title_f')) ?></label><input type="text" name="ap_mission_title" value="<?= e($ap['mission_title']) ?>"></div>
        <div class="field"><label><?= e(t('ta_approach')) ?> — <?= e(t('title_f')) ?></label><input type="text" name="ap_approach_title" value="<?= e($ap['approach_title']) ?>"></div>
      </div>
      <div class="row row-2">
        <div class="field"><label><?= e(t('ta_mission')) ?> — <?= e(t('ta_text')) ?></label><textarea name="ap_mission_text" class="richtext" style="min-height:90px"><?= e($ap['mission_text']) ?></textarea></div>
        <div class="field"><label><?= e(t('ta_approach')) ?> — <?= e(t('ta_text')) ?></label><textarea name="ap_approach_text" class="richtext" style="min-height:90px"><?= e($ap['approach_text']) ?></textarea></div>
      </div>
      <h3 style="margin:.4rem 0"><?= e(t('ta_stats')) ?></h3>
      <div class="grid" style="grid-template-columns:repeat(auto-fill,minmax(200px,1fr))">
        <?php for ($i = 0; $i < 4; $i++): $st = $stats[$i] ?? ['num'=>'','label'=>'']; ?>
          <div class="item-card" style="margin:0">
            <div class="field" style="margin-bottom:.5rem"><label><?= e(t('ta_num')) ?></label><input type="text" name="stat_num[]" value="<?= e($st['num']) ?>"></div>
            <div class="field" style="margin:0"><label><?= e(t('ta_label')) ?></label><input type="text" name="stat_label[]" value="<?= e($st['label']) ?>"></div>
          </div>
        <?php endfor; ?>
      </div>
    </div>
    <button class="btn" type="submit"><?= e(t('save_all')) ?></button>
  </form>

<?php else: $pd = $pages[$editing] ?? ['title'=>'','subtitle'=>'']; ?>
  <form method="post">
    <?= csrf_field() ?><input type="hidden" name="page" value="<?= e($editing) ?>">
    <div class="card">
      <div class="item-head"><h2><?= e($PAGE_DEFS[$editing]) ?></h2><a href="/admin/pages.php" class="btn btn-outline btn-sm">← <?= e(t('back_list')) ?></a></div>
      <div class="field"><label><?= e(t('pg_hero_title')) ?></label><input type="text" name="title" value="<?= e($pd['title']) ?>"></div>
      <div class="field"><label><?= e(t('pg_subtitle')) ?></label><textarea name="subtitle" style="min-height:80px"><?= e($pd['subtitle']) ?></textarea></div>
      <button class="btn" type="submit"><?= e(t('save')) ?></button>
    </div>
  </form>
<?php endif; ?>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
