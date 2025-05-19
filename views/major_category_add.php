<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');
?>

<?php include('header.php'); ?>

<main class="flex-1 p-6 max-w-xl mx-auto">
  <h2 class="text-2xl font-bold mb-4">➕ ເພີ່ມໝວດສາຂາ</h2>

  <form action="<?= BASE_URL ?>actions/major_category_add_process.php" method="POST" class="bg-white p-6 rounded-xl shadow space-y-4">
    <div>
      <label class="block mb-1">ຊື່ (ພາສາລາວ)</label>
      <input type="text" name="category_name_lao" required class="w-full border px-4 py-2 rounded">
    </div>
    <div>
      <label class="block mb-1">ຊື່ (ອັງກິດ)</label>
      <input type="text" name="category_name_en" required class="w-full border px-4 py-2 rounded">
    </div>
    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">💾 ເພີ່ມ</button>
  </form>
</main>

<?php include('footer.php'); ?>
