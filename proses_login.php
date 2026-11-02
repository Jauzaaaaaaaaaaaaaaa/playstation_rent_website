<?php
require_once __DIR__ . '/security.php';
require_post_csrf();
include "koneksi.php";

/* Batas percobaan per sesi untuk memperlambat tebak-tebakan kata sandi */
const BATAS_GAGAL = 5;
const LAMA_KUNCI = 60;

$kunci = $_SESSION['kunci_sampai'] ?? 0;
if ($kunci > time()) {
    $_SESSION['error'] = "Terlalu banyak percobaan. Coba lagi dalam " . ($kunci - time()) . " detik.";
    header("Location: login.php");
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === "" || $password === "") {
    $_SESSION['error'] = "Email dan password wajib diisi.";
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true);
    unset($_SESSION['gagal'], $_SESSION['kunci_sampai'], $_SESSION['csrf']);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];

    header("Location: index.php");
    exit;
}

$_SESSION['gagal'] = ($_SESSION['gagal'] ?? 0) + 1;
if ($_SESSION['gagal'] >= BATAS_GAGAL) {
    $_SESSION['gagal'] = 0;
    $_SESSION['kunci_sampai'] = time() + LAMA_KUNCI;
    $_SESSION['error'] = "Terlalu banyak percobaan. Coba lagi dalam " . LAMA_KUNCI . " detik.";
} else {
    $_SESSION['error'] = "Email atau password salah.";
}
header("Location: login.php");
exit;
