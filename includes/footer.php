</main>

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-col footer-brand">
            <img src="/assets/img/logo.png" alt="<?= e($SITE['name']) ?> loqo" width="140" height="131" class="footer-logo">
            <p><?= e($SITE['description']) ?></p>
        </div>

        <div class="footer-col">
            <h3><?= e(__('footer_menu')) ?></h3>
            <ul>
                <li><a href="<?= e(u('/haqqimizda/')) ?>"><?= e(__('nav_about')) ?></a></li>
                <li><a href="<?= e(u('/layiheler/')) ?>"><?= e(__('nav_projects')) ?></a></li>
                <li><a href="<?= e(u('/xidmetler/')) ?>"><?= e(__('nav_services')) ?></a></li>
                <?php if (!empty($SITE['clients_enabled'])): ?><li><a href="<?= e(u('/musteriler/')) ?>"><?= e(__('nav_clients')) ?></a></li><?php endif; ?>
                <li><a href="<?= e(u('/elaqe/')) ?>"><?= e(__('nav_contact')) ?></a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h3><?= e(__('nav_contact')) ?></h3>
            <ul class="footer-contact">
                <li><span class="fc-ic"><?= icon('phone') ?></span><a href="tel:<?= e($SITE['phone_raw']) ?>"><?= e($SITE['phone']) ?></a></li>
                <li><span class="fc-ic"><?= icon('mail') ?></span><a href="mailto:<?= e($SITE['email']) ?>"><?= e($SITE['email']) ?></a></li>
                <li><span class="fc-ic"><?= icon('pin') ?></span><span><?= e($SITE['address']) ?></span></li>
                <li><span class="fc-ic"><?= icon('clock') ?></span><span><?= e($SITE['work_hours']) ?></span></li>
            </ul>
            <?= social_links($SITE) ?>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <p>&copy; <?= date('Y') ?> <?= e($SITE['legal']) ?>. <?= e(__('rights')) ?></p>
            <p class="footer-credit">Site by <a href="https://webline.az" target="_blank" rel="noopener">Webline.az</a></p>
        </div>
    </div>
</footer>

<script src="<?= e(asset('/assets/js/main.js')) ?>" defer></script>
</body>
</html>
