<?php
include "auth.php";
include "koneksi.php";

$stats = [
    'total_data' => 0,
    'total_durasi' => 0,
    'total_pendapatan' => 0,
];

$statsQuery = $conn->query("SELECT COUNT(*) AS total_data, COALESCE(SUM(durasi), 0) AS total_durasi, COALESCE(SUM(harga), 0) AS total_pendapatan FROM dataps");
if ($statsQuery) {
    $stats = $statsQuery->fetch_assoc();
}

$result = $conn->query("SELECT * FROM dataps ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Rental Playstation</title>
    <link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="atelier/atelier.css">
<link rel="stylesheet" href="atelier/theme.css">
<script src="atelier/theme.js"></script>
<script src="atelier/atelier.js"></script>
</head>
<body>

<div class="page-shell">
    <aside class="sidebar">
        <div class="brand-card">
            <div class="brand-icon">PS</div>
            <div>
                <h1>Rental PlayStation</h1>
                <p>Panel administrasi</p>
            </div>
        </div>

        <nav class="menu-list">
            <a class="active" href="index.php">Dashboard</a>
            <a href="laporan.php">Laporan</a>
            <a href="tambah.php">Tambah Data</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>

    <main class="main-content">
        <section class="hero-card">
            <div>
                <p class="eyebrow">Selamat datang</p>
                <h2><?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
                <p>Kelola data peminjam PlayStation dengan tampilan yang lebih rapi, modern, dan mudah digunakan.</p>
            </div>
            <a href="tambah.php" class="btn btn-primary">+ Tambah Peminjam</a>
        </section>

        <section class="stats-grid">
            <div class="stat-card">
                <span>Total Data</span>
                <strong><?php echo (int) $stats['total_data']; ?></strong>
                <small>peminjam tercatat</small>
            </div>
            <div class="stat-card">
                <span>Total Durasi</span>
                <strong><?php echo (int) $stats['total_durasi']; ?></strong>
                <small>hari rental</small>
            </div>
            <div class="stat-card">
                <span>Total Pendapatan</span>
                <strong>Rp <?php echo number_format((int) $stats['total_pendapatan'], 0, ',', '.'); ?></strong>
                <small>estimasi pemasukan</small>
            </div>
        </section>

        <section class="content-card">
            <div class="section-header">
                <div>
                    <p class="eyebrow">Data terbaru</p>
                    <h3>Daftar Peminjam</h3>
                </div>
                <a href="tambah.php" class="btn btn-secondary">Tambah Data</a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Jenis</th>
                            <th>Durasi</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php $no = 1; ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td class="text-strong"><?php echo htmlspecialchars($row['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($row['no_hp']); ?></td>
                                    <td><span class="badge"><?php echo htmlspecialchars($row['jenis']); ?></span></td>
                                    <td><?php echo (int) $row['durasi']; ?> hari</td>
                                    <td>Rp <?php echo number_format((int) $row['harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <div class="action-group">
                                            <a href="edit.php?id=<?php echo (int) $row['id']; ?>" class="btn btn-edit">Edit</a>
                                            <form action="hapus.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="id" value="<?php echo (int) $row['id']; ?>">
                                                <button type="submit" class="btn btn-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="empty-state">Data belum tersedia. Klik tombol tambah untuk membuat data pertama.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

</body>
</html>
