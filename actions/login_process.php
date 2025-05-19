<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
  $_SESSION['user'] = $user;
  header("Location: " . BASE_URL . "views/dashboard.php");
  exit;
} else {
  header("Location: " . BASE_URL . "views/login.php?error=ຊື່ຜູ້ໃຊ້ ຫຼື ລະຫັດຜິດ");
  exit;
}
