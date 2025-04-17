-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 07:51 AM
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
-- Database: `site_office_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `block_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `site_id`, `block_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Block A', '2025-04-14 04:17:01', '2025-04-14 04:17:01'),
(6, 3, 'Block D', '2025-04-14 05:05:21', '2025-04-14 05:05:21'),
(7, 6, 'Block A', '2025-04-14 05:17:22', '2025-04-14 05:17:22'),
(8, 1, 'Block B', '2025-04-14 07:02:21', '2025-04-14 07:02:21'),
(9, 8, 'Block B', '2025-04-14 23:09:09', '2025-04-14 23:09:09'),
(10, 2, 'Block 1', '2025-04-15 00:07:40', '2025-04-15 00:07:40'),
(11, 4, 'Block F', '2025-04-15 01:41:01', '2025-04-15 01:41:01'),
(12, 2, 'Block G', '2025-04-15 02:10:33', '2025-04-15 02:10:33'),
(13, 9, 'Block A', '2025-04-15 23:42:09', '2025-04-15 23:42:09'),
(14, 9, 'Block B', '2025-04-15 23:42:28', '2025-04-15 23:42:40'),
(15, 9, 'Block C', '2025-04-15 23:42:57', '2025-04-15 23:42:57');

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE `floors` (
  `id` int(11) NOT NULL,
  `block_id` int(11) NOT NULL,
  `floor_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `floors`
--

INSERT INTO `floors` (`id`, `block_id`, `floor_name`, `created_at`, `updated_at`) VALUES
(4, 8, 'Floor 2', '2025-04-14 07:04:59', '2025-04-14 07:04:59'),
(5, 1, 'Floor 1', '2025-04-14 07:21:06', '2025-04-15 01:44:32'),
(6, 9, 'Floor 2', '2025-04-14 23:10:10', '2025-04-14 23:10:10'),
(7, 6, 'Floor 3', '2025-04-14 23:10:29', '2025-04-14 23:10:29'),
(8, 10, 'Floor 7', '2025-04-15 00:08:03', '2025-04-15 00:08:03'),
(9, 11, 'Floor 10', '2025-04-15 01:44:45', '2025-04-15 01:44:45'),
(10, 6, 'Floor 10', '2025-04-15 02:09:33', '2025-04-15 02:09:33'),
(12, 14, 'Floor 1', '2025-04-15 23:43:21', '2025-04-15 23:43:21'),
(13, 14, 'Floor 2', '2025-04-15 23:43:38', '2025-04-15 23:43:38'),
(14, 15, 'Floor 1', '2025-04-15 23:44:04', '2025-04-15 23:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `id` int(11) NOT NULL,
  `floor_id` int(11) NOT NULL,
  `office_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`id`, `floor_id`, `office_name`, `created_at`, `updated_at`) VALUES
(2, 5, 'A12', '2025-04-14 23:43:55', '2025-04-15 23:31:13'),
(6, 6, 'Infotech', '2025-04-14 23:53:27', '2025-04-14 23:53:27'),
(9, 7, 'ADS Media', '2025-04-15 01:20:40', '2025-04-15 01:20:40'),
(11, 6, 'ITC', '2025-04-15 01:29:09', '2025-04-15 01:29:09'),
(12, 6, 'Ecofy', '2025-04-15 01:29:25', '2025-04-15 01:29:25'),
(13, 5, 'Tirth', '2025-04-15 01:29:47', '2025-04-15 01:29:47'),
(15, 9, 'Macro', '2025-04-15 01:47:11', '2025-04-15 01:47:11'),
(16, 5, 'Dixit', '2025-04-15 02:13:15', '2025-04-15 02:21:00'),
(19, 10, 'Pri', '2025-04-15 05:09:05', '2025-04-15 05:41:12'),
(21, 14, 'CA Mehta', '2025-04-15 23:45:11', '2025-04-15 23:45:11');

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `site_name`, `created_at`, `updated_at`) VALUES
(1, 'Goyal', '2025-04-14 01:29:59', '2025-04-14 03:57:04'),
(2, 'Shilp', '2025-04-14 01:31:32', '2025-04-14 01:31:32'),
(3, 'Shree Radhakrishna Group', '2025-04-14 01:32:29', '2025-04-14 01:32:29'),
(4, 'Ratnakar', '2025-04-14 01:35:38', '2025-04-14 01:35:38'),
(6, 'Shree Hari Developers', '2025-04-14 01:42:49', '2025-04-14 01:42:49'),
(8, 'Goyal & Co.', '2025-04-14 23:08:33', '2025-04-14 23:08:33'),
(9, 'Aakash Group', '2025-04-15 23:41:46', '2025-04-15 23:41:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `site_id` (`site_id`);

--
-- Indexes for table `floors`
--
ALTER TABLE `floors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `block_id` (`block_id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `floor_id` (`floor_id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `floors`
--
ALTER TABLE `floors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blocks`
--
ALTER TABLE `blocks`
  ADD CONSTRAINT `blocks_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `floors`
--
ALTER TABLE `floors`
  ADD CONSTRAINT `floors_ibfk_1` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offices`
--
ALTER TABLE `offices`
  ADD CONSTRAINT `offices_ibfk_1` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
