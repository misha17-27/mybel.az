<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/upload.php';
require_login();
$s = load_json('settings', []);
$EL = $ADMIN_LANG; $IS_TR = ($EL !== 'az');   // AZ = əsas (baza), RU/EN = tərcümə

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
    $blk = [];   // settings-ə nisbi struktur

    if ($pg === 'home') {
        $blk['hero'] = ['eyebrow' => trim($_POST['hero_eyebrow'] ?? ''), 'title' => trim($_POST['hero_title'] ?? ''), 'lead' => trim($_POST['hero_lead'] ?? '')];
        if (!$IS_TR) { $blk['hero']['image'] = pg_img('hero_image_file', 'hero_image_url', $SITE['hero']['image'] ?? ''); $blk['hero']['video'] = trim($_POST['hero_video'] ?? ''); }
        $blk['about'] = ['eyebrow' => trim($_POST['about_eyebrow'] ?? ''), 'title' => trim($_POST['about_title'] ?? ''), 'text' => trim($_POST['about_text'] ?? '')];
        if (!$IS_TR) $blk['about']['image'] = pg_img('about_image_file', 'about_image_url', $SITE['about']['image'] ?? '');
        $blk['home'] = [
            'projects_eyebrow' => trim($_POST['h_projects_eyebrow'] ?? ''), 'projects_title' => trim($_POST['h_projects_title'] ?? ''), 'projects_desc' => trim($_POST['h_projects_desc'] ?? ''),
            'services_eyebrow' => trim($_POST['h_services_eyebrow'] ?? ''), 'services_title' => trim($_POST['h_services_title'] ?? ''),
            'clients_eyebrow' => trim($_POST['h_clients_eyebrow'] ?? ''), 'clients_title' => trim($_POST['h_clients_title'] ?? ''),
            'cta_title' => trim($_POST['h_cta_title'] ?? ''), 'cta_text' => trim($_POST['h_cta_text'] ?? ''), 'cta_btn' => trim($_POST['h_cta_btn'] ?? ''),
        ];
    } elseif ($pg === 'about') {
        $stats = [];
        foreach (($_POST['stat_label'] ?? []) as $i => $lbl) {
            $lbl = trim($lbl);
            if ($IS_TR) { $stats[] = ['label' => $lbl]; }
            else { $num = trim($_POST['stat_num'][$i] ?? ''); if ($num !== '' || $lbl !== '') $stats[] = ['num' => $num, 'label' => $lbl]; }
        }
        $blk['about_page'] = ['lead' => trim($_POST['ap_lead'] ?? ''), 'intro_eyebrow' => trim($_POST['ap_intro_eyebrow'] ?? ''), 'intro_title' => trim($_POST['ap_intro_title'] ?? ''), 'intro_text' => trim($_POST['ap_intro_text'] ?? ''), 'stats' => $stats];
        if (!$IS_TR) $blk['about_page']['image'] = pg_img('ap_image_file', 'ap_image_url', $SITE['about_page']['image'] ?? '');
    } elseif ($pg === 'xidmetler') {
        $sectors = [];
        foreach (($_POST['sec_name'] ?? []) as $i => $nm) {
            $nm = trim($nm);
            if ($IS_TR) { $sectors[] = ['name' => $nm]; }
            else { if ($nm === '') continue; $sectors[] = ['icon' => trim($_POST['sec_icon'][$i] ?? 'home'), 'name' => $nm]; }
        }
        $process = [];
        foreach (($_POST['pr_title'] ?? []) as $i => $tt) {
            $tt = trim($tt); $dd = trim($_POST['pr_desc'][$i] ?? '');
            if ($IS_TR) { $process[] = ['title' => $tt, 'desc' => $dd]; }
            else { if ($tt === '' && $dd === '') continue; $process[] = ['title' => $tt, 'desc' => $dd]; }
        }
        $blk['xidmetler_page'] = [
            'sectors_title' => trim($_POST['sectors_title'] ?? ''), 'sectors_desc' => trim($_POST['sectors_desc'] ?? ''), 'sectors' => $sectors,
            'process_eyebrow' => trim($_POST['process_eyebrow'] ?? ''), 'process_title' => trim($_POST['process_title'] ?? ''), 'process' => $process,
        ];
        $blk['pages'] = ['xidmetler' => ['title' => trim($_POST['sectors_title'] ?? ''), 'subtitle' => trim($_POST['sectors_desc'] ?? '')]];
    } elseif (in_array($pg, ['layiheler', 'musteriler', 'elaqe'], true)) {
        $blk['pages'] = [$pg => ['title' => trim($_POST['title'] ?? ''), 'subtitle' => trim($_POST['subtitle'] ?? '')]];
    }
    if (isset($PAGE_DEFS[$pg])) {
        $blk['page_seo'] = [$pg => ['title' => trim($_POST['seo_title'] ?? ''), 'desc' => trim($_POST['seo_desc'] ?? '')]];
    }

    if ($IS_TR) {
        $td = content_tr_data();
        $tset = $td[$EL]['settings'] ?? [];
        foreach ($blk as $k => $v) {
            if (in_array($k, ['pages', 'page_seo'], true)) $tset[$k] = array_replace($tset[$k] ?? [], $v);
            else $tset[$k] = $v;
        }
        $td[$EL]['settings'] = $tset;
        content_tr_save($td);
    } else {
        foreach ($blk as $k => $v) {
            if (in_array($k, ['pages', 'page_seo'], true)) $s[$k] = array_replace($s[$k] ?? [], $v);
            else $s[$k] = $v;
        }
        save_json('settings', $s);
    }
    flash(t('pg_saved'));
    redirect('/admin/pages.php' . ($pg ? '?edit=' . $pg : ''));
}

