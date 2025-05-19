<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');
requireRole('admin');

$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
  echo "<p class='text-red-500 p-4'>❌ ບໍ່ພົບຜູ້ໃຊ້</p>";
  exit;
}
?>

<?php include('header.php'); ?>

<main class="flex-1 p-6 max-w-2xl mx-auto space-y-10">

  <!-- ✅ ฟอร์มแก้ไขข้อมูลผู้ใช้ -->
  <section>
    <h2 class="text-xl font-bold mb-4">🛠 ແກ້ໄຂຂໍ້ມູນ</h2>
    <form action="<?= BASE_URL ?>actions/user_update.php" method="POST" class="bg-white p-6 rounded-xl shadow space-y-4">
      <input type="hidden" name="id" value="<?= $user['id'] ?>">
      <div>
        <label class="block mb-1">👤 ຊື່ຜູ້ໃຊ້</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required class="w-full border px-4 py-2 rounded">
      </div>
      <div>
        <label class="block mb-1">📧 Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="w-full border px-4 py-2 rounded">
      </div>
      <div>
        <label class="block mb-1">🔑 ສິດທິ</label>
        <select name="role" class="w-full border px-4 py-2 rounded">
          <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
          <option value="staff" <?= $user['role'] === 'staff' ? 'selected' : '' ?>>Staff</option>
        </select>
      </div>
      <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
        💾 ບັນທຶກການແກ້ໄຂ
      </button>
    </form>
  </section>

  <!-- ✅ ฟอร์มเปลี่ยนรหัสผ่าน -->
<section>
  <h2 class="text-xl font-bold mb-4">🔒 ປ່ຽນລະຫັດຜ່ານ</h2>

  <?php if (isset($_GET['pw_error'])): ?>
    <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 rounded">
      ⚠ <?= htmlspecialchars($_GET['pw_error']) ?>
    </div>
  <?php endif; ?>

  <?php if (isset($_GET['pw_success'])): ?>
    <div class="bg-green-100 text-green-700 px-4 py-2 mb-4 rounded">
      ✅ <?= htmlspecialchars($_GET['pw_success']) ?>
    </div>
  <?php endif; ?>

  <form action="<?= BASE_URL ?>actions/user_change_password.php" method="POST" class="bg-white p-6 rounded-xl shadow space-y-4">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <div>
      <label class="block mb-1">🔑 ລະຫັດເກົ່າ</label>
      <input type="password" name="current_password" required class="w-full border px-4 py-2 rounded">
    </div>

    <div>
      <label class="block mb-1">🔐 ລະຫັດໃໝ່</label>
      <input type="password" name="new_password" required minlength="6" class="w-full border px-4 py-2 rounded">
    </div>

    <div>
      <label class="block mb-1">🔐 ຢືນຢັນລະຫັດໃໝ່</label>
      <input type="password" name="confirm_password" required minlength="6" class="w-full border px-4 py-2 rounded">
    </div>

    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
      🔁 ປ່ຽນລະຫັດຜ່ານ
    </button>
  </form>
</section>

</main>

<?php include('footer.php'); ?>
