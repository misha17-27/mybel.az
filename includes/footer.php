</main>

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-col footer-brand">
            <img src="/assets/img/logo.png" alt="<?= e($SITE['name']) ?> loqo" width="140" height="131" class="footer-logo">
            <p><?= e($SITE['description']) ?></p>
        </div>

        <div class="footer-col">
            <h3>Menyu</h3>
            <ul>
                <li><a href="/haqqimizda/">Şirkət haqqında</a></li>
                <li><a href="/layiheler/">Layihələr</a></li>
                <li><a href="/xidmetler/">Xidmətlər</a></li>
                <li><a href="/musteriler/">Müştərilər</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h3>Əlaqə</h3>
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
            <p>&copy; <?= date('Y') ?> <?= e($SITE['legal']) ?>. Bütün hüquqlar qorunur.</p>
            <p class="footer-credit">Site by <a href="https://webline.az" target="_blank" rel="noopener">Webline.az</a></p>
        </div>
    </div>
</footer>

<script src="<?= e(asset('/assets/js/main.js')) ?>" defer></script>
</body>
</html>
