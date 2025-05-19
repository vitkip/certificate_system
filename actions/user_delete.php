<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  die("Access denied.");
}

$user_id = intval($_GET['id'] ?? 0);

// ป้องกันลบตัวเอง
if ($_SESSION['user']['id'] == $user_id) {
  die("ບໍ່ສາມາດລົບຕົນເອງໄດ້");
}

$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);

header("Location: " . BASE_URL . "views/user_list.php");
exit;
