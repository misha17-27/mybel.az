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
    ];
    $inner = $p[$name] ?? '<circle cx="12" cy="12" r="9"/>';
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $inner . '</svg>';
}
