<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = 'haqqimizda';
$ps = page_seo('about');
$page_title = $ps['title'] ?: ('Şirkət haqqında — ' . $SITE['name']);
$page_desc  = $ps['desc'] ?: 'MYBEL Concept — restoran, otel və fərdi evlər üçün fərdi mebel istehsalı sahəsində peşəkar komanda.';
$page_url   = '/haqqimizda/';
$breadcrumbs = [['name' => __('nav_home'), 'url' => '/'], ['name' => __('nav_about'), 'url' => '/haqqimizda/']];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="<?= e(__('breadcrumb')) ?>">
            <a href="<?= e(u('/')) ?>"><?= e(__('nav_home')) ?></a><span>/</span><strong><?= e(__('nav_about')) ?></strong>
        </nav>
        <h1><?= e(__('nav_about')) ?></h1>
        <p><?= e($SITE['about_page']['lead']) ?></p>
    </div>
</section>

<section class="section">
    <div class="container about-split">
        <div data-reveal>
            <img src="<?= e($SITE['about_page']['image'] ?: '/assets/img/demo/living-neutral.jpg') ?>" alt="MYBEL Concept interyer işi" width="900" height="820">
        </div>
        <div class="about-text" data-reveal>
            <span class="eyebrow"><?= e($SITE['about_page']['intro_eyebrow']) ?></span>
            <h2 class="section-title"><?= e($SITE['about_page']['intro_title']) ?></h2>
            <?= rich_text($SITE['about_page']['intro_text']) ?>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="stats-row">
            <?php foreach ($SITE['about_page']['stats'] as $st): ?>
                <div class="stat" data-reveal><div class="stat-num"><?= e($st['num']) ?></div><div class="stat-label"><?= e($st['label']) ?></div></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section cta-section">
    <div class="container">
        <div class="cta-band cta-dark" data-reveal>
            <h2><?= e(__('cta_about_title')) ?></h2>
            <p><?= e(__('cta_about_text')) ?></p>
            <a href="<?= e(u('/elaqe/')) ?>" class="btn"><?= e(__('cta_about_btn')) ?></a>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
