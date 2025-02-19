-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2025 at 09:11 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tokobunga`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `idcart` int(11) NOT NULL,
  `orderid` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `tglorder` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) NOT NULL DEFAULT 'Cart'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`idcart`, `orderid`, `userid`, `tglorder`, `status`) VALUES
(11, '15Swf8Ye0Fm.M', 2, '2020-03-16 12:17:34', 'Cart'),
(13, '17hKm2wwVmwxw', 3, '2023-11-29 08:45:28', 'Selesai'),
(14, '17STMXpiOK6/o', 3, '2023-11-30 00:38:13', 'Selesai'),
(15, '170CgXvPuYelU', 3, '2023-12-04 08:18:27', 'Selesai'),
(16, '17b39VpfIw7xo', 3, '2023-12-04 08:35:57', 'Selesai'),
(17, '17qCxqRa52dBQ', 4, '2023-12-04 11:59:47', 'Selesai'),
(19, '17HVvyU1SUsRc', 5, '2024-01-02 07:01:12', 'Selesai'),
(20, '17qdk/Qra5Jl.', 3, '2025-01-19 06:41:00', 'Selesai'),
(21, '17ekyokPxm.LM', 3, '2025-02-01 10:11:14', 'Payment');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id_ck` int(11) NOT NULL,
  `orderid` varchar(100) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat_lengkap` varchar(100) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `kode_pos` varchar(100) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailorder`
--

CREATE TABLE `detailorder` (
  `detailid` int(11) NOT NULL,
  `orderid` varchar(100) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detailorder`
--

INSERT INTO `detailorder` (`detailid`, `orderid`, `idproduk`, `qty`) VALUES
(15, '15Swf8Ye0Fm.M', 7, 3),
(16, '15Swf8Ye0Fm.M', 8, 1),
(17, '17hKm2wwVmwxw', 7, 2),
(20, '17hKm2wwVmwxw', 15, 3),
(24, '17hKm2wwVmwxw', 12, 1),
(25, '17STMXpiOK6/o', 8, 2),
(26, '170CgXvPuYelU', 12, 2),
(31, '17b39VpfIw7xo', 8, 2),
(32, '17b39VpfIw7xo', 12, 1),
(33, '17qCxqRa52dBQ', 8, 1),
(35, '17HVvyU1SUsRc', 15, 2),
(36, '17HVvyU1SUsRc', 12, 1),
(40, '17qdk/Qra5Jl.', 24, 1),
(41, '17qdk/Qra5Jl.', 25, 1),
(42, '17qdk/Qra5Jl.', 27, 1),
(43, '17ekyokPxm.LM', 20, 1),
(44, '17ekyokPxm.LM', 27, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int(11) NOT NULL,
  `namakategori` varchar(20) NOT NULL,
  `tgldibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idkategori`, `namakategori`, `tgldibuat`) VALUES
(1, 'Bunga Tangkai', '2019-12-20 07:28:34'),
(3, 'Bunga Hidup', '2020-03-16 12:15:40'),
(8, 'Bunga Plastik', '2023-10-29 07:07:25'),
(11, 'Buket Bunga', '2025-02-01 08:13:04'),
(12, 'Tangkai', '2025-02-01 08:13:50');

-- --------------------------------------------------------

--
-- Table structure for table `konfirmasi`
--

CREATE TABLE `konfirmasi` (
  `idkonfirmasi` int(11) NOT NULL,
  `orderid` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `payment` varchar(10) NOT NULL,
  `namarekening` varchar(50) NOT NULL,
  `tglbayar` date NOT NULL,
  `tglsubmit` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `userid` int(11) NOT NULL,
  `namalengkap` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `notelp` varchar(15) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `tgljoin` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(7) NOT NULL DEFAULT 'Member',
  `lastlogin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`userid`, `namalengkap`, `email`, `password`, `notelp`, `alamat`, `tgljoin`, `role`, `lastlogin`) VALUES
