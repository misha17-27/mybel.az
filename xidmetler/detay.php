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
    $page_title = __('not_found_short') . ' — ' . $SITE['name'];
    $page_url = '/xidmetler/';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
    echo '<section class="section"><div class="container"><h1>' . e(__('svc_not_found')) . '</h1><p><a class="btn-ghost" href="' . e(u('/xidmetler/')) . '">' . e(__('all_services')) . '</a></p></div></section>';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
    exit;
}

$related = service_projects($item, $PROJECTS);

$page_title = ($item['seo_title'] ?? '') ?: ($item['title'] . ' — Xidmətlər | ' . $SITE['name']);
$page_desc  = ($item['seo_desc'] ?? '') ?: ($item['desc'] ?? '');
$page_url   = '/xidmetler/' . service_slug($item) . '/';
$page_type  = 'article';
$breadcrumbs = [
    ['name' => __('nav_home'), 'url' => '/'],
    ['name' => __('nav_services'), 'url' => '/xidmetler/'],
    ['name' => $item['title'], 'url' => $page_url],
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="<?= e(__('breadcrumb')) ?>">
            <a href="<?= e(u('/')) ?>"><?= e(__('nav_home')) ?></a><span>/</span>
            <a href="<?= e(u('/xidmetler/')) ?>"><?= e(__('nav_services')) ?></a><span>/</span>
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
                <span class="eyebrow"><?= e(__('nav_projects')) ?></span>
                <h2 class="section-title" style="font-size:1.8rem"><?= e(__('related_title')) ?></h2>
            </div>
            <div class="card-grid">
                <?php foreach ($related as $p): ?>
                    <article class="card" data-reveal>
                        <a class="card-media" href="<?= e(u('/layiheler/' . $p['slug'] . '/')) ?>">
                            <span class="card-tag"><?= e(cat_name($p['category'])) ?></span>
                            <img src="<?= e($p['cover']) ?>" alt="<?= e($p['title']) ?>" loading="lazy" width="1200" height="800">
                        </a>
                        <div class="card-body">
                            <h3 class="card-title"><?= e($p['title']) ?></h3>
                            <?php if (!empty($p['location']) || !empty($p['year'])): ?><p class="card-meta"><?= e(trim($p['location'] . (($p['location'] && $p['year']) ? ' · ' : '') . $p['year'])) ?></p><?php endif; ?>
                            <a class="card-link" href="<?= e(u('/layiheler/' . $p['slug'] . '/')) ?>"><?= e(__('view_project')) ?></a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="muted"><?= e(__('no_related')) ?></p>
        <?php endif; ?>
    </div>
</article>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