$editing = $_GET['edit'] ?? null;
if ($editing !== null && !isset($PAGE_DEFS[$editing])) $editing = null;

$PAGE_TITLE = t('n_pages');
$ACTIVE = 'pages';
require __DIR__ . '/includes/layout_top.php';

// Mənbə massivləri — RU/EN olduqda tərcümə (baza üstündən) ilə örtülür
$tset = $IS_TR ? (content_tr_merged()[$EL]['settings'] ?? []) : [];
$hero = $SITE['hero']; $about = $SITE['about']; $home = $SITE['home'];
$ap = $SITE['about_page']; $pages = $SITE['pages'];
$pseo = $editing ? page_seo($editing) : ['title' => '', 'desc' => ''];
if ($IS_TR) {
    $hero  = array_replace($hero, $tset['hero'] ?? []);
    $about = array_replace($about, $tset['about'] ?? []);
    $home  = array_replace($home, $tset['home'] ?? []);
    $ap    = array_replace_recursive($ap, $tset['about_page'] ?? []);
    $pages = array_replace_recursive($pages, $tset['pages'] ?? []);
    if ($editing) $pseo = array_replace($pseo, $tset['page_seo'][$editing] ?? []);
}
$stats = $ap['stats'] ?? [];
$trban = ($IS_TR && $editing) ? '<div class="card" style="border:1px solid var(--brand)"><p class="hint" style="margin:0">' . e(t('tr_note')) . ' — ' . strtoupper($EL) . '</p></div>' : '';

/** SEO kartı */
function seo_card($pseo) {
    ob_start(); ?>
    <div class="card">
      <h2><?= e(t('pg_seo')) ?></h2>
      <p class="hint"><?= e(t('pg_seo_h')) ?></p>
      <div class="field"><label><?= e(t('pg_seo_title')) ?></label><input type="text" name="seo_title" value="<?= e($pseo['title']) ?>" maxlength="70"></div>
      <div class="field"><label><?= e(t('pg_seo_desc')) ?></label><textarea name="seo_desc" style="min-height:70px" maxlength="180"><?= e($pseo['desc']) ?></textarea></div>
    </div>
    <?php return ob_get_clean();
}
?>
<?php if ($editing === null): ?>
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
    <?= $trban ?>
    <div class="card">
      <h2><?= e(t('t_hero')) ?></h2>
      <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="hero_eyebrow" value="<?= e($hero['eyebrow']) ?>"></div>
      <div class="field"><label><?= e(t('t_hero_title')) ?></label><textarea name="hero_title" style="min-height:70px"><?= e($hero['title']) ?></textarea></div>
      <div class="field"><label><?= e(t('t_hero_lead')) ?></label><textarea name="hero_lead" style="min-height:70px"><?= e($hero['lead']) ?></textarea></div>
      <?php if (!$IS_TR): ?>
      <div class="field">
        <label><?= e(t('pg_image')) ?></label>
        <?php if (!empty($hero['image'])): ?><img class="thumb" style="width:150px;height:80px;margin-bottom:.5rem" src="<?= e($hero['image']) ?>" alt=""><?php endif; ?>
        <input type="file" name="hero_image_file" accept="image/*">
        <input type="text" name="hero_image_url" placeholder="<?= e(t('p_or_url')) ?>" style="margin-top:.5rem">
      </div>
      <div class="field">
        <label><?= e(t('t_hero_video')) ?></label>
        <input type="text" name="hero_video" value="<?= e($hero['video'] ?? '') ?>" placeholder="/assets/video/slideshow.mp4">
        <small class="hint" style="display:block;margin-top:.3rem"><?= e(t('t_hero_video_h')) ?></small>
      </div>
      <?php endif; ?>
    </div>
    <div class="card">
      <h2><?= e(t('t_about')) ?></h2>
      <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="about_eyebrow" value="<?= e($about['eyebrow']) ?>"></div>
      <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="about_title" value="<?= e($about['title']) ?>"></div>
      <div class="field"><label><?= e(t('t_about_text')) ?></label><textarea name="about_text" class="richtext" style="min-height:110px"><?= e($about['text']) ?></textarea></div>
      <?php if (!$IS_TR): ?>
      <div class="field">
        <label><?= e(t('pg_image')) ?></label>
        <?php if (!empty($about['image'])): ?><img class="thumb" style="width:150px;height:80px;margin-bottom:.5rem" src="<?= e($about['image']) ?>" alt=""><?php endif; ?>
        <input type="file" name="about_image_file" accept="image/*">
        <input type="text" name="about_image_url" placeholder="<?= e(t('p_or_url')) ?>" style="margin-top:.5rem">
      </div>
      <?php endif; ?>
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
    <?= seo_card($pseo) ?>
    <button class="btn" type="submit"><?= e(t('save_all')) ?></button>
  </form>

