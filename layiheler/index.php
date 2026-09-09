<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = 'layiheler';

$activeCat = $_GET['cat'] ?? '';
$list = visible_sorted($PROJECTS);
if ($activeCat && isset($CATEGORIES[$activeCat])) {
    $list = array_values(array_filter($list, fn($p) => $p['category'] === $activeCat));
}

// Səhifələmə: hər səhifədə 12 layihə
$perPage = 12;
$total = count($list);
$totalPages = max(1, (int)ceil($total / $perPage));
$page = max(1, (int)($_GET['page'] ?? 1));
if ($page > $totalPages) $page = $totalPages;
$pageItems = array_slice($list, ($page - 1) * $perPage, $perPage);
$pageQ = $activeCat ? '?cat=' . rawurlencode($activeCat) . '&' : '?';

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
        <div class="projects-grid">
            <?php foreach ($pageItems as $p): ?>
                <a class="project-tile" href="/layiheler/<?= e($p['slug']) ?>/" data-reveal>
                    <img src="<?= e($p['cover']) ?>" alt="<?= e($p['title']) ?>" loading="lazy" width="1200" height="800">
                    <span class="project-cat"><?= e(cat_name($p['category'])) ?></span>
                    <div class="project-info">
                        <h2 class="project-title"><?= e($p['title']) ?></h2>
                        <?php if (!empty($p['location']) || !empty($p['year'])): ?><span class="project-meta"><?= e(trim($p['location'] . (($p['location'] && $p['year']) ? ' · ' : '') . $p['year'])) ?></span><?php endif; ?>
                        <?php if (!empty($p['excerpt'])): ?><p class="project-excerpt"><?= e($p['excerpt']) ?></p><?php endif; ?>
                        <span class="project-more">Layihəyə bax →</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
        <nav class="pagination" aria-label="Səhifələr">
            <?php if ($page > 1): ?><a class="page-link" href="<?= e($pageQ . 'page=' . ($page - 1)) ?>" aria-label="Əvvəlki">←</a><?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a class="page-link<?= $i === $page ? ' is-active' : '' ?>" href="<?= e($pageQ . 'page=' . $i) ?>"><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?><a class="page-link" href="<?= e($pageQ . 'page=' . ($page + 1)) ?>" aria-label="Növbəti">→</a><?php endif; ?>
        </nav>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
