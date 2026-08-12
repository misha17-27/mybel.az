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
        <h1>Müştərilər</h1>
        <p>İllər ərzində bizə etibar edən brend və şirkətlər.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/clients.php'; ?>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
