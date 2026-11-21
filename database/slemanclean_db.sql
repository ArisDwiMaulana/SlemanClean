-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Nov 21, 2026 at 02:51 AM
-- Server version: 8.0.46
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slemanclean_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `nama`) VALUES
(1, 'Berbah'),
(2, 'Cangkringan'),
(3, 'Depok'),
(4, 'Gamping'),
(5, 'Godean'),
(6, 'Kalasan'),
(7, 'Minggir'),
(8, 'Mlati'),
(9, 'Moyudan'),
(10, 'Ngaglik'),
(11, 'Ngemplak'),
(12, 'Pakem'),
(13, 'Prambanan'),
(14, 'Seyegan'),
(15, 'Sleman'),
(16, 'Tempel'),
(17, 'Turi');

-- --------------------------------------------------------

--
-- Table structure for table `paket_layanan`
--

CREATE TABLE `paket_layanan` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int NOT NULL,
  `durasi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paket_layanan`
--

INSERT INTO `paket_layanan` (`id`, `nama`, `harga`, `durasi`, `deskripsi`) VALUES
('deep', 'Deep Cleaning', 250000, '~5 Jam', 'Pembersihan menyeluruh: kerak kamar mandi, noda dapur, disinfeksi sanitasi.'),
('standard', 'Standard Cleaning', 120000, '~3 Jam', 'Pembersihan rutin: sapu, pel, debu perabot, kamar, dan sampah.');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int NOT NULL,
  `no_order` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `paket_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan_id` int NOT NULL,
  `slot_id` int NOT NULL,
  `tim_id` int DEFAULT NULL,
  `alamat_lengkap` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `total_biaya` int NOT NULL,
  `metode_pembayaran` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pembayaran` enum('Lunas','Pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Lunas',
  `status_pesanan` enum('Diproses','Selesai','Dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diproses',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `no_order`, `user_id`, `paket_id`, `kecamatan_id`, `slot_id`, `tim_id`, `alamat_lengkap`, `tanggal`, `catatan`, `total_biaya`, `metode_pembayaran`, `status_pembayaran`, `status_pesanan`, `created_at`) VALUES
(1, 'SC-20270125-1C34', 2, 'deep', 6, 2, 3, 'Jl. Solo KM 12, Kalasan', '2027-01-25', 'Fokus kamar mandi', 250000, 'QRIS', 'Lunas', 'Diproses', '2026-11-19 12:50:54'),
(2, 'SC-20270125-A2B2', 2, 'standard', 3, 2, 3, 'Condongcatur, Depok', '2027-01-25', NULL, 120000, 'Transfer Bank', 'Lunas', 'Dibatalkan', '2026-11-19 12:50:54'),
(3, 'SC-20270125-8148', 2, 'standard', 3, 2, 2, 'Condongcatur, Depok', '2027-01-25', NULL, 120000, 'QRIS', 'Lunas', 'Selesai', '2026-11-19 12:50:54'),
(4, 'SC-20270125-64EF', 2, 'standard', 3, 2, 1, 'Condongcatur, Depok', '2027-01-25', NULL, 120000, 'QRIS', 'Lunas', 'Diproses', '2026-11-19 12:50:54'),
(5, 'SC-20261109-9942', 3, 'standard', 13, 1, 1, 'Jl. Prambanan No. 5', '2026-11-09', 'Bersihkan ruang tamu', 120000, 'Transfer Bank', 'Lunas', 'Diproses', '2026-11-19 12:50:54'),
(6, 'SC-20261109-36AA', 4, 'standard', 3, 2, 2, 'Perum Condongcatur Asri B-4', '2026-11-09', NULL, 120000, 'QRIS', 'Lunas', 'Selesai', '2026-11-19 12:50:54'),
(7, 'SC-20261121-81AF', 5, 'standard', 3, 1, 2, 'Kost putra amanah, Pugeran, Maguwoharjo', '2026-11-22', '', 120000, 'Transfer Bank', 'Lunas', 'Selesai', '2026-11-21 01:47:38');

-- --------------------------------------------------------

--
-- Table structure for table `slot_waktu`
--

CREATE TABLE `slot_waktu` (
  `id` int NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slot_waktu`
--

INSERT INTO `slot_waktu` (`id`, `nama`, `jam`) VALUES
(1, 'Slot 1 (Pagi)', '08:00 - 11:00'),
(2, 'Slot 2 (Siang)', '13:00 - 16:00'),
(3, 'Slot 3 (Sore)', '16:30 - 19:30');

