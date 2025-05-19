<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

$majors = $pdo->query("SELECT id, major_lao FROM majors")->fetchAll();
$years = $pdo->query("SELECT id, year_name FROM academic_years")->fetchAll();
?>

<?php include('header.php'); ?>

<main class="flex-1 p-6 max-w-2xl mx-auto">
  <h2 class="text-2xl font-bold mb-4">✏️ ແກ້ໄຂນັກຮຽນ</h2>

  <form action="<?= BASE_URL ?>actions/student_update.php" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-xl shadow">
    <input type="hidden" name="id" value="<?= $student['id'] ?>">

    <input type="text" name="std_code" value="<?= htmlspecialchars($student['std_code']) ?>" required class="w-full border px-4 py-2 rounded">
    <input type="text" name="name_lao" value="<?= htmlspecialchars($student['name_lao']) ?>" required class="w-full border px-4 py-2 rounded">
    <input type="text" name="name_en" value="<?= htmlspecialchars($student['name_en']) ?>" required class="w-full border px-4 py-2 rounded">

    <input type="text" name="birth_lao" value="<?= htmlspecialchars($student['birth_lao']) ?>" class="w-full border px-4 py-2 rounded">
    <input type="text" name="birth_en" value="<?= htmlspecialchars($student['birth_en']) ?>" class="w-full border px-4 py-2 rounded">

    <input type="text" name="province_lao" value="<?= htmlspecialchars($student['province_lao']) ?>" class="w-full border px-4 py-2 rounded">
    <input type="text" name="province_en" value="<?= htmlspecialchars($student['province_en']) ?>" class="w-full border px-4 py-2 rounded">

    <select name="major_id" required class="w-full border px-4 py-2 rounded">
      <option value="">-- ເລືອກສາຂາ --</option>
      <?php foreach ($majors as $m): ?>
        <option value="<?= $m['id'] ?>" <?= $student['major_id'] == $m['id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($m['major_lao']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <select name="academic_year_id" required class="w-full border px-4 py-2 rounded">
      <option value="">-- ເລືອກປີການສຶກສາ --</option>
      <?php foreach ($years as $y): ?>
        <option value="<?= $y['id'] ?>" <?= $student['academic_year_id'] == $y['id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($y['year_name']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <?php if (!empty($student['image'])): ?>
      <div>
        <p class="text-sm mb-1">ຮູບປັດຈຸບັນ:</p>
        <img src="../uploads/<?= htmlspecialchars($student['image']) ?>" width="80" class="rounded border">
      </div>
    <?php endif; ?>
    <input type="file" name="image" accept="image/*" class="w-full border px-4 py-2 rounded">

    <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">💾 ບັນທຶກການແກ້ໄຂ</button>
  </form>
</main>

<?php include('footer.php'); ?>