(1, 'Admin', 'admin', '$2y$10$GJVGd4ji3QE8ikTBzNyA0uLQhiGd6MirZeSJV1O6nUpjSVp1eaKzS', '01234567890', 'Indonesia', '2020-03-16 11:31:17', 'Admin', NULL),
(2, 'Guest', 'guest', '$2y$10$xXEMgj5pMT9EE0QAx3QW8uEn155Je.FHH5SuIATxVheOt0Z4rhK6K', '01234567890', 'Indonesia', '2020-03-16 11:30:40', 'Member', NULL),
(3, 'Andi Alif Fachrisyah', 'inites_email@gmail.com', 'm212173', '085242417032', 'Jalan Maccini Tengah', '2023-11-19 11:39:08', 'Member', NULL),
(4, 'User Tes', 'inites@gmail.com', '$2y$10$5QcKPfpucYrnsI.mkodXTO4TCCbn3ag5OjfERGXw0Cvvr5oepo0n6', '1232123', 'jalan tes', '2023-12-04 11:17:36', 'Member', NULL),
(5, 'Aidil Fachrisyah', 'aidilkeren@gmail.com', '$2y$10$hGz63b3MKB2goNHe/FciQ.vMS1a9ybgWY8StB6BieR29fTyPKpPI6', '098727172', 'Jl. Dg Tata 3 No. 12', '2024-01-02 07:00:40', 'Member', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan`
--

CREATE TABLE `pemasukan` (
  `id` int(11) NOT NULL,
  `kode_dokumen` varchar(50) NOT NULL,
  `nama_dokumen` varchar(100) NOT NULL,
  `periode` date NOT NULL,
  `file_dokumen` varchar(255) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemasukan`
--

INSERT INTO `pemasukan` (`id`, `kode_dokumen`, `nama_dokumen`, `periode`, `file_dokumen`, `tanggal`) VALUES
(16, 'DOC1024', 'Periode Oktober 2024', '2024-10-01', 'Flowers by Khansa Oktober 2024 (3).xlsx', '2025-02-13'),
(17, 'DOC1124', 'Periode November 2024', '2024-11-01', 'Flowers by Khansa November 2024 (3).xlsx', '2025-02-13'),
(18, 'DOC0123', 'Periode 2023', '2023-01-01', 'Data Dokumen 2.xlsx', '2025-02-18'),
(20, 'DOC0121', 'Periode 2021', '2021-01-01', 'Flowers by Khansa 2021 Terurut.xlsx', '2025-02-18'),
(24, 'DOC1224', 'Desember 24 - Januari 25', '2024-12-01', 'Flowers by Khansa Desember 2024 - Januari 2025.xlsx', '2025-02-18');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `no` int(11) NOT NULL,
  `metode` varchar(25) NOT NULL,
  `norek` varchar(25) NOT NULL,
  `logo` text DEFAULT NULL,
  `an` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`no`, `metode`, `norek`, `logo`, `an`) VALUES
(1, 'Bank BCA', '13131231231', 'produk/metode/bca.jpg', 'Admin'),
(2, 'Bank Mandiri', '943248844843', 'produk/metode/mandiri.jpg', 'Admin'),
(3, 'DANA', '0882313132123', 'produk/metode/dana.png', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `idproduk` int(11) NOT NULL,
  `idkategori` int(11) NOT NULL,
  `namaproduk` varchar(30) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `rate` int(11) NOT NULL,
  `hargaafter` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `tgldibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idproduk`, `idkategori`, `namaproduk`, `gambar`, `deskripsi`, `rate`, `hargaafter`, `stok`, `tgldibuat`) VALUES
