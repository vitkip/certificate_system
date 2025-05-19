<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

// รับค่ารายการ checkbox ที่เลือก
$ids = $_POST['ids'] ?? [];

if (!empty($ids)) {
  // เตรียม placeholders สำหรับการค้นหารูปภาพ
  $placeholders = implode(',', array_fill(0, count($ids), '?'));
  
  // ดึงข้อมูลรูปภาพก่อนลบ
  $stmt = $pdo->prepare("SELECT id, image FROM students WHERE id IN ($placeholders)");
  $stmt->execute($ids);
  $students = $stmt->fetchAll();
  
  // ลบรูปภาพแต่ละรายการ
  foreach ($students as $student) {
    if (!empty($student['image'])) {
      $image_path = BASE_PATH . 'uploads/' . $student['image'];
      if (file_exists($image_path)) {
        unlink($image_path);
      }
    }
  }

  // ลบข้อมูลจากฐานข้อมูล
  $stmt = $pdo->prepare("DELETE FROM students WHERE id IN ($placeholders)");
  $stmt->execute($ids);
}

// กลับไปหน้ารายการนักเรียน
header("Location: " . BASE_URL . "views/student_list.php");
exit;
