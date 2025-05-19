<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  die("Access denied.");
}

$id = intval($_POST['id']);
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$role = $_POST['role'] === 'admin' ? 'admin' : 'staff';

// ป้องกันลบ username ว่าง
if ($username === '') {
  die("❌ ຕ້ອງມີ username");
}

// ป้องกันเปลี่ยน role ของตัวเองผ่าน POST
if ($_SESSION['user']['id'] == $id) {
  $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
  $stmt->execute([$username, $email, $id]);
} else {
  $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
  $stmt->execute([$username, $email, $role, $id]);
}

header("Location: " . BASE_URL . "views/user_list.php");
exit;
