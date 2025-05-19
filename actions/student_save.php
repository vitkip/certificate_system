<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

$std_code = trim($_POST['std_code']);
$name_lao = trim($_POST['name_lao']);
$name_en = trim($_POST['name_en']);
$birth_lao = trim($_POST['birth_lao']);
$birth_en = trim($_POST['birth_en']);
$province_lao = trim($_POST['province_lao']);
$province_en = trim($_POST['province_en']);
$major_id = $_POST['major_id'] !== '' ? intval($_POST['major_id']) : null;
$academic_year_id = $_POST['academic_year_id'] !== '' ? intval($_POST['academic_year_id']) : null;

$image_name = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $image_name = uniqid('img_') . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], BASE_PATH . 'uploads/' . $image_name);
}

$stmt = $pdo->prepare("INSERT INTO students (
    std_code, name_lao, name_en, birth_lao, birth_en,
    province_lao, province_en, major_id, academic_year_id, image
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->execute([
    $std_code, $name_lao, $name_en, $birth_lao, $birth_en,
    $province_lao, $province_en, $major_id, $academic_year_id, $image_name
]);

header("Location: ../views/student_list.php");
exit;
