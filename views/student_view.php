<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

if (!isset($_GET['id'])) {
  header('Location: ' . BASE_URL . 'views/student_list.php');
  exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT s.*, m.major_lao, a.year_name FROM students s
  LEFT JOIN majors m ON s.major_id = m.id
  LEFT JOIN academic_years a ON s.academic_year_id = a.id
  WHERE s.id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
  echo "<p class='text-red-600 text-center mt-4'>ບໍ່ພົບຂໍ້ມູນນັກຮຽນ</p>";
  exit;
}
?>

<?php include('header.php'); ?>

<main class="flex-1 p-6 max-w-3xl mx-auto">
  <h2 class="text-2xl font-bold mb-6">📄 ລາຍລະອຽດນັກຮຽນ</h2>

  <div class="bg-white p-6 rounded-xl shadow space-y-4">
    <?php if ($student['image']): ?>
      <img src="<?= BASE_URL . 'uploads/' . $student['image'] ?>" alt="Student Image" class="w-32 h-32 object-cover rounded-full mx-auto">
    <?php endif; ?>

    <p><strong>ລະຫັດນັກຮຽນ:</strong> <?= htmlspecialchars($student['std_code']) ?></p>
    <p><strong>ຊື່ (ພາສາລາວ):</strong> <?= htmlspecialchars($student['name_lao']) ?></p>
    <p><strong>ຊື່ (ອັງກິດ):</strong> <?= htmlspecialchars($student['name_en']) ?></p>
    <p><strong>ສະຖານທີເກີດ (ພາສາລາວ):</strong> <?= htmlspecialchars($student['birth_lao']) ?></p>
    <p><strong>Place of Birth (EN):</strong> <?= htmlspecialchars($student['birth_en']) ?></p>
    <p><strong>ແຂວງ (ພາສາລາວ):</strong> <?= htmlspecialchars($student['province_lao']) ?></p>
    <p><strong>Province (EN):</strong> <?= htmlspecialchars($student['province_en']) ?></p>
    <p><strong>ສາຂາວິຊາ:</strong> <?= htmlspecialchars($student['major_lao']) ?></p>
    <p><strong>ປີການສຶກສາ:</strong> <?= htmlspecialchars($student['year_name']) ?></p>
    <p><strong>ວັນທີເພີ່ມ:</strong> <?= htmlspecialchars($student['created_at']) ?></p>

    <div class="pt-4">
      <a href="student_edit.php?id=<?= $student['id'] ?>" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">✏️ ແກ້ໄຂ</a>
      <a href="student_list.php" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">🔙 ກັບຄືນ</a>
    </div>
  </div>
</main>

<?php include('footer.php'); ?>
