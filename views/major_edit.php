<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM majors WHERE id = ?");
$stmt->execute([$id]);
$major = $stmt->fetch();

$cats = $pdo->query("SELECT id, category_name_lao FROM major_categories")->fetchAll();

if (!$major) {
  echo "<p class='p-4 text-red-500'>❌ ບໍ່ພົບຂໍ້ມູນ</p>";
  exit;
}
?>

<?php include('header.php'); ?>

<main class="flex-1 p-6 max-w-xl mx-auto">
  <h2 class="text-2xl font-bold mb-4">✏️ ແກ້ໄຂສາຂາ</h2>

  <form action="<?= BASE_URL ?>actions/major_edit_process.php" method="POST" class="space-y-4 bg-white p-6 rounded-xl shadow">
    <input type="hidden" name="id" value="<?= $major['id'] ?>">
    <div>
      <label class="block mb-1">📘 ຊື່ສາຂາ (ພາສາລາວ)</label>
      <input type="text" name="major_lao" value="<?= htmlspecialchars($major['major_lao']) ?>" required class="w-full border px-4 py-2 rounded">
    </div>
    <div>
      <label class="block mb-1">📖 ຊື່ສາຂາ (ອັງກິດ)</label>
      <input type="text" name="major_en" value="<?= htmlspecialchars($major['major_en']) ?>" required class="w-full border px-4 py-2 rounded">
    </div>
    <div>
      <label class="block mb-1">🏷 ໝວດສາຂາ</label>
      <select name="category_id" class="w-full border px-4 py-2 rounded">
        <option value="">-- ບໍ່ລະບຸ --</option>
        <?php foreach ($cats as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= $major['category_id'] == $cat['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['category_name_lao']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">💾 ບັນທຶກການແກ້ໄຂ</button>
  </form>
</main>

<?php include('footer.php'); ?>
