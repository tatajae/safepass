-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Bulan Mei 2026 pada 12.23
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

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
-- Struktur dari tabel `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `activity` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `logs`
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
(20, 26, 'login', '2026-05-23 10:03:34'),
(21, 26, 'login', '2026-05-23 10:09:30'),
(22, 26, 'login', '2026-05-23 10:13:22'),
(23, 26, 'login', '2026-05-24 06:02:55'),
(24, 27, 'login', '2026-05-24 07:18:30'),
(25, 27, 'login', '2026-05-24 07:51:41'),
(26, 27, 'login', '2026-05-24 08:11:37'),
(27, 27, 'login', '2026-05-24 08:17:04'),
(28, 27, 'login', '2026-05-24 08:20:58'),
(29, 26, 'login', '2026-05-24 08:25:09'),
(30, 26, 'login', '2026-05-24 08:31:21'),
(31, 27, 'login', '2026-05-24 08:36:56'),
(32, 27, 'login', '2026-05-24 08:45:01'),
(33, 27, 'login', '2026-05-24 08:48:32'),
(34, 27, 'login', '2026-05-24 08:53:58'),
(35, 27, 'login', '2026-05-24 08:54:19'),
(36, 27, 'login', '2026-05-24 08:56:10'),
(37, 27, 'login', '2026-05-24 09:05:42'),
(38, 27, 'login', '2026-05-24 09:34:53'),
(39, 27, 'login', '2026-05-24 09:43:29'),
(40, 27, 'login', '2026-05-24 09:50:44'),
(41, 27, 'login', '2026-05-24 09:51:39'),
(42, 27, 'login', '2026-05-24 09:58:39'),
(43, 27, 'login', '2026-05-24 10:09:48'),
(44, 27, 'login', '2026-05-24 10:22:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
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
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `created_at`, `last_login`, `salt`, `auth_verifier`) VALUES
(26, 'Tata', 'tata@gmail.com', '2026-05-15 12:20:07', NULL, 'I6VToFXGDsDErX3GWFlxIQ==', '3yVLF6cK9g07ZHtbsa2B+TdesClxMd1ScbB1iMAcrx0='),
(27, 'Jaehyun', 'Jaehyun@gmail.com', '2026-05-24 07:18:17', NULL, 'n80tJCgVnAldC25zewye6Q==', '3ZPOua5UylIhrfLG7Nx26dnchNQz258CMlcoc8nMTH4=');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vaults`
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
-- Dumping data untuk tabel `vaults`
--

INSERT INTO `vaults` (`id`, `user_id`, `created_at`, `password_strength`, `updated_at`, `encrypted_data`, `iv`, `salt`) VALUES
(18, 26, '2026-05-16 06:19:51', NULL, '2026-05-16 06:19:51', 'zxVF5RCI7oZCsZcQ82ay0/C2vL2MoQRk8S3vNzv9gPwN0JbEGTjKEZgESWv/Hb5tAuC4/wfbVXVXUxp4YqxIW+Vti/QS+bQFpPOXSoPoWrtRbdOPUWaTsPEfzrQfcpxq8S7E4AhwoY8Yt0+csQ==', 'UiKXfCmzfGTJBNAO', 'RQRY4k/dJGM3AN09p9fjZQ=='),
(19, 26, '2026-05-16 06:30:39', NULL, '2026-05-24 08:55:05', 'avisbudimanLtcHCKfgXhyMElbQ+I28EoSNntg3ctdUrXqZIwsECvBLSIgSvyX8bea8vlIXRHgIIxnG34i7FwVpH+IVYf0u501AYiXgZis9TXvf/JLC7SxbiiY/975J3uc7drC3lix56v', 'avissLeYnK0xx6Td', 'avissxo+TzVt91un6gkgcA=='),
(20, 26, '2026-05-23 10:10:17', NULL, '2026-05-24 06:04:06', '2u7gQMlElF/RtibCCe3w+AqnkTDSvgS4xxMmNLr172x7LM+sGDG1W2F5HTf+uJv03Cg/5iZvXe3jfAzWTatyRFzPDTSePfRte9JSBkNmaRNDfuXinEPZBTo=', 'y20tvpEFUgT5GS0o', 'g8DqmTt2zaETihz41TrIIQ=='),
(24, 27, '2026-05-24 09:59:15', NULL, '2026-05-24 09:59:15', 'W2gCYqgpeMwxROMRNDzStJAzyG1pJHacitkDN10Vz04vktu2p/PQp/x00ozqSqiAFUatjNflXaf7KMWojReU1wI/aJ6c2SwF4i1R4hMCOg5b9KhArqUZMGRGEHG+ag==', '2z969/XjJbTmeTM9', 'Fx2hibfeOBAyhGZCJQOLMw=='),
(25, 27, '2026-05-24 10:08:32', NULL, '2026-05-24 10:09:31', 'zzzzzzzzzzwwMaMZEsbTEakkZZ859d8Xm1htjzbFDJaEoDXOkyxDzS4sKYK/gcg8fIFGtjrcicalnemU3L2tZYIJJKXXsL2FKLa+8jtDZrBvq5DHpMMIYrrAmgIVAo4k', '2A5GrEpaV8sr3/+k', 'bThYTlbGqwdfaeW3NwD72A==');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `vaults`
--
ALTER TABLE `vaults`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `vaults`
--
ALTER TABLE `vaults`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
