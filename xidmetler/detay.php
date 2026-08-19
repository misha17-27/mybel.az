<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = 'xidmetler';

$slug = $_GET['slug'] ?? '';
$item = null;
foreach (visible_sorted($SERVICES) as $s) {
    if (service_slug($s) === $slug) { $item = $s; break; }
}

if (!$item) {
    http_response_code(404);
    $page_title = 'Tapılmadı — ' . $SITE['name'];
    $page_url = '/xidmetler/';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
    echo '<section class="section"><div class="container"><h1>Xidmət tapılmadı</h1><p><a class="btn-ghost" href="/xidmetler/">Bütün xidmətlər</a></p></div></section>';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
    exit;
}

$related = service_projects($item, $PROJECTS);

$page_title = ($item['seo_title'] ?? '') ?: ($item['title'] . ' — Xidmətlər | ' . $SITE['name']);
$page_desc  = ($item['seo_desc'] ?? '') ?: ($item['desc'] ?? '');
$page_url   = '/xidmetler/' . service_slug($item) . '/';
$page_type  = 'article';
$breadcrumbs = [
    ['name' => 'Ana səhifə', 'url' => '/'],
    ['name' => 'Xidmətlər', 'url' => '/xidmetler/'],
    ['name' => $item['title'], 'url' => $page_url],
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Naviqasiya izi">
            <a href="/">Ana səhifə</a><span>/</span>
            <a href="/xidmetler/">Xidmətlər</a><span>/</span>
            <strong><?= e($item['title']) ?></strong>
        </nav>
        <div class="inline" style="gap:1rem;align-items:center">
            <span class="service-icon" style="margin:0"><?= icon($item['icon'] ?? 'design') ?></span>
            <h1 style="margin:0"><?= e($item['title']) ?></h1>
        </div>
        <p><?= e($item['desc'] ?? '') ?></p>
    </div>
</section>

<article class="section">
    <div class="container">
        <?php if (!empty($item['body'])): ?>
            <div class="detail-body" data-reveal><?= $item['body'] ?></div>
        <?php endif; ?>

        <?php if (!empty($related)): ?>
            <div class="section-head" style="margin-top:2.5rem">
                <span class="eyebrow">Layihələr</span>
                <h2 class="section-title" style="font-size:1.8rem">Bu xidmətə aid layihələr</h2>
            </div>
            <div class="card-grid">
                <?php foreach ($related as $p): ?>
                    <article class="card" data-reveal>
                        <a class="card-media" href="/layiheler/<?= e($p['slug']) ?>/">
                            <span class="card-tag"><?= e(cat_name($p['category'])) ?></span>
                            <img src="<?= e($p['cover']) ?>" alt="<?= e($p['title']) ?>" loading="lazy" width="1200" height="800">
                        </a>
                        <div class="card-body">
                            <h3 class="card-title"><?= e($p['title']) ?></h3>
                            <?php if (!empty($p['location']) || !empty($p['year'])): ?><p class="card-meta"><?= e(trim($p['location'] . (($p['location'] && $p['year']) ? ' · ' : '') . $p['year'])) ?></p><?php endif; ?>
                            <a class="card-link" href="/layiheler/<?= e($p['slug']) ?>/">Layihəyə bax</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="muted">Bu xidmət üzrə layihələr tezliklə əlavə olunacaq.</p>
        <?php endif; ?>
    </div>
</article>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
