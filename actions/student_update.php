<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

$id = intval($_POST['id']);
$std_code = trim($_POST['std_code']);
$name_lao = trim($_POST['name_lao']);
$name_en = trim($_POST['name_en']);
$birth_lao = trim($_POST['birth_lao']);
$birth_en = trim($_POST['birth_en']);
$province_lao = trim($_POST['province_lao']);
$province_en = trim($_POST['province_en']);
$major_id = $_POST['major_id'] !== '' ? intval($_POST['major_id']) : null;
$academic_year_id = $_POST['academic_year_id'] !== '' ? intval($_POST['academic_year_id']) : null;

// ดึงชื่อไฟล์เดิมก่อน
$stmt = $pdo->prepare("SELECT image FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();
$image_name = $student['image'];

// ถ้ามีการอัปโหลดใหม่ ให้เขียนทับ
if (!empty($_FILES['image']['name'])) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $new_name = $image_name ?? uniqid('img_') . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], BASE_PATH . 'uploads/' . $new_name);
    $image_name = $new_name;
}

// อัปเดตข้อมูล
$stmt = $pdo->prepare("UPDATE students SET std_code=?, name_lao=?, name_en=?, birth_lao=?, birth_en=?, province_lao=?, province_en=?, major_id=?, academic_year_id=?, image=? WHERE id=?");
$stmt->execute([
    $std_code, $name_lao, $name_en, $birth_lao, $birth_en,
    $province_lao, $province_en, $major_id, $academic_year_id,
    $image_name, $id
]);

header("Location: ../views/student_list.php");
exit;
