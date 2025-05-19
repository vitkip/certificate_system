<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

// ตรวจสอบว่ามีการส่ง ID มาหรือไม่
if (!isset($_POST['id']) || empty($_POST['id'])) {
  $_SESSION['error'] = "❌ ຂໍ້ມູນບໍ່ຖືກຕ້ອງ";
  header("Location: " . BASE_URL . "views/student_list.php");
  exit;
}

// ดึงข้อมูลจากฟอร์ม
$id = intval($_POST['id']);
$std_code = trim($_POST['std_code']);
$name_lao = trim($_POST['name_lao']);
$name_en = trim($_POST['name_en']);
$province_lao = trim($_POST['province_lao']);
$province_en = trim($_POST['province_en']);
$major_id = intval($_POST['major_id']);
$academic_year_id = intval($_POST['academic_year_id']);

// ตรวจสอบข้อมูลที่จำเป็น
if (empty($std_code) || empty($name_lao) || empty($name_en)) {
  $_SESSION['error'] = "❌ ກະລຸນາປ້ອນຂໍ້ມູນທີ່ຈຳເປັນໃຫ້ຄົບຖ້ວນ";
  header("Location: " . BASE_URL . "views/student_edit.php?id=" . $id);
  exit;
}

// จัดการกับวันเดือนปีเกิด
// ตรวจสอบว่ามีการส่งข้อมูลวันเดือนปีเกิดแบบ dropdown มาหรือไม่
if (isset($_POST['birth_day_lao']) && isset($_POST['birth_month_lao']) && isset($_POST['birth_year_lao'])) {
  $birth_day_lao = $_POST['birth_day_lao'];
  $birth_month_lao = $_POST['birth_month_lao'];
  $birth_year_lao = $_POST['birth_year_lao'];
  
  if (!empty($birth_day_lao) && !empty($birth_month_lao) && !empty($birth_year_lao)) {
    $birth_lao = $birth_year_lao . "-" . str_pad($birth_month_lao, 2, "0", STR_PAD_LEFT) . "-" . str_pad($birth_day_lao, 2, "0", STR_PAD_LEFT);
  } else {
    $birth_lao = null;
  }
  
  $birth_day_en = $_POST['birth_day_en'];
  $birth_month_en = $_POST['birth_month_en'];
  $birth_year_en = $_POST['birth_year_en'];
  
  if (!empty($birth_day_en) && !empty($birth_month_en) && !empty($birth_year_en)) {
    $birth_en = $birth_year_en . "-" . str_pad($birth_month_en, 2, "0", STR_PAD_LEFT) . "-" . str_pad($birth_day_en, 2, "0", STR_PAD_LEFT);
  } else {
    $birth_en = null;
  }
} else {
  // ถ้าไม่มีการส่งข้อมูลแบบ dropdown ให้ใช้ข้อมูลจาก hidden fields
  $birth_lao = !empty($_POST['birth_lao']) ? $_POST['birth_lao'] : null;
  $birth_en = !empty($_POST['birth_en']) ? $_POST['birth_en'] : null;
}

// ดึงข้อมูลนักเรียนเดิมเพื่อตรวจสอบรูปภาพ
$stmt = $pdo->prepare("SELECT image FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();
$old_image = $student['image'];

// จัดการกับการอัปโหลดรูปภาพ (ถ้ามี)
$image = $old_image; // ใช้รูปเดิมถ้าไม่มีการอัปโหลดใหม่

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
  $upload_dir = __DIR__ . '/../uploads/students/';
  
  // สร้างโฟลเดอร์หากยังไม่มี
  if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
  }
  
  $file_tmp = $_FILES['image']['tmp_name'];
  $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
  $file_name = uniqid() . '.' . $file_ext;
  
  // ตรวจสอบนามสกุลไฟล์
  $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
  if (!in_array($file_ext, $allowed_exts)) {
    $_SESSION['error'] = "❌ ສາມາດອັບໂຫລດ JPG, JPEG, PNG, GIF ໄດ້ເທົ່ານັ້ນ";
    header("Location: " . BASE_URL . "views/student_edit.php?id=" . $id);
    exit;
  }
  
  // ตรวจสอบขนาดไฟล์ (ไม่เกิน 2MB)
  if ($_FILES['image']['size'] > 2097152) {
    $_SESSION['error'] = "❌ ຂະໜາດຮູບຕ້ອງບໍ່ເກີນ 2MB";
    header("Location: " . BASE_URL . "views/student_edit.php?id=" . $id);
    exit;
  }
  
  // อัปโหลดไฟล์
  if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
    $image = $file_name;
    
    // ลบรูปเก่าหากมีการอัปโหลดรูปใหม่และรูปเก่าไม่ใช่รูป default
    if (!empty($old_image) && file_exists($upload_dir . $old_image)) {
      unlink($upload_dir . $old_image);
    }
  } else {
    $_SESSION['error'] = "❌ ເກີດຂໍ້ຜິດພາດໃນການອັບໂຫລດຮູບ";
    header("Location: " . BASE_URL . "views/student_edit.php?id=" . $id);
    exit;
  }
}

// อัปเดตข้อมูลในฐานข้อมูล
try {
  $sql = "UPDATE students SET 
            std_code = ?, 
            name_lao = ?, 
            name_en = ?, 
            birth_lao = ?, 
            birth_en = ?, 
            province_lao = ?, 
            province_en = ?, 
            major_id = ?, 
            academic_year_id = ?, 
            image = ?, 
            updated_at = NOW() 
          WHERE id = ?";
          
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $std_code,
    $name_lao,
    $name_en,
    $birth_lao,
    $birth_en,
    $province_lao,
    $province_en,
    $major_id,
    $academic_year_id,
    $image,
    $id
  ]);
  
  $_SESSION['success'] = "✅ ແກ້ໄຂຂໍ້ມູນນັກຮຽນສຳເລັດແລ້ວ";
} catch (PDOException $e) {
  $_SESSION['error'] = "❌ ເກີດຂໍ້ຜິດພາດ: " . $e->getMessage();
}

// กลับไปยังหน้ารายการนักเรียน
header("Location: " . BASE_URL . "views/student_list.php");
exit;
