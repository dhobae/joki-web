-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 28, 2025 at 07:42 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pinjaman_mobil_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_jenis` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id`, `nama_jenis`, `created_at`, `updated_at`) VALUES
(1, 'suv', NULL, NULL),
(2, 'sedan', '2025-07-27 23:36:22', '2025-07-27 23:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `merk`
--

CREATE TABLE `merk` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_merk` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merk`
--

INSERT INTO `merk` (`id`, `nama_merk`, `created_at`, `updated_at`) VALUES
(1, 'bmw', NULL, NULL),
(2, 'audi', '2025-07-27 23:36:31', '2025-07-27 23:36:31');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2025_07_22_152130_create_pinjaman_mobil_db_merk_table', 1),
(3, '2025_07_22_153830_create_pinjaman_mobil_db_jenis_table', 1),
(4, '2025_07_22_154202_create_pinjaman_mobil_db_mobil_table', 1),
(5, '2025_07_22_160130_create_pinjaman_mobil_db_peminjaman_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id` bigint UNSIGNED NOT NULL,
  `plat_mobil` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_merk` bigint UNSIGNED NOT NULL,
  `id_jenis` bigint UNSIGNED NOT NULL,
  `model` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` int NOT NULL,
  `foto_mobil` text COLLATE utf8mb4_unicode_ci,
  `catatan_lain` text COLLATE utf8mb4_unicode_ci,
  `status_mobil` enum('Tersedia','Tidak Tersedia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id`, `plat_mobil`, `id_merk`, `id_jenis`, `model`, `kapasitas`, `foto_mobil`, `catatan_lain`, `status_mobil`, `created_at`, `updated_at`) VALUES
(1, 'DA 7123 PCF', 1, 1, 'ADwad', 1, 'foto_mobil/bIRo9c8nUGmPmos9KWzBeQaQb5rZ80FwqvcnVQCR.png', NULL, 'Tersedia', '2025-07-27 23:16:17', '2025-07-27 23:16:30'),
(2, 'adwaad', 1, 1, 'awdwadwa', 1, 'foto_mobil/EfIbf0EW5lEdzoOytNRlUq5NnboJsSnBDh6wrUdn.png', NULL, 'Tersedia', '2025-07-27 23:17:03', '2025-07-27 23:18:37');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_mobil` bigint UNSIGNED NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `tanggal_pengembalian` datetime DEFAULT NULL,
  `status_peminjaman` enum('diajukan','disetujui','digunakan','dikembalikan','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diajukan',
  `bukti_pengembalian` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Yc1K4QIi1ZMgim9PCQHBhpkUBEbHstezrSEPiXBG', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV2xJS0FsUWcxdjJydWo0VkMxcHE3SnlhRkx5TGcwSVJEQ3RUTnhOZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tb2JpbCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1753688515);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `divisi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peran` enum('admin','karyawan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `no_telp`, `divisi`, `peran`, `foto`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ridho s', 'lesturegt@gmail.com', '081323464274', 'adwaawda', 'karyawan', NULL, NULL, '$2y$12$gS7o0KLO4yuBzKmZz8ytFOURtKs4SVQWkpe/tDqLXr9PmNjKgX/qi', NULL, '2025-07-27 22:24:48', '2025-07-27 22:24:48'),
(2, 'Admin', 'admin@gmail.com', '08579902422', 'Pengawas', 'admin', 'none', '2025-07-27 22:38:23', '$2y$12$W13DgutX3cOwmuV6hzqpBOCH/nYDoqAQJyUO1OwrDDaVWZYdRwPyC', NULL, '2025-07-27 22:38:23', '2025-07-27 22:38:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merk`
--
ALTER TABLE `merk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobil_plat_mobil_unique` (`plat_mobil`),
  ADD KEY `mobil_id_merk_foreign` (`id_merk`),
  ADD KEY `mobil_id_jenis_foreign` (`id_jenis`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjaman_id_user_foreign` (`id_user`),
  ADD KEY `peminjaman_id_mobil_foreign` (`id_mobil`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `merk`
--
ALTER TABLE `merk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mobil`
--
ALTER TABLE `mobil`
  ADD CONSTRAINT `mobil_id_jenis_foreign` FOREIGN KEY (`id_jenis`) REFERENCES `jenis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mobil_id_merk_foreign` FOREIGN KEY (`id_merk`) REFERENCES `merk` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_id_mobil_foreign` FOREIGN KEY (`id_mobil`) REFERENCES `mobil` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