<?php elseif ($editing === 'about'): ?>
  <form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?><input type="hidden" name="page" value="about">
    <div class="item-head"><h2><?= e(t('pg_about')) ?></h2><a href="/admin/pages.php" class="btn btn-outline btn-sm">← <?= e(t('back_list')) ?></a></div>
    <?= $trban ?>
    <div class="card">
      <div class="field"><label><?= e(t('ta_lead')) ?></label><input type="text" name="ap_lead" value="<?= e($ap['lead']) ?>"></div>
      <?php if (!$IS_TR): ?>
      <div class="field">
        <label><?= e(t('pg_image')) ?></label>
        <?php if (!empty($ap['image'])): ?><img class="thumb" style="width:150px;height:80px;margin-bottom:.5rem" src="<?= e($ap['image']) ?>" alt=""><?php endif; ?>
        <input type="file" name="ap_image_file" accept="image/*">
        <input type="text" name="ap_image_url" placeholder="<?= e(t('p_or_url')) ?>" style="margin-top:.5rem">
      </div>
      <?php endif; ?>
      <h3 style="margin:.4rem 0"><?= e(t('ta_intro')) ?></h3>
      <div class="row row-2">
        <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="ap_intro_eyebrow" value="<?= e($ap['intro_eyebrow']) ?>"></div>
        <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="ap_intro_title" value="<?= e($ap['intro_title']) ?>"></div>
      </div>
      <div class="field"><label><?= e(t('ta_text')) ?></label><textarea name="ap_intro_text" class="richtext" style="min-height:110px"><?= e($ap['intro_text']) ?></textarea></div>
      <h3 style="margin:.4rem 0"><?= e(t('ta_stats')) ?></h3>
      <div class="grid" style="grid-template-columns:repeat(auto-fill,minmax(200px,1fr))">
        <?php for ($i = 0; $i < 4; $i++): $st = $stats[$i] ?? ['num'=>'','label'=>'']; ?>
          <div class="item-card" style="margin:0">
            <?php if (!$IS_TR): ?><div class="field" style="margin-bottom:.5rem"><label><?= e(t('ta_num')) ?></label><input type="text" name="stat_num[]" value="<?= e($st['num'] ?? '') ?>"></div><?php endif; ?>
            <div class="field" style="margin:0"><label><?= e(t('ta_label')) ?><?php if ($IS_TR && !empty($st['num'])): ?> <span class="hint">(<?= e($st['num']) ?>)</span><?php endif; ?></label><input type="text" name="stat_label[]" value="<?= e($st['label'] ?? '') ?>"></div>
          </div>
        <?php endfor; ?>
      </div>
    </div>
    <?= seo_card($pseo) ?>
    <button class="btn" type="submit"><?= e(t('save_all')) ?></button>
  </form>

