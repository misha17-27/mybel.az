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
        // Link kliklənəndə menyunu bağla
        navList.querySelectorAll('a').forEach(function (a) {
            a.addEventListener('click', function () {
                navList.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('nav-open');
            });
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

    // ---- Sadə lightbox (qalereya şəkilləri) ----
    var galleryImgs = document.querySelectorAll('[data-lightbox]');
    if (galleryImgs.length) {
        var box = document.createElement('div');
        box.className = 'lightbox';
        box.innerHTML = '<button class="lightbox-close" aria-label="Bağla">&times;</button><img alt="">';
        document.body.appendChild(box);
        var boxImg = box.querySelector('img');
        var close = function () { box.classList.remove('is-open'); document.body.style.overflow = ''; };
        galleryImgs.forEach(function (img) {
            img.addEventListener('click', function () {
                boxImg.src = img.getAttribute('data-full') || img.src;
                boxImg.alt = img.alt || '';
                box.classList.add('is-open');
                document.body.style.overflow = 'hidden';
            });
        });
        box.addEventListener('click', function (ev) {
            if (ev.target === box || ev.target.classList.contains('lightbox-close')) close();
        });
        document.addEventListener('keydown', function (ev) {
            if (ev.key === 'Escape') close();
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
