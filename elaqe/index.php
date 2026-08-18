<?php
require $_SERVER['DOCUMENT_ROOT'] . '/includes/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/mailer.php';
$current_section = 'elaqe';

// ---- Sadə forma emalı (POST) ----
$sent = false; $error = ''; $old = ['name' => '', 'email' => '', 'phone' => '', 'message' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';

    // Sahələri təmizlə: idarəetmə simvolları sil, uzunluğu məhdudlaşdır
    $clean = function ($v, $max, $oneLine = true) {
        $v = trim((string)$v);
        $v = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $v); // control chars (\n, \t qalır)
        if ($oneLine) $v = preg_replace('/[\r\n]+/', ' ', $v);
        return mb_substr($v, 0, $max);
    };
    $old['name']    = $clean($_POST['name'] ?? '', 100);
    $old['email']   = $clean($_POST['email'] ?? '', 120);
    $old['phone']   = preg_replace('/[^\d+()\-\s]/u', '', $clean($_POST['phone'] ?? '', 25)); // yalnız telefon simvolları
    $old['message'] = $clean($_POST['message'] ?? '', 3000, false);

    // Sürət limiti: bir IP-dən saatda ən çox 5 müraciət
    $flog = load_json('formlog', []);
    $now = time();
    $recent = array_values(array_filter($flog[$ip] ?? [], fn($t) => $t > $now - 3600));

    if (!empty($_POST['website'])) {                        // honeypot
        $error = 'Spam aşkarlandı.';
    } elseif (turnstile_active($SITE) && !turnstile_verify($SITE['security']['turnstile_secret'], $_POST['cf-turnstile-response'] ?? null, $ip)) {
        $error = 'Zəhmət olmasa robot olmadığınızı təsdiqləyin.';
    } elseif (count($recent) >= 5) {
        $error = 'Çox sayda müraciət göndərilib. Bir saatdan sonra yenidən cəhd edin.';
    } elseif (mb_strlen($old['name']) < 2 || mb_strlen($old['message']) < 5) {
        $error = 'Zəhmət olmasa ad və mesaj sahələrini düzgün doldurun.';
    } elseif ($old['email'] !== '' && !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'E-poçt ünvanı düzgün deyil.';
    } elseif ($old['phone'] !== '' && strlen(preg_replace('/\D/', '', $old['phone'])) < 7) {
        $error = 'Telefon nömrəsi düzgün deyil.';
    } else {
        $body = "Ad: {$old['name']}\nE-poçt: {$old['email']}\nTelefon: {$old['phone']}\n\n{$old['message']}";
        @error_log('[MYBEL əlaqə] ' . str_replace("\n", ' | ', $body));
        $mErr = null;
        @send_site_mail($SITE['email'], 'Yeni müraciət — mybel.az', $body, $mErr);

        $messages = load_json('messages', []);
        array_unshift($messages, [
            'id' => new_id(), 'name' => $old['name'], 'email' => $old['email'], 'phone' => $old['phone'],
            'message' => $old['message'], 'ip' => $ip, 'date' => date('Y-m-d H:i'), 'read' => false,
        ]);
        save_json('messages', array_slice($messages, 0, 500)); // fayl şişməsin

        // sürət limiti jurnalını yenilə + köhnələri təmizlə
        $recent[] = $now;
        $flog[$ip] = $recent;
        foreach ($flog as $k => $ts) {
            $flog[$k] = array_values(array_filter($ts, fn($t) => $t > $now - 3600));
            if (!$flog[$k]) unset($flog[$k]);
        }
        save_json('formlog', $flog);

        $sent = true;
        $old = ['name' => '', 'email' => '', 'phone' => '', 'message' => ''];
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
        <h1><?= e($SITE['pages']['elaqe']['title']) ?></h1>
        <p><?= e($SITE['pages']['elaqe']['subtitle']) ?></p>
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
                        <input type="text" id="name" name="name" value="<?= e($old['name']) ?>" required maxlength="100" autocomplete="name">
                    </div>
                    <div class="field">
                        <label for="phone">Telefon</label>
                        <input type="tel" id="phone" name="phone" value="<?= e($old['phone']) ?>" data-phone inputmode="tel" pattern="[0-9+()\-\s]{7,25}" maxlength="25" autocomplete="tel" placeholder="+994 50 000 00 00">
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label for="email">E-poçt</label>
                        <input type="email" id="email" name="email" value="<?= e($old['email']) ?>" maxlength="120" autocomplete="email">
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label for="message">Mesaj *</label>
                        <textarea id="message" name="message" required minlength="5" maxlength="3000"><?= e($old['message']) ?></textarea>
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
            <div style="margin-top:1.5rem">
                <?= social_links($SITE) ?>
            </div>
        </aside>
    </div>

    <div class="container">
        <iframe class="map-embed" src="<?= e($SITE['map']) ?>" loading="lazy" title="Xəritədə MYBEL Concept" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
