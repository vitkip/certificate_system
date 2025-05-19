<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

$id = intval($_GET['id'] ?? 0);

// ตรวจสอบว่ามีการใช้งานหรือไม่ก่อนลบ (optional)
$stmt = $pdo->prepare("DELETE FROM majors WHERE id = ?");
$stmt->execute([$id]);

header("Location: " . BASE_URL . "views/major_list.php");
exit;
