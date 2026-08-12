<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = '';
$page_title = $SITE['name'] . ' — ' . $SITE['tagline'] . ' | Bakı';
$page_desc  = $SITE['description'];
$page_url   = '/';

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>

<!-- ============ HERO ============ -->
<section class="hero home-hero">
    <div class="container">
        <span class="eyebrow">Premium mebel &amp; interyer</span>
        <h1 class="hero-title">Məkanınıza dəyər qatan<br>fərdi mebel həlləri</h1>
        <p class="hero-lead">Restoran, otel və fərdi evlər üçün layihələndirmədən quraşdırmaya qədər tam interyer və mebel istehsalı.</p>
        <div class="hero-actions">
            <a href="/layiheler/" class="btn">Layihələrimiz</a>
            <a href="/elaqe/" class="btn btn-outline">Bizimlə əlaqə</a>
        </div>
        <figure class="hero-figure">
            <img src="/assets/img/demo/hero.jpg" alt="MYBEL Concept — müasir interyer və mebel nümunəsi" width="1600" height="700">
        </figure>
    </div>
</section>

<!-- ============ HAQQIMIZDA (qısa) ============ -->
<section class="section">
    <div class="container about-split">
        <div class="about-text" data-reveal>
            <span class="eyebrow">Şirkət haqqında</span>
            <h2 class="section-title">Keyfiyyət və dizaynı bir araya gətiririk</h2>
            <p><?= e(ph_text(1)) ?></p>
            <p><?= e('MYBEL Concept peşəkar komandası ilə hər layihəyə fərdi yanaşır və uzunömürlü nəticə təqdim edir.') ?></p>
            <a href="/haqqimizda/" class="btn-ghost">Ətraflı </a>
        </div>
        <div data-reveal>
            <img src="/assets/img/demo/corner-orange.jpg" alt="MYBEL Concept interyer detalı" width="900" height="760">
        </div>
    </div>
</section>

<!-- ============ LAYİHƏLƏR ============ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Layihələr</span>
            <h2 class="section-title">Seçilmiş işlərimiz</h2>
            <p class="section-desc">Restoran, otel və fərdi evlər üzrə tamamladığımız bəzi layihələr.</p>
        </div>
        <div class="card-grid">
            <?php foreach (array_slice($PROJECTS, 0, 3) as $p): ?>
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

<!-- ============ FƏALİYYƏT SAHƏLƏRİ ============ -->
<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow">Fəaliyyət sahələri</span>
            <h2 class="section-title">Hansı sahələrdə çalışırıq</h2>
        </div>
        <div class="card-grid">
            <?php foreach ($AREAS as $a): ?>
                <article class="card" data-reveal>
                    <a class="card-media" href="/fealiyyet/<?= e($a['slug']) ?>/">
                        <img src="<?= e($a['cover']) ?>" alt="<?= e($a['title']) ?>" loading="lazy" width="1200" height="800">
                    </a>
                    <div class="card-body">
                        <h3 class="card-title"><?= e($a['title']) ?></h3>
                        <p class="card-excerpt"><?= e($a['excerpt']) ?></p>
                        <a class="card-link" href="/fealiyyet/<?= e($a['slug']) ?>/">Ətraflı</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ XİDMƏTLƏR ============ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Xidmətlər</span>
            <h2 class="section-title">Nə təklif edirik</h2>
        </div>
        <div class="services-grid">
            <?php foreach ($SERVICES as $s): ?>
                <div class="service-card" data-reveal>
                    <div class="service-icon"><?= icon($s['icon']) ?></div>
                    <h3><?= e($s['title']) ?></h3>
                    <p><?= e($s['desc']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ MÜŞTƏRİLƏR ============ -->
<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow">Müştərilər</span>
            <h2 class="section-title">Bizə etibar edənlər</h2>
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients.php'; ?>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="section">
    <div class="container">
        <div class="cta-band" data-reveal>
            <h2>Layihəniz üçün təklif alın</h2>
            <p>İdeyanızı bizimlə bölüşün — komandamız ölçü, dizayn və qiymət təklifini hazırlasın.</p>
            <a href="/elaqe/" class="btn">Sifariş ver</a>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
