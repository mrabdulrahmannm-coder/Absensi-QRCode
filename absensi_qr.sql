-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Mar 2026 pada 08.20
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_qr`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id`, `nama`, `username`, `password`, `created_at`) VALUES
(1, 'aaaaa', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', '2026-03-03 06:40:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `ttl` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu','Buddha','Konghucu') NOT NULL,
  `nama_ayah` varchar(100) NOT NULL,
  `nama_ibu` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `nis`, `kelas`, `ttl`, `jenis_kelamin`, `alamat`, `agama`, `nama_ayah`, `nama_ibu`, `foto`, `created_at`) VALUES
(1, 'Ahmad Rizky Pratama', '1001', 'X RPL 1', 'Batam, 12 Mei 2008', 'Laki-laki', 'Bengkong Indah, Batam', 'Islam', 'Budi Santoso', 'Siti Aminah', '0a235cdde478c4f68f01f44611c35b7d.png', '2026-03-03 07:06:29'),
(2, 'Putri Ayu Lestari', '1002', 'X RPL 1', 'Tanjung Pinang, 3 Juli 2008', 'Perempuan', 'Nagoya, Batam', 'Islam', 'Andi Wijaya', 'Rina Marlina', '10-101206_anime-keren-buat-profil.webp', '2026-03-03 07:06:29'),
(3, 'Michael Jonathan', '1003', 'X TKJ 1', 'Jakarta, 21 Januari 2008', 'Laki-laki', 'Baloi, Batam', 'Kristen', 'Thomas Jonathan', 'Maria Clara', 'd4a70580-af6e-44da-ad19-1e7c52386bce.jpg', '2026-03-03 07:06:29'),
(4, 'Citra Dewi Anggraini', '1004', 'XI RPL 2', 'Batam, 9 September 2007', 'Perempuan', 'Batu Aji, Batam', 'Islam', 'Hendra Saputra', 'Nurhayati', 'dbc3feef89a9d49f9ec2b164f08f6c71.jpg', '2026-03-03 07:06:29'),
(5, 'Kevin Saputra', '1005', 'XI TKJ 1', 'Medan, 15 Februari 2007', 'Laki-laki', 'Sekupang, Batam', 'Buddha', 'Rudi Saputra', 'Lina Wati', 'photo_6122657764179295906_w.jpg', '2026-03-03 07:06:29'),
(6, 'Angelina Putria', '1006', 'XII RPL 1', 'Batam, 30 Oktober 2006', 'Perempuan', 'Tiban, Batam', 'Katolik', 'Yosef Putra', 'Martha Simanjuntak', 'photo_6318706150610157352_y.jpg', '2026-03-03 01:19:12');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
