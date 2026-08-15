<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/mailer.php';
$current_section = 'elaqe';

// ---- Sadə forma emalı (POST) ----
$sent = false; $error = ''; $old = ['name' => '', 'email' => '', 'phone' => '', 'message' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Honeypot (spam qoruması)
    if (!empty($_POST['website'])) {
        $error = 'Spam aşkarlandı.';
    } elseif (turnstile_active($SITE) && !turnstile_verify($SITE['security']['turnstile_secret'], $_POST['cf-turnstile-response'] ?? null, $_SERVER['REMOTE_ADDR'] ?? null)) {
        $error = 'Zəhmət olmasa robot olmadığınızı təsdiqləyin.';
    } else {
        $old['name']    = trim($_POST['name'] ?? '');
        $old['email']   = trim($_POST['email'] ?? '');
        $old['phone']   = trim($_POST['phone'] ?? '');
        $old['message'] = trim($_POST['message'] ?? '');

        if ($old['name'] === '' || $old['message'] === '') {
            $error = 'Zəhmət olmasa ad və mesaj sahələrini doldurun.';
        } elseif ($old['email'] !== '' && !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
            $error = 'E-poçt ünvanı düzgün deyil.';
        } else {
            // Real serverdə burada mail() və ya CRM inteqrasiyası olacaq.
            $body = "Ad: {$old['name']}\nE-poçt: {$old['email']}\nTelefon: {$old['phone']}\n\n{$old['message']}";
            @error_log('[MYBEL əlaqə] ' . str_replace("\n", ' | ', $body));
            // SMTP (varsa) ilə göndər, yoxsa mail()
            $mErr = null;
            @send_site_mail($SITE['email'], 'Yeni müraciət — mybel.az', $body, $mErr);
            // Admin panel üçün müraciəti yadda saxla
            $messages = load_json('messages', []);
            array_unshift($messages, [
                'id'      => new_id(),
                'name'    => $old['name'],
                'email'   => $old['email'],
                'phone'   => $old['phone'],
                'message' => $old['message'],
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? '',
                'date'    => date('Y-m-d H:i'),
                'read'    => false,
            ]);
            save_json('messages', $messages);
            $sent = true;
            $old = ['name' => '', 'email' => '', 'phone' => '', 'message' => ''];
        }
    }
}

$page_title = 'Əlaqə — ' . $SITE['name'];
$page_desc  = 'MYBEL Concept ilə əlaqə: telefon, e-poçt, ünvan və sifariş formu.';
$page_url   = '/elaqe/';
$breadcrumbs = [['name' => 'Ana səhifə', 'url' => '/'], ['name' => 'Əlaqə', 'url' => '/elaqe/']];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <nav class="breadcrumb" aria-label="Naviqasiya izi">
            <a href="/">Ana səhifə</a><span>/</span><strong>Əlaqə</strong>
        </nav>
        <h1>Əlaqə</h1>
        <p>Layihəniz və ya sualınızla bağlı bizimlə əlaqə saxlayın.</p>
    </div>
</section>

<section class="section">
    <div class="container contact-layout">
        <div>
            <?php if ($sent): ?>
                <div class="alert alert-success">Təşəkkür edirik! Müraciətiniz qəbul olundu, tezliklə sizinlə əlaqə saxlayacağıq.</div>
            <?php elseif ($error): ?>
                <div class="alert alert-error"><?= e($error) ?></div>
            <?php endif; ?>

            <form method="post" action="/elaqe/" novalidate>
                <div class="form-row two">
                    <div class="field">
                        <label for="name">Ad, Soyad *</label>
                        <input type="text" id="name" name="name" value="<?= e($old['name']) ?>" required>
                    </div>
                    <div class="field">
                        <label for="phone">Telefon</label>
                        <input type="tel" id="phone" name="phone" value="<?= e($old['phone']) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label for="email">E-poçt</label>
                        <input type="email" id="email" name="email" value="<?= e($old['email']) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label for="message">Mesaj *</label>
                        <textarea id="message" name="message" required><?= e($old['message']) ?></textarea>
                    </div>
                </div>
                <!-- honeypot -->
                <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">
                <?php if (turnstile_active($SITE)): ?>
                    <div style="margin:.2rem 0 1rem"><div class="cf-turnstile" data-sitekey="<?= e($SITE['security']['turnstile_site']) ?>"></div></div>
                    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                <?php endif; ?>
                <button type="submit" class="btn">Göndər</button>
                <p class="form-note">* işarəli sahələr mütləqdir.</p>
            </form>
        </div>

        <aside>
            <ul class="contact-info">
                <li><span class="label">Telefon</span><a href="tel:<?= e($SITE['phone_raw']) ?>"><?= e($SITE['phone']) ?></a></li>
                <li><span class="label">E-poçt</span><a href="mailto:<?= e($SITE['email']) ?>"><?= e($SITE['email']) ?></a></li>
                <li><span class="label">Ünvan</span><span><?= e($SITE['address']) ?></span></li>
                <li><span class="label">İş saatı</span><span><?= e($SITE['work_hours']) ?></span></li>
            </ul>
            <div class="footer-social" style="margin-top:1.5rem">
                <a href="<?= e($SITE['social']['instagram']) ?>" target="_blank" rel="noopener" class="btn btn-outline btn-sm">Instagram</a>
                <a href="<?= e($SITE['social']['whatsapp']) ?>" target="_blank" rel="noopener" class="btn btn-outline btn-sm">WhatsApp</a>
            </div>
        </aside>
    </div>

    <div class="container">
        <iframe class="map-embed" src="<?= e($SITE['map']) ?>" loading="lazy" title="Xəritədə MYBEL Concept" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
