<?php
require_once __DIR__ . '/security.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = $_SESSION['error'] ?? "";
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rental Playstation</title>
    <link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="atelier/atelier.css">
<link rel="stylesheet" href="atelier/theme.css">
<script src="atelier/theme.js"></script>
<script src="atelier/atelier.js"></script>
</head>
<body class="auth-page">

<div class="auth-wrapper">
    <div class="auth-hero">
        <div class="brand-icon large">PS</div>
        <p class="eyebrow">Aplikasi UJK</p>
        <h1>Rental PlayStation</h1>
        <p>Dashboard sederhana untuk mencatat peminjam, durasi sewa, jenis PlayStation, dan total harga rental.</p>
    </div>

    <div class="login-card">
        <h2>Masuk Admin</h2>
        <p class="muted">Silakan login untuk mengelola data rental.</p>

        <?php if ($error != ""): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="proses_login.php" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="nama@email.com" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Login</button>
        </form>
    </div>
</div>

</body>
</html>
