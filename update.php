<?php
include "auth.php";
include "koneksi.php";

$id = (int) ($_POST['id'] ?? 0);
$nama = trim($_POST['nama'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$jenis = trim($_POST['jenis'] ?? '');
$durasi = (int) ($_POST['durasi'] ?? 0);
$harga = (int) ($_POST['harga'] ?? 0);

if ($id <= 0 || $nama == "" || $no_hp == "" || $jenis == "" || $durasi <= 0 || $harga < 0) {
    die("Data tidak valid.");
}

$stmt = $conn->prepare("UPDATE dataps SET nama = ?, no_hp = ?, jenis = ?, durasi = ?, harga = ? WHERE id = ?");
$stmt->bind_param("sssiii", $nama, $no_hp, $jenis, $durasi, $harga, $id);
$stmt->execute();

header("Location: index.php");
exit;
?>