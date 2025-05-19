<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

$lao = trim($_POST['category_name_lao']);
$en = trim($_POST['category_name_en']);

if ($lao && $en) {
  $stmt = $pdo->prepare("INSERT INTO major_categories (category_name_lao, category_name_en) VALUES (?, ?)");
  $stmt->execute([$lao, $en]);
}

header("Location: " . BASE_URL . "views/major_category_list.php");
exit;
