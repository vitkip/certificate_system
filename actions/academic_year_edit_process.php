// ✅ actions/academic_year_edit_process.php
<?php
require_once('../config/config.php');
session_start();
$id = intval($_POST['id']);
$year = trim($_POST['year_name']);
if ($year !== '') {
  $stmt = $pdo->prepare("UPDATE academic_years SET year_name = ? WHERE id = ?");
  $stmt->execute([$year, $id]);
}
header("Location: ../views/academic_year_list.php");
exit;
