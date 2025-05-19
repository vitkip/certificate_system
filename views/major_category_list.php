<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

$stmt = $pdo->query("SELECT * FROM major_categories ORDER BY id DESC");
$categories = $stmt->fetchAll();
?>

<?php include('header.php'); ?>

<main class="flex-1 p-6">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold">🏷 ລາຍຊື່ໝວດສາຂາ</h2>
    <a href="<?= BASE_URL ?>views/major_category_add.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">➕ ເພີ່ມໝວດໃໝ່</a>
  </div>

  <div class="overflow-x-auto bg-white rounded-xl shadow">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 text-left">#</th>
          <th class="px-4 py-2 text-left">ຊື່ (ລາວ)</th>
          <th class="px-4 py-2 text-left">ຊື່ (ອັງກິດ)</th>
          <th class="px-4 py-2 text-left">ຈັດການ</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php foreach ($categories as $index => $cat): ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"><?= $index + 1 ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($cat['category_name_lao']) ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($cat['category_name_en']) ?></td>
            <td class="px-4 py-2 space-x-2">
              <a href="<?= BASE_URL ?>views/major_category_edit.php?id=<?= $cat['id'] ?>" class="text-yellow-600 hover:underline">ແກ້ໄຂ</a>
              <a href="<?= BASE_URL ?>actions/major_category_delete.php?id=<?= $cat['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('ຢືນຢືນການລົບ?')">ລົບ</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('footer.php'); ?>
