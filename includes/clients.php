<?php
/** Müştəri loqoları — sonsuz (loop) karusel. $CLIENTS massivini istifadə edir. */
?>
<div class="clients-marquee" role="region" aria-label="Müştəri loqoları">
    <div class="clients-track">
        <?php for ($rep = 0; $rep < 2; $rep++): ?>
            <?php foreach (visible_sorted($CLIENTS) as $c): ?>
                <div class="client-cell"<?= $rep ? ' aria-hidden="true"' : '' ?>>
                    <img src="<?= e($c['logo']) ?>" alt="<?= e($c['name']) ?> loqo" loading="lazy" width="240" height="120">
                </div>
            <?php endforeach; ?>
        <?php endfor; ?>
    </div>
</div>
