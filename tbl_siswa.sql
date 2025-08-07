-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2025 at 08:57 AM
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
-- Database: `tbl_siswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'sehyeon', 'revanjr123', 'Ryu Se-hyeon'),
(2, 'admin', 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas_log`
--

CREATE TABLE `aktivitas_log` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `aksi` varchar(255) NOT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktivitas_log`
--

INSERT INTO `aktivitas_log` (`id`, `admin_id`, `aksi`, `waktu`) VALUES
(1, 2, 'Menambahkan siswa: tes', '2025-08-07 13:31:18'),
(2, 1, 'Menambahkan siswa: Muhammad Aldi', '2025-08-07 13:36:52'),
(3, 2, 'Menambahkan siswa: kemem', '2025-08-07 13:39:08');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `nisn`, `kelas`, `jenis_kelamin`, `tgl_lahir`, `alamat`, `created_at`) VALUES
(1, 'Revan Junior W', '354.23', 'XII', 'L', '2008-06-20', 'Jalan Bajak V No 7b', '2025-08-05 06:17:35'),
(2, 'Mhd. Abidin Abbas Lubis', '356.23', 'XII', 'L', '2007-01-01', 'Mandala', '2025-08-05 07:10:05'),
(3, 'Marcello Julien Manik', '357.23', 'XII', 'L', '2008-01-01', 'Tanjung Morawa', '2025-08-05 07:10:59'),
(4, 'Rizky Armansyah Purba', '358.23', 'XII', 'L', '2008-01-01', 'Pasar Merah', '2025-08-05 07:12:25'),
(7, 'Alexander Waist', '359.23', 'XI', NULL, '2009-03-09', 'Washington DC', '2025-08-07 06:12:14'),
(8, 'Sienna Galiien', '360.23', 'XII', NULL, '2002-02-10', 'Nein', '2025-08-07 06:18:39'),
(9, 'Sienna Galiien', '360.23', 'XII', NULL, '2002-02-10', 'Nein', '2025-08-07 06:19:32'),
(10, 'sada', '121', 'XII', 'L', '1231-03-21', '1231', '2025-08-07 06:19:59'),
(11, '123', '357.23', 'X', 'L', '2222-02-22', '23', '2025-08-07 06:21:06'),
(12, '123', '357.23', 'X', 'L', '2222-02-22', '23', '2025-08-07 06:21:16'),
(13, '123', '357.23', 'X', 'L', '2222-02-22', '23', '2025-08-07 06:29:29'),
(14, 'tes', 'tes', 'XI', 'L', '1212-12-12', '1212', '2025-08-07 06:31:18'),
(15, 'Muhammad Aldi', '362.23', 'XII', 'L', '1111-11-11', 'SSS', '2025-08-07 06:36:52'),
(16, 'kemem', '245345', 'XII', 'L', '2025-08-01', 'paret', '2025-08-07 06:39:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aktivitas_log`
--
ALTER TABLE `aktivitas_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `aktivitas_log`
--
ALTER TABLE `aktivitas_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aktivitas_log`
--
ALTER TABLE `aktivitas_log`
  ADD CONSTRAINT `aktivitas_log_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
