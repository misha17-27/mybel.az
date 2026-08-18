/* MYBEL Concept — ümumi skriptlər */
(function () {
    'use strict';

    // ---- Mobil menyu ----
    var toggle = document.querySelector('.nav-toggle');
    var navList = document.getElementById('navList');
    if (toggle && navList) {
        toggle.addEventListener('click', function () {
            var open = navList.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            document.body.classList.toggle('nav-open', open);
        });
        // Bağla düyməsi (X)
        var navClose = document.getElementById('navClose');
        var closeMenu = function () {
            navList.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
            document.body.classList.remove('nav-open');
        };
        if (navClose) navClose.addEventListener('click', closeMenu);
        // Link kliklənəndə menyunu bağla
        navList.querySelectorAll('a').forEach(function (a) {
            a.addEventListener('click', closeMenu);
        });
    }

    // ---- Scroll zamanı header vəziyyəti ----
    var header = document.getElementById('siteHeader');
    if (header) {
        var onScroll = function () {
            header.classList.toggle('is-scrolled', window.scrollY > 20);
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    // ---- Lightbox (qalereya + irəli/geri keçid) ----
    var galleryImgs = Array.prototype.slice.call(document.querySelectorAll('[data-lightbox]'));
    if (galleryImgs.length) {
        var box = document.createElement('div');
        box.className = 'lightbox';
        box.innerHTML =
            '<button class="lightbox-close" aria-label="Bağla">&times;</button>' +
            '<button class="lightbox-nav lightbox-prev" aria-label="Əvvəlki">&#8249;</button>' +
            '<img alt="">' +
            '<button class="lightbox-nav lightbox-next" aria-label="Növbəti">&#8250;</button>';
        document.body.appendChild(box);
        var boxImg = box.querySelector('img');
        var items = galleryImgs.map(function (img) {
            return { src: img.getAttribute('data-full') || img.src, alt: img.alt || '' };
        });
        var idx = 0;
        var single = items.length < 2;
        if (single) box.classList.add('lightbox-single');

        var show = function (i) {
            idx = (i + items.length) % items.length;
            boxImg.src = items[idx].src;
            boxImg.alt = items[idx].alt;
        };
        var open = function (i) { show(i); box.classList.add('is-open'); document.body.style.overflow = 'hidden'; };
        var close = function () { box.classList.remove('is-open'); document.body.style.overflow = ''; };
        var next = function () { show(idx + 1); };
        var prev = function () { show(idx - 1); };

        galleryImgs.forEach(function (img, i) { img.addEventListener('click', function () { open(i); }); });
        box.querySelector('.lightbox-next').addEventListener('click', function (e) { e.stopPropagation(); next(); });
        box.querySelector('.lightbox-prev').addEventListener('click', function (e) { e.stopPropagation(); prev(); });
        box.addEventListener('click', function (ev) {
            if (ev.target === box || ev.target.classList.contains('lightbox-close')) close();
        });
        document.addEventListener('keydown', function (ev) {
            if (!box.classList.contains('is-open')) return;
            if (ev.key === 'Escape') close();
            else if (ev.key === 'ArrowRight') next();
            else if (ev.key === 'ArrowLeft') prev();
        });
        // toxunma ilə sürüşdürmə (swipe)
        var x0 = null;
        box.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true });
        box.addEventListener('touchend', function (e) {
            if (x0 === null) return;
            var dx = e.changedTouches[0].clientX - x0;
            if (Math.abs(dx) > 40) { dx < 0 ? next() : prev(); }
            x0 = null;
        });
    }

    // ---- Reveal-on-scroll animasiya ----
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); }
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('[data-reveal]').forEach(function (el) { io.observe(el); });
    } else {
        document.querySelectorAll('[data-reveal]').forEach(function (el) { el.classList.add('is-in'); });
    }
})();
