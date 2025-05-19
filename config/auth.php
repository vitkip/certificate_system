<?php
// config/auth.php

// เริ่ม session ถ้ายังไม่เริ่ม
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ตรวจสอบว่ามีการ login หรือไม่
if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'views/login.php');
    exit;
}

// ฟังก์ชันตรวจสอบสิทธิ์ role
function requireRole($role = 'admin') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $role) {
        echo "<h2>🚫 Access Denied</h2>";
        exit;
    }
}
?>
