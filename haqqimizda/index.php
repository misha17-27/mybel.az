<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = 'haqqimizda';
$page_title = 'Şirkət haqqında — ' . $SITE['name'];
$page_desc  = 'MYBEL Concept — restoran, otel və fərdi evlər üçün fərdi mebel istehsalı sahəsində peşəkar komanda. Şirkətimiz haqqında.';
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
            <?php foreach (preg_split('/\n{2,}/', trim($SITE['about_page']['intro_text'])) as $par): ?>
                <p><?= nl2br(e($par)) ?></p>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ VİDEO ============ -->
<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow">Video</span>
            <h2 class="section-title">Şirkətimiz haqqında video</h2>
        </div>
        <?php $about_video = $SITE['about_page']['video'] ?? ''; ?>
        <?php if ($about_video !== ''): ?>
            <?= video_embed($about_video) ?>
        <?php else: ?>
            <div class="video-placeholder" data-reveal>
                <div>
                    <svg width="46" height="46" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto .6rem"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none"/></svg>
                    <p>Video buraya əlavə olunacaq</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="about-split" style="align-items:start">
            <div class="about-text" data-reveal>
                <span class="eyebrow">Missiyamız</span>
                <h2 class="section-title"><?= e($SITE['about_page']['mission_title']) ?></h2>
                <?php foreach (preg_split('/\n{2,}/', trim($SITE['about_page']['mission_text'])) as $par): ?><p><?= nl2br(e($par)) ?></p><?php endforeach; ?>
            </div>
            <div class="about-text" data-reveal>
                <span class="eyebrow">Yanaşmamız</span>
                <h2 class="section-title"><?= e($SITE['about_page']['approach_title']) ?></h2>
                <?php foreach (preg_split('/\n{2,}/', trim($SITE['about_page']['approach_text'])) as $par): ?><p><?= nl2br(e($par)) ?></p><?php endforeach; ?>
            </div>
        </div>
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
