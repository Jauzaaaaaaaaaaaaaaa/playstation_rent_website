<?php
session_start();
include "koneksi.php";

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email == "" || $password == "") {
    $_SESSION['error'] = "Email dan password wajib diisi.";
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];

    header("Location: index.php");
    exit;
} else {
    $_SESSION['error'] = "Email atau password salah.";
    header("Location: login.php");
    exit;
}
?>