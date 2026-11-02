<?php
include "auth.php";
require_post_csrf();
include "koneksi.php";

$nama = trim($_POST['nama'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$jenis = trim($_POST['jenis'] ?? '');
$durasi = (int) ($_POST['durasi'] ?? 0);
$harga = (int) ($_POST['harga'] ?? 0);

$salah = validasi_rental($nama, $no_hp, $jenis, $durasi, $harga);
if ($salah !== null) {
    http_response_code(422);
    exit(htmlspecialchars($salah));
}

$stmt = $conn->prepare("INSERT INTO dataps (nama, no_hp, jenis, durasi, harga) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssii", $nama, $no_hp, $jenis, $durasi, $harga);
$stmt->execute();

header("Location: index.php");
exit;
