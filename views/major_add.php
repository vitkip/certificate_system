<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

// ดึง category มาแสดง
$cats = $pdo->query("SELECT id, category_name_lao FROM major_categories")->fetchAll();
?>

<?php include('header.php'); ?>

<main class="flex-1 p-6 max-w-xl mx-auto">
  <h2 class="text-2xl font-bold mb-4">➕ ເພີ່ມສາຂາໃໝ່</h2>

  <form action="<?= BASE_URL ?>actions/major_add_process.php" method="POST" class="space-y-4 bg-white p-6 rounded-xl shadow">
    <div>
      <label class="block mb-1">📘 ຊື່ສາຂາ (ພາສາລາວ)</label>
      <input type="text" name="major_lao" required class="w-full border px-4 py-2 rounded">
    </div>
    <div>
      <label class="block mb-1">📖 ຊື່ສາຂາ (ອັງກິດ)</label>
      <input type="text" name="major_en" required class="w-full border px-4 py-2 rounded">
    </div>
    <div>
      <label class="block mb-1">🏷 ໝວດສາຂາ</label>
      <select name="category_id" class="w-full border px-4 py-2 rounded">
        <option value="">-- ເລືອກໝວດ --</option>
        <?php foreach ($cats as $cat): ?>
          <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['category_name_lao']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">💾 ເພີ່ມ</button>
  </form>
</main>

<?php include('footer.php'); ?>
