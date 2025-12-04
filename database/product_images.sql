-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 04, 2025 at 06:30 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentpedia`
--

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `path`, `created_at`, `updated_at`) VALUES
(1, 2, 'kaosPutih.jpeg', '2025-11-25 15:36:30', '2025-11-25 15:36:30'),
(2, 2, 'kaosPink.jpeg', '2025-11-25 15:36:30', '2025-11-25 15:36:30'),
(3, 2, 'KaosAbu.jpeg', '2025-11-25 15:36:30', '2025-11-25 15:36:30'),
(4, 1, 'dressWanitaCasual.jpeg', '2025-11-27 07:34:25', '2025-11-27 07:34:25'),
(5, 3, 'sunscreenSPF50wardah.png', '2025-11-27 07:34:25', '2025-11-27 07:34:25'),
(6, 4, 'dispenserMiyako.jpeg', '2025-11-27 07:34:25', '2025-11-27 07:34:25'),
(7, 5, 'HeadsetRexusVonixF30.webp', '2025-11-27 07:34:25', '2025-11-27 07:34:25'),
(8, 6, 'BBCreamMaybelline.jpeg', '2025-11-27 09:52:39', '2025-11-27 09:52:39'),
(9, 6, 'BBCreamMaybelline(ijo).jpeg', '2025-11-27 09:52:39', '2025-11-27 09:52:39'),
(10, 6, 'BBCreamMaybelline(pink).jpeg', '2025-11-27 09:52:39', '2025-11-27 09:52:39'),
(11, 6, 'BBCreamMaybelline(Hijau).jpeg', '2025-11-27 09:52:39', '2025-11-27 09:52:39'),
(12, 7, 'KesetKaretAntiSlip.webp', '2025-11-27 09:57:20', '2025-11-27 09:57:20'),
(13, 8, 'HoodieOversizeWanita2.jpeg', '2025-11-27 09:57:20', '2025-11-27 09:57:20'),
(14, 9, 'TonerExfoliatingAvoskin.jpeg', '2025-11-27 09:57:20', '2025-11-27 09:57:20'),
(15, 10, 'RaketPadel.jpeg', '2025-11-27 09:57:20', '2025-11-27 09:57:20'),
(16, 11, 'padelRaket.jpeg', '2025-11-27 10:24:20', '2025-11-27 10:24:20'),
(17, 12, 'kipasAnginCosmos.jpeg', '2025-11-27 10:24:20', '2025-11-27 10:24:20'),
(18, 13, 'rokplisketpremium.jpeg', '2025-11-27 10:24:20', '2025-11-27 10:24:20'),
(19, 14, 'dressCasual.jpeg', '2025-11-27 10:24:20', '2025-11-27 10:24:20'),
(20, 15, 'sapuLantai.jpeg', '2025-11-27 10:27:12', '2025-11-27 10:27:12'),
(21, 16, 'speedRopeJump.jpeg', '2025-11-27 10:27:12', '2025-11-27 10:27:12'),
(22, 17, 'maskaraBarenbliss.jpeg', '2025-11-27 10:27:12', '2025-11-27 10:27:12'),
(23, 18, 'HoodieOversizeW.jpeg', '2025-11-27 10:27:12', '2025-11-27 10:27:12'),
(24, 19, 'tonerExfoAvoskin.jpeg', '2025-11-27 10:29:02', '2025-11-27 10:29:02'),
(25, 20, 'kemejaLinen.jpeg', '2025-11-27 10:29:02', '2025-11-27 10:29:02'),
(26, 21, 'kesetKaret.jpeg', '2025-11-27 10:29:02', '2025-11-27 10:29:02'),
(27, 22, 'airFryer.jpeg', '2025-11-27 10:29:02', '2025-11-27 10:29:02'),
(28, 23, 'tempatSampah.jpeg', '2025-11-27 10:30:36', '2025-11-27 10:30:36'),
(29, 24, 'jaketBomberPria.jpeg', '2025-11-27 10:30:36', '2025-11-27 10:30:36'),
(30, 25, 'FlashDisk.jpeg', '2025-11-27 10:30:36', '2025-11-27 10:30:36'),
(31, 26, 'harddisk.jpeg', '2025-11-27 10:30:36', '2025-11-27 10:30:36'),
(32, 27, 'acLG.jpeg', '2025-11-27 10:31:55', '2025-11-27 10:31:55'),
(33, 28, 'setelanTrainingPria.jpeg', '2025-11-27 10:31:55', '2025-11-27 10:31:55'),
(34, 29, 'gymBagWaterproof.jpeg', '2025-11-27 10:31:55', '2025-11-27 10:31:55'),
(35, 30, 'serumSomebyme.jpeg', '2025-11-27 10:31:55', '2025-11-27 10:31:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
