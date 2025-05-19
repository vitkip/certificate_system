<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

// ดึงข้อมูล majors + category
$sql = "
  SELECT m.id, m.major_lao, m.major_en, c.category_name_lao 
  FROM majors m
  LEFT JOIN major_categories c ON m.category_id = c.id
  ORDER BY m.id DESC
";
$stmt = $pdo->query($sql);
$majors = $stmt->fetchAll();
?>

<?php include('header.php'); ?>

<main class="flex-1 p-6">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold">📚 ລາຍຊື່ສາຂາວິຊາ</h2>
    <a href="<?= BASE_URL ?>views/major_add.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
      ➕ ເພີ່ມສາຂາໃໝ່
    </a>
  </div>
  

  <div class="overflow-x-auto bg-white rounded-xl shadow">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 text-left">#</th>
          <th class="px-4 py-2 text-left">📘 ຊື່ສາຂາ (ລາວ)</th>
          <th class="px-4 py-2 text-left">📖 ຊື່ສາຂາ (ອັງກິດ)</th>
          <th class="px-4 py-2 text-left">🏷 ໝວດສາຂາ</th>
          <th class="px-4 py-2 text-left">🛠 ຈັດການ</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php foreach ($majors as $index => $major): ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"><?= $index + 1 ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($major['major_lao']) ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($major['major_en']) ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($major['category_name_lao'] ?? '—') ?></td>
            <td class="px-4 py-2 space-x-2">
              <a href="<?= BASE_URL ?>views/major_edit.php?id=<?= $major['id'] ?>" class="text-yellow-600 hover:underline">ແກ້ໄຂ</a>
              <a href="<?= BASE_URL ?>actions/major_delete.php?id=<?= $major['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('ຢືນຢືນການລົບ?')">ລົບ</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('footer.php'); ?>
