<?php
include "auth.php";
require_post_csrf();
include "koneksi.php";

$id = (int) ($_POST['id'] ?? 0);
if ($id <= 0) {
    http_response_code(422);
    exit('Data tidak valid.');
}
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

$stmt = $conn->prepare("UPDATE dataps SET nama = ?, no_hp = ?, jenis = ?, durasi = ?, harga = ? WHERE id = ?");
$stmt->bind_param("sssiii", $nama, $no_hp, $jenis, $durasi, $harga, $id);
$stmt->execute();

header("Location: index.php");
exit;
