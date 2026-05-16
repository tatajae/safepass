-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2026 at 08:36 AM
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
(19, 26, 'login', '2026-05-16 06:09:25');

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
(26, 'Tata', 'tata@gmail.com', '2026-05-15 12:20:07', NULL, 'I6VToFXGDsDErX3GWFlxIQ==', '3yVLF6cK9g07ZHtbsa2B+TdesClxMd1ScbB1iMAcrx0=');

-- --------------------------------------------------------

--
-- Table structure for table `vaults`
--

CREATE TABLE `vaults` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password_strength` varchar(20) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `encrypted_data` longtext DEFAULT NULL,
  `iv` text DEFAULT NULL,
  `salt` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaults`
--

INSERT INTO `vaults` (`id`, `user_id`, `created_at`, `password_strength`, `updated_at`, `encrypted_data`, `iv`, `salt`) VALUES
(18, 26, '2026-05-16 06:19:51', NULL, '2026-05-16 06:19:51', 'zxVF5RCI7oZCsZcQ82ay0/C2vL2MoQRk8S3vNzv9gPwN0JbEGTjKEZgESWv/Hb5tAuC4/wfbVXVXUxp4YqxIW+Vti/QS+bQFpPOXSoPoWrtRbdOPUWaTsPEfzrQfcpxq8S7E4AhwoY8Yt0+csQ==', 'UiKXfCmzfGTJBNAO', 'RQRY4k/dJGM3AN09p9fjZQ=='),
(19, 26, '2026-05-16 06:30:39', NULL, '2026-05-16 06:30:39', 'AQ5YUiPLdILtcHCKfgXhyMElbQ+I28EoSNntg3ctdUrXqZIwsECvBLSIgSvyX8bea8vlIXRHgIIxnG34i7FwVpH+IVYf0u501AYiXgZis9TXvf/JLC7SxbiiY/975J3uc7drC3lix56v', 'eo7SnLeYnK0xx6Td', 'osyk2xo+TzVt91un6gkgcA==');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `vaults`
--
ALTER TABLE `vaults`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
