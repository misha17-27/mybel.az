<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
$current_section = 'fealiyyet';
$page_title = 'Fəaliyyət sahələri — ' . $SITE['name'];
$page_desc  = 'MYBEL Concept-in fəaliyyət sahələri: restoranlar, otellər və fərdi evlər üçün mebel və interyer həlləri.';
$page_url   = '/fealiyyet/';
$breadcrumbs = [['name' => 'Ana səhifə', 'url' => '/'], ['name' => 'Fəaliyyət sahələri', 'url' => '/fealiyyet/']];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Naviqasiya izi">
            <a href="/">Ana səhifə</a><span>/</span><strong>Fəaliyyət sahələri</strong>
        </nav>
        <h1>Fəaliyyət sahələri</h1>
        <p>Fərqli sektorlarda ixtisaslaşmış təcrübəmizlə tam interyer həlləri təqdim edirik.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="card-grid">
            <?php foreach ($AREAS as $a): ?>
                <article class="card" data-reveal>
                    <a class="card-media" href="/fealiyyet/<?= e($a['slug']) ?>/">
                        <img src="<?= e($a['cover']) ?>" alt="<?= e($a['title']) ?>" loading="lazy" width="1200" height="800">
                    </a>
                    <div class="card-body">
                        <h2 class="card-title"><?= e($a['title']) ?></h2>
                        <p class="card-excerpt"><?= e($a['excerpt']) ?></p>
                        <a class="card-link" href="/fealiyyet/<?= e($a['slug']) ?>/">Ətraflı</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
