-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2025 at 08:12 AM
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
-- Database: `sieksa`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `id_ekstrakurikuler` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `pertemuan` int(11) DEFAULT NULL,
  `materi` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'open',
  `path` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_ekstrakurikuler`, `tanggal`, `pertemuan`, `materi`, `status`, `path`) VALUES
(1, 1, '2025-06-11', 1, NULL, 'closed', NULL),
(2, 1, '2025-06-11', 1, 'q', 'closed', NULL),
(3, 1, '2025-06-11', 2, 'pertemuan ke 2', 'closed', NULL),
(4, 1, '2025-06-11', 2, 'nn', 'open', NULL),
(5, 1, '2025-06-11', 3, 'pp', 'closed', NULL),
(6, 1, '2025-06-11', 4, 'w', 'closed', NULL),
(7, 1, '2025-06-11', 4, 'dd', 'closed', NULL),
(8, 1, '2025-06-11', 5, 'gch', 'closed', NULL),
(9, 1, '2025-06-11', 2, '3', 'closed', NULL),
(10, 1, '2025-06-11', 6, 'e', 'closed', NULL),
(11, 1, '2025-06-11', 3, '2', 'closed', NULL),
(12, 1, '2025-06-11', 7, 'ff', 'closed', NULL),
(13, 1, '2025-06-11', 8, 'materi 8', 'closed', 'materi/K4jHEdDLLHg9RnNBwKAtHC21h5Ow0lfxL0pvBLaX.pdf'),
(14, 2, '2025-06-11', 1, 'pj2 test', 'open', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id_akun`, `nim`, `password`) VALUES
(2, '230411100040', '$2y$12$qKWVodHXGAdH6cgKF.ao/eYJKkLmuSIPd8jzF4rhULvJTyxIT.NiG'),
(3, '1', '$2y$12$FOVBOhpJUbOiu5SeH/1LBebGDHuYUILtKmhYtHegRz3CC0ccbLeC6'),
(13, '12', '$2y$12$NbtGQazCZYoQ.ChH7lxbf.GAGUMKcyTMi9w42eO0UkSG9g8hFDyG.'),
(15, '230411100181', '$2y$12$Ryuna8KHbkvrus9e31jH4uyQtSKoZIUXhILnB20Q6nIWdu4ZZeQpe'),
(16, '02', '$2y$12$2470P2Tqxp.lYw/bxKZER.A/hpdiKsqO.QxgbH.032tOIj.5N0hjK'),
(17, '0202', '$2y$12$t2/QuqFDV3KNyrMsiSxQp.tf.qAOQuKikBA4.GXha7/sbzb6vZ2DK'),
(19, '111', '$2y$12$XqWbl8b48/GW5HhuBaKuhOsg49y64T9b81aU92UPDBQhNAkWzuWTS'),
(20, '230411100089', '$2y$12$HUcRyZAvHKw.yiBX504RyOLPu4KWAhtcxV81Qe1inXbgVpQ/1r98m');

-- --------------------------------------------------------

--
-- Table structure for table `akuns`
--

