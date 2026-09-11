<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = '';
$ps = page_seo('home');
$page_title = $ps['title'] ?: ($SITE['seo']['home_title'] ?: ($SITE['name'] . ' — ' . $SITE['tagline']));
$page_desc  = $ps['desc'] ?: ($SITE['seo']['home_desc'] ?: $SITE['description']);
$page_image = $SITE['seo']['og_image'] ?: '/assets/img/logo.png';
$page_url   = '/';

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<!-- ============ HERO ============ -->
<section class="hero home-hero">
    <?php $hero_video = $SITE['hero']['video'] ?? ''; $hero_poster = $SITE['hero']['image'] ?: '/assets/img/demo/hero.jpg'; ?>
    <?php if ($hero_video !== ''): ?>
    <video class="hero-video" autoplay muted loop playsinline preload="auto"
           poster="<?= e($hero_poster) ?>" aria-hidden="true">
        <source src="<?= e(strpos($hero_video, 'http') === 0 ? $hero_video : asset($hero_video)) ?>" type="video/mp4">
    </video>
    <?php else: ?>
    <img class="hero-video" src="<?= e($hero_poster) ?>" alt="" aria-hidden="true">
    <?php endif; ?>
    <div class="container">
        <span class="eyebrow"><?= e($SITE['hero']['eyebrow']) ?></span>
        <h1 class="hero-title"><?= nl2br(e($SITE['hero']['title'])) ?></h1>
        <p class="hero-lead"><?= e($SITE['hero']['lead']) ?></p>
        <div class="hero-actions">
            <a href="/layiheler/" class="btn">Layihələrimiz</a>
            <a href="/elaqe/" class="btn btn-outline">Bizimlə əlaqə</a>
        </div>
    </div>
</section>

<!-- ============ HAQQIMIZDA (qısa) ============ -->
<section class="section">
    <div class="container about-split">
        <div class="about-text" data-reveal>
            <span class="eyebrow"><?= e($SITE['about']['eyebrow']) ?></span>
            <h2 class="section-title"><?= e($SITE['about']['title']) ?></h2>
            <?= rich_text($SITE['about']['text']) ?>
            <a href="/haqqimizda/" class="btn-ghost">Ətraflı </a>
        </div>
        <div data-reveal>
            <img src="<?= e($SITE['about']['image'] ?: '/assets/img/demo/corner-orange.jpg') ?>" alt="MYBEL Concept interyer detalı" width="900" height="760">
        </div>
    </div>
</section>

<!-- ============ LAYİHƏLƏR ============ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow"><?= e($SITE['home']['projects_eyebrow']) ?></span>
            <h2 class="section-title"><?= e($SITE['home']['projects_title']) ?></h2>
            <p class="section-desc"><?= e($SITE['home']['projects_desc']) ?></p>
        </div>
        <div class="card-grid">
            <?php foreach (array_slice(visible_sorted($PROJECTS), 0, 3) as $p): ?>
                <article class="card" data-reveal>
                    <a class="card-media" href="/layiheler/<?= e($p['slug']) ?>/">
                        <span class="card-tag"><?= e(cat_name($p['category'])) ?></span>
                        <img src="<?= e($p['cover']) ?>" alt="<?= e($p['title']) ?>" loading="lazy" width="1200" height="800">
                    </a>
                    <div class="card-body">
                        <h3 class="card-title"><?= e($p['title']) ?></h3>
                        <?php if (!empty($p['location']) || !empty($p['year'])): ?><p class="card-meta"><?= e(trim($p['location'] . (($p['location'] && $p['year']) ? ' · ' : '') . $p['year'])) ?></p><?php endif; ?>
                        <?php if (!empty($p['excerpt'])): ?><p class="card-excerpt"><?= e($p['excerpt']) ?></p><?php endif; ?>
                        <a class="card-link" href="/layiheler/<?= e($p['slug']) ?>/">Layihəyə bax</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <div style="margin-top:2.5rem">
            <a href="/layiheler/" class="btn btn-outline">Bütün layihələr</a>
        </div>
    </div>
</section>

<!-- ============ XİDMƏTLƏR ============ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-head-row">
            <div class="section-head" style="margin-bottom:0">
                <span class="eyebrow"><?= e($SITE['home']['services_eyebrow']) ?></span>
                <h2 class="section-title"><?= e($SITE['home']['services_title']) ?></h2>
            </div>
            <a href="/xidmetler/" class="btn btn-outline">Xidmətlər</a>
        </div>
        <div class="sectors-grid">
            <?php foreach ($SITE['xidmetler_page']['sectors'] as $sec): ?>
                <a class="sector-item" href="/xidmetler/" data-reveal>
                    <div class="sector-icon"><?= icon($sec['icon']) ?></div>
                    <span class="sector-name"><?= e($sec['name']) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ MÜŞTƏRİLƏR ============ -->
<?php if (!empty($SITE['clients_enabled'])): ?>
<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow"><?= e($SITE['home']['clients_eyebrow']) ?></span>
            <h2 class="section-title"><?= e($SITE['home']['clients_title']) ?></h2>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients.php'; ?>
    </div>
</section>
<?php endif; ?>

<!-- ============ CTA ============ -->
<section class="section">
    <div class="container">
        <div class="cta-band" data-reveal>
            <h2><?= e($SITE['home']['cta_title']) ?></h2>
            <p><?= e($SITE['home']['cta_text']) ?></p>
            <a href="/elaqe/" class="btn"><?= e($SITE['home']['cta_btn']) ?></a>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
