<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

// ดึงข้อมูลสาขาและปีการศึกษาเพื่อใช้ในตัวกรอง
$majors = $pdo->query("SELECT id, major_lao FROM majors ORDER BY major_lao")->fetchAll();
$years = $pdo->query("SELECT id, year_name FROM academic_years ORDER BY year_name DESC")->fetchAll();

// รับค่าพารามิเตอร์สำหรับการค้นหาและกรอง
$q = $_GET['q'] ?? '';
$major_id = isset($_GET['major_id']) ? intval($_GET['major_id']) : 0;
$year_id = isset($_GET['year_id']) ? intval($_GET['year_id']) : 0;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$per_page = 10; // จำนวนรายการต่อหน้า

// สร้าง SQL query พื้นฐาน
$sql_base = "FROM students s
             LEFT JOIN majors m ON s.major_id = m.id
             LEFT JOIN academic_years y ON s.academic_year_id = y.id
             WHERE 1=1";
$params = [];

// เพิ่มเงื่อนไขการค้นหา
if ($q !== '') {
    $sql_base .= " AND (s.name_lao LIKE :q OR s.name_en LIKE :q OR s.std_code LIKE :q)";
    $params[':q'] = "%$q%";
}

if ($major_id > 0) {
    $sql_base .= " AND s.major_id = :major_id";
    $params[':major_id'] = $major_id;
}

if ($year_id > 0) {
    $sql_base .= " AND s.academic_year_id = :year_id";
    $params[':year_id'] = $year_id;
}

// ดึงจำนวนรายการทั้งหมดเพื่อทำ pagination
$count_sql = "SELECT COUNT(*) as total " . $sql_base;
$count_stmt = $pdo->prepare($count_sql);
$count_stmt->execute($params);
$total_records = $count_stmt->fetch()['total'];
$total_pages = ceil($total_records / $per_page);

// ปรับค่าหน้าให้ถูกต้อง
if ($page < 1) $page = 1;
if ($page > $total_pages && $total_pages > 0) $page = $total_pages;

// คำนวณ offset สำหรับการดึงข้อมูล
$offset = ($page - 1) * $per_page;

// ดึงข้อมูลนักเรียนตามเงื่อนไขและการแบ่งหน้า
$sql = "SELECT s.*, m.major_lao, m.major_en, y.year_name " . $sql_base . " ORDER BY s.id DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);

// เพิ่มพารามิเตอร์สำหรับ LIMIT และ OFFSET
$params[':limit'] = $per_page;
$params[':offset'] = $offset;

// ต้องใส่ PDO::PARAM_INT เพื่อให้ bindValue ทำงานถูกต้องกับ LIMIT และ OFFSET
foreach ($params as $key => $value) {
    if ($key == ':limit' || $key == ':offset') {
        $stmt->bindValue($key, $value, PDO::PARAM_INT);
    } else {
        $stmt->bindValue($key, $value);
    }
}

$stmt->execute();
$students = $stmt->fetchAll();

// ตรวจสอบข้อความแจ้งเตือน
$error_message = $_SESSION['error'] ?? '';
$success_message = $_SESSION['success'] ?? '';

// ล้างข้อความหลังจากใช้งาน
if (isset($_SESSION['error'])) unset($_SESSION['error']);
if (isset($_SESSION['success'])) unset($_SESSION['success']);
?>

<?php include('header.php'); ?>

