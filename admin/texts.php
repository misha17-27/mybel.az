<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();
$s = load_json('settings', []);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $s['name']        = trim($_POST['name'] ?? $s['name']);
    $s['legal']       = trim($_POST['legal'] ?? '');
    $s['tagline']     = trim($_POST['tagline'] ?? '');
    $s['description'] = trim($_POST['description'] ?? '');
    $s['hero'] = [
        'eyebrow' => trim($_POST['hero_eyebrow'] ?? ''),
        'title'   => trim($_POST['hero_title'] ?? ''),
        'lead'    => trim($_POST['hero_lead'] ?? ''),
    ];
    $s['about'] = [
        'eyebrow' => trim($_POST['about_eyebrow'] ?? ''),
        'title'   => trim($_POST['about_title'] ?? ''),
        'text'    => trim($_POST['about_text'] ?? ''),
        'video'   => trim($_POST['about_video'] ?? ''),
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
    $stats = [];
    foreach (($_POST['stat_num'] ?? []) as $i => $num) {
        $num = trim($num); $lbl = trim($_POST['stat_label'][$i] ?? '');
        if ($num !== '' || $lbl !== '') $stats[] = ['num' => $num, 'label' => $lbl];
    }
    $s['about_page'] = [
        'lead'           => trim($_POST['ap_lead'] ?? ''),
        'intro_eyebrow'  => trim($_POST['ap_intro_eyebrow'] ?? ''),
        'intro_title'    => trim($_POST['ap_intro_title'] ?? ''),
        'intro_text'     => trim($_POST['ap_intro_text'] ?? ''),
        'mission_title'  => trim($_POST['ap_mission_title'] ?? ''),
        'mission_text'   => trim($_POST['ap_mission_text'] ?? ''),
        'approach_title' => trim($_POST['ap_approach_title'] ?? ''),
        'approach_text'  => trim($_POST['ap_approach_text'] ?? ''),
        'stats'          => $stats,
    ];
    save_json('settings', $s);
    flash(t('t_saved'));
    redirect('/admin/texts.php');
}

