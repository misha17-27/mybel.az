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
        <p>MYBEL Concept — dizayn, keyfiyyət və dəqiqliyi birləşdirən mebel istehsalçısı.</p>
    </div>
</section>

<section class="section">
    <div class="container about-split">
        <div data-reveal>
            <img src="/assets/img/demo/living-neutral.jpg" alt="MYBEL Concept interyer işi" width="900" height="820">
        </div>
        <div class="about-text" data-reveal>
            <span class="eyebrow">Kimik biz</span>
            <h2 class="section-title">İdeyanı reallığa çeviririk</h2>
            <p><?= e(ph_text(1)) ?></p>
            <p><?= e(ph_text(1)) ?></p>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="about-split" style="align-items:start">
            <div class="about-text" data-reveal>
                <span class="eyebrow">Missiyamız</span>
                <h2 class="section-title">Hər detala önəm veririk</h2>
                <p><?= e(ph_text(1)) ?></p>
            </div>
            <div class="about-text" data-reveal>
                <span class="eyebrow">Yanaşmamız</span>
                <h2 class="section-title">Layihələndirmədən quraşdırmaya</h2>
                <p><?= e(ph_text(1)) ?></p>
            </div>
        </div>
        <div class="stats-row">
            <div class="stat" data-reveal><div class="stat-num">150+</div><div class="stat-label">Tamamlanmış layihə</div></div>
            <div class="stat" data-reveal><div class="stat-num">12</div><div class="stat-label">İl təcrübə</div></div>
            <div class="stat" data-reveal><div class="stat-num">40+</div><div class="stat-label">Komanda üzvü</div></div>
            <div class="stat" data-reveal><div class="stat-num">98%</div><div class="stat-label">Məmnun müştəri</div></div>
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
