-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 04, 2026 at 12:51 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_anggota`
--

CREATE TABLE `tb_anggota` (
  `id_anggota` int NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text,
  `tgl_daftar` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_anggota`
--

INSERT INTO `tb_anggota` (`id_anggota`, `nama`, `email`, `no_hp`, `alamat`, `tgl_daftar`) VALUES
(1, 'Andi Saputra', 'andi@gmail.com', '081234567801', 'Surabaya', '2026-01-10'),
(2, 'Budi Santoso', 'budi@gmail.com', '081234567802', 'Sidoarjo', '2026-01-12'),
(3, 'Citra Lestari', 'citra@gmail.com', '081234567803', 'Gresik', '2026-01-15'),
(4, 'Dewi Anggraini', 'dewi@gmail.com', '081234567804', 'Mojokerto', '2026-01-18'),
(6, 'Fajar Ramadhan', 'fajar@gmail.com', '081234567806', 'Surabaya', '2026-01-22');

-- --------------------------------------------------------

--
-- Table structure for table `tb_buku`
--

CREATE TABLE `tb_buku` (
  `id_buku` int NOT NULL,
  `kode_buku` varchar(10) DEFAULT NULL,
  `judul` varchar(100) NOT NULL,
  `pengarang` varchar(50) DEFAULT NULL,
  `tahun` int DEFAULT NULL,
  `stok` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_buku`
--

INSERT INTO `tb_buku` (`id_buku`, `kode_buku`, `judul`, `pengarang`, `tahun`, `stok`) VALUES
(1, 'BK001', 'Pemrograman PHP', 'Abdul Kadir', 2022, 10),
(2, 'BK002', 'Database MySQL', 'Budi Raharjo', 2021, 2),
(3, 'BK003', 'HTML dan CSS', 'Jubilee Enterprise', 2023, 5),
(4, 'BK004', 'JavaScript Dasar', 'Raharjo', 2022, 1),
(5, 'BK005', 'Belajar Python', 'Andi Publisher', 2024, 0),
(6, 'BK006', 'Pemrograman Web', 'Riyanto', 2023, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tb_peminjaman`
--

CREATE TABLE `tb_peminjaman` (
  `id_pinjam` int NOT NULL,
  `id_anggota` int DEFAULT NULL,
  `id_buku` int DEFAULT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Dipinjam',
  `denda` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_peminjaman`
--

INSERT INTO `tb_peminjaman` (`id_pinjam`, `id_anggota`, `id_buku`, `tgl_pinjam`, `tgl_kembali`, `status`, `denda`) VALUES
(1, 1, 1, '2026-10-20', '2026-11-04', 'Dikembalikan', 0),
(2, 2, 2, '2026-10-21', NULL, 'Dipinjam', 0),
(3, 3, 3, '2026-10-22', NULL, 'Dipinjam', 0),
(4, 1, 4, '2026-10-23', NULL, 'Dipinjam', 0),
(5, 4, 5, '2026-10-24', NULL, 'Dipinjam', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_anggota`
--
ALTER TABLE `tb_anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tb_buku`
--
ALTER TABLE `tb_buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD UNIQUE KEY `kode_buku` (`kode_buku`);

--
-- Indexes for table `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `fk_anggota` (`id_anggota`),
  ADD KEY `fk_buku` (`id_buku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_anggota`
--
ALTER TABLE `tb_anggota`
  MODIFY `id_anggota` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_buku`
--
ALTER TABLE `tb_buku`
  MODIFY `id_buku` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  MODIFY `id_pinjam` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  ADD CONSTRAINT `fk_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`),
  ADD CONSTRAINT `fk_buku` FOREIGN KEY (`id_buku`) REFERENCES `tb_buku` (`id_buku`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
