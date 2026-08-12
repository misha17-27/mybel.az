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
                <li><a href="/fealiyyet/">Fəaliyyət sahələri</a></li>
                <li><a href="/xidmetler/">Xidmətlər</a></li>
                <li><a href="/musteriler/">Müştərilər</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h3>Əlaqə</h3>
            <ul class="footer-contact">
                <li><a href="tel:<?= e($SITE['phone_raw']) ?>"><?= e($SITE['phone']) ?></a></li>
                <li><a href="mailto:<?= e($SITE['email']) ?>"><?= e($SITE['email']) ?></a></li>
                <li><?= e($SITE['address']) ?></li>
                <li><?= e($SITE['work_hours']) ?></li>
            </ul>
            <div class="footer-social">
                <a href="<?= e($SITE['social']['instagram']) ?>" rel="noopener" target="_blank" aria-label="Instagram">Instagram</a>
                <a href="<?= e($SITE['social']['facebook']) ?>" rel="noopener" target="_blank" aria-label="Facebook">Facebook</a>
                <a href="<?= e($SITE['social']['whatsapp']) ?>" rel="noopener" target="_blank" aria-label="WhatsApp">WhatsApp</a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p>&copy; <?= date('Y') ?> <?= e($SITE['legal']) ?>. Bütün hüquqlar qorunur.</p>
        </div>
    </div>
</footer>

<script src="/assets/js/main.js?v=1" defer></script>
</body>
</html>
