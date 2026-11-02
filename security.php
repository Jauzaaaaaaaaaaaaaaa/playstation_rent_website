<?php
/* Sesi yang aman dan token CSRF untuk semua form. */
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']),
    ]);
    session_start();
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . htmlspecialchars(csrf_token()) . '">';
}

/* Hanya menerima POST dengan token yang cocok. */
function require_post_csrf(): void
{
    $token = $_POST['csrf'] ?? '';
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !is_string($token) || !hash_equals(csrf_token(), $token)) {
        http_response_code(403);
        exit('Permintaan ditolak. Muat ulang halaman lalu coba lagi.');
    }
}

function jenis_valid(): array
{
    return ['PlayStation 3', 'PlayStation 4', 'PlayStation 5'];
}

/* Validasi bersama untuk simpan dan update. Mengembalikan pesan kesalahan atau null. */
function validasi_rental(string $nama, string $no_hp, string $jenis, int $durasi, int $harga): ?string
{
    if ($nama === '' || mb_strlen($nama) > 120) {
        return 'Nama wajib diisi, maksimal 120 karakter.';
    }
    if (!preg_match('/^[0-9+][0-9 -]{7,19}$/', $no_hp)) {
        return 'Nomor HP tidak valid.';
    }
    if (!in_array($jenis, jenis_valid(), true)) {
        return 'Jenis PlayStation tidak dikenal.';
    }
    if ($durasi < 1 || $durasi > 24) {
        return 'Durasi harus 1 sampai 24 hari.';
    }
    if ($harga < 0) {
        return 'Harga tidak boleh negatif.';
    }
    return null;
}
