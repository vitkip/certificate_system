<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

$id = intval($_POST['id']);
$lao = trim($_POST['category_name_lao']);
$en = trim($_POST['category_name_en']);

if ($lao && $en) {
  $stmt = $pdo->prepare("UPDATE major_categories SET category_name_lao = ?, category_name_en = ? WHERE id = ?");
  $stmt->execute([$lao, $en, $id]);
}

header("Location: " . BASE_URL . "views/major_category_list.php");
exit;
