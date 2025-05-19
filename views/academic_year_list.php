<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

$years = $pdo->query("SELECT * FROM academic_years ORDER BY id DESC")->fetchAll();
include('header.php');
?>
<main class="p-6 max-w-xl mx-auto">
  <div class="flex justify-between mb-4">
    <h2 class="text-2xl font-bold">📅 ປີການສຶກສາ</h2>
    <a href="academic_year_add.php" class="bg-blue-600 text-white px-4 py-2 rounded">➕ ເພີ່ມ</a>
  </div>

  <table class="w-full bg-white rounded shadow text-sm">
    <thead class="bg-gray-100">
      <tr><th>#</th><th>ປີ</th><th>ຈັດການ</th></tr>
    </thead>
    <tbody>
      <?php foreach ($years as $i => $y): ?>
        <tr class="hover:bg-gray-50">
          <td><?= $i + 1 ?></td>
          <td><?= htmlspecialchars($y['year_name']) ?></td>
          <td>
            <a href="academic_year_edit.php?id=<?= $y['id'] ?>" class="text-yellow-600">ແກ້ໄຂ</a>
            <a href="../actions/academic_year_delete.php?id=<?= $y['id'] ?>" class="text-red-600 ml-2" onclick="return confirm('ລົບ?')">ລົບ</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>
<?php include('footer.php'); ?>