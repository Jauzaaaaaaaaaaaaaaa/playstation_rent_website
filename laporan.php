<?php
include "auth.php";
include "koneksi.php";

$ringkas = $conn->query("SELECT COUNT(*) AS transaksi, COALESCE(SUM(harga), 0) AS omzet, COALESCE(SUM(durasi), 0) AS hari, COALESCE(AVG(harga), 0) AS rata FROM dataps")->fetch_assoc();

$bulan = $conn->query("SELECT DATE_FORMAT(created_at, '%Y-%m') AS bulan, COUNT(*) AS transaksi, SUM(harga) AS omzet FROM dataps GROUP BY bulan ORDER BY bulan DESC LIMIT 12")->fetch_all(MYSQLI_ASSOC);
$bulan = array_reverse($bulan);

$jenis = $conn->query("SELECT jenis, COUNT(*) AS transaksi, SUM(durasi) AS hari, SUM(harga) AS omzet, ROUND(SUM(harga) / NULLIF(SUM(durasi), 0)) AS per_hari FROM dataps GROUP BY jenis ORDER BY omzet DESC")->fetch_all(MYSQLI_ASSOC);

$pelanggan = $conn->query("SELECT nama, COUNT(*) AS transaksi, SUM(harga) AS omzet FROM dataps GROUP BY nama, no_hp ORDER BY omzet DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);

$rp = fn($n) => 'Rp ' . number_format((float) $n, 0, ',', '.');
$maxBulan = max(array_merge([1], array_column($bulan, 'omzet')));
$maxJenis = max(array_merge([1], array_column($jenis, 'omzet')));
$nmBulan = ['01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Rental Playstation</title>
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
            <a href="index.php">Dashboard</a>
            <a class="active" href="laporan.php">Laporan</a>
            <a href="tambah.php">Tambah Data</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>

    <main class="main-content">
        <section class="hero-card">
            <div>
                <p class="eyebrow">Analitik bisnis</p>
                <h2>Laporan Rental</h2>
                <p>Dihitung langsung dari data transaksi dengan query agregat SQL.</p>
            </div>
        </section>

        <section class="stats-grid">
            <div class="stat-card"><span>Omzet</span><strong><?php echo $rp($ringkas['omzet']); ?></strong><small><?php echo (int) $ringkas['transaksi']; ?> transaksi</small></div>
            <div class="stat-card"><span>Hari disewa</span><strong><?php echo (int) $ringkas['hari']; ?></strong><small>total durasi</small></div>
            <div class="stat-card"><span>Rata-rata transaksi</span><strong><?php echo $rp($ringkas['rata']); ?></strong><small>per penyewaan</small></div>
        </section>

        <section class="content-card">
            <div class="section-header"><div><p class="eyebrow">Tren</p><h3>Omzet per bulan</h3></div></div>
            <?php if ($bulan): ?>
            <div class="lp-months" role="img" aria-label="Omzet per bulan">
                <?php foreach ($bulan as $b): [$y, $m] = explode('-', $b['bulan']); ?>
                <div class="lp-month" title="<?php echo htmlspecialchars($nmBulan[$m] . ' ' . $y . ': ' . $rp($b['omzet']) . ', ' . $b['transaksi'] . ' transaksi'); ?>">
                    <small><?php echo number_format($b['omzet'] / 1000, 0, ',', '.'); ?>rb</small>
                    <i style="height:<?php echo round($b['omzet'] / $maxBulan * 100); ?>%"></i>
                    <span><?php echo $nmBulan[$m]; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?><p class="muted">Belum ada data.</p><?php endif; ?>
        </section>

        <section class="content-card">
            <div class="section-header"><div><p class="eyebrow">Produk</p><h3>Kinerja per jenis</h3></div></div>
            <div class="table-responsive">
                <table class="table lp-table">
                    <thead><tr><th>Jenis</th><th>Omzet</th><th>Transaksi</th><th>Hari</th><th>Omzet per hari</th></tr></thead>
                    <tbody>
                    <?php foreach ($jenis as $j): ?>
                        <tr>
                            <td class="text-strong"><?php echo htmlspecialchars($j['jenis']); ?><i class="lp-bar" style="width:<?php echo round($j['omzet'] / $maxJenis * 100); ?>%"></i></td>
                            <td><?php echo $rp($j['omzet']); ?></td>
                            <td><?php echo (int) $j['transaksi']; ?></td>
                            <td><?php echo (int) $j['hari']; ?></td>
                            <td><?php echo $rp($j['per_hari']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="content-card">
            <div class="section-header"><div><p class="eyebrow">Pelanggan</p><h3>Lima penyewa teratas</h3></div></div>
            <div class="table-responsive">
                <table class="table lp-table">
                    <thead><tr><th>Nama</th><th>Transaksi</th><th>Total</th></tr></thead>
                    <tbody>
                    <?php foreach ($pelanggan as $p): ?>
                        <tr><td class="text-strong"><?php echo htmlspecialchars($p['nama']); ?></td><td><?php echo (int) $p['transaksi']; ?></td><td><?php echo $rp($p['omzet']); ?></td></tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

</body>
</html>
