<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = 'layiheler';

$activeCat = $_GET['cat'] ?? '';
$list = visible_sorted($PROJECTS);
if ($activeCat && isset($CATEGORIES[$activeCat])) {
    $list = array_values(array_filter($list, fn($p) => $p['category'] === $activeCat));
}

$ps = page_seo('layiheler');
$page_title = $ps['title'] ?: ('Layihələr — ' . $SITE['name']);
$page_desc  = $ps['desc'] ?: 'MYBEL Concept-in restoran, otel və fərdi evlər üzrə tamamladığı mebel və interyer layihələri.';
$page_url   = '/layiheler/';
$breadcrumbs = [['name' => 'Ana səhifə', 'url' => '/'], ['name' => 'Layihələr', 'url' => '/layiheler/']];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Naviqasiya izi">
            <a href="/">Ana səhifə</a><span>/</span><strong>Layihələr</strong>
        </nav>
        <h1><?= e($SITE['pages']['layiheler']['title']) ?></h1>
        <p><?= e($SITE['pages']['layiheler']['subtitle']) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="filter-bar">
            <a href="/layiheler/" class="<?= $activeCat === '' ? 'is-active' : '' ?>">Hamısı</a>
            <?php foreach ($CATEGORIES as $key => $label): ?>
                <a href="/layiheler/?cat=<?= e($key) ?>" class="<?= $activeCat === $key ? 'is-active' : '' ?>"><?= e($label) ?></a>
            <?php endforeach; ?>
        </div>

        <?php if (empty($list)): ?>
            <p>Bu kateqoriyada hələ layihə yoxdur.</p>
        <?php else: ?>
        <div class="card-grid">
            <?php foreach ($list as $p): ?>
                <article class="card" data-reveal>
                    <a class="card-media" href="/layiheler/<?= e($p['slug']) ?>/">
                        <span class="card-tag"><?= e(cat_name($p['category'])) ?></span>
                        <img src="<?= e($p['cover']) ?>" alt="<?= e($p['title']) ?>" loading="lazy" width="1200" height="800">
                    </a>
                    <div class="card-body">
                        <h2 class="card-title"><?= e($p['title']) ?></h2>
                        <?php if (!empty($p['location']) || !empty($p['year'])): ?><p class="card-meta"><?= e(trim($p['location'] . (($p['location'] && $p['year']) ? ' · ' : '') . $p['year'])) ?></p><?php endif; ?>
                        <?php if (!empty($p['excerpt'])): ?><p class="card-excerpt"><?= e($p['excerpt']) ?></p><?php endif; ?>
                        <a class="card-link" href="/layiheler/<?= e($p['slug']) ?>/">Layihəyə bax</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
