-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Apr 28, 2026 at 03:48 AM
-- Server version: 9.6.0
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int NOT NULL,
  `id_penulis` int NOT NULL,
  `id_kategori` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hari_tanggal` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `id_penulis`, `id_kategori`, `judul`, `isi`, `gambar`, `hari_tanggal`) VALUES
(1, 4, 1, 'tidur utama', 'gue paling kece', '69f0207126369.jpg', 'Selasa, 28 April 2026 | 09:50'),
(2, 5, 2, 'jangan selingkuh ya', 'biar ga selingkuh ', '69f024ad840f7.jpg', 'Selasa, 28 April 2026 | 10:08'),
(4, 7, 3, 'trsrh', 'apa aja trsrh', '69f0269dc9b9c.jpg', 'Selasa, 28 April 2026 | 10:16');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_artikel`
--

CREATE TABLE `kategori_artikel` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_artikel`
--

INSERT INTO `kategori_artikel` (`id`, `nama_kategori`, `keterangan`) VALUES
(1, 'romance', 'sgt uwow\r\nmantap\r\n'),
(2, 'self improvement', 'hal hal agar tidak selingkuh'),
(3, 'random', 'apa aja');

-- --------------------------------------------------------

--
-- Table structure for table `penulis`
--

CREATE TABLE `penulis` (
  `id` int NOT NULL,
  `nama_depan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_belakang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penulis`
--

INSERT INTO `penulis` (`id`, `nama_depan`, `nama_belakang`, `user_name`, `password`, `foto`) VALUES
(4, 'pin', '10', 'memmpinn', '$2y$10$FpsR4nHrtP/Wl1YQxZiyKeQO9UBM13e928JdbGEC5sIThQ6mpzVES', 'default.png'),
(5, 'insyaf', 'dek', 'syafno', '$2y$10$JxzvhGJGI2ro6Hf4RyxnQuwhWVeQJEEa60zNUTxRDJh163sR89k/q', '69f0255c46157.jpg'),
(7, 'aya ', 'we', 'ayayawae', '$2y$10$Y7ImVU.HBo7af36nyUuJwexFuUNww0UHHvDnwiNHPoJXBXBAHPW6K', 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_artikel_penulis` (`id_penulis`),
  ADD KEY `fk_artikel_kategori` (`id_kategori`);

--
-- Indexes for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_nama_kategori` (`nama_kategori`);

--
-- Indexes for table `penulis`
--
ALTER TABLE `penulis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penulis`
--
ALTER TABLE `penulis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `fk_artikel_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_artikel` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_artikel_penulis` FOREIGN KEY (`id_penulis`) REFERENCES `penulis` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
