<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

// ตรวจสอบสิทธิ์
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  die("Access denied.");
}

$user_id = intval($_POST['user_id']);
$new_role = $_POST['new_role'] === 'admin' ? 'admin' : 'staff';

// ป้องกันเปลี่ยน role ของตัวเอง
if ($_SESSION['user']['id'] == $user_id) {
  header("Location: " . BASE_URL . "views/user_list.php?error=ບໍ່ສາມາດແກ້ສິດຂອງຕົນເອງ");
  exit;
}

$stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
$stmt->execute([$new_role, $user_id]);

header("Location: " . BASE_URL . "views/user_list.php");
exit;
