<?php
require_once(__DIR__ . '/../config/config.php');

// ถ้า login แล้ว → ไม่ต้องสมัครซ้ำ
session_start();
if (isset($_SESSION['user'])) {
  header("Location: " . BASE_URL . "views/dashboard.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="lo">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Certificate System</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-tr from-blue-500 to-purple-600 min-h-screen flex items-center justify-center">

  <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">📝 ລົງທະບຽນຜູ້ໃຊ້</h2>

    <?php if (isset($_GET['error'])): ?>
      <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 rounded">
        ⚠ <?= htmlspecialchars($_GET['error']) ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
      <div class="bg-green-100 text-green-700 px-4 py-2 mb-4 rounded">
        ✅ <?= htmlspecialchars($_GET['success']) ?>
      </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>actions/register_process.php" method="POST" class="space-y-4">
      <div>
        <label class="block text-gray-700 mb-1">👤 ຊື່ຜູ້ໃຊ້</label>
        <input type="text" name="username" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">📧 Email</label>
        <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">🔒 ລະຫັດຜ່ານ</label>
        <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">🔑 ສິດທິ</label>
        <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded">
          <option value="admin">Admin</option>
          <option value="staff" selected>Staff</option>
        </select>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
        ລົງທະບຽນ
      </button>

      <p class="text-sm text-center text-gray-500 pt-2">
        ມີບັນຊີແລ້ວ? <a href="<?= BASE_URL ?>views/login.php" class="text-blue-600 hover:underline">ກົດເຂົ້າລະບົບ</a>
      </p>
    </form>
  </div>

</body>
</html>
