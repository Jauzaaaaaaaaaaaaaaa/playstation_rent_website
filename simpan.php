<?php
include "auth.php";
include "koneksi.php";

$nama = trim($_POST['nama'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$jenis = trim($_POST['jenis'] ?? '');
$durasi = (int) ($_POST['durasi'] ?? 0);
$harga = (int) ($_POST['harga'] ?? 0);

if ($nama == "" || $no_hp == "" || $jenis == "" || $durasi <= 0 || $harga < 0) {
    die("Data yang diinput tidak valid.");
}

$stmt = $conn->prepare("INSERT INTO dataps (nama, no_hp, jenis, durasi, harga) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssii", $nama, $no_hp, $jenis, $durasi, $harga);
$stmt->execute();

header("Location: index.php");
exit;
?>