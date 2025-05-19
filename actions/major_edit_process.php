<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

$id = intval($_POST['id']);
$major_lao = trim($_POST['major_lao']);
$major_en = trim($_POST['major_en']);
$category_id = $_POST['category_id'] !== '' ? intval($_POST['category_id']) : null;

if ($major_lao && $major_en) {
  $stmt = $pdo->prepare("UPDATE majors SET major_lao = ?, major_en = ?, category_id = ? WHERE id = ?");
  $stmt->execute([$major_lao, $major_en, $category_id, $id]);
}

header("Location: " . BASE_URL . "views/major_list.php");
exit;