(7, 3, 'Tulip', '653e31dbecd30.jpeg', 'Bunga yang cantik dan cerah', 5, 25000, 8, '2023-10-29 10:20:11'),
(8, 3, 'Mawar Merah', '6559cbe29ade0.png', 'Mawar Merah Cantik', 4, 20000, 12, '2023-10-29 13:56:33'),
(12, 1, 'Bunga Kamelia', '6559f7f673937.jpg', 'Bunga Cantik', 4, 40000, 10, '2023-11-19 11:56:38'),
(15, 3, 'Anggrek Putih', '6566dd9450c0a.jpg', 'Salah satu jenis anggrek yang yang sangat disukai oleh banyak orang, karena ia memiliki warna bunga yang cerah dan terlihat sangat cantik.', 4, 40000, 10, '2023-11-29 06:43:32'),
(18, 3, 'Edelweiss', '666810c22c421.jpg', 'Tumbuhan endemik zona alpina/montana di berbagai pegunungan tinggi di Indonesia yang saat ini dikategorikan sebagai tumbuhan langka. Tumbuhan ini dapat mencapai ketinggian 8 meter dan dapat memiliki b', 2, 30000, 20, '2024-06-11 08:54:26'),
(19, 11, 'Buket Mini', '679dde4a949c8.jpg', 'Keindahan yang pas di tangan! Buket mini ini sempurna untuk hadiah kecil penuh makna.\r\n(Bunga disesuaikan dengan yang ready di toko)', 4, 30000, 10, '2025-02-01 08:41:46'),
(20, 11, 'Buket Medium', '679ddecb1d53a.jpg', 'Sentuhan manis untuk hari istimewa. Buket medium yang elegan, sempurna untuk segala acara.\r\n(Bunga disesuaikan dengan yang ready di toko)', 4, 100000, 19, '2025-02-01 08:43:55'),
(21, 11, 'Buket XXL', '679de13748d85.jpg', 'Untuk momen besar, butuh buket yang besar! XXL buket kami, penuh warna dan cinta, siap memberi kejutan!\r\n', 5, 250000, 10, '2025-02-01 08:54:15'),
(22, 11, 'Buket X-Tra Large', '679de193bedec.jpg', 'Lebih besar, lebih meriah! Buket X-Tra Large, sempurna untuk menciptakan kesan luar biasa!', 3, 200000, 9, '2025-02-01 08:55:47'),
(23, 11, 'Buket Large', '679de1e2cd80f.jpg', 'Pesona bunga yang besar untuk cinta yang tak terbatas! Buket besar kami, hadir dengan kesan elegan dan menawan.', 5, 150000, 10, '2025-02-01 08:57:06'),
(24, 11, 'Buket Small', '679de23078cbc.jpg', 'Ukuran kecil, cinta yang besar! Buket kecil ini sempurna untuk menyampaikan pesan hati.', 5, 50000, 11, '2025-02-01 08:58:24'),
(25, 11, 'Buket Round', '679de2ade5a78.jpg', 'Keindahan berbentuk sempurna! Paket Round, buket bunga yang menawan dengan desain simetris.', 5, 300000, 9, '2025-02-01 09:00:29'),
(26, 11, 'Buket Mawar + Baby Breath', '679de2f9451a7.jpg', 'Sentuhan romantis dengan mawar dan baby breath! Buket elegan ini akan membuat hati siapa saja meleleh.', 5, 170000, 20, '2025-02-01 09:01:45'),
(27, 11, 'Buket Mawar + Baby Breath Larg', '679de3b55f96f.jpg', 'Cinta yang besar dalam setiap kelopak! Buket Large Mawar dengan baby breath, pilihan sempurna untuk momen istimewa.', 4, 310000, 9, '2025-02-01 09:03:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`idcart`),
  ADD UNIQUE KEY `orderid` (`orderid`),
  ADD KEY `orderid_2` (`orderid`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id_ck`),
  ADD KEY `orderid` (`orderid`);

--
-- Indexes for table `detailorder`
--
ALTER TABLE `detailorder`
  ADD PRIMARY KEY (`detailid`),
  ADD KEY `orderid` (`orderid`),
  ADD KEY `idproduk` (`idproduk`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indexes for table `konfirmasi`
--
ALTER TABLE `konfirmasi`
  ADD PRIMARY KEY (`idkonfirmasi`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`),
  ADD KEY `idkategori` (`idkategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `idcart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id_ck` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detailorder`
--
ALTER TABLE `detailorder`
  MODIFY `detailid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `konfirmasi`
--
ALTER TABLE `konfirmasi`
  MODIFY `idkonfirmasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detailorder`
--
ALTER TABLE `detailorder`
  ADD CONSTRAINT `idproduk` FOREIGN KEY (`idproduk`) REFERENCES `produk` (`idproduk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderid` FOREIGN KEY (`orderid`) REFERENCES `cart` (`orderid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `konfirmasi`
--
ALTER TABLE `konfirmasi`
  ADD CONSTRAINT `userid` FOREIGN KEY (`userid`) REFERENCES `login` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `idkategori` FOREIGN KEY (`idkategori`) REFERENCES `kategori` (`idkategori`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
