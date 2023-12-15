-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2023 at 10:49 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_sales`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(10) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `ukuran` varchar(10) NOT NULL,
  `harga` int(100) NOT NULL,
  `status` enum('AVAIL','BOOKED') NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `nama`, `kategori`, `ukuran`, `harga`, `status`, `created_at`) VALUES
(1, 'Laptop ASUS', 'Elektronik', '14 inch', 8000000, 'AVAIL', '2023-01-01 08:00:00'),
(2, 'Jaket Denim', 'Fashion', 'M', 350000, 'AVAIL', '2023-01-02 10:30:00'),
(3, 'Buku Novel', 'Buku', 'Standard', 75000, 'BOOKED', '2023-01-03 12:45:00'),
(4, 'Sepatu Lari Nike', 'Olahraga', '42', 1200000, 'AVAIL', '2023-01-04 15:20:00'),
(5, 'Smartphone Samsung', 'Elektronik', '6.2 inch', 3500000, 'AVAIL', '2023-01-05 09:30:00'),
(6, 'Kemeja Formal', 'Fashion', 'L', 250000, 'AVAIL', '2023-01-06 11:45:00'),
(7, 'Buku Pendidikan', 'Buku', 'A4', 120000, 'BOOKED', '2023-01-07 13:15:00'),
(8, 'Treadmill Elektrik', 'Olahraga', 'Standard', 5000000, 'AVAIL', '2023-01-08 14:40:00'),
(9, 'Earphone Bluetooth', 'Elektronik', 'Universal', 300000, 'AVAIL', '2023-01-09 16:00:00'),
(10, 'Celana Jeans', 'Fashion', 'S', 200000, 'BOOKED', '2023-01-10 17:25:00'),
(20, 'qweqw', 'Makanan Ringan', 'XS', 21312, 'BOOKED', ''),
(25, 'testhapus', 'Makanan Ringan', 'XS', 2312, 'AVAIL', ''),
(30, 'TestInsertb', 'Unity', 'XS', 12000, 'AVAIL', ''),
(31, 'TestEditSpread', 'Makanan Ringan', 'M', 1213123, 'AVAIL', '');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `katid` int(11) NOT NULL,
  `katnama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`katid`, `katnama`) VALUES
