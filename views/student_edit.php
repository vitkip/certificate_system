<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');

$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

$majors = $pdo->query("SELECT id, major_lao, major_en FROM majors")->fetchAll();
$years = $pdo->query("SELECT id, year_name FROM academic_years")->fetchAll();
$error_message = $_SESSION['error'] ?? '';
$success_message = $_SESSION['success'] ?? '';

if (!empty($error_message)) {
  echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded' role='alert'>{$error_message}</div>";
  unset($_SESSION['error']);
}

if (!empty($success_message)) {
  echo "<div class='bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded' role='alert'>{$success_message}</div>";
  unset($_SESSION['success']);
}
?>

<?php include('header.php'); ?>

<main class="bg-gray-50 flex-1 py-8 px-4">
  <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
    <!-- Form Header -->
    <div class="bg-gradient-to-r from-yellow-50 to-amber-50 p-8 border-b border-gray-200">
      <div class="flex items-center justify-center gap-4 mb-4">
        <div class="bg-yellow-600 p-3 rounded-full shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">ແກ້ໄຂຂໍ້ມູນນັກຮຽນ</h2>
      </div>
      <p class="text-gray-600 text-center max-w-lg mx-auto">ແກ້ໄຂຂໍ້ມູນນັກຮຽນໃນລະບົບ</p>
    </div>

    <!-- Form Container -->
    <form action="<?= BASE_URL ?>actions/student_update.php" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
      <input type="hidden" name="id" value="<?= $student['id'] ?>">
      
      <!-- Basic Information Section -->
      <div class="mb-10">
        <h3 class="text-lg font-medium text-yellow-700 mb-5 pb-2 border-b border-gray-200 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
          ຂໍ້ມູນພື້ນຖານ
        </h3>
        
        <div class="grid md:grid-cols-2 gap-6">
          <div class="col-span-1">
            <label for="std_code" class="block text-sm font-medium text-gray-700 mb-1">ລະຫັດນັກຮຽນ *</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-yellow-500">🆔</span>
              </div>
              <input type="text" name="std_code" id="std_code" value="<?= htmlspecialchars($student['std_code']) ?>" required 
                  class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
            </div>
          </div>
          
          <div class="col-span-1 sm:col-span-2 md:col-span-1">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">ຮູບນັກຮຽນ</label>
            <div class="relative border-2 border-dashed border-yellow-300 rounded-lg p-6 text-center hover:bg-yellow-50 transition-all duration-200 bg-yellow-50/30">
              <?php if (!empty($student['image'])): ?>
                <div class="mb-2">
                  <p class="text-sm mb-1">ຮູບປັດຈຸບັນ:</p>
                  <img src="../uploads/<?= htmlspecialchars($student['image']) ?>" class="h-20 mx-auto object-contain rounded">
                </div>
              <?php endif; ?>
              <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
              <div class="space-y-2 text-center">
                <svg class="mx-auto h-10 w-10 text-yellow-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                  <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-sm text-gray-600">ກົດເລືອກ ຫຼື ລາກຮູບມາວາງໃສ່</p>
                <p class="text-xs text-gray-500">PNG, JPG (ຂະໜາດສູງສຸດ 2MB)</p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Name Fields -->
        <div class="grid md:grid-cols-2 gap-6 mt-6">
          <div>
            <label for="name_lao" class="block text-sm font-medium text-gray-700 mb-1">ຊື່ (ພາສາລາວ) *</label>
            <input type="text" name="name_lao" id="name_lao" value="<?= htmlspecialchars($student['name_lao']) ?>" required 
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
          </div>
          <div>
            <label for="name_en" class="block text-sm font-medium text-gray-700 mb-1">ຊື່ (ພາສາອັງກິດ) *</label>
            <input type="text" name="name_en" id="name_en" value="<?= htmlspecialchars($student['name_en']) ?>" required 
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
          </div>
        </div>
      </div>
      
      <!-- Birth Information Section -->
      <div class="mb-10 bg-gray-50 p-6 rounded-lg">
        <h3 class="text-lg font-medium text-yellow-700 mb-5 pb-2 border-b border-gray-200 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          ຂໍ້ມູນວັນເດືອນປີເກີດ
        </h3>
        
        <?php
        // Function to generate date dropdown selectors
        function generateDateSelection($prefix, $label, $dateValue, $language = 'lao') {
          // Parse the date if it exists
          $day = '';
          $month = '';
          $year = '';
          
          if (!empty($dateValue)) {
            $date = new DateTime($dateValue);
            $day = $date->format('d');
            $month = $date->format('m');
            $year = $date->format('Y');
          }
          
          $months = [];
          $dayLabel = 'ວັນທີ';
          $monthLabel = 'ເດືອນ';
          $yearLabel = 'ປີ';
          
          if ($language == 'en') {
            $months = [
              '01' => 'January', '02' => 'February', '03' => 'March',
              '04' => 'April', '05' => 'May', '06' => 'June',
              '07' => 'July', '08' => 'August', '09' => 'September',
              '10' => 'October', '11' => 'November', '12' => 'December'
            ];
            $dayLabel = 'Day';
            $monthLabel = 'Month';
            $yearLabel = 'Year';
          } else {
            $months = [
              '01' => 'ມັງກອນ', '02' => 'ກຸມພາ', '03' => 'ມີນາ',
              '04' => 'ເມສາ', '05' => 'ພຶດສະພາ', '06' => 'ມິຖຸນາ',
              '07' => 'ກໍລະກົດ', '08' => 'ສິງຫາ', '09' => 'ກັນຍາ',
              '10' => 'ຕຸລາ', '11' => 'ພະຈິກ', '12' => 'ທັນວາ'
            ];
          }
          
          echo '<div>';
          echo '<label for="' . $prefix . '_day" class="block text-sm font-medium text-gray-700 mb-1">' . $label . '</label>';
          echo '<div class="flex gap-2">';
          
          // Day select
          echo '<div class="w-1/4">';
          echo '<select name="' . $prefix . '_day" id="' . $prefix . '_day" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">';
          echo '<option value="">' . $dayLabel . '</option>';
          for ($i = 1; $i <= 31; $i++) {
            $selected = ($i == (int)$day) ? 'selected' : '';
            echo '<option value="' . sprintf('%02d', $i) . '" ' . $selected . '>' . $i . '</option>';
          }
          echo '</select>';
          echo '</div>';
          
          // Month select
          echo '<div class="w-2/5">';
          echo '<select name="' . $prefix . '_month" id="' . $prefix . '_month" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">';
          echo '<option value="">' . $monthLabel . '</option>';
          foreach ($months as $num => $name) {
            $selected = ($num == $month) ? 'selected' : '';
            echo '<option value="' . $num . '" ' . $selected . '>' . $name . '</option>';
          }
          echo '</select>';
          echo '</div>';
          
          // Year select
          echo '<div class="w-1/3">';
          echo '<select name="' . $prefix . '_year" id="' . $prefix . '_year" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">';
          echo '<option value="">' . $yearLabel . '</option>';
          $currentYear = (int)date('Y');
          for ($i = $currentYear - 50; $i <= $currentYear - 10; $i++) {
            $selected = ($i == $year) ? 'selected' : '';
            echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
          }
          echo '</select>';
          echo '</div>';
          
          echo '</div>'; // End flex container
          echo '</div>'; // End outer div
        }
        ?>

        <div class="grid md:grid-cols-2 gap-6">
          <?php
          // Generate Lao date selection
          generateDateSelection('birth_lao', 'ວັນເດືອນປີເກີດ (ພາສາລາວ)', $student['birth_lao'], 'lao');
          
          // Generate English date selection
          generateDateSelection('birth_en', 'Date of Birth (English)', $student['birth_en'], 'en');
          ?>
        </div>

        <input type="hidden" name="birth_lao" id="birth_lao_hidden" value="<?= htmlspecialchars($student['birth_lao']) ?>">
        <input type="hidden" name="birth_en" id="birth_en_hidden" value="<?= htmlspecialchars($student['birth_en']) ?>">

        <script>
          // เพิ่มฟังก์ชันนี้ในส่วนของ JavaScript
          function updateHiddenDateFields() {
            // อัปเดตค่าในฟิลด์ซ่อนเมื่อมีการเปลี่ยนแปลงในตัวเลือกวันเดือนปี
            let dayLao = document.getElementById('birth_day_lao').value;
            let monthLao = document.getElementById('birth_month_lao').value;
            let yearLao = document.getElementById('birth_year_lao').value;
            
            if (dayLao && monthLao && yearLao) {
              const formattedDateLao = `${yearLao}-${monthLao.padStart(2, '0')}-${dayLao.padStart(2, '0')}`;
              document.getElementById('birth_lao_hidden').value = formattedDateLao;
              document.getElementById('birth_en_hidden').value = formattedDateLao; // ใช้ค่าเดียวกันสำหรับทั้งสองภาษา
            }
          }
          
          // เรียกใช้ฟังก์ชันเมื่อมีการเปลี่ยนแปลงในตัวเลือกวันเดือนปี
          document.getElementById('birth_day_lao').addEventListener('change', updateHiddenDateFields);
          document.getElementById('birth_month_lao').addEventListener('change', updateHiddenDateFields);
          document.getElementById('birth_year_lao').addEventListener('change', updateHiddenDateFields);
          document.getElementById('birth_day_en').addEventListener('change', updateHiddenDateFields);
          document.getElementById('birth_month_en').addEventListener('change', updateHiddenDateFields);
          document.getElementById('birth_year_en').addEventListener('change', updateHiddenDateFields);
        </script>
      </div>
      
      <!-- Location Information -->
      <div class="mb-10">
        <h3 class="text-lg font-medium text-yellow-700 mb-5 pb-2 border-b border-gray-200 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          ຂໍ້ມູນສະຖານທີ່
        </h3>
        
        <div class="grid md:grid-cols-2 gap-6">
          <div>
            <label for="province_lao" class="block text-sm font-medium text-gray-700 mb-1">ແຂວງ (ພາສາລາວ)</label>
            <select name="province_lao" id="province_lao" 
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
              <option value="">-- ເລືອກແຂວງ --</option>
              <?php
              $provinces_lao = ["ນະຄອນຫຼວງວຽງຈັນ", "ຜົ້ງສາລີ", "ຫຼວງນໍ້າທາ", "ອຸດົມໄຊ", "ບໍແກ້ວ", "ຫຼວງພະບາງ", "ຫົວພັນ", 
                      "ໄຊຍະບູລີ", "ຊຽງຂວາງ", "ວຽງຈັນ", "ບໍລິຄໍາໄຊ", "ຄໍາມ່ວນ", "ສະຫວັນນະເຂດ", "ສາລະວັນ", "ເຊກອງ", 
                      "ຈໍາປາສັກ", "ອັດຕະປື", "ໄຊສົມບູນ"];
              foreach ($provinces_lao as $province): 
              ?>
                <option value="<?= $province ?>" <?= $student['province_lao'] == $province ? 'selected' : '' ?>>
                  <?= $province ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          
          <div>
            <label for="province_en" class="block text-sm font-medium text-gray-700 mb-1">Province (English)</label>
            <select name="province_en" id="province_en" 
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
              <option value="">-- Select Province --</option>
              <?php
              $provinces_en = ["Vientiane Capital", "Phongsaly", "Luang Namtha", "Oudomxay", "Bokeo", "Luang Prabang", "Huaphanh", 
                      "Xayaboury", "Xiengkhuang", "Vientiane Province", "Borikhamxay", "Khammouane", "Savannakhet", "Saravane", 
                      "Sekong", "Champasack", "Attapeu", "Xaysomboon"];
              foreach ($provinces_en as $province): 
              ?>
                <option value="<?= $province ?>" <?= $student['province_en'] == $province ? 'selected' : '' ?>>
                  <?= $province ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
      
      <!-- Education Information -->
      <div class="mb-10 bg-gray-50 p-6 rounded-lg">
        <h3 class="text-lg font-medium text-yellow-700 mb-5 pb-2 border-b border-gray-200 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M12 14l9-5-9-5-9 5 9 5z" />
            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
          </svg>
          ຂໍ້ມູນການສຶກສາ
        </h3>
        
        <div class="grid md:grid-cols-2 gap-6">
          <div>
            <label for="major_id" class="block text-sm font-medium text-gray-700 mb-1">ສາຂາ *</label>
            <select name="major_id" id="major_id" required 
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
              <option value="">-- ເລືອກສາຂາ --</option>
              <?php foreach ($majors as $m): ?>
                <option value="<?= $m['id'] ?>" <?= $student['major_id'] == $m['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($m['major_lao']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          
          <div>
            <label for="major_en" class="block text-sm font-medium text-gray-700 mb-1">Major (English)</label>
            <select id="major_en" 
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
              <option value="">-- Major English --</option>
              <?php foreach ($majors as $m): ?>
                <option value="<?= $m['id'] ?>" <?= $student['major_id'] == $m['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($m['major_en'] ?? '') ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        
        <!-- Academic Year -->
        <div class="mt-6">
          <label for="academic_year_id" class="block text-sm font-medium text-gray-700 mb-1">ປີການສຶກສາ *</label>
          <select name="academic_year_id" id="academic_year_id" required 
              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all">
            <option value="">-- ເລືອກປີການສຶກສາ --</option>
            <?php foreach ($years as $y): ?>
              <option value="<?= $y['id'] ?>" <?= $student['academic_year_id'] == $y['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($y['year_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      
      <!-- Submit buttons -->
      <div class="flex items-center justify-center space-x-4 pt-6 mt-8 border-t">
        <a href="<?= BASE_URL ?>views/student_list.php" 
           class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all shadow-sm font-medium flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
          ຍົກເລີກ
        </a>
        <button type="submit" 
                class="px-6 py-2.5 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all shadow-md font-medium flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
          </svg>
          ບັນທຶກການແກ້ໄຂ
        </button>
      </div>
    </form>
  </div>
</main>

<script>
  // Province sync
  const provinceMap = {
    "ນະຄອນຫຼວງວຽງຈັນ": "Vientiane Capital",
    "ຜົ້ງສາລີ": "Phongsaly",
    "ຫຼວງນໍ້າທາ": "Luang Namtha",
    "ອຸດົມໄຊ": "Oudomxay",
    "ບໍແກ້ວ": "Bokeo",
    "ຫຼວງພະບາງ": "Luang Prabang",
    "ຫົວພັນ": "Huaphanh",
    "ໄຊຍະບູລີ": "Xayaboury",
    "ຊຽງຂວາງ": "Xiengkhuang",
    "ວຽງຈັນ": "Vientiane Province",
    "ບໍລິຄໍາໄຊ": "Borikhamxay",
    "ຄໍາມ່ວນ": "Khammouane",
    "ສະຫວັນນະເຂດ": "Savannakhet",
    "ສາລະວັນ": "Saravane",
    "ເຊກອງ": "Sekong",
    "ຈໍາປາສັກ": "Champasack",
    "ອັດຕະປື": "Attapeu",
    "ໄຊສົມບູນ": "Xaysomboon"
  };

  document.getElementById('province_lao').addEventListener('change', function() {
    const laoProvince = this.value;
    const englishProvince = provinceMap[laoProvince] || "";
    document.getElementById('province_en').value = englishProvince;
  });

  document.getElementById('province_en').addEventListener('change', function() {
    const englishProvince = this.value;
    for (const [lao, english] of Object.entries(provinceMap)) {
      if (english === englishProvince) {
        document.getElementById('province_lao').value = lao;
        break;
      }
    }
  });

  // Major sync
  document.getElementById('major_id').addEventListener('change', function() {
    const selectedIndex = this.selectedIndex;
    document.getElementById('major_en').selectedIndex = selectedIndex;
  });
  
  document.getElementById('major_en').addEventListener('change', function() {
    const selectedIndex = this.selectedIndex;
    document.getElementById('major_id').selectedIndex = selectedIndex;
  });
  
  // Live preview for image upload
  const imageInput = document.querySelector('input[name="image"]');
  imageInput.addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const uploadArea = imageInput.parentElement;
        
        // Remove existing preview if there is one
        const existingPreview = uploadArea.querySelector('.mb-2');
        if (existingPreview) {
          uploadArea.removeChild(existingPreview);
        }
        
        const preview = document.createElement('div');
        preview.className = 'mb-2';
        preview.innerHTML = `
          <p class="text-sm mb-1">ຮູບໃໝ່ທີ່ເລືອກ:</p>
          <div class="relative w-full flex items-center justify-center">
            <img src="${e.target.result}" class="h-20 mx-auto object-contain rounded" />
            <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1" onclick="resetImageUpload()">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        `;
        uploadArea.insertBefore(preview, uploadArea.firstChild);
        uploadArea.querySelector('.space-y-2').style.display = 'none';
      };
      reader.readAsDataURL(file);
    }
  });
  
  function resetImageUpload() {
    const imageInput = document.querySelector('input[name="image"]');
    imageInput.value = '';
    
    const uploadArea = imageInput.parentElement;
    const newPreview = uploadArea.querySelector('.mb-2:first-child');
    if (newPreview && newPreview.querySelector('p').textContent.includes('ຮູບໃໝ່')) {
      uploadArea.removeChild(newPreview);
    }
    
    // แสดงรูปเดิมถ้ามี
    const originalPreview = uploadArea.querySelector('.mb-2');
    if (!originalPreview) {
      uploadArea.querySelector('.space-y-2').style.display = 'block';
    }
  }

  // Date format conversion
  document.addEventListener('DOMContentLoaded', function() {
    // ซิงค์ค่าระหว่างวันที่ภาษาลาวและอังกฤษ
    const birthLaoInput = document.getElementById('birth_lao');
    const birthEnInput = document.getElementById('birth_en');
    
    birthLaoInput.addEventListener('change', function() {
      birthEnInput.value = this.value;
    });
    
    birthEnInput.addEventListener('change', function() {
      birthLaoInput.value = this.value;
    });
  });
</script>

<?php include('footer.php'); ?>

