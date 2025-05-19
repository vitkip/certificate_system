<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/auth.php');
?>
<!DOCTYPE html>
<html lang="lo">
<head>
  <meta charset="UTF-8">
  <title>📄 Dashboard - Certificate System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100 text-gray-800">
  <header class="bg-gradient-to-r from-purple-600 to-blue-600 text-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <h1 class="text-xl font-bold"><a  href="<?= BASE_URL ?>views/dashboard.php">🎓</a> ລະບົບອອກໃບປະການ ວິທະຍາໄລຄູສົງ ອົງຕື້</h1>
      <div>
        <span class="mr-4">👤 <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
        <a href="<?= BASE_URL ?>actions/logout.php" class="bg-white text-purple-700 px-3 py-1 rounded hover:bg-gray-200">Logout</a>
       
      </div>
    </div>
  </header>
  <div class="flex">
