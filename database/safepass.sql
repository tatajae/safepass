-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2026 at 03:50 PM
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
-- Database: `safepass`
--

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `activity` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `activity`, `created_at`) VALUES
(1, 5, 'Login berhasil', '2026-05-14 02:42:06'),
(2, 5, 'Login berhasil', '2026-05-14 10:28:23'),
(3, 5, 'Login berhasil', '2026-05-14 10:37:20'),
(4, 5, 'Login berhasil', '2026-05-14 10:50:30'),
(5, 5, 'Login berhasil', '2026-05-14 11:10:58'),
(6, 5, 'Login berhasil', '2026-05-14 11:15:29'),
(7, 5, 'Login berhasil', '2026-05-14 11:50:33'),
(8, 5, 'Login berhasil', '2026-05-14 14:04:55'),
(9, 5, 'login', '2026-05-15 08:48:51'),
(10, 5, 'login', '2026-05-15 09:09:50'),
(11, 5, 'login', '2026-05-15 09:36:39'),
(12, 5, 'login', '2026-05-15 09:46:07'),
(13, 25, 'login', '2026-05-15 09:50:39'),
(14, 5, 'login', '2026-05-15 12:09:56'),
(15, 26, 'login', '2026-05-15 12:20:23'),
(16, 26, 'login', '2026-05-15 12:31:45'),
(17, 26, 'login', '2026-05-15 13:20:59'),
(18, 26, 'login', '2026-05-16 05:59:41'),
(19, 26, 'login', '2026-05-16 06:09:25'),
(20, 26, 'login', '2026-05-18 02:48:57'),
(21, 26, 'login', '2026-05-18 03:18:55'),
(22, 26, 'login', '2026-05-18 03:37:26'),
(23, 26, 'login', '2026-05-18 03:43:26'),
(24, 26, 'login', '2026-05-18 03:50:12'),
(25, 26, 'login', '2026-05-18 04:06:14'),
(26, 26, 'login', '2026-05-18 04:15:43'),
(27, 26, 'login', '2026-05-18 04:37:23'),
(28, 26, 'login', '2026-05-23 10:31:07'),
(29, 27, 'login', '2026-05-24 11:01:40'),
(30, 27, 'login', '2026-05-24 11:11:17'),
(31, 27, 'login', '2026-05-24 11:43:01'),
(32, 26, 'login', '2026-05-24 11:46:36'),
(33, 27, 'login', '2026-05-24 11:53:18'),
(34, 27, 'login', '2026-05-24 12:11:09'),
(35, 28, 'login', '2026-05-24 12:23:38'),
(36, 28, 'login', '2026-05-24 12:34:18'),
(37, 27, 'login', '2026-05-24 12:44:59'),
(38, 27, 'login', '2026-05-24 12:53:32'),
(39, 27, 'login', '2026-05-24 12:54:30'),
(40, 27, 'login', '2026-05-24 13:05:53'),
(41, 27, 'login', '2026-05-24 13:11:33'),
(42, 27, 'login', '2026-05-24 13:21:29'),
(43, 27, 'login', '2026-05-24 13:30:13'),
(44, 29, 'login', '2026-05-24 13:31:30'),
(45, 29, 'login', '2026-05-24 13:38:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `salt` text DEFAULT NULL,
  `auth_verifier` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `created_at`, `last_login`, `salt`, `auth_verifier`) VALUES
(26, 'Tata', 'tata@gmail.com', '2026-05-15 12:20:07', NULL, 'I6VToFXGDsDErX3GWFlxIQ==', '3yVLF6cK9g07ZHtbsa2B+TdesClxMd1ScbB1iMAcrx0='),
(27, 'Jaehyun', 'jaehyun@gmail.com', '2026-05-24 11:01:19', NULL, 'dy4jlb/6gNxDlhqsUZMV2Q==', 'jWwR/QIO3xAL/NEINAy+NszBmlNqxJcv1d89LCXhpyM='),
(29, 'Caca', 'caca@gmail.com', '2026-05-24 13:31:20', NULL, 'DIoeYFRBdxy4gmGLLBUWkw==', 'b6siUXqiQSCGfHtRCU45whL0MxJjmeNEiXZ4VQCJlOo=');

-- --------------------------------------------------------

--
-- Table structure for table `vaults`
--

CREATE TABLE `vaults` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `website` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password_strength` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `encrypted_data` longtext DEFAULT NULL,
  `iv` text DEFAULT NULL,
  `salt` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaults`
--

INSERT INTO `vaults` (`id`, `user_id`, `website`, `username`, `created_at`, `password_strength`, `updated_at`, `encrypted_data`, `iv`, `salt`) VALUES
(33, 27, 'Gmail', 'Jaehyun127@gmail.com', '2026-05-24 11:34:11', 'Strong', '2026-05-24 11:34:11', 'q0F4b1iesWaGdoc9dbG3jCmTdAGI6rxAQyT5m3p1WCWnd8ReEZ2DJXTR0aqfSO5ypFSzZ0XFQGeVlfd79N+Kd+gz5Zr8EVSsGxbllxcz536swk9gpdS7xk5ABI76wqZPHtk45mJCNXMArg==', '9EmtHI2w6Er41URm', 'lloHD5XtZ14r74XF4BLCQQ=='),
(35, 27, 'Instagram', 'Jaehyunnn', '2026-05-24 11:47:55', 'Weak', '2026-05-24 11:55:57', 'iI69PFRP8XblAz/jamalfznUatX7bu2olEkNl5Vtrx9tmS5kwZZEI0hXsrFMGXL7dmsU8srV9xCl/r01kKrBV4IBSGA2LLR5iSgt8oHVAXL4EKcUK7BGG60=', 'EhgiT7Z7MrQyQ18V', 'cAT32Y0EvvoNkZudnGEcwQ=='),
(36, 27, 'Instagram', 'jejeje', '2026-05-24 12:12:11', 'Weak', '2026-05-24 12:12:11', 'ziWfK0tfmkZycF5rYtbyIYD8UD1mo2SJZXm4emmST/k7Zyt8aH620v7oCOQ+6+F3hhQ+6NWTYRj0I43o9qV6/852inu+SRJTwsfrDiReUI+AxvU7KO2/', 'dD0lXLnon9n37oAC', 'YISqHdYYLNDgIGQ6NUMc4A==');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vaults`
--
ALTER TABLE `vaults`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `vaults`
--
ALTER TABLE `vaults`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
