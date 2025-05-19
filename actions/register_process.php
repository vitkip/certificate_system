<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'staff';

if ($username === '' || $password === '') {
  header("Location: " . BASE_URL . "views/register.php?error=ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບ");
  exit;
}

// ตรวจสอบซ้ำชื่อผู้ใช้
$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->fetch()) {
  header("Location: " . BASE_URL . "views/register.php?error=ຊື່ຜູ້ໃຊ້ນີ້ໃຊ້ໄປແລ້ວ");
  exit;
}

// บันทึกลงฐานข้อมูล
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->execute([$username, $email, $hash, $role]);

header("Location: " . BASE_URL . "views/register.php?success=ລົງທະບຽນສຳເລັດ!");
