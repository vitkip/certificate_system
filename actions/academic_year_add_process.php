// ✅ actions/academic_year_add_process.php
<?php
require_once('../config/config.php');
session_start();
$year = trim($_POST['year_name']);
if ($year !== '') {
  $stmt = $pdo->prepare("INSERT INTO academic_years (year_name) VALUES (?)");
  $stmt->execute([$year]);
}
header("Location: ../views/academic_year_list.php");
exit;