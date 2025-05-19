<?php
require_once(__DIR__ . '/../config/config.php');
session_start();

$id = intval($_GET['id'] ?? 0);

// ลบหมวดหมู่
$stmt = $pdo->prepare("DELETE FROM major_categories WHERE id = ?");
$stmt->execute([$id]);

header("Location: " . BASE_URL . "views/major_category_list.php");
exit;
