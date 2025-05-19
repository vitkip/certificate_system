<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM major_categories WHERE id = ?");
$stmt->execute([$id]);
$cat = $stmt->fetch();

if (!$cat) {
  echo "<p class='p-4 text-red-500'>❌ ບໍ່ພົບໝວດ</p>";
  exit;
}
?>

<?php include('header.php'); ?>

<main class="flex-1 p-6 max-w-xl mx-auto">
  <h2 class="text-2xl font-bold mb-4">✏️ ແກ້ໄຂໝວດສາຂາ</h2>

  <form action="<?= BASE_URL ?>actions/major_category_edit_process.php" method="POST" class="bg-white p-6 rounded-xl shadow space-y-4">
    <input type="hidden" name="id" value="<?= $cat['id'] ?>">
    <div>
      <label class="block mb-1">ຊື່ (ລາວ)</label>
      <input type="text" name="category_name_lao" value="<?= htmlspecialchars($cat['category_name_lao']) ?>" required class="w-full border px-4 py-2 rounded">
    </div>
    <div>
      <label class="block mb-1">ຊື່ (ອັງກິດ)</label>
      <input type="text" name="category_name_en" value="<?= htmlspecialchars($cat['category_name_en']) ?>" required class="w-full border px-4 py-2 rounded">
    </div>
    <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">💾 ບັນທຶກການແກ້ໄຂ</button>
  </form>
</main>

<?php include('footer.php'); ?>
