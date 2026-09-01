<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = 'xidmetler';
$ps = page_seo('xidmetler');
$page_title = $ps['title'] ?: ('Xidmətlər — ' . $SITE['name']);
$page_desc  = $ps['desc'] ?: 'MYBEL Concept xidmətləri: mebel dizaynı, 2D/3D layihələndirmə, istehsal, nəzarət və təhvil — hotel, restoran, ofis, təhsil, tibb və fərdi evlər üçün.';
$page_url   = '/xidmetler/';
$breadcrumbs = [['name' => 'Ana səhifə', 'url' => '/'], ['name' => 'Xidmətlər', 'url' => '/xidmetler/']];

$xp = $SITE['xidmetler_page'];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Naviqasiya izi">
            <a href="/">Ana səhifə</a><span>/</span><strong>Xidmətlər</strong>
        </nav>
        <h1><?= e($xp['sectors_title']) ?></h1>
        <p><?= e($xp['sectors_desc']) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="sectors-grid">
            <?php foreach ($xp['sectors'] as $sec): ?>
                <div class="sector-item" data-reveal>
                    <div class="sector-icon"><?= icon($sec['icon']) ?></div>
                    <span class="sector-name"><?= e($sec['name']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section-tint">
    <div class="container">
        <div class="section-head center">
            <?php if (!empty($xp['process_eyebrow'])): ?><span class="eyebrow"><?= e($xp['process_eyebrow']) ?></span><?php endif; ?>
            <h2 class="section-title"><?= e($xp['process_title']) ?></h2>
        </div>
        <ol class="process">
            <?php foreach ($xp['process'] as $i => $st): ?>
                <li class="process-step" data-reveal>
                    <div class="process-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></div>
                    <div class="process-body">
                        <h3><?= e($st['title']) ?></h3>
                        <p><?= e($st['desc']) ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
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
