<?php
/** Sadə inline SVG ikonlar (xidmətlər üçün). */
function icon($name) {
    $p = [
        'kitchen'  => '<path d="M4 3h16v7H4z"/><path d="M4 10v11M20 10v11M8 6h.01M12 6h.01"/><path d="M4 14h16"/>',
        'table'    => '<path d="M3 9h18"/><path d="M5 9v11M19 9v11"/><path d="M4 5h16l1 4H3z"/>',
        'bed'      => '<path d="M3 18v-6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v6"/><path d="M3 14h18M7 10V8a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/><path d="M3 18v2M21 18v2"/>',
        'wardrobe' => '<rect x="5" y="3" width="14" height="18" rx="1"/><path d="M12 3v18M9 10h.5M15 10h-.5"/>',
        'sofa'     => '<path d="M4 11V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3"/><path d="M2 13a2 2 0 0 1 2-2 2 2 0 0 1 2 2v3h12v-3a2 2 0 0 1 4 0v5H2z"/>',
        'design'   => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',
        // sahə (sector) ikonları
        'hotel'      => '<rect x="4" y="3" width="16" height="18" rx="1"/><path d="M4 21h16"/><path d="M8 7h.01M12 7h.01M16 7h.01M8 11h.01M12 11h.01M16 11h.01M8 15h.01M16 15h.01"/><path d="M11 21v-3a1 1 0 0 1 2 0v3"/>',
        'restaurant' => '<path d="M3 2v7a3 3 0 0 0 3 3v10"/><path d="M6 2v9"/><path d="M9 2v7a3 3 0 0 1-3 3"/><path d="M21 15V2a5 5 0 0 0-5 5v6a2 2 0 0 0 2 2h3zm0 0v7"/>',
        'education'  => '<path d="M22 10 12 5 2 10l10 5 10-5z"/><path d="M6 12v5c0 1.66 2.69 3 6 3s6-1.34 6-3v-5"/><path d="M22 10v6"/>',
        'medical'    => '<path d="M11 3a1 1 0 0 0-1 1v5H5a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v5a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-5h5a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1h-5V4a1 1 0 0 0-1-1z"/>',
        'business'   => '<path d="M6 22V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v18"/><path d="M14 9h3a1 1 0 0 1 1 1v12"/><path d="M3 22h18"/><path d="M9 7h.01M9 11h.01M9 15h.01"/>',
        'office'     => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><path d="M2 13h20"/>',
        'home'       => '<path d="M3 9.5 12 3l9 6.5"/><path d="M5 10v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V10"/><path d="M9.5 21v-6h5v6"/>',
        'phone'    =>'<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.9.34 1.79.63 2.65a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.42-1.42a2 2 0 0 1 2.11-.45c.86.29 1.75.5 2.65.63A2 2 0 0 1 22 16.92z"/>',
        'mail'     => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/>',
        'pin'      => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
        'clock'    => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
    ];
    $inner = $p[$name] ?? '<circle cx="12" cy="12" r="9"/>';
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $inner . '</svg>';
}

/** Sosial şəbəkə ikonları */
function social_icon($name) {
    $p = [
        'instagram' => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>',
        'facebook'  => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>',
        'whatsapp'  => '<path d="M3 21l1.65-3.8a9 9 0 1 1 3.4 2.9z"/><path d="M9 10a.5 .5 0 0 0 1 0V9a.5 .5 0 0 0-1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0-1h-1a.5 .5 0 0 0 0 1"/>',
        'youtube'   => '<path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="currentColor" stroke="none"/>',
    ];
    // X (Twitter) — dolu loqo
    if ($name === 'x') {
        return '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>';
    }
    $inner = $p[$name] ?? '<circle cx="12" cy="12" r="9"/>';
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $inner . '</svg>';
}

/** Doldurulmuş sosial keçidləri ikon kimi göstərir */
function social_links($SITE, $extraClass = '') {
    $order = ['instagram', 'facebook', 'whatsapp', 'youtube', 'x'];
    $out = '<div class="social-icons ' . $extraClass . '">';
    foreach ($order as $sn) {
        $url = $SITE['social'][$sn] ?? '';
        if (trim((string)$url) === '') continue;
        $out .= '<a href="' . e($url) . '" target="_blank" rel="noopener" class="social-icon" aria-label="' . ucfirst($sn) . '">' . social_icon($sn) . '</a>';
    }
    return $out . '</div>';
}
