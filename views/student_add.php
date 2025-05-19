<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');


$majors = $pdo->query("SELECT id, major_lao, major_en FROM majors")->fetchAll();
$years = $pdo->query("SELECT id, year_name FROM academic_years")->fetchAll();
?>

<?php include('header.php'); ?>

<main class="bg-gray-50 flex-1 py-8 px-4">
  <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
    <!-- Form Header -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-8 border-b border-gray-200">
      <div class="flex items-center justify-center gap-4 mb-4">
        <div class="bg-blue-600 p-3 rounded-full shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">ເພີ່ມນັກຮຽນໃໝ່</h2>
      </div>
      <p class="text-gray-600 text-center max-w-lg mx-auto">ປ້ອນຂໍ້ມູນນັກຮຽນເພື່ອເພີ່ມເຂົ້າໃນລະບົບ</p>
    </div>

    <!-- Form Container -->
    <form action="<?= BASE_URL ?>actions/student_save.php" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
      <!-- Basic Information Section -->
      <div class="mb-10">
        <h3 class="text-lg font-medium text-blue-700 mb-5 pb-2 border-b border-gray-200 flex items-center gap-2">
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
                <span class="text-blue-500">🆔</span>
              </div>
              <input type="text" name="std_code" id="std_code" required 
                  class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>
          </div>
          
          <div class="col-span-1 sm:col-span-2 md:col-span-1">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">ຮູບນັກຮຽນ</label>
            <div class="relative border-2 border-dashed border-blue-300 rounded-lg p-6 text-center hover:bg-blue-50 transition-all duration-200 bg-blue-50/30">
              <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
              <div class="space-y-2 text-center">
                <svg class="mx-auto h-14 w-14 text-blue-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
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
            <input type="text" name="name_lao" id="name_lao" required 
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
          </div>
          <div>
            <label for="name_en" class="block text-sm font-medium text-gray-700 mb-1">ຊື່ (ພາສາອັງກິດ) *</label>
            <input type="text" name="name_en" id="name_en" required 
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
          </div>
        </div>
      </div>
      
      <!-- Birth Information Section -->
      <div class="mb-10 bg-gray-50 p-6 rounded-lg">
        <h3 class="text-lg font-medium text-blue-700 mb-5 pb-2 border-b border-gray-200 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          ຂໍ້ມູນວັນເດືອນປີເກີດ
        </h3>
        
        <!-- Lao Date -->
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">ວັນ/ເດືອນ/ປີເກີດ (ພາສາລາວ)</label>
          <div class="grid grid-cols-3 gap-3">
            <select name="birth_day_lao" id="birth_day_lao" 
                class="border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
              <option value="">ວັນທີ</option>
              <?php for($i = 1; $i <= 31; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
              <?php endfor; ?>
            </select>
            <select name="birth_month_lao" id="birth_month_lao" 
                class="border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
              <option value="">ເດືອນ</option>
              <?php 
              $lao_months = ["ມັງກອນ", "ກຸມພາ", "ມີນາ", "ເມສາ", "ພຶດສະພາ", "ມິຖຸນາ", 
                "ກໍລະກົດ", "ສິງຫາ", "ກັນຍາ", "ຕຸລາ", "ພະຈິກ", "ທັນວາ"];
              for($i = 1; $i <= 12; $i++): 
              ?>
                <option value="<?= $i ?>"><?= $lao_months[$i-1] ?></option>
              <?php endfor; ?>
            </select>
            <select name="birth_year_lao" id="birth_year_lao" 
                class="border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
              <option value="">ປີ</option>
              <?php 
              $current_year = (int)date('Y');
              for($i = $current_year - 50; $i <= $current_year - 10; $i++): 
              ?>
                <option value="<?= $i ?>"><?= $i ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>
        
        <!-- English Date -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth (English)</label>
          <div class="grid grid-cols-3 gap-3">
            <select name="birth_day_en" id="birth_day_en" 
                class="border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
              <option value="">Day</option>
              <?php for($i = 1; $i <= 31; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
              <?php endfor; ?>
            </select>
            <select name="birth_month_en" id="birth_month_en" 
                class="border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
              <option value="">Month</option>
              <?php 
              $english_months = ["January", "February", "March", "April", "May", "June", 
                "July", "August", "September", "October", "November", "December"];
              for($i = 1; $i <= 12; $i++): 
              ?>
                <option value="<?= $i ?>"><?= $english_months[$i-1] ?></option>
              <?php endfor; ?>
            </select>
            <select name="birth_year_en" id="birth_year_en" 
                class="border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
              <option value="">Year</option>
              <?php 
              $current_year = (int)date('Y');
              for($i = $current_year - 50; $i <= $current_year - 10; $i++): 
              ?>
                <option value="<?= $i ?>"><?= $i ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <input type="hidden" name="birth_lao" id="birth_lao">
        </div>
      </div>
      
      <!-- Location Information -->
      <div class="mb-10">
        <h3 class="text-lg font-medium text-blue-700 mb-5 pb-2 border-b border-gray-200 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          ຂໍ້ມູນສະຖານທີ່
        </h3>
        
        <div class="grid md:grid-cols-2 gap-6">
          <!-- Province selection -->
          <div>
            <label for="province_lao" class="block text-sm font-medium text-gray-700 mb-1">ແຂວງ (ພາສາລາວ) *</label>
            <select name="province_lao" id="province_lao" required 
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
              <option value="">-- ເລືອກແຂວງ --</option>
              <option value="ນະຄອນຫຼວງວຽງຈັນ">ນະຄອນຫຼວງວຽງຈັນ</option>
              <option value="ຜົ້ງສາລີ">ຜົ້ງສາລີ</option>
              <option value="ຫຼວງນໍ້າທາ">ຫຼວງນໍ້າທາ</option>
              <option value="ອຸດົມໄຊ">ອຸດົມໄຊ</option>
              <option value="ບໍ່ແກ້ວ">ບໍ່ແກ້ວ</option>
              <option value="ຫຼວງພະບາງ">ຫຼວງພະບາງ</option>
              <option value="ຫົວພັນ">ຫົວພັນ</option>
              <option value="ໄຊຍະບູລີ">ໄຊຍະບູລີ</option>
              <option value="ຊຽງຂວາງ">ຊຽງຂວາງ</option>
              <option value="ວຽງຈັນ">ວຽງຈັນ</option>
              <option value="ບໍລິຄໍາໄຊ">ບໍລິຄໍາໄຊ</option>
              <option value="ຄໍາມ່ວນ">ຄໍາມ່ວນ</option>
              <option value="ສະຫວັນນະເຂດ">ສະຫວັນນະເຂດ</option>
              <option value="ສາລະວັນ">ສາລະວັນ</option>
              <option value="ເຊກອງ">ເຊກອງ</option>
              <option value="ຈໍາປາສັກ">ຈໍາປາສັກ</option>
              <option value="ອັດຕະປື">ອັດຕະປື</option>
              <option value="ໄຊສົມບູນ">ໄຊສົມບູນ</option>
            </select>
          </div>
          
          <div>
            <label for="province_en" class="block text-sm font-medium text-gray-700 mb-1">Province (English)</label>
            <select name="province_en" id="province_en" 
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
              <option value="">-- Select Province --</option>
              <option value="Vientiane Capital">Vientiane Capital</option>
              <option value="Phongsaly">Phongsaly</option>
              <option value="Luang Namtha">Luang Namtha</option>
              <option value="Oudomxay">Oudomxay</option>
              <option value="Bokeo">Bokeo</option>
              <option value="Luang Prabang">Luang Prabang</option>
              <option value="Huaphanh">Huaphanh</option>
              <option value="Xayaboury">Xayaboury</option>
              <option value="Xiengkhuang">Xiengkhuang</option>
              <option value="Vientiane Province">Vientiane Province</option>
              <option value="Borikhamxay">Borikhamxay</option>
              <option value="Khammouane">Khammouane</option>
              <option value="Savannakhet">Savannakhet</option>
              <option value="Saravane">Saravane</option>
              <option value="Sekong">Sekong</option>
              <option value="Champasack">Champasack</option>
              <option value="Attapeu">Attapeu</option>
              <option value="Xaysomboon">Xaysomboon</option>
            </select>
          </div>
        </div>
      </div>
      
      <!-- Education Information -->
      <div class="mb-10 bg-gray-50 p-6 rounded-lg">
        <h3 class="text-lg font-medium text-blue-700 mb-5 pb-2 border-b border-gray-200 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M12 14l9-5-9-5-9 5 9 5z" />
            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
          </svg>
          ຂໍ້ມູນການສຶກສາ
        </h3>
        
        <div class="grid md:grid-cols-2 gap-6">
          <!-- Major selection -->
          <div>
            <label for="major_lao" class="block text-sm font-medium text-gray-700 mb-1">ສາຂາ (ພາສາລາວ) *</label>
            <select name="major_id" id="major_lao" required 
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
              <option value="">-- ເລືອກສາຂາ --</option>
              <?php foreach ($majors as $m): ?>
                <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['major_lao']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          
          <div>
            <label for="major_en" class="block text-sm font-medium text-gray-700 mb-1">Major (English)</label>
            <select id="major_en" 
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
              <option value="">-- Major English --</option>
              <?php foreach ($majors as $m): ?>
                <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['major_en'] ?? '') ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        
        <!-- Academic Year -->
        <div class="mt-6">
          <label for="academic_year_id" class="block text-sm font-medium text-gray-700 mb-1">ປີການສຶກສາ *</label>
          <select name="academic_year_id" id="academic_year_id" required 
              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            <option value="">-- ເລືອກປີການສຶກສາ --</option>
            <?php foreach ($years as $y): ?>
              <option value="<?= $y['id'] ?>"><?= htmlspecialchars($y['year_name']) ?></option>
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
                class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-md font-medium flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          ບັນທຶກຂໍ້ມູນ
        </button>
      </div>
    </form>
  </div>
</main>

<script>
  // Keep the original date and province sync scripts
  document.getElementById('birth_day_lao').addEventListener('change', function() {
    document.getElementById('birth_day_en').value = this.value;
    updateHiddenDate();
  });
  
  document.getElementById('birth_month_lao').addEventListener('change', function() {
    document.getElementById('birth_month_en').value = this.value;
    updateHiddenDate();
  });
  
  document.getElementById('birth_year_lao').addEventListener('change', function() {
    document.getElementById('birth_year_en').value = this.value;
    updateHiddenDate();
  });
  
  document.getElementById('birth_day_en').addEventListener('change', function() {
    document.getElementById('birth_day_lao').value = this.value;
    updateHiddenDate();
  });
  
  document.getElementById('birth_month_en').addEventListener('change', function() {
    document.getElementById('birth_month_lao').value = this.value;
    updateHiddenDate();
  });
  
  document.getElementById('birth_year_en').addEventListener('change', function() {
    document.getElementById('birth_year_lao').value = this.value;
    updateHiddenDate();
  });
  
  function updateHiddenDate() {
    const day = document.getElementById('birth_day_en').value;
    const month = document.getElementById('birth_month_en').value;
    const year = document.getElementById('birth_year_en').value;
    
    if(day && month && year) {
      const monthPadded = month.toString().padStart(2, '0');
      const dayPadded = day.toString().padStart(2, '0');
      document.getElementById('birth_lao').value = `${year}-${monthPadded}-${dayPadded}`;
    }
  }

  // Province sync
  const provinceMap = {
    "ນະຄອນຫຼວງວຽງຈັນ": "Vientiane Capital",
    "ຜົ້ງສາລີ": "Phongsaly",
    "ຫຼວງນໍ້າທາ": "Luang Namtha",
    "ອຸດົມໄຊ": "Oudomxay",
    "ບໍ່ແກ້ວ": "Bokeo",
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

  // Major sync
  document.getElementById('major_lao').addEventListener('change', function() {
    const selectedIndex = this.selectedIndex;
    document.getElementById('major_en').selectedIndex = selectedIndex;
  });
  
  document.getElementById('major_en').addEventListener('change', function() {
    const selectedIndex = this.selectedIndex;
    document.getElementById('major_lao').selectedIndex = selectedIndex;
  });
  
  // Live preview for image upload
  const imageInput = document.querySelector('input[name="image"]');
  imageInput.addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const uploadArea = imageInput.parentElement;
        const preview = document.createElement('div');
        preview.className = 'absolute inset-0 flex items-center justify-center';
        preview.innerHTML = `
          <div class="relative w-full h-full flex items-center justify-center">
            <img src="${e.target.result}" class="max-h-full max-w-full object-contain" />
            <button type="button" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1" onclick="resetImageUpload()">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        `;
        
        // Remove existing preview if there is one
        const existingPreview = uploadArea.querySelector('.absolute:not(input)');
        if (existingPreview) {
          uploadArea.removeChild(existingPreview);
        }
        
        uploadArea.appendChild(preview);
        uploadArea.querySelector('.space-y-1').style.display = 'none';
      };
      reader.readAsDataURL(file);
    }
  });
  
  function resetImageUpload() {
    const imageInput = document.querySelector('input[name="image"]');
    imageInput.value = '';
    
    const uploadArea = imageInput.parentElement;
    const preview = uploadArea.querySelector('.absolute:not(input)');
    if (preview) {
      uploadArea.removeChild(preview);
    }
    
    uploadArea.querySelector('.space-y-1').style.display = 'block';
  }
</script>

<?php include('footer.php'); ?>