-- --------------------------------------------------------

--
-- Table structure for table `tim_kebersihan`
--

CREATE TABLE `tim_kebersihan` (
  `id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ketua` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wa` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_operasional` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tim_kebersihan`
--

INSERT INTO `tim_kebersihan` (`id`, `nama`, `ketua`, `wa`, `status_operasional`, `created_at`) VALUES
(1, 'Tim Merapi Clean', 'Ahmad Fauzi', '081223344550', 'aktif', '2026-11-19 12:50:54'),
(2, 'Tim Sleman Sembada', 'Bagus Pratama', '081334455660', 'aktif', '2026-11-19 12:50:54'),
(3, 'Tim Kaliurang Bersih', 'Chandra Wijaya', '081556677880', 'aktif', '2026-11-19 12:50:54'),
(4, 'pandawara', 'ucup', '0812345623', 'nonaktif', '2026-11-20 13:37:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_wa` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan_asal` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_asal` text COLLATE utf8mb4_unicode_ci,
  `role` enum('admin','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `no_wa`, `kecamatan_asal`, `alamat_asal`, `role`, `created_at`) VALUES
(1, 'Admin SlemanClean', 'admin@slemanclean.id', '$2y$10$oM0AXMzoyDpVXQahcMSI8OW1rnDNpNPILpItsltItiq2ixh0veU82', '081200000000', 'Depok', 'Kantor Operasional Depok, Sleman', 'admin', '2026-11-19 12:50:54'),
(2, 'Siti Rahmawati', 'siti@gmail.com', '$2y$10$if/vCc2wWzPSM/kLaMjb1en4ByKs774HL8zloCCxpsTKJk.eca5E2', '085712345678', 'Kalasan', 'Jl. Solo KM 12, Kalasan, Sleman', 'customer', '2026-11-19 12:50:54'),
(3, 'Doni Kusuma', 'doni@gmail.com', '$2y$10$if/vCc2wWzPSM/kLaMjb1en4ByKs774HL8zloCCxpsTKJk.eca5E2', '087890123456', 'Prambanan', 'Jl. Prambanan No. 5, Sleman', 'customer', '2026-11-19 12:50:54'),
(4, 'Juned', 'juned@gmail.com', '$2y$10$if/vCc2wWzPSM/kLaMjb1en4ByKs774HL8zloCCxpsTKJk.eca5E2', '081234567890', 'Depok', 'Perum Condongcatur Asri B-4, Depok, Sleman', 'customer', '2026-11-19 12:50:54'),
(5, 'mamat', 'mamat@gmail.com', '$2y$10$jseR914CYzVwxDC6r9gh0uCBEvr1JUF6xrtiry7E45AggIxUtyQ.a', '0812345678', 'Kalasan', 'Duri, Tirtomartani, Kec. Kalasan, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55571', 'customer', '2026-11-19 14:10:02'),
(6, 'courage', 'courage@gmail.com', '$2y$10$gmPviohF8OYxhW5O8XIwhuAWviXofwkoMwh.qXwcJO3KDE1reUgwe', '08442432543346', 'Depok', 'Pugeran, Maguwoharjo, Depok, Sleman', 'customer', '2026-11-19 14:21:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `paket_layanan`
--
ALTER TABLE `paket_layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_order` (`no_order`),
  ADD KEY `fk_pesanan_user` (`user_id`),
  ADD KEY `fk_pesanan_paket` (`paket_id`),
  ADD KEY `fk_pesanan_kecamatan` (`kecamatan_id`),
  ADD KEY `fk_pesanan_slot` (`slot_id`),
  ADD KEY `fk_pesanan_tim` (`tim_id`);

--
-- Indexes for table `slot_waktu`
--
ALTER TABLE `slot_waktu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tim_kebersihan`
--
ALTER TABLE `tim_kebersihan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `slot_waktu`
--
ALTER TABLE `slot_waktu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tim_kebersihan`
--
ALTER TABLE `tim_kebersihan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pesanan_kecamatan` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pesanan_paket` FOREIGN KEY (`paket_id`) REFERENCES `paket_layanan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pesanan_slot` FOREIGN KEY (`slot_id`) REFERENCES `slot_waktu` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pesanan_tim` FOREIGN KEY (`tim_id`) REFERENCES `tim_kebersihan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pesanan_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
