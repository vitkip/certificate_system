<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM academic_years WHERE id = ?");
$stmt->execute([$id]);
$year = $stmt->fetch();
include('header.php');
?>
<main class="p-6 max-w-xl mx-auto">
  <h2 class="text-2xl font-bold mb-4">✏️ ແກ້ໄຂປີການສຶກສາ</h2>
  <form action="../actions/academic_year_edit_process.php" method="POST" class="bg-white p-6 shadow rounded space-y-4">
    <input type="hidden" name="id" value="<?= $year['id'] ?>">
    <input type="text" name="year_name" value="<?= htmlspecialchars($year['year_name']) ?>" required class="w-full border px-4 py-2 rounded">
    <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded">💾 ບັນທຶກ</button>
  </form>
</main>
<?php include('footer.php'); ?>
