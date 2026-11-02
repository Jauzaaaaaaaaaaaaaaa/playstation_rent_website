<?php
/* Nilai koneksi bisa diatur lewat variabel lingkungan untuk produksi dan pengujian. */
mysqli_report(MYSQLI_REPORT_OFF);

$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$db   = getenv('DB_NAME') ?: 'rental_playstation';
$port = (int) (getenv('DB_PORT') ?: 3306);

$conn = @new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    error_log('Koneksi database gagal: ' . $conn->connect_error);
    http_response_code(500);
    exit('Layanan sedang tidak tersedia. Pastikan MySQL berjalan dan database.sql sudah diimpor.');
}

$conn->set_charset("utf8mb4");
