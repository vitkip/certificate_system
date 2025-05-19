<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

// รับค่า ID
$id = intval($_GET['id'] ?? 0);

// ตรวจสอบและดึงข้อมูลนักเรียน
$stmt = $pdo->prepare("SELECT image FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if ($student) {
  // ลบไฟล์ภาพถ้ามี
  if (!empty($student['image'])) {
    $image_path = BASE_PATH . 'uploads/' . $student['image'];
    if (file_exists($image_path)) {
      unlink($image_path);
    }
  }

  // ลบข้อมูลนักเรียนจาก DB
  $del = $pdo->prepare("DELETE FROM students WHERE id = ?");
  $del->execute([$id]);
}

// กลับไปหน้า list
header("Location: " . BASE_URL . "views/student_list.php");
exit;
