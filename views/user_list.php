<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Total count
$total_stmt = $pdo->query("SELECT COUNT(*) FROM users");
$total_users = $total_stmt->fetchColumn();
$total_pages = ceil($total_users / $limit);

// ดึงข้อมูลผู้ใช้
$stmt = $pdo->prepare("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll();
?>

<?php include('header.php'); ?>

<main class="flex-1 p-6">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold text-gray-800">🧑‍💻 ລາຍຊື່ຜູ້ໃຊ້</h2>
    <a href="<?= BASE_URL ?>views/register.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">➕ ເພີ່ມຜູ້ໃຊ້</a>
  </div>

  <div class="overflow-x-auto bg-white rounded-xl shadow mb-4">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 text-left">#</th>
          <th class="px-4 py-2 text-left">👤 ຊື່ຜູ້ໃຊ້</th>
          <th class="px-4 py-2 text-left">📧 Email</th>
          <th class="px-4 py-2 text-left">🔑 ສິດທິ</th>
          <th class="px-4 py-2 text-left">🛠 ຈັດການ</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php foreach ($users as $index => $user): ?>
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-2"><?= $offset + $index + 1 ?></td>
          <td class="px-4 py-2"><?= htmlspecialchars($user['username']) ?></td>
          <td class="px-4 py-2"><?= htmlspecialchars($user['email']) ?></td>
          <td class="px-4 py-2 capitalize">
            <?= $user['role'] ?>
            <?php if ($_SESSION['user']['id'] !== $user['id']): ?>
              <form action="<?= BASE_URL ?>actions/change_role.php" method="POST" class="inline-block ml-2">
                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                <input type="hidden" name="new_role" value="<?= $user['role'] === 'admin' ? 'staff' : 'admin' ?>">
                <button type="submit" class="text-blue-500 hover:underline text-xs">[ແປງເປັນ <?= $user['role'] === 'admin' ? 'staff' : 'admin' ?>]</button>
              </form>
            <?php endif; ?>
          </td>
          <td class="px-4 py-2 space-x-2">
            <a href="<?= BASE_URL ?>views/user_edit.php?id=<?= $user['id'] ?>" class="text-yellow-600 hover:underline">ແກ້ໄຂ</a>
            <?php if ($_SESSION['user']['id'] !== $user['id']): ?>
              <a href="<?= BASE_URL ?>actions/user_delete.php?id=<?= $user['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('ຍືນຢືນການລົບ?')">ລົບ</a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="flex justify-center space-x-2 text-sm">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <a href="?page=<?= $i ?>" class="px-3 py-1 rounded <?= $i === $page ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' ?>">
        <?= $i ?>
      </a>
    <?php endfor; ?>
  </div>
</main>

<?php include('footer.php'); ?>
