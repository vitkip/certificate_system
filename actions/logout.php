<?php
require_once(__DIR__ . '/../config/config.php');

// เริ่ม session
session_start();

// ล้างข้อมูล session ทั้งหมด
$_SESSION = [];
session_destroy();

// กลับไปหน้า login
header("Location: " . BASE_URL . "views/login.php");
exit;