<main class="flex-1 bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
      <div class="flex flex-col md:flex-row md:items-end md:justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">ລາຍການນັກຮຽນ</h1>
          <p class="mt-2 text-sm text-gray-600">ຈັດການຂໍ້ມູນນັກຮຽນໃນລະບົບ</p>
        </div>
        <div class="mt-4 md:mt-0 flex">
          <a href="student_add.php" 
             class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg shadow flex items-center justify-center transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            ເພີ່ມນັກຮຽນໃໝ່
          </a>
        </div>
      </div>
    </div>
    
    <!-- Alerts -->
    <?php if (!empty($success_message)): ?>
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-md shadow-sm">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm text-green-700"><?= $success_message ?></p>
        </div>
        <div class="ml-auto pl-3">
          <div class="-mx-1.5 -my-1.5">
            <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()" 
                    class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none">
              <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($error_message)): ?>
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md shadow-sm">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm text-red-700"><?= $error_message ?></p>
        </div>
        <div class="ml-auto pl-3">
          <div class="-mx-1.5 -my-1.5">
            <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()" 
                    class="inline-flex rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none">
              <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    
    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
      <form method="GET" class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2">
          <label for="q" class="block text-sm font-medium text-gray-700 mb-1">ຄົ້ນຫາ</label>
          <div class="relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
            </div>
            <input type="text" name="q" id="q" value="<?= htmlspecialchars($q) ?>" 
                   class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                   placeholder="ຄົ້ນຫາຊື່, ລະຫັດນັກຮຽນ">
          </div>
        </div>
        
        <div>
          <label for="major_id" class="block text-sm font-medium text-gray-700 mb-1">ສາຂາ</label>
          <select name="major_id" id="major_id" 
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            <option value="0">-- ທັງໝົດ --</option>
            <?php foreach ($majors as $major): ?>
              <option value="<?= $major['id'] ?>" <?= $major_id == $major['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($major['major_lao']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div>
          <label for="year_id" class="block text-sm font-medium text-gray-700 mb-1">ປີການສຶກສາ</label>
          <select name="year_id" id="year_id"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            <option value="0">-- ທັງໝົດ --</option>
            <?php foreach ($years as $year): ?>
              <option value="<?= $year['id'] ?>" <?= $year_id == $year['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($year['year_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div class="md:col-span-4 flex space-x-3">
          <button type="submit" 
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow flex items-center transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
            ຄົ້ນຫາ
          </button>
          
          <a href="<?= BASE_URL ?>views/student_list.php" 
             class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded shadow flex items-center transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
            </svg>
            ລ້າງຕົວກອງ
          </a>
        </div>
      </form>
    </div>
    
    <!-- Student List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
      <div class="px-4 py-5 sm:p-6">
        <?php if ($total_records > 0): ?>
          <div class="mb-3 text-sm text-gray-500">
            ພົບ <b><?= $total_records ?></b> ລາຍການ, 
            ສະແດງຜົນ <b><?= ($page - 1) * $per_page + 1 ?> - <?= min($page * $per_page, $total_records) ?></b>
          </div>
          
          <form method="POST" action="<?= BASE_URL ?>actions/student_bulk_delete.php" id="bulk-form">
            <div class="overflow-x-auto rounded-lg border border-gray-200">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-3 py-3 text-left">
                      <div class="flex items-center">
                        <input type="checkbox" id="select-all" 
                               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="select-all" class="sr-only">Select All</label>
                      </div>
                    </th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ຮູບພາບ</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ລະຫັດ</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ຊື່ນັກຮຽນ</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ສາຂາ</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ປີການສຶກສາ</th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ຈັດການ</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <?php foreach ($students as $student): ?>
                  <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-3 py-4 whitespace-nowrap">
                      <input type="checkbox" name="ids[]" value="<?= $student['id'] ?>" 
                             class="student-checkbox h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap">
                      <?php if (!empty($student['image'])): ?>
                        <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-100 border">
                          <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($student['image']) ?>" 
                               alt="<?= htmlspecialchars($student['name_lao']) ?>" 
                               class="h-full w-full object-cover">
                        </div>
                      <?php else: ?>
                        <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-100 border flex items-center justify-center">
                          <svg class="h-8 w-8 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                          </svg>
                        </div>
                      <?php endif; ?>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                      <?= htmlspecialchars($student['std_code']) ?>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap">
                      <div class="text-sm font-medium text-gray-900">
                        <?= htmlspecialchars($student['name_lao']) ?>
                      </div>
                      <div class="text-sm text-gray-500">
                        <?= htmlspecialchars($student['name_en']) ?>
                      </div>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap">
                      <div class="text-sm font-medium text-gray-900">
                        <?= htmlspecialchars($student['major_lao']) ?>
                      </div>
                      <div class="text-sm text-gray-500">
                        <?= htmlspecialchars($student['major_en'] ?? '') ?>
                      </div>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                      <?= htmlspecialchars($student['year_name']) ?>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                      <div class="flex space-x-2">
                        <a href="<?= BASE_URL ?>views/student_edit.php?id=<?= $student['id'] ?>" 
                           class="text-yellow-600 hover:text-yellow-900 rounded-full p-1 hover:bg-yellow-100 transition-all">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                          </svg>
                        </a>
                        <a href="javascript:void(0)" 
                           onclick="confirmDelete(<?= $student['id'] ?>, '<?= htmlspecialchars(addslashes($student['name_lao'])) ?>')"
                           class="text-red-600 hover:text-red-900 rounded-full p-1 hover:bg-red-100 transition-all">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                          </svg>
                        </a>
                        <a href="<?= BASE_URL ?>views/student_view.php?id=<?= $student['id'] ?>" 
                           class="text-blue-600 hover:text-blue-900 rounded-full p-1 hover:bg-blue-100 transition-all">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                          </svg>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            
            <!-- Bulk Actions -->
            <div class="mt-4 flex items-center space-x-3">
              <button type="button" id="bulk-delete-btn"
                      class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow flex items-center disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                      disabled>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                ລົບຂໍ້ມູນທີ່ເລືອກ
              </button>
              
              <span id="selected-count" class="text-sm text-gray-500">
                ເລືອກແລ້ວ 0 ລາຍການ
              </span>
            </div>
          </form>
          
          <!-- Pagination -->
          <?php if ($total_pages > 1): ?>
          <div class="flex items-center justify-between mt-6">
            <div class="flex-1 flex justify-between sm:hidden">
              <?php if ($page > 1): ?>
              <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($q) ?>&major_id=<?= $major_id ?>&year_id=<?= $year_id ?>" 
                 class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                ໜ້າກ່ອນໜ້າ
              </a>
              <?php endif; ?>
              
              <?php if ($page < $total_pages): ?>
              <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($q) ?>&major_id=<?= $major_id ?>&year_id=<?= $year_id ?>" 
                 class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                ໜ້າຕໍ່ໄປ
              </a>
              <?php endif; ?>
            </div>
            
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  ສະແດງຜົນ <span class="font-medium"><?= ($page - 1) * $per_page + 1 ?></span> ຫາ 
                  <span class="font-medium"><?= min($page * $per_page, $total_records) ?></span> ຈາກທັງໝົດ 
                  <span class="font-medium"><?= $total_records ?></span> ລາຍການ
                </p>
              </div>
              
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                  <?php if ($page > 1): ?>
                  <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($q) ?>&major_id=<?= $major_id ?>&year_id=<?= $year_id ?>" 
                     class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <span class="sr-only">Previous</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                  </a>
                  <?php endif; ?>
                  
                  <?php 
                  // แสดงลิงก์หน้าต่างๆ
                  $start_page = max(1, $page - 2);
                  $end_page = min($total_pages, $page + 2);
                  
                  // แสดงหน้าแรกถ้าไม่ได้อยู่ใกล้หน้าแรก
                  if ($start_page > 1) {
                      echo '<a href="?page=1&q=' . urlencode($q) . '&major_id=' . $major_id . '&year_id=' . $year_id . '" 
                             class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>';
                      if ($start_page > 2) {
                          echo '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
                      }
                  }
                  
                  // แสดงหน้าปัจจุบันและหน้าใกล้เคียง
                  for ($i = $start_page; $i <= $end_page; $i++) {
                      if ($i == $page) {
                          echo '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">' . $i . '</span>';
                      } else {
                          echo '<a href="?page=' . $i . '&q=' . urlencode($q) . '&major_id=' . $major_id . '&year_id=' . $year_id . '" 
                                 class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">' . $i . '</a>';
                      }
                  }
                  
                  // แสดงหน้าสุดท้ายถ้าไม่ได้อยู่ใกล้หน้าสุดท้าย
                  if ($end_page < $total_pages) {
                      if ($end_page < $total_pages - 1) {
                          echo '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
                      }
                      echo '<a href="?page=' . $total_pages . '&q=' . urlencode($q) . '&major_id=' . $major_id . '&year_id=' . $year_id . '" 
                             class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">' . $total_pages . '</a>';
                  }
                  ?>
                  
                  <?php if ($page < $total_pages): ?>
                  <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($q) ?>&major_id=<?= $major_id ?>&year_id=<?= $year_id ?>" 
                     class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <span class="sr-only">Next</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                  </a>
                  <?php endif; ?>
                </nav>
              </div>
            </div>
          </div>
          <?php endif; ?>
          
        <?php else: ?>
          <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">ບໍ່ພົບຂໍ້ມູນ</h3>
            <p class="mt-1 text-sm text-gray-500">ບໍ່ພົບຂໍ້ມູນນັກຮຽນທີ່ຕ້ອງການຄົ້ນຫາ</p>
            <div class="mt-6">
              <a href="<?= BASE_URL ?>views/student_add.php" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                ເພີ່ມນັກຮຽນໃໝ່
              </a>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</main>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
  <div class="fixed inset-0 bg-black opacity-50"></div>
  <div class="relative bg-white rounded-lg max-w-md w-full mx-4 p-6 shadow-xl">
    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
      <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
      </svg>
    </div>
    <h3 class="text-lg font-medium text-gray-900 text-center mb-2" id="modal-title">ຢືນຢັນການລົບ</h3>
    <p class="text-sm text-gray-500 text-center mb-6" id="modal-message">ທ່ານຕ້ອງການລົບຂໍ້ມູນນີ້ແທ້ບໍ່? ການກະທຳນີ້ບໍ່ສາມາດຍ້ອນກັບໄດ້.</p>
    <div class="flex justify-center space-x-3">
      <button type="button" id="modal-cancel" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-all">
        ຍົກເລີກ
      </button>
      <a href="#" id="modal-confirm" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all">
        ລົບຂໍ້ມູນ
      </a>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
  <div class="fixed inset-0 bg-black opacity-50"></div>
  <div class="relative bg-white rounded-lg max-w-md w-full mx-4 p-6 shadow-xl">
    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
      <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
      </svg>
    </div>
    <h3 class="text-lg font-medium text-gray-900 text-center mb-2" id="modal-title">ຢືນຢັນການລົບ</h3>
    <p class="text-sm text-gray-500 text-center mb-6" id="modal-message">ທ່ານຕ້ອງການລົບຂໍ້ມູນນີ້ແທ້ບໍ່? ການກະທຳນີ້ບໍ່ສາມາດຍ້ອນກັບໄດ້.</p>
    <div class="flex justify-center space-x-3">
      <button type="button" id="modal-cancel" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-all">
        ຍົກເລີກ
      </button>
      <a href="#" id="modal-confirm" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all">
        ລົບຂໍ້ມູນ
      </a>
    </div>
  </div>
</div>

<!-- Modal for Bulk Delete Confirmation -->
<div id="bulk-delete-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
  <div class="fixed inset-0 bg-black opacity-50"></div>
  <div class="relative bg-white rounded-lg max-w-md w-full mx-4 p-6 shadow-xl">
    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
      <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
      </svg>
    </div>
    <h3 class="text-lg font-medium text-gray-900 text-center mb-2">ຢືນຢັນການລົບຫຼາຍລາຍການ</h3>
    <p class="text-sm text-gray-500 text-center mb-6" id="bulk-modal-message">ທ່ານຕ້ອງການລົບນັກຮຽນທີ່ເລືອກທັງໝົດ <span id="bulk-count" class="font-bold">0</span> ລາຍການແທ້ບໍ່? ການກະທຳນີ້ບໍ່ສາມາດຍ້ອນກັບໄດ້.</p>
    <div class="flex justify-center space-x-3">
      <button type="button" id="bulk-modal-cancel" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-all">
        ຍົກເລີກ
      </button>
      <button type="button" id="bulk-modal-confirm" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all">
        ລົບຂໍ້ມູນ
      </button>
    </div>
  </div>
</div>

<script>
  // Single Delete Confirmation
  function confirmDelete(id, name) {
    const modal = document.getElementById('delete-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalMessage = document.getElementById('modal-message');
    const modalConfirm = document.getElementById('modal-confirm');
    const modalCancel = document.getElementById('modal-cancel');
    
    modalTitle.textContent = 'ຢືນຢັນການລົບ';
    modalMessage.textContent = `ທ່ານຕ້ອງການລົບນັກຮຽນ "${name}" ແທ້ບໍ່? ການກະທຳນີ້ບໍ່ສາມາດຍ້ອນກັບໄດ້.`;
    modalConfirm.href = `<?= BASE_URL ?>actions/student_delete.php?id=${id}`;
    
    modal.classList.remove('hidden');
    
    modalCancel.addEventListener('click', function() {
      modal.classList.add('hidden');
    });
    
    // ປິດ modal ເມື່ອຄລິກທີ່ພື້ນຫຼັງສີດຳ
    modal.addEventListener('click', function(e) {
      if (e.target === modal) {
        modal.classList.add('hidden');
      }
    });
  }
  
  // Bulk Delete Functionality
  document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const selectedCountSpan = document.getElementById('selected-count');
    const bulkForm = document.getElementById('bulk-form');
    const bulkDeleteModal = document.getElementById('bulk-delete-modal');
    const bulkModalCancel = document.getElementById('bulk-modal-cancel');
    const bulkModalConfirm = document.getElementById('bulk-modal-confirm');
    const bulkCount = document.getElementById('bulk-count');
    
    // Update selected count and button state
    function updateSelectedCount() {
      const selectedCount = document.querySelectorAll('.student-checkbox:checked').length;
      selectedCountSpan.textContent = `ເລືອກແລ້ວ ${selectedCount} ລາຍການ`;
      bulkDeleteBtn.disabled = selectedCount === 0;
      return selectedCount;
    }
    
    // Handle "Select All" checkbox
    if (selectAllCheckbox) {
      selectAllCheckbox.addEventListener('change', function() {
        studentCheckboxes.forEach(cb => {
          cb.checked = this.checked;
        });
        updateSelectedCount();
      });
    }
    
    // Handle individual checkboxes
    studentCheckboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        // ຫຼັງຈາກທີ່ເລືອກຫຼາຍລາຍການ ແລ້ວຍົກເລີກບາງລາຍການ ໃຫ້ຍົກເລີກ select all ເຊັ່ນກັນ
        if (!this.checked && selectAllCheckbox.checked) {
          selectAllCheckbox.checked = false;
        }
        
        // ຫຼັງຈາກທີ່ເລືອກໝົດທຸກລາຍການແລ້ວ ໃຫ້ເລືອກ select all ເຊັ່ນກັນ
        if (document.querySelectorAll('.student-checkbox:checked').length === studentCheckboxes.length) {
          selectAllCheckbox.checked = true;
        }
        
        updateSelectedCount();
      });
    });
    
    // Handle Bulk Delete Button
    if (bulkDeleteBtn) {
      bulkDeleteBtn.addEventListener('click', function() {
        const selectedCount = updateSelectedCount();
        if (selectedCount > 0) {
          bulkCount.textContent = selectedCount;
          bulkDeleteModal.classList.remove('hidden');
        }
      });
    }
    
    // Handle Bulk Delete Modal Cancel
    if (bulkModalCancel) {
      bulkModalCancel.addEventListener('click', function() {
        bulkDeleteModal.classList.add('hidden');
      });
    }
    
    // Handle Bulk Delete Modal Confirm
    if (bulkModalConfirm) {
      bulkModalConfirm.addEventListener('click', function() {
        bulkForm.submit();
      });
    }
    
    // ປິດ modal ເມື່ອຄລິກທີ່ພື້ນຫຼັງສີດຳ
    bulkDeleteModal.addEventListener('click', function(e) {
      if (e.target === bulkDeleteModal) {
        bulkDeleteModal.classList.add('hidden');
      }
    });
    
    // ອັບເດດຈຳນວນເລືອກເມື່ອໂຫຼດໜ້າ
    updateSelectedCount();
  });
</script>

<?php include('footer.php'); ?>