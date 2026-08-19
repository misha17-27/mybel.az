<?php
/**
 * admin/includes/bootstrap.php — admin panelin əsası.
 * Sessiya, autentifikasiya, CSRF, rol yoxlaması.
 */
declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/includes/config.php'; // $SITE, store funksiyaları

// ---- Sessiya ----
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'path' => '/']);
    session_name('mybel_admin');
    session_start();
}

// ---- Dil (RU/EN/AZ) ----
require_once __DIR__ . '/i18n.php';

// ---- İlk admin istifadəçisini yarat (seed) ----
function ensure_users_seed(): array {
    $users = load_json('users', []);
    if (empty($users)) {
        $users = [[
            'id'       => new_id(),
            'name'     => 'Admin',
            'email'    => 'admin@mybel.az',
            'pass'     => password_hash('mybel1234', PASSWORD_DEFAULT),
            'role'     => 'admin',
            'active'   => true,
            'last'     => '',
        ]];
        save_json('users', $users);
    }
    return $users;
}

function all_users(): array { return ensure_users_seed(); }

function find_user_by_email(string $email): ?array {
    foreach (all_users() as $u) {
        if (strcasecmp($u['email'], $email) === 0) return $u;
    }
    return null;
}
function find_user_by_id(?string $id): ?array {
    if (!$id) return null;
    foreach (all_users() as $u) {
        if ($u['id'] === $id) return $u;
    }
    return null;
}

/** e-poçt VƏ YA istifadəçi adı (name) ilə tap */
function find_user_by_login(string $login): ?array {
    $login = trim($login);
    if ($login === '') return null;
    foreach (all_users() as $u) {
        if (strcasecmp($u['email'], $login) === 0 || strcasecmp($u['name'], $login) === 0) return $u;
    }
    return null;
}

// ---- Şifrə sıfırlama tokenləri (data/resets.json) ----
function create_reset_token(string $uid): string {
    $tokens = load_json('resets', []);
    $now = time();
    foreach ($tokens as $k => $t) if (($t['exp'] ?? 0) < $now) unset($tokens[$k]);
    $token = bin2hex(random_bytes(32));
    $tokens[$token] = ['uid' => $uid, 'exp' => $now + 3600];
    save_json('resets', $tokens);
    return $token;
}
function reset_token_user(?string $token): ?array {
    if (!$token) return null;
    $t = (load_json('resets', []))[$token] ?? null;
    if (!$t || ($t['exp'] ?? 0) < time()) return null;
    return find_user_by_id($t['uid']);
}
function consume_reset_token(string $token): void {
    $tokens = load_json('resets', []);
    unset($tokens[$token]);
    save_json('resets', $tokens);
}

// ---- CSRF ----
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_field(): string {
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}
function csrf_check(): void {
    $ok = isset($_POST['_csrf']) && hash_equals($_SESSION['csrf'] ?? '', $_POST['_csrf']);
    if (!$ok) { http_response_code(419); exit('CSRF token yanlışdır. Səhifəni yeniləyin.'); }
}

// ---- Autentifikasiya ----
function current_user(): ?array {
    return find_user_by_id($_SESSION['uid'] ?? null);
}
function is_logged_in(): bool { return current_user() !== null; }

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: /admin/login.php');
        exit;
    }
}
function require_admin(): void {
    require_login();
    $u = current_user();
    if (($u['role'] ?? '') !== 'admin') {
        http_response_code(403);
        exit('Bu bölmə yalnız administrator üçündür.');
    }
}

// ---- Giriş cəhdlərinin məhdudlaşdırılması (throttle) ----
function login_throttle_key(): string { return 'ip_' . ($_SERVER['REMOTE_ADDR'] ?? 'cli'); }
function login_attempts_left(): int {
    $log = load_json('loginlog', []);
    $key = login_throttle_key();
    $now = time();
    $recent = array_filter($log[$key] ?? [], fn($t) => $t > $now - 900); // 15 dəq
    return max(0, 10 - count($recent));
}
function login_record_fail(): void {
    $log = load_json('loginlog', []);
    $key = login_throttle_key();
    $now = time();
    $log[$key] = array_values(array_filter($log[$key] ?? [], fn($t) => $t > $now - 900));
    $log[$key][] = $now;
    save_json('loginlog', $log);
}
function login_clear(): void {
    $log = load_json('loginlog', []);
    unset($log[login_throttle_key()]);
    save_json('loginlog', $log);
}

// ---- flash mesajları ----
function flash(string $msg, string $type = 'success'): void {
    $_SESSION['flash'][] = ['msg' => $msg, 'type' => $type];
}
function get_flashes(): array {
    $f = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $f;
}

// ---- redirect köməkçisi ----
function redirect(string $to): void { header('Location: ' . $to); exit; }