CREATE TABLE `akuns` (
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_022|127.0.0.1', 'i:2;', 1750234718),
('laravel_cache_022|127.0.0.1:timer', 'i:1750234718;', 1750234718);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_absensi`
--

CREATE TABLE `detail_absensi` (
  `id_detail_absensi` int(11) NOT NULL,
  `id_absensi` int(11) NOT NULL,
  `id_pengguna` varchar(20) NOT NULL,
  `status` enum('hadir','sakit','izin','alpha') DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_absensi`
--

INSERT INTO `detail_absensi` (`id_detail_absensi`, `id_absensi`, `id_pengguna`, `status`, `note`) VALUES
(1, 1, '123', 'hadir', NULL),
(2, 1, '1', 'hadir', NULL),
(3, 10, '230411100040', 'hadir', 'Absensi via QR Code pada 2025-06-11 05:45:40'),
(4, 11, '230411100040', 'hadir', 'Absensi via QR Code pada 2025-06-11 06:05:06'),
(5, 8, '230411100040', 'hadir', 'Absensi via QR Code pada 2025-06-11 06:54:54'),
(6, 6, '230411100040', 'hadir', 'Absensi via QR Code pada 2025-06-11 06:57:53'),
(7, 13, '02', 'sakit', 'Absensi via QR Code pada 2025-06-11 10:39:55'),
(8, 2, '02', 'hadir', 'Absensi via QR Code pada 2025-06-11 10:41:41'),
(9, 14, '02', 'hadir', 'Absensi via QR Code pada 2025-06-11 10:47:30'),
(10, 4, '123', 'hadir', 'Absensi via QR Code pada 2025-06-11 11:01:23'),
(11, 14, '022', 'sakit', NULL);

--
-- Triggers `detail_absensi`
--
DELIMITER $$
CREATE TRIGGER `before_insert_detail_absensi_check_ekstra` BEFORE INSERT ON `detail_absensi` FOR EACH ROW BEGIN
    DECLARE registered_ekstra_id_pengguna VARCHAR(50); -- ID Ekstra yang terdaftar di tabel pengguna
    DECLARE absensi_ekstra_id VARCHAR(50);             -- ID Ekstra dari entri absensi terkait

    -- 1. Ambil id_ekstrakurikuler dari tabel 'pengguna' berdasarkan 'id_pengguna' yang melakukan absensi
    -- Asumsi: 'nim' di tabel 'pengguna' adalah ID pengguna yang dicocokkan dengan 'id_pengguna' di 'detail_absensi'
    SELECT id_ekstrakurikuler INTO registered_ekstra_id_pengguna
    FROM pengguna
    WHERE nim = NEW.id_pengguna;

    -- 2. Ambil id_ekstrakurikuler dari tabel 'absensi' berdasarkan 'id_absensi' dari detail_absensi yang akan disisipkan
    -- Asumsi: 'id_ekstrakurikuler' ada di tabel 'absensi'
    SELECT id_ekstrakurikuler INTO absensi_ekstra_id
    FROM absensi
    WHERE id_absensi = NEW.id_absensi;

    -- 3. Periksa apakah ID ekstrakurikuler yang terdaftar untuk pengguna
    --    cocok dengan ID ekstrakurikuler dari absensi yang terkait.
    --    Juga periksa jika ada data yang NULL (artinya NIM/ID Absensi tidak ditemukan)
    IF registered_ekstra_id_pengguna IS NULL OR absensi_ekstra_id IS NULL OR
       registered_ekstra_id_pengguna <> absensi_ekstra_id THEN
        -- Jika tidak cocok atau ada data yang tidak ditemukan, batalkan operasi INSERT
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Ketidakcocokan data Ekstrakurikuler. ID Ekstrakurikuler absensi tidak sesuai dengan yang terdaftar untuk pengguna ini, atau data absensi/pengguna tidak ditemukan.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ekstrakurikuler`
--

CREATE TABLE `ekstrakurikuler` (
  `id_ekstrakurikuler` int(11) NOT NULL,
  `nama_ekstra` varchar(100) NOT NULL,
  `hari` varchar(20) DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `kuota` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('buka','tutup') NOT NULL,
  `id_pj` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ekstrakurikuler`
--

INSERT INTO `ekstrakurikuler` (`id_ekstrakurikuler`, `nama_ekstra`, `hari`, `jam`, `kuota`, `keterangan`, `status`, `id_pj`) VALUES
(1, 'arduino', 'Rabu', '13:02:00', 11, 'arduino ekstra', 'tutup', NULL),
(2, 'english course', 'Minggu', '17:04:00', 10, 'ekstra  english course', 'buka', '0202'),
(4, 'banjari', 'Rabu', '17:18:00', 10, NULL, 'buka', '1');

--
-- Triggers `ekstrakurikuler`
--
DELIMITER $$
CREATE TRIGGER `cek_bentrok_ekskul` BEFORE INSERT ON `ekstrakurikuler` FOR EACH ROW BEGIN
  DECLARE bentrok INT;

  SELECT COUNT(*) INTO bentrok
  FROM ekstrakurikuler
  WHERE
    hari = NEW.hari AND
    TIMESTAMPDIFF(MINUTE, jam, NEW.jam) BETWEEN -90 AND 90;

  IF bentrok > 0 THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Jadwal ini bentrok dengan ekstra lainnya';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cek_bentrok_ekskul_update` BEFORE UPDATE ON `ekstrakurikuler` FOR EACH ROW BEGIN
  DECLARE bentrok INT;

  SELECT COUNT(*) INTO bentrok
  FROM ekstrakurikuler
  WHERE
    id_ekstrakurikuler != NEW.id_ekstrakurikuler AND
    hari = NEW.hari AND
    TIMESTAMPDIFF(MINUTE, jam, NEW.jam) BETWEEN -90 AND 90;

  IF bentrok > 0 THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Jadwal ini bentrok dengan ekstra lainnya';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_31_180928_add_two_factor_columns_to_users_table', 2),
