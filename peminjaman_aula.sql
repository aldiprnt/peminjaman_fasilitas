-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2026 at 02:49 PM
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
-- Database: `peminjaman_aula`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id_fasilitas` int(11) NOT NULL,
  `nama_item` varchar(100) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `kategori` enum('Aula','Gamelan','Pakaian Tari') NOT NULL,
  `stok` int(11) DEFAULT 1,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id_fasilitas`, `nama_item`, `id_kategori`, `kategori`, `stok`, `deskripsi`) VALUES
(1, 'satu set gambelan baleganjur', 2, 'Aula', 1, 'satu set gambelan baleganjur'),
(2, 'tombak tari baris', 3, 'Gamelan', 5, 'perlengkapan tari'),
(3, 'Pakaian Tari  rejang', 3, 'Pakaian Tari', 8, 'pakaian tari rejang'),
(5, 'gender wayang ', 2, 'Aula', 4, '2 set gender wayang'),
(6, 'satu set gambelan slonding', 2, 'Aula', 1, 'satu barung gambelan slonding'),
(7, 'aula utama', 1, 'Aula', 1, 'aula kampus ratna kapasitas 300 orang\r\n'),
(8, 'Set Gamelan semarandana', 2, 'Gamelan', 1, 'satu barung gambelan semarandana'),
(9, 'Set Gamelan Angklung', 2, 'Gamelan', 1, 'satu set gambelan angklung'),
(10, 'Sound System', 1, 'Gamelan', 1, 'sound sistem'),
(11, 'alat musik band', 2, 'Gamelan', 0, 'perlengkapan alat musik '),
(12, 'Kostum Tari Pendet ', 3, 'Pakaian Tari', 10, 'pakaian tari pendet'),
(13, 'Kostum Tari Baris', 3, 'Pakaian Tari', 8, 'pakaian tari baris gede'),
(14, 'Gelungan', 3, 'Pakaian Tari', 10, 'gelungan tari'),
(15, 'gong kebyar 1 barung', 2, 'Aula', 1, 'gong kebyar 1 barung'),
(16, 'Kendang satu pasang', 2, 'Gamelan', 1, 'Ruang Kesenian - 2 Buah');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Aula'),
(2, 'Gamelan'),
(3, 'Pakaian Tari');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama_mahasiswa` varchar(100) NOT NULL,
  `id_fasilitas` int(11) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `jumlah` int(11) DEFAULT 1,
  `foto_pinjam` varchar(255) DEFAULT NULL,
  `foto_kembali` varchar(255) DEFAULT NULL,
  `tgl_dikembalikan` datetime DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak','Dikembalikan') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `nim`, `nama_mahasiswa`, `id_fasilitas`, `tgl_pinjam`, `tgl_kembali`, `jumlah`, `foto_pinjam`, `foto_kembali`, `tgl_dikembalikan`, `status`) VALUES
(15, '12345678', 'aldi pranata', 15, '2026-11-01', '2026-11-05', 1, '1793527851_Logo-Universitas-Hindu-Negeri-I-Gusti-Bagus-Sugriwa-Format-AI-PNG-EPS-SVG-CDR.webp', NULL, NULL, 'Pending'),
(16, '0987654', 'adit', 16, '2026-11-01', '2026-11-07', 1, '1793527920_pexels-tonywuphotography-17352573.jpg', NULL, NULL, 'Disetujui'),
(17, '2345678', 'wahyuu', 7, '2026-11-01', '2026-11-05', 1, '1793530515_WhatsApp Image 2026-10-10 at 15.50.59.jpeg', NULL, NULL, 'Pending'),
(18, '456789', 'wisnu', 9, '2026-11-01', '2026-11-05', 1, '1793530771_WhatsApp Image 2026-10-10 at 15.50.59.jpeg', NULL, NULL, 'Pending'),
(19, '678901', 'hanggara', 10, '2026-11-01', '2026-11-06', 1, '1793530820_WhatsApp Image 2026-10-10 at 15.50.59.jpeg', NULL, NULL, 'Disetujui'),
(20, '23234567', 'wedaa', 8, '2026-11-01', '2026-11-05', 1, '1793530858_WhatsApp Image 2026-10-10 at 15.50.59.jpeg', NULL, NULL, 'Pending'),
(21, '678567', 'indra', 13, '2026-11-01', '2026-11-05', 5, '1793530899_WhatsApp Image 2026-10-10 at 15.50.59.jpeg', 'kembali_1793532197_401.jpeg', NULL, 'Dikembalikan'),
(22, '257651763', 'desta', 2, '2026-11-01', '2026-11-11', 1, '1793530940_WhatsApp Image 2026-10-10 at 15.50.59.jpeg', NULL, NULL, 'Pending'),
(23, '32974', 'gusnan', 11, '2026-11-01', '2026-11-11', 1, '1793530985_WhatsApp Image 2026-10-10 at 15.50.59.jpeg', NULL, NULL, 'Pending'),
(24, '9466433', 'bagia', 5, '2026-11-01', '2026-11-14', 2, '1793531031_WhatsApp Image 2026-10-10 at 15.50.59.jpeg', 'kembali_1793532103_646.jpeg', NULL, 'Dikembalikan');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `role`) VALUES
(1, 'admin', 'admin123', 'Administrator Utama', 'admin'),
(2, 'mahasiswa', 'user123', 'Mahasiswa Pengguna', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id_fasilitas`),
  ADD KEY `fk_fasilitas_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_fasilitas` (`id_fasilitas`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id_fasilitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD CONSTRAINT `fk_fasilitas_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_fasilitas`) REFERENCES `fasilitas` (`id_fasilitas`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
