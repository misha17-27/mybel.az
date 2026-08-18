<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = '';
$page_title = $SITE['seo']['home_title'] ?: ($SITE['name'] . ' — ' . $SITE['tagline']);
$page_desc  = $SITE['seo']['home_desc'] ?: $SITE['description'];
$page_image = $SITE['seo']['og_image'] ?: '/assets/img/logo.png';
$page_url   = '/';

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<!-- ============ HERO ============ -->
<section class="hero home-hero">
    <div class="container">
        <span class="eyebrow"><?= e($SITE['hero']['eyebrow']) ?></span>
        <h1 class="hero-title"><?= nl2br(e($SITE['hero']['title'])) ?></h1>
        <p class="hero-lead"><?= e($SITE['hero']['lead']) ?></p>
        <div class="hero-actions">
            <a href="/layiheler/" class="btn">Layihələrimiz</a>
            <a href="/elaqe/" class="btn btn-outline">Bizimlə əlaqə</a>
        </div>
        <figure class="hero-figure">
            <img src="<?= e($SITE['hero']['image'] ?: '/assets/img/demo/hero.jpg') ?>" alt="MYBEL Concept — müasir interyer və mebel nümunəsi" width="1600" height="700">
        </figure>
    </div>
</section>

<!-- ============ HAQQIMIZDA (qısa) ============ -->
<section class="section">
    <div class="container about-split">
        <div class="about-text" data-reveal>
            <span class="eyebrow"><?= e($SITE['about']['eyebrow']) ?></span>
            <h2 class="section-title"><?= e($SITE['about']['title']) ?></h2>
            <?php foreach (preg_split('/\n{2,}/', trim($SITE['about']['text'])) as $par): ?>
                <p><?= nl2br(e($par)) ?></p>
            <?php endforeach; ?>
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
                        <p class="card-meta"><?= e($p['location']) ?> · <?= e($p['year']) ?></p>
                        <p class="card-excerpt"><?= e($p['excerpt']) ?></p>
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
        <div class="section-head">
            <span class="eyebrow"><?= e($SITE['home']['services_eyebrow']) ?></span>
            <h2 class="section-title"><?= e($SITE['home']['services_title']) ?></h2>
        </div>
        <div class="services-grid">
            <?php foreach (visible_sorted($SERVICES) as $s): ?>
                <a class="service-card" href="/xidmetler/<?= e(service_slug($s)) ?>/" data-reveal>
                    <div class="service-icon"><?= icon($s['icon']) ?></div>
                    <h3><?= e($s['title']) ?></h3>
                    <p><?= e($s['desc']) ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ MÜŞTƏRİLƏR ============ -->
<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow"><?= e($SITE['home']['clients_eyebrow']) ?></span>
            <h2 class="section-title"><?= e($SITE['home']['clients_title']) ?></h2>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients.php'; ?>
    </div>
</section>

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