(5, '2025_05_31_193908_create_akun_table', 2),
(6, '2025_06_11_055543_add_status_to_absensi_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `musahil_pendamping`
--

CREATE TABLE `musahil_pendamping` (
  `id_pendaping` int(11) NOT NULL,
  `id_musahil_pendamping` varchar(20) NOT NULL,
  `id_warga` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `musahil_pendamping`
--

INSERT INTO `musahil_pendamping` (`id_pendaping`, `id_musahil_pendamping`, `id_warga`) VALUES
(6, '02', '022'),
(1, '1', '230411100040'),
(2, '1', '230411100181'),
(4, '12', '123');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemateri`
--

CREATE TABLE `pemateri` (
  `id_pemateri` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `id_ekstrakulikuler` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `role` enum('warga','musahil','pj','admin') DEFAULT NULL,
  `id_ekstrakurikuler` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`nim`, `nama`, `email`, `telepon`, `role`, `id_ekstrakurikuler`) VALUES
('02', 'musahil2', 'musahil2@gmail.com', '000', 'musahil', 2),
('0202', 'pj2', 'pj2@gmail.com', '112', 'pj', 2),
('022', 'aldi02', 'aldi02@gmail.com', '11', 'warga', 2),
('1', 'musahil 1', 'musahil@gmail.com', '1', 'pj', 4),
('11', 'dioaja', 'diodio@gmail.com', '21', 'pj', NULL),
('111', 'admin', 'admin1@gmail.com', '999', 'admin', NULL),
('12', 'pj1', 'pj@gmail.com', '11', 'musahil', NULL),
('123', 'aldi', 'aldi@gmail.com', '000', 'warga', 2),
('230411100040', 'M. Aldi Rahmandika', 'aldirahmandika2@gmail.com', '000', 'warga', 2),
('230411100089', 'halo', 'halo@gmail.com', '089745672', 'musahil', 1),
('230411100181', 'Fathan', 'alizainfathan@gmail.com', '0897254562773', 'warga', 2);

--
-- Triggers `pengguna`
--
DELIMITER $$
CREATE TRIGGER `treshold_kuota` BEFORE UPDATE ON `pengguna` FOR EACH ROW BEGIN
    DECLARE jumlah INT DEFAULT 0;
    DECLARE num_kuota INT DEFAULT 0;

    IF NEW.id_ekstrakurikuler IS NOT NULL 
       OR NEW.id_ekstrakurikuler != OLD.id_ekstrakurikuler THEN
        SELECT COUNT(*) INTO jumlah 
        FROM pengguna 
        WHERE id_ekstrakurikuler = NEW.id_ekstrakurikuler;

        SELECT kuota INTO num_kuota 
        FROM ekstrakurikuler 
        WHERE id_ekstrakurikuler = NEW.id_ekstrakurikuler;

        IF jumlah >= num_kuota THEN
            SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'kuota pendaftaran penuh';
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('OeLScxHOO3FrAL18tbF9KI4BG8MCxhqrTSBrR1Fc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS2l5OHpYaTVjaEk0WHkxNHJQbW1UTjNPeE5PWDhHVlNicmx0YmQ3ciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fX0=', 1750351117);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'aldi rahmandika', 'aldirahmandika4@gmail.com', NULL, '$2y$12$qQiR1zMeBCBt2eBPZSTs7ewPfnifQIBN3qgZ42LjRHj.lFQRVdR0O', NULL, NULL, NULL, 'byYP3ejzh9eRf5JUE2ganqWmqS4hSycG9Rx1rd8M9UuOwu2zPXuLN2eEmOsX', '2025-05-31 11:25:11', '2025-05-31 11:25:11'),
(2, 'aldi', 'aldirahmandika2@gmail.com', NULL, '$2y$12$9I.AbkOSBdmoZPb/pN62telNmN8ihRlBDPxr2SMt4xuv3zazBWLDG', NULL, NULL, NULL, NULL, '2025-05-31 11:51:32', '2025-05-31 11:51:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `id_ekstrakulikuler` (`id_ekstrakurikuler`);

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `akuns`
--
ALTER TABLE `akuns`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `akuns_nim_unique` (`nim`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `detail_absensi`
--
ALTER TABLE `detail_absensi`
  ADD PRIMARY KEY (`id_detail_absensi`),
  ADD UNIQUE KEY `id_absensi` (`id_absensi`,`id_pengguna`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  ADD PRIMARY KEY (`id_ekstrakurikuler`),
  ADD KEY `idx_id_pj` (`id_pj`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `musahil_pendamping`
--
ALTER TABLE `musahil_pendamping`
  ADD PRIMARY KEY (`id_pendaping`),
  ADD UNIQUE KEY `id_musahil_pendamping` (`id_musahil_pendamping`,`id_warga`),
  ADD KEY `id_warga` (`id_warga`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pemateri`
--
ALTER TABLE `pemateri`
  ADD PRIMARY KEY (`id_pemateri`),
  ADD KEY `id_ekstrakulikuler` (`id_ekstrakulikuler`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`nim`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_ektrakulikuler` (`id_ekstrakurikuler`);

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
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `akuns`
--
ALTER TABLE `akuns`
  MODIFY `id_akun` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_absensi`
--
ALTER TABLE `detail_absensi`
  MODIFY `id_detail_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  MODIFY `id_ekstrakurikuler` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `musahil_pendamping`
--
ALTER TABLE `musahil_pendamping`
  MODIFY `id_pendaping` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pemateri`
--
ALTER TABLE `pemateri`
  MODIFY `id_pemateri` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_ekstrakurikuler`) REFERENCES `ekstrakurikuler` (`id_ekstrakurikuler`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `akun`
--
ALTER TABLE `akun`
  ADD CONSTRAINT `akun_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `pengguna` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_absensi`
--
ALTER TABLE `detail_absensi`
  ADD CONSTRAINT `detail_absensi_ibfk_1` FOREIGN KEY (`id_absensi`) REFERENCES `absensi` (`id_absensi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_absensi_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  ADD CONSTRAINT `fk_ekstrakurikuler_pj` FOREIGN KEY (`id_pj`) REFERENCES `pengguna` (`nim`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `musahil_pendamping`
--
ALTER TABLE `musahil_pendamping`
  ADD CONSTRAINT `musahil_pendamping_ibfk_1` FOREIGN KEY (`id_musahil_pendamping`) REFERENCES `pengguna` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `musahil_pendamping_ibfk_2` FOREIGN KEY (`id_warga`) REFERENCES `pengguna` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pemateri`
--
ALTER TABLE `pemateri`
  ADD CONSTRAINT `pemateri_ibfk_1` FOREIGN KEY (`id_ekstrakulikuler`) REFERENCES `ekstrakurikuler` (`id_ekstrakurikuler`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_ibfk_1` FOREIGN KEY (`id_ekstrakurikuler`) REFERENCES `ekstrakurikuler` (`id_ekstrakurikuler`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
