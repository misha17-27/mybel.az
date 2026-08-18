<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = 'musteriler';
$page_title = 'Müştərilər — ' . $SITE['name'];
$page_desc  = 'MYBEL Concept-ə etibar edən müştərilər və tərəfdaşlar.';
$page_url   = '/musteriler/';
$breadcrumbs = [['name' => 'Ana səhifə', 'url' => '/'], ['name' => 'Müştərilər', 'url' => '/musteriler/']];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Naviqasiya izi">
            <a href="/">Ana səhifə</a><span>/</span><strong>Müştərilər</strong>
        </nav>
        <h1><?= e($SITE['pages']['musteriler']['title']) ?></h1>
        <p><?= e($SITE['pages']['musteriler']['subtitle']) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="clients-grid">
            <?php foreach (visible_sorted($CLIENTS) as $c): ?>
                <div class="client-cell">
                    <?php if (!empty($c['link'])): ?>
                        <a href="<?= e($c['link']) ?>" target="_blank" rel="noopener" aria-label="<?= e($c['name']) ?>"><img src="<?= e($c['logo']) ?>" alt="<?= e($c['name']) ?> loqo" loading="lazy" width="240" height="120"></a>
                    <?php else: ?>
                        <img src="<?= e($c['logo']) ?>" alt="<?= e($c['name']) ?> loqo" loading="lazy" width="240" height="120">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
