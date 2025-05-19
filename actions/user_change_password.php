<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

if (!isset($_SESSION['user'])) {
  die("Access denied");
}

$current_user_id = $_SESSION['user']['id'];
$is_admin = $_SESSION['user']['role'] === 'admin';

$user_id = intval($_POST['id']);
$current_password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

$redirect_url = BASE_URL . "views/user_edit.php?id=$user_id";

// ตรวจสอบช่องว่าง
if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
  header("Location: $redirect_url&pw_error=ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບ");
  exit;
}

// ตรวจสอบความถูกต้อง
if ($new_password !== $confirm_password) {
  header("Location: $redirect_url&pw_error=ລະຫັດໃໝ່ບໍ່ກົງກັນ");
  exit;
}
if (strlen($new_password) < 6) {
  header("Location: $redirect_url&pw_error=ລະຫັດໃໝ່ຕ້ອງຢ່າງນ້ອຍ 6 ຕົວອັກສອນ");
  exit;
}

// ดึงรหัสเดิมจากฐานข้อมูล
$stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user || !password_verify($current_password, $user['password'])) {
  header("Location: $redirect_url&pw_error=ລະຫັດເກົ່າບໍ່ຖືກຕ້ອງ");
  exit;
}

// อัปเดตรหัสผ่านใหม่
$new_hash = password_hash($new_password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->execute([$new_hash, $user_id]);

header("Location: $redirect_url&pw_success=ປ່ຽນລະຫັດສຳເລັດແລ້ວ");
exit;
