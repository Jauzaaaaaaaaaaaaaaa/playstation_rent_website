<?php
include "auth.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data - Rental Playstation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-page">
    <div class="form-card">
        <div class="section-header">
            <div>
                <p class="eyebrow">Form peminjam</p>
                <h2>Tambah Data Playstation</h2>
                <p class="muted">Lengkapi data peminjam sebelum menyimpan.</p>
            </div>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </div>

        <form action="simpan.php" method="POST" class="modern-form">
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Peminjam</label>
                    <input type="text" name="nama" placeholder="Contoh: Budi Santoso" required>
                </div>

                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" name="no_hp" placeholder="Contoh: 081234567890" required>
                </div>

                <div class="form-group">
                    <label>Jenis Playstation</label>
                    <select name="jenis" required>
                        <option value="">Pilih jenis</option>
                        <option value="PlayStation 3">PlayStation 3</option>
                        <option value="PlayStation 4">PlayStation 4</option>
                        <option value="PlayStation 5">PlayStation 5</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Durasi (hari)</label>
                    <input type="number" name="durasi" min="1" max="24" placeholder="Contoh: 3" required>
                </div>

                <div class="form-group form-wide">
                    <label>Harga</label>
                    <input type="number" name="harga" min="0" placeholder="Contoh: 150000" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="index.php" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
