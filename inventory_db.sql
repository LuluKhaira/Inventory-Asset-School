-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2024 at 09:35 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` tinyint(4) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `building` varchar(50) NOT NULL,
  `asset_condition` varchar(255) DEFAULT NULL,
  `jumlah` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `nama`, `building`, `asset_condition`, `jumlah`) VALUES
(1, 'Meja Komputer RPS/RPL', '4', 'Aktif', 40),
(2, 'Kursi Besi Biru RPL/RPS', '4', 'Aktif', 37),
(3, 'Kursi Besi Biru RPL/RPS', '4', 'Rusak', 3),
(4, 'Papan Infokus RPL/RPS', '4', 'Aktif', 2),
(5, 'Papan Tulis RPL/RPS', '4', 'Aktif', 1),
(6, 'Infokus RPL/RPS', '4', 'Aktif', 2),
(7, 'AC RPL/RPS', '4', 'Aktif', 2);

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `id` int(11) NOT NULL,
  `building_name` varchar(255) NOT NULL,
  `letak_gedung_lantai` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`id`, `building_name`, `letak_gedung_lantai`, `created_at`) VALUES
(4, 'Gedung Inovatif', 1, '2024-10-17 06:50:02');

-- --------------------------------------------------------

--
-- Table structure for table `history_barang`
--

CREATE TABLE `history_barang` (
  `id` int(11) NOT NULL,
  `asset_id` tinyint(4) NOT NULL,
  `user` varchar(100) NOT NULL,
  `usage_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `brand_name`, `quantity`) VALUES
(1, 'Laptop', 'Acer', 2),
(2, 'Laptop', 'Asus', 1),
(4, 'Laptop', 'Lenovo', 5),
(5, 'Komputer', 'Asus', 3),
(7, 'Laptop', '', 1),
(8, 'Laptop', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `level`) VALUES
(6, 'gojo', 'khaira', 'gojo@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(7, 'w', 'w', 'tai@gmail.com', '$2y$10$Yyu5P88jKc6vgcHJet9kD.jGzZfNSd7KyJtdfcZClItw0TLjJ4QAS', 'user'),
(8, 'lulu', 'khaira', 'lulu@gmail.com', '$2y$10$KXghyYvczfGGWM4eV5HGR.u7ZeS1eYIe7VZNCyqdYxU1jIQ1U9a3G', 'admin'),
(9, 'gojo', 'hawa', 'admin@gmail.com', '$2y$10$TKcBCFp8Oq.Rom0fQzq59e5WGq90zzk4.rUrnu31r5YDcQf0k/XBG', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_barang`
--
ALTER TABLE `history_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
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
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `history_barang`
--
ALTER TABLE `history_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history_barang`
--
ALTER TABLE `history_barang`
  ADD CONSTRAINT `history_barang_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
