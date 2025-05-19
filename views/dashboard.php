<?php include('header.php'); ?>

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md h-screen hidden md:block">
  <nav class="px-4 py-6 space-y-4">
    <a href="<?= BASE_URL ?>views/dashboard.php" class="block py-2 px-4 rounded hover:bg-purple-100">🏠 Dashboard</a>
    <a href="<?= BASE_URL ?>views/student_list.php" class="block py-2 px-4 rounded hover:bg-purple-100">👥 ຈັດການນັກຮຽນ</a>
    <a href="<?= BASE_URL ?>views/certificate_list.php" class="block py-2 px-4 rounded hover:bg-purple-100">📜 ໃບປະກາດ</a>
    <a href="<?= BASE_URL ?>views/major_list.php" class="block py-2 px-4 rounded hover:bg-purple-100">📚 ສາຂາວິຊາ</a>
    <a href="<?= BASE_URL ?>views/major_category_list.php" class="block py-2 px-4 rounded hover:bg-purple-100">🗂️ ໝວດສາຂາ</a>
    <a href="<?= BASE_URL ?>views/academic_year_list.php" class="block py-2 px-4 rounded hover:bg-purple-100">📅 ປີການສຶກສາ</a>
    <a href="<?= BASE_URL ?>views/user_list.php" class="block py-2 px-4 rounded hover:bg-purple-100">🛠 ຜູ້ໃຊ້ລະບົບ</a>
  </nav>
</aside>

<!-- Main Content -->
<main class="flex-1 p-6">
  <h2 class="text-2xl font-bold mb-4">📊 ໜ້າຫຼັກ Dashboard</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-xl p-4 shadow text-center">
      <div class="text-purple-600 text-3xl">🎓</div>
      <p class="text-sm text-gray-500 mt-2">ນັກຮຽນທັງໝົດ</p>
      <p class="text-xl font-semibold">120</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow text-center">
      <div class="text-blue-600 text-3xl">📜</div>
      <p class="text-sm text-gray-500 mt-2">ໃບປະກາດທີ່ອອກແລ້ວ</p>
      <p class="text-xl font-semibold">89</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow text-center">
      <div class="text-green-600 text-3xl">📚</div>
      <p class="text-sm text-gray-500 mt-2">ສາຂາວິຊາ</p>
      <p class="text-xl font-semibold">8</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow text-center">
      <div class="text-red-600 text-3xl">🧑‍💻</div>
      <p class="text-sm text-gray-500 mt-2">Admin</p>
      <p class="text-xl font-semibold">3</p>
    </div>
  </div>
</main>

<?php include('footer.php'); ?>
