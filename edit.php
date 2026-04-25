<?php
include "auth.php";
include "koneksi.php";

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    die("ID tidak valid.");
}

$stmt = $conn->prepare("SELECT * FROM dataps WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data - Rental Playstation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-page">
    <div class="form-card">
        <div class="section-header">
            <div>
                <p class="eyebrow">Perbarui data</p>
                <h2>Edit Data Playstation</h2>
                <p class="muted">Ubah informasi peminjam lalu simpan kembali.</p>
            </div>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </div>

        <form action="update.php" method="POST" class="modern-form">
            <input type="hidden" name="id" value="<?php echo (int) $data['id']; ?>">

            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Peminjam</label>
                    <input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                </div>

                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" name="no_hp" value="<?php echo htmlspecialchars($data['no_hp']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Jenis Playstation</label>
                    <select name="jenis" required>
                        <?php
                        $jenisOptions = ['PlayStation 3', 'PlayStation 4', 'PlayStation 5'];
                        foreach ($jenisOptions as $option):
                        ?>
                            <option value="<?php echo $option; ?>" <?php echo ($data['jenis'] == $option) ? 'selected' : ''; ?>>
                                <?php echo $option; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Durasi (hari)</label>
                    <input type="number" name="durasi" value="<?php echo htmlspecialchars($data['durasi']); ?>" min="1" max="24" required>
                </div>

                <div class="form-group form-wide">
                    <label>Harga</label>
                    <input type="number" name="harga" value="<?php echo htmlspecialchars($data['harga']); ?>" min="0" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="index.php" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
