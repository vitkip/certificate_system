<?php
// config/config.php

// ตั้ง BASE_PATH สำหรับใช้งานเป็น path หลักในทุกหน้า
define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// URL หลัก (แก้ให้ตรงกับ domain หรือ localhost ของคุณ)
define('BASE_URL', 'http://localhost/certificate/');

// การเชื่อมต่อฐานข้อมูลด้วย PDO
$host = '127.0.0.1';
$db   = 'certificate-system';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // แจ้ง error ชัดเจน
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // คืนค่าเป็น array
    PDO::ATTR_EMULATE_PREPARES   => false,                  // ป้องกัน SQL injection
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}
?>