$PAGE_TITLE = t('t_title');
$ACTIVE = 'texts';
require __DIR__ . '/includes/layout_top.php';
$hero = $s['hero'] ?? []; $about = $s['about'] ?? [];
$home = $SITE['home']; $ap = $SITE['about_page'];
$stats = $ap['stats'] ?? [];
?>
<form method="post">
  <?= csrf_field() ?>
  <div class="card">
    <h2><?= e(t('t_common')) ?></h2>
    <div class="row row-2">
      <div class="field"><label><?= e(t('name')) ?></label><input type="text" name="name" value="<?= e($s['name']??'') ?>"></div>
      <div class="field"><label><?= e(t('t_legal')) ?></label><input type="text" name="legal" value="<?= e($s['legal']??'') ?>"></div>
    </div>
    <div class="field"><label><?= e(t('t_slogan')) ?></label><input type="text" name="tagline" value="<?= e($s['tagline']??'') ?>"></div>
    <div class="field"><label><?= e(t('t_shortdesc')) ?></label><textarea name="description" style="min-height:70px"><?= e($s['description']??'') ?></textarea></div>
  </div>

  <div class="card">
    <h2><?= e(t('t_hero')) ?></h2>
    <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="hero_eyebrow" value="<?= e($hero['eyebrow']??'') ?>"></div>
    <div class="field"><label><?= e(t('t_hero_title')) ?></label><textarea name="hero_title" style="min-height:70px"><?= e($hero['title']??'') ?></textarea></div>
    <div class="field"><label><?= e(t('t_hero_lead')) ?></label><textarea name="hero_lead" style="min-height:70px"><?= e($hero['lead']??'') ?></textarea></div>
  </div>

  <div class="card">
    <h2><?= e(t('t_about')) ?></h2>
    <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="about_eyebrow" value="<?= e($about['eyebrow']??'') ?>"></div>
    <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="about_title" value="<?= e($about['title']??'') ?>"></div>
    <div class="field"><label><?= e(t('t_about_text')) ?></label><textarea name="about_text" style="min-height:130px"><?= e($about['text']??'') ?></textarea></div>
    <div class="field"><label><?= e(t('t_video')) ?></label><input type="text" name="about_video" value="<?= e($about['video']??'') ?>" placeholder="https://youtu.be/... / https://vimeo.com/... / .mp4"><small class="hint" style="display:block;margin-top:.3rem"><?= e(t('t_video_h')) ?></small></div>
  </div>

  <div class="card">
    <h2><?= e(t('th_home')) ?></h2>
    <h3 style="font-size:.95rem;margin:.5rem 0"><?= e(t('th_projects')) ?></h3>
    <div class="row row-2">
      <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="h_projects_eyebrow" value="<?= e($home['projects_eyebrow']) ?>"></div>
      <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="h_projects_title" value="<?= e($home['projects_title']) ?>"></div>
    </div>
    <div class="field"><label><?= e(t('th_desc')) ?></label><input type="text" name="h_projects_desc" value="<?= e($home['projects_desc']) ?>"></div>
    <h3 style="font-size:.95rem;margin:.5rem 0"><?= e(t('th_services')) ?></h3>
    <div class="row row-2">
      <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="h_services_eyebrow" value="<?= e($home['services_eyebrow']) ?>"></div>
      <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="h_services_title" value="<?= e($home['services_title']) ?>"></div>
    </div>
    <h3 style="font-size:.95rem;margin:.5rem 0"><?= e(t('th_clients')) ?></h3>
    <div class="row row-2">
      <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="h_clients_eyebrow" value="<?= e($home['clients_eyebrow']) ?>"></div>
      <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="h_clients_title" value="<?= e($home['clients_title']) ?>"></div>
    </div>
    <h3 style="font-size:.95rem;margin:.5rem 0"><?= e(t('th_cta')) ?></h3>
    <div class="row row-2">
      <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="h_cta_title" value="<?= e($home['cta_title']) ?>"></div>
      <div class="field"><label><?= e(t('th_btn')) ?></label><input type="text" name="h_cta_btn" value="<?= e($home['cta_btn']) ?>"></div>
    </div>
    <div class="field"><label><?= e(t('th_desc')) ?></label><input type="text" name="h_cta_text" value="<?= e($home['cta_text']) ?>"></div>
  </div>

  <div class="card">
    <h2><?= e(t('ta_page')) ?></h2>
    <div class="field"><label><?= e(t('ta_lead')) ?></label><input type="text" name="ap_lead" value="<?= e($ap['lead']) ?>"></div>
    <h3 style="font-size:.95rem;margin:.5rem 0"><?= e(t('ta_intro')) ?></h3>
    <div class="row row-2">
      <div class="field"><label><?= e(t('t_eyebrow')) ?></label><input type="text" name="ap_intro_eyebrow" value="<?= e($ap['intro_eyebrow']) ?>"></div>
      <div class="field"><label><?= e(t('title_f')) ?></label><input type="text" name="ap_intro_title" value="<?= e($ap['intro_title']) ?>"></div>
    </div>
    <div class="field"><label><?= e(t('ta_text')) ?></label><textarea name="ap_intro_text" style="min-height:110px"><?= e($ap['intro_text']) ?></textarea></div>
    <div class="row row-2">
      <div class="field"><label><?= e(t('ta_mission')) ?> — <?= e(t('title_f')) ?></label><input type="text" name="ap_mission_title" value="<?= e($ap['mission_title']) ?>"></div>
      <div class="field"><label><?= e(t('ta_approach')) ?> — <?= e(t('title_f')) ?></label><input type="text" name="ap_approach_title" value="<?= e($ap['approach_title']) ?>"></div>
    </div>
    <div class="row row-2">
      <div class="field"><label><?= e(t('ta_mission')) ?> — <?= e(t('ta_text')) ?></label><textarea name="ap_mission_text" style="min-height:90px"><?= e($ap['mission_text']) ?></textarea></div>
      <div class="field"><label><?= e(t('ta_approach')) ?> — <?= e(t('ta_text')) ?></label><textarea name="ap_approach_text" style="min-height:90px"><?= e($ap['approach_text']) ?></textarea></div>
    </div>
    <h3 style="font-size:.95rem;margin:.5rem 0"><?= e(t('ta_stats')) ?></h3>
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
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
