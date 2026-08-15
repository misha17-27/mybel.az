<?php
/**
 * store.php — JSON əsaslı sadə məlumat saxlama qatı (verilənlər bazası əvəzi).
 * Bütün məzmun /data/*.json fayllarında saxlanılır. Admin panel bunları redaktə edir,
 * publik sayt isə oxuyur.
 */

function data_dir() {
    return dirname(__DIR__) . '/data';
}
function data_path($name) {
    return data_dir() . '/' . preg_replace('/[^a-z0-9_-]/i', '', $name) . '.json';
}

/** JSON oxu (yoxdursa default qaytar) */
function load_json($name, $default = []) {
    $f = data_path($name);
    if (!is_file($f)) return $default;
    $raw = file_get_contents($f);
    $d = json_decode($raw, true);
    return is_array($d) ? $d : $default;
}

/** JSON yaz (atomik: tmp -> rename) */
function save_json($name, $data) {
    $dir = data_dir();
    if (!is_dir($dir)) @mkdir($dir, 0775, true);
    $f = data_path($name);
    $tmp = $f . '.' . getmypid() . '.tmp';
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if (file_put_contents($tmp, $json, LOCK_EX) === false) return false;
    return rename($tmp, $f);
}

/** Fayl yoxdursa default ilə yaradıb qaytarır (seed) */
function load_or_seed($name, $default) {
    $f = data_path($name);
    if (is_file($f)) return load_json($name, $default);
    save_json($name, $default);
    return $default;
}

/** Sadə unikal id */
function new_id() {
    return substr(bin2hex(random_bytes(6)), 0, 10);
}

/** slug yaradıcı (az hərfləri latına) */
function slugify($text) {
    $map = ['ə'=>'e','ç'=>'c','ğ'=>'g','ı'=>'i','ö'=>'o','ş'=>'s','ü'=>'u',
            'Ə'=>'e','Ç'=>'c','Ğ'=>'g','İ'=>'i','I'=>'i','Ö'=>'o','Ş'=>'s','Ü'=>'u'];
    $text = strtr($text, $map);
    $text = mb_strtolower($text, 'UTF-8');
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-') ?: 'item-' . new_id();
}
