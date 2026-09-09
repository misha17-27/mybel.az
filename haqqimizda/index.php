<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = 'haqqimizda';
$ps = page_seo('about');
$page_title = $ps['title'] ?: ('Şirkət haqqında — ' . $SITE['name']);
$page_desc  = $ps['desc'] ?: 'MYBEL Concept — restoran, otel və fərdi evlər üçün fərdi mebel istehsalı sahəsində peşəkar komanda.';
$page_url   = '/haqqimizda/';
$breadcrumbs = [['name' => 'Ana səhifə', 'url' => '/'], ['name' => 'Şirkət haqqında', 'url' => '/haqqimizda/']];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Naviqasiya izi">
            <a href="/">Ana səhifə</a><span>/</span><strong>Şirkət haqqında</strong>
        </nav>
        <h1>Şirkət haqqında</h1>
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

<section class="section">
    <div class="container">
        <div class="cta-band" data-reveal>
            <h2>Birlikdə işləyək</h2>
            <p>Növbəti layihənizi MYBEL Concept ilə həyata keçirin.</p>
            <a href="/elaqe/" class="btn">Əlaqə saxla</a>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
