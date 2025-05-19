<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');
include('header.php');
?>
<main class="p-6 max-w-xl mx-auto">
  <h2 class="text-2xl font-bold mb-4">➕ ເພີ່ມປີການສຶກສາ</h2>
  <form action="../actions/academic_year_add_process.php" method="POST" class="bg-white p-6 shadow rounded space-y-4">
    <input type="text" name="year_name" required placeholder="ປີການສຶກສາ" class="w-full border px-4 py-2 rounded">
    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">💾 ເພີ່ມ</button>
  </form>
</main>
<?php include('footer.php'); ?>