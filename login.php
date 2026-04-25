<?php
session_start();

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
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="admin@gmail.com" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Login</button>
        </form>

        <div class="login-note">
            <strong>Default:</strong> admin@gmail.com / admin123
        </div>
    </div>
</div>

</body>
</html>
