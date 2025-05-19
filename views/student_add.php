<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

$majors = $pdo->query("SELECT id, major_lao FROM majors")->fetchAll();
$years = $pdo->query("SELECT id, year_name FROM academic_years")->fetchAll();
?>

<?php include('header.php'); ?>

<main class="flex-1 p-6 max-w-2xl mx-auto">
  <h2 class="text-2xl font-bold mb-4">➕ ເພີ່ມນັກຮຽນ</h2>

  <form action="<?= BASE_URL ?>actions/student_save.php" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-xl shadow">
    <input type="text" name="std_code" placeholder="ລະຫັດນັກຮຽນ" required class="w-full border px-4 py-2 rounded">
    <input type="text" name="name_lao" placeholder="ຊື່ (ພາສາລາວ)" required class="w-full border px-4 py-2 rounded">
    <input type="text" name="name_en" placeholder="ຊື່ (ອັງກິດ)" required class="w-full border px-4 py-2 rounded">

    <input type="text" name="birth_lao" placeholder="ສະຖານທີເກີດ (ພາສາລາວ)" class="w-full border px-4 py-2 rounded">
    <input type="text" name="birth_en" placeholder="Place of Birth (English)" class="w-full border px-4 py-2 rounded">

    <input type="text" name="province_lao" placeholder="ແຂວງ (ພາສາລາວ)" class="w-full border px-4 py-2 rounded">
    <input type="text" name="province_en" placeholder="Province (English)" class="w-full border px-4 py-2 rounded">

    <select name="major_id" required class="w-full border px-4 py-2 rounded">
      <option value="">-- ເລືອກສາຂາ --</option>
      <?php foreach ($majors as $m): ?>
        <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['major_lao']) ?></option>
      <?php endforeach; ?>
    </select>

    <select name="academic_year_id" required class="w-full border px-4 py-2 rounded">
      <option value="">-- ເລືອກປີການສຶກສາ --</option>
      <?php foreach ($years as $y): ?>
        <option value="<?= $y['id'] ?>"><?= htmlspecialchars($y['year_name']) ?></option>
      <?php endforeach; ?>
    </select>

    <input type="file" name="image" accept="image/*" class="w-full border px-4 py-2 rounded">

    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">💾 ເພີ່ມ</button>
  </form>
</main>

<?php include('footer.php'); ?>
