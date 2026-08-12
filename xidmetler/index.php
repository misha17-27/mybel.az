<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = 'xidmetler';
$page_title = 'Xidmətlər — ' . $SITE['name'];
$page_desc  = 'MYBEL Concept xidmətləri: mətbəx mebeli, restoran masaları, otel otaqları, qarderob, yumşaq mebel və interyer dizayn.';
$page_url   = '/xidmetler/';
$breadcrumbs = [['name' => 'Ana səhifə', 'url' => '/'], ['name' => 'Xidmətlər', 'url' => '/xidmetler/']];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Naviqasiya izi">
            <a href="/">Ana səhifə</a><span>/</span><strong>Xidmətlər</strong>
        </nav>
        <h1>Xidmətlər</h1>
        <p>Layihələndirmədən istehsala və quraşdırmaya qədər tam mebel xidmətləri.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="services-grid">
            <?php foreach ($SERVICES as $s): ?>
                <div class="service-card" data-reveal>
                    <div class="service-icon"><?= icon($s['icon']) ?></div>
                    <h2 style="font-size:1.25rem;margin-bottom:.5rem"><?= e($s['title']) ?></h2>
                    <p><?= e($s['desc']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="cta-band" data-reveal>
            <h2>Sizə uyğun həll axtarırıq</h2>
            <p>Ehtiyacınızı bizə bildirin — layihə və qiymət təklifini hazırlayaq.</p>
            <a href="/elaqe/" class="btn">Təklif al</a>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
