<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
http_response_code(404);
$current_section = '';
$page_title = 'Səhifə tapılmadı — ' . $SITE['name'];
$page_desc  = 'Axtardığınız səhifə tapılmadı.';
$page_url   = '/404';

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<section class="section" style="text-align:center;min-height:50vh;display:grid;place-content:center">
    <div class="container">
        <p class="eyebrow">404</p>
        <h1 class="section-title">Səhifə tapılmadı</h1>
        <p class="section-desc" style="margin-inline:auto">Axtardığınız səhifə mövcud deyil və ya köçürülüb.</p>
        <p style="margin-top:2rem"><a href="/" class="btn">Ana səhifəyə qayıt</a></p>
    </div>
</section>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
