-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jan 2021 pada 13.11
-- Versi server: 10.4.8-MariaDB
-- Versi PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_wisuda`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `administrators`
--

CREATE TABLE `administrators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_admin` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `administrators`
--

INSERT INTO `administrators` (`id`, `nama_admin`, `username`, `password`, `last_login`, `created_at`, `updated_at`) VALUES
(3, 'Admin', 'admin', '$2y$10$QwnguEtcDmercHyNgLoecOgQ6Cx27oK2hyh0f2souu0ENS4pQBIEG', '2021-01-09 05:02:31', '2020-11-10 07:36:18', '2021-01-09 05:02:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `departements`
--

CREATE TABLE `departements` (
  `id_prodi` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_prodi` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenjang` enum('D3','S1','S2','S3') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `departements`
--

INSERT INTO `departements` (`id_prodi`, `nama_prodi`, `jenjang`, `created_at`, `updated_at`) VALUES
('55201', 'Teknik Informatika', 'S1', '2020-11-01 01:56:49', '2020-11-27 10:16:59'),
('57201', 'Sistem Informasi', 'S1', '2020-11-01 06:00:48', NULL),
('57401', 'Manajemen Informatika', 'D3', '2020-11-29 12:56:59', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `graduations`
--

CREATE TABLE `graduations` (
  `tahun` year(4) NOT NULL,
  `angkatan` int(11) NOT NULL,
  `tgl_wisuda` date NOT NULL,
  `tgl_yudisium` date NOT NULL,
  `tempat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `graduations`
--

