<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = 'fealiyyet';

$slug = $_GET['slug'] ?? '';
$item = find_by_slug($AREAS, $slug);

if (!$item) {
    http_response_code(404);
    $page_title = 'Tapılmadı — ' . $SITE['name'];
    $page_url = '/fealiyyet/';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
    echo '<section class="section"><div class="container"><h1>Səhifə tapılmadı</h1><p><a class="btn-ghost" href="/fealiyyet/">Bütün fəaliyyət sahələri</a></p></div></section>';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
    exit;
}

// Bu sahəyə aid layihələr
$related = array_values(array_filter($PROJECTS, fn($p) => $p['category'] === $item['slug']));

$page_title = $item['title'] . ' — Fəaliyyət sahələri | ' . $SITE['name'];
$page_desc  = $item['excerpt'];
$page_url   = '/fealiyyet/' . $item['slug'] . '/';
$page_type  = 'article';
$page_image = $item['cover'];
$breadcrumbs = [
    ['name' => 'Ana səhifə', 'url' => '/'],
    ['name' => 'Fəaliyyət sahələri', 'url' => '/fealiyyet/'],
    ['name' => $item['title'], 'url' => $page_url],
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Naviqasiya izi">
            <a href="/">Ana səhifə</a><span>/</span>
            <a href="/fealiyyet/">Fəaliyyət sahələri</a><span>/</span>
            <strong><?= e($item['title']) ?></strong>
        </nav>
        <h1><?= e($item['title']) ?></h1>
        <p><?= e($item['excerpt']) ?></p>
    </div>
</section>

<article class="section">
    <div class="container">
        <div class="detail-cover">
            <img src="<?= e($item['cover']) ?>" alt="<?= e($item['title']) ?> — əsas görüntü" width="1200" height="525">
        </div>

        <div class="detail-body" data-reveal><?= $item['body'] ?></div>

        <?php if (!empty($item['gallery'])): ?>
            <h2 class="section-title" style="margin:2.5rem 0 1rem;font-size:1.5rem">Qalereya</h2>
            <div class="gallery-grid">
                <?php foreach ($item['gallery'] as $i => $g): ?>
                    <img src="<?= e($g) ?>" data-full="<?= e($g) ?>" data-lightbox alt="<?= e($item['title']) ?> — şəkil <?= $i + 1 ?>" loading="lazy" width="1200" height="800">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</article>

<?php if (!empty($related)): ?>
<section class="section section-alt">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Bu sahədə</span>
            <h2 class="section-title"><?= e($item['title']) ?> üzrə layihələr</h2>
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
                        <p class="card-meta"><?= e($p['location']) ?> · <?= e($p['year']) ?></p>
                        <a class="card-link" href="/layiheler/<?= e($p['slug']) ?>/">Layihəyə bax</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
