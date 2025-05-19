<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

$q = $_GET['q'] ?? '';
$students = [];

if ($q !== '') {
  $sql = "SELECT s.*, m.major_lao, y.year_name FROM students s
          LEFT JOIN majors m ON s.major_id = m.id
          LEFT JOIN academic_years y ON s.academic_year_id = y.id
          WHERE s.name_lao LIKE :q OR s.std_code LIKE :q
          ORDER BY s.id DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':q' => "%$q%"]);
} else {
  $sql = "SELECT s.*, m.major_lao, y.year_name FROM students s
          LEFT JOIN majors m ON s.major_id = m.id
          LEFT JOIN academic_years y ON s.academic_year_id = y.id
          ORDER BY s.id DESC";
  $stmt = $pdo->query($sql);
}
$students = $stmt->fetchAll();
?>

<?php include('header.php'); ?>

<main class="flex-1 p-6 max-w-2xl mx-auto">
  <div class="flex justify-between items-center mb-4">
    <form method="GET" class="flex gap-2 w-full">
      <input name="q" value="<?= htmlspecialchars($q) ?>" placeholder="ຄົ້ນຫາຊື່ ຫຼື ລະຫັດ" class="border px-4 py-2 rounded w-full">
      <button class="bg-blue-600 text-white px-4 py-2 rounded">🔍 ຄົ້ນຫາ</button>
    </form>
    <a href="student_add.php" class="ml-4 bg-green-600 text-white px-4 py-2 rounded">➕ ເພີ່ມນັກຮຽນ</a>
  </div>
  <form method="POST" action="<?= BASE_URL ?>actions/student_bulk_delete.php">
    <div class="overflow-x-auto">
      <table class="w-full bg-white text-sm rounded shadow">
        <thead class="bg-gray-100">
          <tr>
            <th><input type="checkbox" onclick="document.querySelectorAll('[name=\'ids[]\']').forEach(cb => cb.checked = this.checked)"></th>
            <th>#</th><th>ລະຫັດ</th><th>ຮູບພາບ</th><th>ຊື່</th><th>ສາຂາ</th><th>ປີ</th><th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($students as $i => $s): ?>
          <tr class="hover:bg-gray-50">
            <td><input type="checkbox" name="ids[]" value="<?= $s['id'] ?>"></td>
            <td><?= $i + 1 ?></td>           
            <td><?= htmlspecialchars($s['std_code']) ?></td>
            <td>
              <?php if (!empty($s['image'])): ?>
                <img src="../uploads/<?= htmlspecialchars($s['image']) ?>" width="40">
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($s['name_lao']) ?></td>
            <td><?= htmlspecialchars($s['major_lao']) ?></td>
            <td><?= htmlspecialchars($s['year_name']) ?></td>         
            <td>
              <a href="student_edit.php?id=<?= $s['id'] ?>" class="text-yellow-600 hover:underline">ແກ້ໄຂ</a>
              <a href="../actions/student_delete.php?id=<?= $s['id'] ?>" class="text-red-600 hover:underline ml-2" onclick="return confirm('ຢືນຢືນການລົບ?')">ລົບ</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <button type="submit" class="mt-4 bg-red-600 text-white px-4 py-2 rounded" onclick="return confirm('ຢືນຢືນການລົບນັກຮຽນຫຼາຍລາຍການ?')">
      🗑 ລົບທີ່ເລືອກ
    </button>
  </form>
</main>

<?php include('footer.php'); ?>
