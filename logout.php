<?php
require_once __DIR__ . '/security.php';
$_SESSION = [];
session_destroy();
header("Location: login.php");
exit;
