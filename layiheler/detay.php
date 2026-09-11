<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = 'layiheler';

$slug = $_GET['slug'] ?? '';
$item = find_by_slug($PROJECTS, $slug);

if (!$item) {
    http_response_code(404);
    $page_title = __('not_found_short') . ' — ' . $SITE['name'];
    $page_url = '/layiheler/';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
    echo '<section class="section"><div class="container"><h1>' . e(__('proj_not_found')) . '</h1><p><a class="btn-ghost" href="' . e(u('/layiheler/')) . '">' . e(__('all_projects')) . '</a></p></div></section>';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
    exit;
}

// prev/next
$keys = array_column($PROJECTS, 'slug');
$idx = array_search($slug, $keys, true);
$prev = $idx > 0 ? $PROJECTS[$idx - 1] : null;
$next = $idx < count($PROJECTS) - 1 ? $PROJECTS[$idx + 1] : null;

$page_title = ($item['seo_title'] ?? '') ?: ($item['title'] . ' — Layihələr | ' . $SITE['name']);
$page_desc  = ($item['seo_desc'] ?? '') ?: $item['excerpt'];
$page_url   = '/layiheler/' . $item['slug'] . '/';
$page_type  = 'article';
$page_image = $item['cover'];
$breadcrumbs = [
    ['name' => __('nav_home'), 'url' => '/'],
    ['name' => __('nav_projects'), 'url' => '/layiheler/'],
    ['name' => $item['title'], 'url' => $page_url],
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="<?= e(__('breadcrumb')) ?>">
            <a href="<?= e(u('/')) ?>"><?= e(__('nav_home')) ?></a><span>/</span>
            <a href="<?= e(u('/layiheler/')) ?>"><?= e(__('nav_projects')) ?></a><span>/</span>
            <strong><?= e($item['title']) ?></strong>
        </nav>
        <h1><?= e($item['title']) ?></h1>
        <?php if (!empty($item['excerpt'])): ?><p><?= e($item['excerpt']) ?></p><?php endif; ?>
    </div>
</section>

<article class="section">
    <div class="container">
        <div class="detail-cover">
            <img src="<?= e($item['cover']) ?>" alt="<?= e($item['title']) ?> — <?= e(__('img_main')) ?>" width="1200" height="525">
        </div>

        <div class="detail-facts">
            <div><div class="fact-label"><?= e(__('d_category')) ?></div><div class="fact-value"><?= e(cat_name($item['category'])) ?></div></div>
            <?php if (!empty($item['location'])): ?><div><div class="fact-label"><?= e(__('d_location')) ?></div><div class="fact-value"><?= e($item['location']) ?></div></div><?php endif; ?>
            <?php if (!empty($item['year'])): ?><div><div class="fact-label"><?= e(__('d_year')) ?></div><div class="fact-value"><?= e($item['year']) ?></div></div><?php endif; ?>
        </div>

        <?php if (!empty(trim($item['body']))): ?>
        <div class="detail-body" data-reveal>
            <?= $item['body'] // redaktordan HTML ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($item['gallery'])): ?>
            <h2 class="section-title" style="margin:2.5rem 0 1.8rem;font-size:1.5rem"><?= e(__('gallery')) ?></h2>
            <div class="gallery-grid">
                <?php foreach ($item['gallery'] as $i => $g): ?>
                    <img src="<?= e($g) ?>" data-full="<?= e($g) ?>" data-lightbox alt="<?= e($item['title']) ?> — <?= e(__('img_photo')) ?> <?= $i + 1 ?>" loading="lazy">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <nav class="detail-nav">
            <?php if ($prev): ?><a class="detail-nav-link" href="<?= e(u('/layiheler/' . $prev['slug'] . '/')) ?>">← <?= e($prev['title']) ?></a><?php else: ?><span></span><?php endif; ?>
            <?php if ($next): ?><a class="detail-nav-link" href="<?= e(u('/layiheler/' . $next['slug'] . '/')) ?>"><?= e($next['title']) ?> →</a><?php endif; ?>
        </nav>
    </div>
</article>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