<?php elseif ($editing === 'xidmetler'):
    $xp = $SITE['xidmetler_page'];
    if ($IS_TR) $xp = array_replace_recursive($xp, $tset['xidmetler_page'] ?? []);
    $ICONS = ['hotel','restaurant','education','medical','business','office','home','kitchen','table','bed','wardrobe','sofa','design'];
    $secRows = $xp['sectors'] ?? []; while (count($secRows) < 10) $secRows[] = ['icon'=>'home','name'=>''];
    $prRows  = $xp['process'] ?? []; while (count($prRows) < 12) $prRows[] = ['title'=>'','desc'=>'']; ?>
  <form method="post">
    <?= csrf_field() ?><input type="hidden" name="page" value="xidmetler">
    <div class="item-head"><h2><?= e($PAGE_DEFS['xidmetler']) ?></h2><a href="/admin/pages.php" class="btn btn-outline btn-sm">← <?= e(t('back_list')) ?></a></div>
    <?= $trban ?>
    <div class="card">
      <div class="field"><label><?= e(t('pg_hero_title')) ?></label><input type="text" name="sectors_title" value="<?= e($xp['sectors_title'] ?? '') ?>"></div>
      <div class="field"><label><?= e(t('pg_subtitle')) ?></label><textarea name="sectors_desc" style="min-height:80px"><?= e($xp['sectors_desc'] ?? '') ?></textarea></div>
    </div>
    <div class="card">
      <h2><?= e(t('xp_sectors')) ?></h2>
      <p class="hint"><?= e(t('xp_sectors_h')) ?></p>
      <div class="grid" style="grid-template-columns:repeat(auto-fill,minmax(230px,1fr))">
        <?php foreach ($secRows as $sec): ?>
          <div class="item-card" style="margin:0">
            <?php if (!$IS_TR): ?>
            <div class="field" style="margin-bottom:.5rem"><label><?= e(t('s_icon')) ?></label>
              <select name="sec_icon[]">
                <?php foreach ($ICONS as $ic): ?><option value="<?= e($ic) ?>"<?= (($sec['icon'] ?? '') === $ic) ? ' selected' : '' ?>><?= e(t('ic_'.$ic)) ?></option><?php endforeach; ?>
              </select>
            </div>
            <?php endif; ?>
            <div class="field" style="margin:0"><label><?= e(t('name')) ?></label><input type="text" name="sec_name[]" value="<?= e($sec['name'] ?? '') ?>"></div>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="hint" style="margin-top:.6rem"><?= e(t('xp_row_hint')) ?></p>
    </div>
    <div class="card">
      <h2><?= e(t('xp_process')) ?></h2>
      <p class="hint"><?= e(t('xp_process_h')) ?></p>
      <div class="row row-2">
        <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="process_eyebrow" value="<?= e($xp['process_eyebrow'] ?? '') ?>"></div>
        <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="process_title" value="<?= e($xp['process_title'] ?? '') ?>"></div>
      </div>
      <?php foreach ($prRows as $i => $st): ?>
        <div class="item-card" style="margin:.5rem 0">
          <div class="field" style="margin-bottom:.5rem"><label><?= $i+1 ?>. <?= e(t('title_f')) ?></label><input type="text" name="pr_title[]" value="<?= e($st['title'] ?? '') ?>"></div>
          <div class="field" style="margin:0"><label><?= e(t('ta_text')) ?></label><textarea name="pr_desc[]" style="min-height:60px"><?= e($st['desc'] ?? '') ?></textarea></div>
        </div>
      <?php endforeach; ?>
      <p class="hint" style="margin-top:.6rem"><?= e(t('xp_row_hint')) ?></p>
    </div>
    <?= seo_card($pseo) ?>
    <button class="btn" type="submit"><?= e(t('save_all')) ?></button>
  </form>

<?php else: $pd = $pages[$editing] ?? ['title'=>'','subtitle'=>'']; ?>
  <form method="post">
    <?= csrf_field() ?><input type="hidden" name="page" value="<?= e($editing) ?>">
    <div class="item-head"><h2><?= e($PAGE_DEFS[$editing]) ?></h2><a href="/admin/pages.php" class="btn btn-outline btn-sm">← <?= e(t('back_list')) ?></a></div>
    <?= $trban ?>
    <div class="card">
      <div class="field"><label><?= e(t('pg_hero_title')) ?></label><input type="text" name="title" value="<?= e($pd['title']) ?>"></div>
      <div class="field"><label><?= e(t('pg_subtitle')) ?></label><textarea name="subtitle" style="min-height:80px"><?= e($pd['subtitle']) ?></textarea></div>
    </div>
    <?= seo_card($pseo) ?>
    <button class="btn" type="submit"><?= e(t('save')) ?></button>
  </form>
<?php endif; ?>
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