INSERT INTO `graduations` (`tahun`, `angkatan`, `tgl_wisuda`, `tgl_yudisium`, `tempat`) VALUES
(2020, 1, '2020-11-13', '2020-11-12', 'AP'),
(2021, 2, '2021-01-09', '2021-01-09', 'Asia Plaza');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2020_10_29_073931_create_graduations_table', 1),
(4, '2020_10_30_093640_create_administrators_table', 2),
(5, '2020_11_01_075020_create_departements_table', 3),
(6, '2020_11_01_101637_create_students_table', 4),
(7, '2020_11_16_185934_create_verifications_table', 5),
(8, '2020_11_21_091714_create_testimonials_table', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `students`
--

CREATE TABLE `students` (
  `nim` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_mhs` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jk` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `id_prodi` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year(4) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ipk` decimal(3,2) UNSIGNED NOT NULL,
  `judul_skripsi` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `edited` enum('not yet','edited') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not yet',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `students`
--

INSERT INTO `students` (`nim`, `nama_mhs`, `jk`, `tempat_lahir`, `tgl_lahir`, `id_prodi`, `tahun`, `email`, `no_hp`, `alamat`, `photo`, `ipk`, `judul_skripsi`, `password`, `last_login`, `edited`, `created_at`, `updated_at`) VALUES
('A2.1700001', 'Deden Juliandi', 'L', 'Sumedang', '2020-11-25', '55201', 2020, 'dede@gmail.com', '082218725241', 'Sumedang Utara', 'A21700001.jpg', '4.00', 'Aplikasi Sidang dan Skripsi', '$2y$10$f6HgYTActEbB.QoXNT7vj.lvMtVd2gANJmwavNwE4T4MLEglw4vDC', '2021-01-09 04:57:13', 'edited', '2020-11-16 13:21:42', '2021-01-09 05:00:01'),
('A2.1700002', 'Yusup Apandi', 'L', 'Sumedang', '1999-04-18', '55201', 2020, 'dede@gmail.com', '082218725241', 'Sumedang', NULL, '4.00', 'Aplikasi Sidang dan Skripsi', '$2y$10$LZ3aN2AO0rzxFgmsQgUaPu8igGBaS0Bc9J8vot8o9MKVotnAEI2si', '2020-12-27 01:28:22', 'edited', '2020-11-16 13:21:42', '2020-12-27 01:28:22'),
('A2.1700077', 'Tari', 'P', 'Sumedang', '2021-01-05', '55201', 2021, 'A2.1700139@stmik-sumedang.ac.id', '082218725240', 'Sumedang', NULL, '3.80', 'Aplikasi', '$2y$10$qXPuURRli3QlsMuFuSHzvucSjtndNssK83beU208AhlVdNpnFAA4K', '2021-01-09 05:03:35', 'edited', '2021-01-09 04:50:40', '2021-01-09 05:03:35'),
('A2.1700087', 'devan', 'L', 'bandung', '1999-11-27', '57201', 2020, 'dede1@gmail.com', '082218725241', 'kebon kalapa', 'A21700087.jpg', '3.39', 'bank', '$2y$10$uDT5H67pKB6mD810fwpdM.e98vOOwC5i1CIBzUHh9D5ZiYVurS11m', '2020-12-27 01:59:00', 'edited', '2020-11-26 07:03:31', '2020-12-27 03:16:21'),
('A2.1700088', 'Radi Aditya', 'L', NULL, NULL, '55201', 2021, NULL, NULL, NULL, NULL, '4.00', 'Aplikasi Wisuda', '$2y$10$vwN2DZ6tSL8uH8NzAnM.1uoBC/W9XNVNkE1eK1tWeU52F6McFtWk6', '2021-01-09 04:16:01', 'not yet', '2021-01-09 03:59:08', '2021-01-09 04:16:01');

--
-- Trigger `students`
--
DELIMITER $$
CREATE TRIGGER `create_verifications` AFTER INSERT ON `students` FOR EACH ROW INSERT INTO verifications SET nim = NEW.nim
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_verifications` AFTER DELETE ON `students` FOR EACH ROW DELETE FROM verifications WHERE nim = OLD.nim
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nim` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `testimoni` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `testimonials`
--

INSERT INTO `testimonials` (`id`, `nim`, `testimoni`, `rating`, `created_at`, `updated_at`) VALUES
(9, 'A2.1700001', 'ohdaisk', 4, '2020-11-26 06:57:23', '2021-01-09 04:58:37'),
(10, 'A2.1700002', 'Sangat Puas', 5, '2020-12-27 01:28:37', NULL),
(11, 'A2.1700087', 'Netral', 3, '2020-12-27 01:59:11', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `verifications`
--

CREATE TABLE `verifications` (
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembayaran` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lppm` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perpus` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pembayaran` enum('not uploaded','pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not uploaded',
  `status_lppm` enum('not uploaded','pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not uploaded',
  `status_perpus` enum('not uploaded','pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not uploaded'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `verifications`
--

INSERT INTO `verifications` (`nim`, `pembayaran`, `lppm`, `perpus`, `status_pembayaran`, `status_lppm`, `status_perpus`) VALUES
('A2.1700001', 'A21700001.png', 'A21700001.png', 'A21700001.jpeg', 'approved', 'approved', 'approved'),
('A2.1700002', 'A21700002.jpeg', 'A21700002.jpeg', 'A21700002.jpg', 'approved', 'approved', 'approved'),
('A2.1700077', 'A21700077.jpg', 'A21700077.jpg', 'A21700077.png', 'approved', 'pending', 'approved'),
('A2.1700087', 'A21700087.png', 'A21700087.png', 'A21700087.jpg', 'approved', 'approved', 'approved'),
('A2.1700088', NULL, NULL, NULL, 'not uploaded', 'not uploaded', 'not uploaded');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `administrators_username_unique` (`username`);

--
-- Indeks untuk tabel `departements`
--
ALTER TABLE `departements`
  ADD PRIMARY KEY (`id_prodi`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `graduations`
--
ALTER TABLE `graduations`
  ADD PRIMARY KEY (`tahun`),
  ADD UNIQUE KEY `angkatan` (`angkatan`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`nim`);

--
-- Indeks untuk tabel `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `verifications`
--
ALTER TABLE `verifications`
  ADD PRIMARY KEY (`nim`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
