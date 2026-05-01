-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: May 01, 2026 at 08:27 PM
-- Server version: 8.0.43
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jerry_bil_jb`
--

-- --------------------------------------------------------

--
-- Table structure for table `guestbook`
--

CREATE TABLE `guestbook` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `message` text,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guestbook`
--

INSERT INTO `guestbook` (`id`, `name`, `message`, `timestamp`) VALUES
(1, 'jack', 'looks good', '2026-04-30 18:45:52'),
(2, 'jack', 'looks good', '2026-04-30 18:56:47'),
(3, 'jack', 'looks good', '2026-04-30 18:58:13'),
(4, 'jack', 'looks good', '2026-04-30 19:06:55'),
(5, 'jack', 'looks good', '2026-04-30 19:08:59'),
(6, 'jack', 'looks good', '2026-04-30 19:09:43'),
(7, 'jack', 'looks good', '2026-04-30 19:11:04'),
(8, 'jack', 'looks good', '2026-04-30 19:12:17'),
(9, 'jack', 'looks good', '2026-04-30 19:19:04');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int NOT NULL,
  `text` text,
  `author` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `text`, `author`, `timestamp`) VALUES
(1, 'Jerry\'s leadership at CSi Services transformed our operations. His disciplined approach delivered results.', 'Client A', '2026-04-29 19:49:51'),
(2, 'xFit changed my fitness journey. Jerry\'s programs are practical and effective.', 'Client B', '2026-04-29 19:49:51'),
(3, 'GrayMentality philosophy helped me find balance in life. Truly inspiring.', 'Client C', '2026-04-29 19:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `ip`, `country`, `city`, `timestamp`) VALUES
(1, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 19:49:52'),
(2, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 19:50:01'),
(3, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 19:54:18'),
(4, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 19:57:55'),
(5, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 19:59:53'),
(6, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 19:59:55'),
(7, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:00:19'),
(8, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:00:21'),
(9, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:00:39'),
(10, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:02:58'),
(11, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:03:02'),
(12, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:03:04'),
(13, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:04:25'),
(14, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:05:01'),
(15, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:24:26'),
(16, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:27:12'),
(17, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:28:55'),
(18, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:28:58'),
(19, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:29:01'),
(20, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:29:50'),
(21, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:29:54'),
(22, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:29:56'),
(23, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:30:31'),
(24, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:30:57'),
(25, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:31:13'),
(26, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:32:01'),
(27, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:34:29'),
(28, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:35:20'),
(29, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:43:24'),
(30, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:46:57'),
(31, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:53:57'),
(32, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:59:37'),
(33, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 20:59:47'),
(34, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 21:02:15'),
(35, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 21:05:08'),
(36, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 21:05:28'),
(37, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 21:08:11'),
(38, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 21:08:43'),
(39, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 21:10:06'),
(40, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 21:10:20'),
(41, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 21:11:48'),
(42, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 21:28:13'),
(43, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 21:29:38'),
(44, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 22:02:33'),
(45, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 22:38:45'),
(46, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-29 23:05:06'),
(47, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 00:24:12'),
(48, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 00:54:46'),
(49, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 01:50:20'),
(50, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 04:14:05'),
(51, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 04:22:40'),
(52, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 04:46:02'),
(53, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 06:09:49'),
(54, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 06:28:51'),
(55, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 06:28:52'),
(56, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 06:29:13'),
(57, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 06:29:14'),
(58, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 06:53:59'),
(59, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 07:26:24'),
(60, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 07:28:35'),
(61, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 07:51:34'),
(62, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 07:55:48'),
(63, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 07:56:11'),
(64, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 07:56:34'),
(65, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 10:21:31'),
(66, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 12:17:38'),
(67, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 12:56:09'),
(68, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 12:58:02'),
(69, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 13:04:41'),
(70, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 13:52:02'),
(71, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 13:52:54'),
(72, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 13:52:55'),
(73, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 14:00:40'),
(74, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 14:30:02'),
(75, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 15:46:22'),
(76, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 16:23:14'),
(77, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 16:23:15'),
(78, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 16:23:18'),
(79, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 16:24:48'),
(80, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 17:45:09'),
(81, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 18:42:26'),
(82, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 18:42:32'),
(83, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 18:45:52'),
(84, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 18:56:47'),
(85, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 18:58:13'),
(86, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 19:06:55'),
(87, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 19:08:59'),
(88, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 19:09:43'),
(89, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 19:11:04'),
(90, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 19:12:17'),
(91, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 19:19:04'),
(92, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 19:38:09'),
(93, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 21:00:19'),
(94, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 21:00:20'),
(95, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 21:00:22'),
(96, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 22:13:21'),
(97, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 22:34:07'),
(98, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 23:05:34'),
(99, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 23:12:23'),
(100, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 23:34:04'),
(101, '172.20.0.1', 'Unknown', 'Unknown', '2026-04-30 23:36:08'),
(102, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 00:21:23'),
(103, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 02:01:01'),
(104, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 02:12:07'),
(105, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 02:24:56'),
(106, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 03:34:55'),
(107, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 06:45:51'),
(108, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 07:04:31'),
(109, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 07:25:03'),
(110, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 07:25:03'),
(111, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 08:04:37'),
(112, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 08:09:00'),
(113, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 08:09:21'),
(114, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 09:02:06'),
(115, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 09:30:13'),
(116, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 09:40:11'),
(117, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 09:57:58'),
(118, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 10:02:46'),
(119, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 10:38:02'),
(120, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 11:55:06'),
(121, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 11:56:08'),
(122, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 13:30:03'),
(123, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 13:30:03'),
(124, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 13:58:51'),
(125, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 14:01:32'),
(126, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 14:41:52'),
(127, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 17:09:36'),
(128, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 17:09:37'),
(129, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 17:09:38'),
(130, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 17:09:38'),
(131, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 17:09:39'),
(132, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 19:45:11'),
(133, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 20:26:27'),
(134, '172.20.0.1', 'Unknown', 'Unknown', '2026-05-01 20:26:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guestbook`
--
ALTER TABLE `guestbook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guestbook`
--
ALTER TABLE `guestbook`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
