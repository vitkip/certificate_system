// ✅ actions/academic_year_delete.php
<?php
require_once('../config/config.php');
session_start();
$id = intval($_GET['id'] ?? 0);
$pdo->prepare("DELETE FROM academic_years WHERE id = ?")->execute([$id]);
header("Location: ../views/academic_year_list.php");
exit;
