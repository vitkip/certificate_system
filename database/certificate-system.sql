-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2025 at 07:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `certificate-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດປີການສຶກສາ',
  `year_name` varchar(20) NOT NULL COMMENT 'ຊື່ປີການສຶກສາ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ຕາຕະລາງປີການສຶກສາ';

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `year_name`) VALUES
(1, '2025'),
(2, '2026'),
(3, '2027');

-- --------------------------------------------------------

--
-- Table structure for table `majors`
--

CREATE TABLE `majors` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດສາຂາ',
  `major_lao` varchar(100) NOT NULL COMMENT 'ຊື່ສາຂາ (ພາສາລາວ)',
  `major_en` varchar(100) NOT NULL COMMENT 'ຊື່ສາຂາ (ພາສາອັງກິດ)',
  `category_id` int(11) DEFAULT NULL COMMENT 'ເຊື່ອມໄປຫາໝວດສາຂາ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ຕາຕະລາງສາຂາວິຊາ';

--
-- Dumping data for table `majors`
--

INSERT INTO `majors` (`id`, `major_lao`, `major_en`, `category_id`) VALUES
(1, 'ຄູພາລາລາວ-ວັນນະຄະດີ', 'Lao - Literature', 1),
(2, 'ຄູພາສາອັງກິດ', 'English', 2),
(3, 'ຄູພຸດທະສາສະໜາ-ພາສາລາວ', 'Buddhist and Lao language', 3);

-- --------------------------------------------------------

--
-- Table structure for table `major_categories`
--

CREATE TABLE `major_categories` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດໝວດສາຂາ',
  `category_name_lao` varchar(100) NOT NULL COMMENT 'ຊື່ໝວດສາຂາ (ພາສາລາວ)',
  `category_name_en` varchar(100) NOT NULL COMMENT 'ຊື່ໝວດສາຂາ (ພາສາອັງກິດ)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ຕາຕະລາງໝວດສາຂາ';

--
-- Dumping data for table `major_categories`
--

INSERT INTO `major_categories` (`id`, `category_name_lao`, `category_name_en`) VALUES
(1, 'ຄູພຸດທະສາສະໜາ-ພາສາລາວ', 'Buddhist and Lao language'),
(2, 'ຄູພາສາອັງກິດ', 'English'),
(3, 'ຄູພາລາລາວ-ວັນນະຄະດີ', 'Lao - Literature');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດສະມາຊິກ',
  `full_name` varchar(100) NOT NULL COMMENT 'ຊື່ເຕັມ',
  `email` varchar(100) DEFAULT NULL COMMENT 'ອີເມວ',
  `phone` varchar(20) DEFAULT NULL COMMENT 'ເບີໂທ',
  `address` text DEFAULT NULL COMMENT 'ທີ່ຢູ່',
  `member_type` enum('general','student','monk') DEFAULT 'general' COMMENT 'ປະເພດສະມາຊິກ',
  `registered_at` datetime DEFAULT current_timestamp() COMMENT 'ວັນທີລົງທະບຽນ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ຕາຕະລາງສະມາຊິກ';

-- --------------------------------------------------------

--
-- Table structure for table `std_cert`
--

CREATE TABLE `std_cert` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດໃບປະກາດ',
  `student_id` int(11) NOT NULL COMMENT 'ເຊື່ອມກັບນັກຮຽນ',
  `certificate_code` varchar(50) DEFAULT NULL COMMENT 'ລະຫັດໃບປະກາດ',
  `issued_date` date DEFAULT curdate() COMMENT 'ວັນທີອອກໃບປະກາດ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ຕາຕະລາງຂໍ້ມູນໃບປະກາດ';

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດນັກຮຽນ',
  `std_code` varchar(20) NOT NULL COMMENT 'ລະຫັດນັກຮຽນ',
  `name_lao` varchar(100) NOT NULL COMMENT 'ຊື່ນັກຮຽນ (ພາສາລາວ)',
  `name_en` varchar(100) NOT NULL COMMENT 'ຊື່ນັກຮຽນ (ພາສາອັງກິດ)',
  `birth_lao` varchar(100) DEFAULT NULL COMMENT 'ສະຖານທີເກີດ (ພາສາລາວ)',
  `birth_en` varchar(100) DEFAULT NULL COMMENT 'ສະຖານທີເກີດ (ພາສາອັງກິດ)',
  `province_lao` varchar(100) DEFAULT NULL COMMENT 'ແຂວງ (ພາສາລາວ)',
  `province_en` varchar(100) DEFAULT NULL COMMENT 'ແຂວງ (ພາສາອັງກິດ)',
  `major_id` int(11) DEFAULT NULL COMMENT 'ສາຂາວິຊາ',
  `academic_year_id` int(11) DEFAULT NULL COMMENT 'ປີການສຶກສາ',
  `image` varchar(255) DEFAULT NULL COMMENT 'ຊື່ໄຟລ໌ຮູບພາບນັກຮຽນ',
  `created_at` datetime DEFAULT current_timestamp() COMMENT 'ວັນທີເພີ່ມ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ຕາຕະລາງນັກຮຽນ';

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `std_code`, `name_lao`, `name_en`, `birth_lao`, `birth_en`, `province_lao`, `province_en`, `major_id`, `academic_year_id`, `image`, `created_at`) VALUES
(25, '001232', 'ທອງສັນ ວາລິນທອງ', 'ທອງສັນ ວາລິນທອງ', '1990-02-16', '', 'ຈໍາປາສັກ', 'Champasack', 2, 3, 'img_682b6af923ed8.png', '2025-05-20 00:31:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'ລະຫັດຜູ້ໃຊ້',
  `username` varchar(50) NOT NULL COMMENT 'ຊື່ຜູ້ໃຊ້',
  `password` varchar(255) NOT NULL COMMENT 'ລະຫັດຜ່ານ',
  `email` varchar(100) DEFAULT NULL COMMENT 'ອີເມວ',
  `role` enum('admin','staff') DEFAULT 'admin' COMMENT 'ສິດທິຂອງຜູ້ໃຊ້',
  `created_at` datetime DEFAULT current_timestamp() COMMENT 'ວັນທີສ້າງ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ຕາຕະລາງຜູ້ໃຊ້ລະບົບ';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$lQ6CS0KGQy8T330YymKSEuk3qz.yE79FPoiH4v8oPbVhIwCjcucgW', 'admin@gmail.com', 'admin', '2025-05-17 06:21:41'),
(3, 'monks', '$2y$10$j9hnJZKCjBqJvdcMMxlPw.ctfextq2GmN1vVTjCcjzJRWlQhSyI0K', 'monks@gmail.com', 'staff', '2025-05-17 06:40:42'),
(4, 'Novice', '$2y$10$nxIC3GSTpLw.7agC2KPAKusF8RXEEB7zn4J6QrzSLy3G879J//siS', 'vonice@gmai.com', 'staff', '2025-05-17 06:41:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `year_name` (`year_name`);

--
-- Indexes for table `majors`
--
ALTER TABLE `majors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `major_categories`
--
ALTER TABLE `major_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `std_cert`
--
ALTER TABLE `std_cert`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_code` (`certificate_code`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `std_code` (`std_code`),
  ADD KEY `major_id` (`major_id`),
  ADD KEY `academic_year_id` (`academic_year_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດປີການສຶກສາ', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `majors`
--
ALTER TABLE `majors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດສາຂາ', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `major_categories`
--
ALTER TABLE `major_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດໝວດສາຂາ', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດສະມາຊິກ';

--
-- AUTO_INCREMENT for table `std_cert`
--
ALTER TABLE `std_cert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດໃບປະກາດ';

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດນັກຮຽນ', AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ລະຫັດຜູ້ໃຊ້', AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `majors`
--
ALTER TABLE `majors`
  ADD CONSTRAINT `majors_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `major_categories` (`id`);

--
-- Constraints for table `std_cert`
--
ALTER TABLE `std_cert`
  ADD CONSTRAINT `std_cert_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