(1, 'Unity'),
(2, 'Makanan Ringan'),
(3, 'Minuman'),
(4, 'Lain-lain'),
(5, 'Fashion'),
(17, 'dsgf'),
(18, 'dsfs'),
(26, 'Makanan Berat');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2021-02-23-084451', 'App\\Database\\Migrations\\Kategori', 'default', 'App', 1702371128, 1),
(2, '2021-02-23-085017', 'App\\Database\\Migrations\\Satuan', 'default', 'App', 1702371128, 1),
(3, '2021-02-23-091656', 'App\\Database\\Migrations\\Produk', 'default', 'App', 1702371128, 1),
(4, '2021-02-24-161052', 'App\\Database\\Migrations\\Supplier', 'default', 'App', 1702371128, 1),
(5, '2021-02-24-161641', 'App\\Database\\Migrations\\Pembelian', 'default', 'App', 1702371128, 1),
(6, '2021-02-24-163504', 'App\\Database\\Migrations\\Pembeliandetail', 'default', 'App', 1702371128, 1),
(7, '2021-02-24-170642', 'App\\Database\\Migrations\\Pelanggan', 'default', 'App', 1702371128, 1),
(8, '2021-02-24-170646', 'App\\Database\\Migrations\\Penjualan', 'default', 'App', 1702371128, 1),
(9, '2021-02-24-170649', 'App\\Database\\Migrations\\Penjualandetail', 'default', 'App', 1702371128, 1),
(10, '2021-02-24-170651', 'App\\Database\\Migrations\\Temppenjualan', 'default', 'App', 1702371128, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `pel_kode` int(11) NOT NULL,
  `pel_nama` varchar(100) NOT NULL,
  `pel_alamat` text NOT NULL,
  `pel_telp` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `beli_faktur` char(20) NOT NULL,
  `beli_tgl` date NOT NULL,
  `beli_jenisbayar` enum('T','K') NOT NULL DEFAULT 'T',
  `beli_supkode` int(11) NOT NULL,
  `beli_dispersen` double(11,2) NOT NULL DEFAULT 0.00,
  `beli_disuang` double(11,2) NOT NULL DEFAULT 0.00,
  `beli_totalkotor` double(11,2) NOT NULL DEFAULT 0.00,
  `beli_totalbersih` double(11,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `detbeli_id` bigint(11) NOT NULL,
  `detbeli_faktur` char(20) NOT NULL,
  `detbeli_kodebarcode` char(50) NOT NULL,
  `detbeli_hargabeli` double(11,2) NOT NULL DEFAULT 0.00,
  `detbeli_hargajual` double(11,2) NOT NULL DEFAULT 0.00,
  `detbeli_jml` double(11,2) NOT NULL DEFAULT 0.00,
  `detbeli_subtotal` double(11,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `jual_faktur` char(20) NOT NULL,
  `jual_tgl` date NOT NULL,
  `jual_pelkode` int(11) NOT NULL,
  `jual_dispersen` double(11,2) NOT NULL DEFAULT 0.00,
  `jual_disuang` double(11,2) NOT NULL DEFAULT 0.00,
  `jual_totalkotor` double(11,2) NOT NULL DEFAULT 0.00,
  `jual_totalbersih` double(11,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `detjual_id` bigint(11) NOT NULL,
  `detjual_faktur` char(20) NOT NULL,
  `detjual_kodebarcode` char(50) NOT NULL,
  `detjual_hargabeli` double(11,2) NOT NULL DEFAULT 0.00,
  `detjual_hargajual` double(11,2) NOT NULL DEFAULT 0.00,
  `detjual_jml` double(11,2) NOT NULL DEFAULT 0.00,
  `detjual_subtotal` double(11,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `kodebarcode` char(50) NOT NULL,
  `namaproduk` varchar(100) NOT NULL,
  `produk_satid` int(11) NOT NULL,
  `produk_katid` int(11) NOT NULL,
  `stok_tersedia` double(11,2) NOT NULL DEFAULT 0.00,
  `harga_beli` double(11,2) NOT NULL DEFAULT 0.00,
  `harga_jual` double(11,2) NOT NULL DEFAULT 0.00,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`kodebarcode`, `namaproduk`, `produk_satid`, `produk_katid`, `stok_tersedia`, `harga_beli`, `harga_jual`, `gambar`) VALUES
('testImg1', 'testImg', 2, 1, 12.00, 0.00, 0.00, 'assets/upload/testImg1-testImg.png'),
('testImg3', 'testImg', 2, 1, 12.00, 0.00, 0.00, 'assets/upload/testImg3-testImg.png'),
('testImg4', 'testImg', 2, 1, 12.00, 0.00, 0.00, 'assets/upload/testImg4-testImg.png');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `satid` int(11) NOT NULL,
  `satnama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`satid`, `satnama`) VALUES
(2, 'kilogram');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `sup_kode` int(11) NOT NULL,
  `sup_nama` varchar(100) NOT NULL,
  `sup_alamat` text NOT NULL,
  `sup_telp` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `temp_penjualan`
--

CREATE TABLE `temp_penjualan` (
  `detjual_id` bigint(11) NOT NULL,
  `detjual_faktur` char(20) NOT NULL,
  `detjual_kodebarcode` char(50) NOT NULL,
  `detjual_hargabeli` double(11,2) NOT NULL DEFAULT 0.00,
  `detjual_hargajual` double(11,2) NOT NULL DEFAULT 0.00,
  `detjual_jml` double(11,2) NOT NULL DEFAULT 0.00,
  `detjual_subtotal` double(11,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`katid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`pel_kode`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`beli_faktur`),
  ADD KEY `pembelian_beli_supkode_foreign` (`beli_supkode`);

--
-- Indexes for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`detbeli_id`),
  ADD KEY `pembelian_detail_detbeli_faktur_foreign` (`detbeli_faktur`),
  ADD KEY `pembelian_detail_detbeli_kodebarcode_foreign` (`detbeli_kodebarcode`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`jual_faktur`),
  ADD KEY `penjualan_jual_pelkode_foreign` (`jual_pelkode`);

--
-- Indexes for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`detjual_id`),
  ADD KEY `penjualan_detail_detjual_faktur_foreign` (`detjual_faktur`),
  ADD KEY `penjualan_detail_detjual_kodebarcode_foreign` (`detjual_kodebarcode`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`kodebarcode`),
  ADD KEY `produk_produk_satid_foreign` (`produk_satid`),
  ADD KEY `produk_produk_katid_foreign` (`produk_katid`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`satid`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`sup_kode`);

--
-- Indexes for table `temp_penjualan`
--
ALTER TABLE `temp_penjualan`
  ADD PRIMARY KEY (`detjual_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `katid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `pel_kode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `detbeli_id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `detjual_id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `satid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `sup_kode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_penjualan`
--
ALTER TABLE `temp_penjualan`
  MODIFY `detjual_id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_beli_supkode_foreign` FOREIGN KEY (`beli_supkode`) REFERENCES `supplier` (`sup_kode`) ON UPDATE CASCADE;

--
-- Constraints for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD CONSTRAINT `pembelian_detail_detbeli_faktur_foreign` FOREIGN KEY (`detbeli_faktur`) REFERENCES `pembelian` (`beli_faktur`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembelian_detail_detbeli_kodebarcode_foreign` FOREIGN KEY (`detbeli_kodebarcode`) REFERENCES `produk` (`kodebarcode`) ON UPDATE CASCADE;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_jual_pelkode_foreign` FOREIGN KEY (`jual_pelkode`) REFERENCES `pelanggan` (`pel_kode`) ON UPDATE CASCADE;

--
-- Constraints for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD CONSTRAINT `penjualan_detail_detjual_faktur_foreign` FOREIGN KEY (`detjual_faktur`) REFERENCES `penjualan` (`jual_faktur`) ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_detail_detjual_kodebarcode_foreign` FOREIGN KEY (`detjual_kodebarcode`) REFERENCES `produk` (`kodebarcode`) ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_produk_katid_foreign` FOREIGN KEY (`produk_katid`) REFERENCES `kategori` (`katid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `produk_produk_satid_foreign` FOREIGN KEY (`produk_satid`) REFERENCES `satuan` (`satid`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
