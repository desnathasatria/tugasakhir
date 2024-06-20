-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2024 at 11:09 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gtt`
--

-- --------------------------------------------------------

--
-- Table structure for table `administration`
--

CREATE TABLE `administration` (
  `id` INT(11) NOT NULL,
  `id_user` INT(11) DEFAULT NULL,
  `id_letter` INT(11) DEFAULT NULL,
  `status` TINYINT(1) DEFAULT 1,
  `file_name` VARCHAR(100) DEFAULT NULL,
  `submit_date` DATETIME DEFAULT CURRENT_TIMESTAMP(),
  `finish_date` DATETIME DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administration`
--

INSERT INTO `administration` (`id`, `id_user`, `id_letter`, `status`, `file_name`, `submit_date`, `finish_date`) VALUES
(93, 53, 3, 2, NULL, '2023-11-22 21:07:05', '2023-11-23 21:53:21'),
(94, 53, 2, 3, NULL, '2023-11-22 21:22:54', NULL),
(95, 57, 2, 3, NULL, '2023-11-23 07:52:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `app_credential`
--

CREATE TABLE `app_credential` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(100) DEFAULT NULL,
  `created_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `created_by` INT(11) DEFAULT NULL,
  `updated_date` TIMESTAMP NULL DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `deleted_date` TIMESTAMP NULL DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `is_deleted` TINYINT(1) DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `app_credential`
--

INSERT INTO `app_credential` (`id`, `name`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`, `is_deleted`) VALUES
(1, 'admin', '2023-10-27 02:10:01', NULL, NULL, NULL, NULL, NULL, 0),
(2, 'super admin', '2023-10-29 02:03:50', NULL, NULL, NULL, NULL, NULL, 0),
(3, 'pelanggan', '2023-10-29 02:03:57', NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `app_menu`
--

CREATE TABLE `app_menu` (
  `id` INT(11) NOT NULL,
  `id_parent` INT(11) DEFAULT NULL,
  `name` VARCHAR(100) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `icon` TEXT DEFAULT NULL,
  `link` VARCHAR(100) DEFAULT NULL,
  `sort` INT(11) DEFAULT NULL,
  `type` INT(11) DEFAULT NULL,
  `is_admin` TINYINT(1) DEFAULT NULL,
  `created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `created_by` INT(11) DEFAULT NULL,
  `updated_date` TIMESTAMP NULL DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `deleted_date` TIMESTAMP NULL DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `is_deleted` TINYINT(1) DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `app_menu`
--

INSERT INTO `app_menu` (`id`, `id_parent`, `name`, `description`, `icon`, `link`, `sort`, `type`, `is_admin`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`, `is_deleted`) VALUES
(1, 1, 'Dashboard', 'Menu untuk dashboard admin', 'nav-icon fa-solid fa-house fa-lg\r\n', '/dashboard', 1, 1, 1, '2023-11-03 05:16:37', NULL, NULL, NULL, NULL, NULL, 0),
(2, 3, 'Kelola Komponen', 'Menu dropdown untuk kelola komponen yang akan ditampilkan pada menu user masyarakat', 'nav-icon fa-solid fa-wand-magic-sparkles', '#', 2, 2, 1, '2023-11-03 05:48:45', NULL, NULL, NULL, NULL, NULL, 0),
(4, 3, 'Kelola Carousel', 'Menu child dari dropdown kelola home', NULL, '/manage-carousel', 2, 3, 1, '2023-11-03 05:54:08', NULL, NULL, NULL, NULL, NULL, 0),
(6, 2, 'Kelola Profil User', 'Menu untuk kelola user baik admin, superadmin, atau masyarakat\r\n', 'nav-icon fa-solid fa-users', '/profil-admin', 3, 1, 1, '2023-11-03 05:18:51', NULL, NULL, NULL, NULL, NULL, 0),
(7, 4, 'Kelola Profil UMKM', 'Menu kelola profil UMKM', 'nav-icon fa-solid fa-building-columns', '/manage-company-profile', 2, 1, 1, '2023-11-03 05:46:34', NULL, NULL, NULL, NULL, NULL, 0),
(8, 3, 'Kritik & Saran', 'Menu untuk kelola kritik dan saran\r\n', 'nav-icon fa-solid fa-comments', '/message-user', 4, 1, 1, '2023-11-05 07:15:12', NULL, NULL, NULL, NULL, NULL, 0),
(239, 3, 'Kelola Kategori Galeri', 'Menu child dari dropdown kelola home\r\n', NULL, '/manage-category-gallery', 2, 3, 1, '2023-11-06 04:12:01', NULL, NULL, NULL, NULL, NULL, 0),
(240, 3, 'Kelola Detail Galeri', 'Menu child dari dropdown kelola home', NULL, '/manage-gallery', 2, 3, 1, '2023-11-06 04:29:56', NULL, NULL, NULL, NULL, NULL, 0),
(247, 5, 'Produk', 'Menu untuk Kelola Produk', 'nav-icon fa-regular fa-folder-open', '#', 2, 2, 1, '2024-03-18 02:56:06', NULL, NULL, NULL, NULL, NULL, 0),
(248, 5, 'Kelola Produk', 'Menu child dari Produk\r\n', 'nav-icon fa-solid fa-folder', '/manage-product', 2, 3, 1, '2024-03-18 02:58:45', NULL, NULL, NULL, NULL, NULL, 0),
(249, 5, 'Kelola Kategori Produk', 'Menu Child dari Produk\r\n', NULL, '/manage-category-product', 2, 3, 1, '2024-03-18 03:00:00', NULL, NULL, NULL, NULL, NULL, 0),
(250, 6, 'Kelola Transaksi', 'Menu untuk mengelola transaksi', 'nav-icon fa-solid fa-gear', '#', 2, 2, 1, '2024-03-18 03:03:03', NULL, NULL, NULL, NULL, NULL, 0),
(251, 6, 'Kelola Pembelian', 'Menu child dari Kelola Transaksi', NULL, '/manage-purchase', 2, 3, 1, '2024-03-18 03:04:11', NULL, NULL, NULL, NULL, NULL, 0),
(252, 6, 'Kelola History', 'Menu child dari kelola transaksi\r\n', NULL, '/manage-history', 2, 3, 1, '2024-03-18 03:05:22', NULL, NULL, NULL, NULL, NULL, 0),
(254, 7, 'Supplier', 'Menu Supplier untuk kelola stok\\\r\n', 'nav-icon fa-solid fa-pen-to-square', '/manage-supplier', 2, 1, 1, '2024-04-22 02:56:57', NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `carousel_menu`
--

CREATE TABLE `carousel_menu` (
  `id` INT(11) NOT NULL,
  `title` VARCHAR(100) DEFAULT NULL,
  `sub_title` VARCHAR(255) DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `created_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `created_by` INT(11) DEFAULT NULL,
  `updated_date` DATETIME DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `deleted_date` DATETIME DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `is_deleted` TINYINT(1) DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel_menu`
--

INSERT INTO `carousel_menu` (`id`, `title`, `sub_title`, `image`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`, `is_deleted`) VALUES
(4, 'Judul Ulasan', 'Sub Ulasan', 'Carousel-2023-11-16_01-38-14.png', '2023-11-16 07:38:14', 1, NULL, NULL, '2023-11-23 04:32:06', 1, 1),
(5, 'Rapat Kulo', 'Jaranan', 'Carousel-2023-11-22_22-33-50.jpg', '2023-11-23 04:33:50', 1, '2024-05-16 11:26:28', 1, NULL, NULL, 0),
(6, 'Slogan Burengan', 'Burengan Reborn', 'Carousel-2023-11-22_22-36-04.jpg', '2023-11-23 04:36:04', 1, NULL, NULL, '2023-11-23 07:05:13', 56, 1),
(7, 'Rapat', 'Rapat dengan mahasiswa PSDKU POLINEMA', 'Carousel-2023-11-23_01-17-47.jpg', '2023-11-23 07:05:09', 56, '2023-11-23 07:17:47', 56, NULL, NULL, 0),
(8, 'Fasilitas', 'Ruang tunggu kelurahan', 'Carousel-2023-11-23_01-55-04.jpg', '2023-11-23 07:55:04', 1, NULL, NULL, '2023-11-23 07:55:21', 1, 1),
(9, 'Seni Budaya', 'GTT', 'Carousel-2024-05-15_07-38-16.png', '2024-05-15 12:38:17', 1, NULL, NULL, '2024-05-16 11:02:54', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` VARCHAR(128) NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `timestamp` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` BLOB NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE `company_profile` (
  `id_company` INT(11) NOT NULL,
  `company_name` VARCHAR(150) DEFAULT NULL,
  `address` VARCHAR(255) DEFAULT NULL,
  `province` VARCHAR(100) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `phone_number` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `embed_address` TEXT DEFAULT NULL,
  `company_logo` VARCHAR(255) DEFAULT NULL,
  `logo_footer` VARCHAR(255) DEFAULT NULL,
  `created_date` DATETIME DEFAULT CURRENT_TIMESTAMP(),
  `created_by` INT(11) DEFAULT NULL,
  `updated_date` DATETIME DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `deleted_date` DATETIME DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `is_deleted` TINYINT(1) DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_profile`
--

INSERT INTO `company_profile` (`id_company`, `company_name`, `address`, `province`, `city`, `phone_number`, `email`, `embed_address`, `company_logo`, `logo_footer`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`, `is_deleted`) VALUES
(1, 'GTT', 'Jl. Pamenang No.1, Besok, Toyoresmi, Kec. Ngasem, Kabupaten Kediri', '11', '179', '085233175312', 'Gttkediri@yahoo.co.id', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15811.474021979933!2d111.9880199!3d-7.8037427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e785a02bd6effb7%3A0xf175d81d9ce79ff6!2sGtt%20Pusat%20Oleh%20Oleh!5e0!3m2!1sen!2sid!4v1715326784423!5m2!1sen!2sid', 'company_2024-05-01_07-27-43.png', NULL, '2023-08-09 08:52:27', NULL, '2024-06-16 01:29:57', 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_category`
--

CREATE TABLE `gallery_category` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(100) DEFAULT NULL,
  `created_date` DATETIME DEFAULT CURRENT_TIMESTAMP(),
  `created_by` INT(11) DEFAULT NULL,
  `updated_date` DATETIME DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `deleted_date` DATETIME DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `is_deleted` TINYINT(1) DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_category`
--

INSERT INTO `gallery_category` (`id`, `name`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`, `is_deleted`) VALUES
(3, 'Ruangan', '2023-11-06 11:28:58', 1, '2023-11-23 06:38:25', 56, '2024-03-27 08:10:43', 1, 1),
(4, 'Fasilitas', '2023-11-06 11:29:08', 1, NULL, NULL, '2024-03-27 08:10:46', 1, 1),
(5, 'Kantin', '2023-11-23 07:55:48', 1, NULL, NULL, '2024-03-27 08:10:48', 1, 1),
(6, 'ktok', '2024-03-05 11:45:55', 1, NULL, NULL, '2024-03-27 08:10:50', 1, 1),
(7, 'Basah', '2024-03-22 08:32:09', 1, NULL, NULL, '2024-03-22 08:32:38', 1, 1),
(8, 'Ruang Samping', '2024-05-10 15:03:02', 1, '2024-05-10 15:03:10', 1, NULL, NULL, 0),
(9, 'Tempat Parkir', '2024-05-10 15:03:24', 1, NULL, NULL, NULL, NULL, 0),
(10, 'Lobby', '2024-05-10 15:03:32', 1, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_image`
--

CREATE TABLE `gallery_image` (
  `id` INT(11) NOT NULL,
  `id_category` INT(11) DEFAULT NULL,
  `title` VARCHAR(100) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `created_date` DATETIME DEFAULT CURRENT_TIMESTAMP(),
  `created_by` INT(11) DEFAULT NULL,
  `updated_date` DATETIME DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `deleted_date` DATETIME DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `is_deleted` TINYINT(1) DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_image`
--

INSERT INTO `gallery_image` (`id`, `id_category`, `title`, `description`, `image`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`, `is_deleted`) VALUES
(4, 4, 'Lapangan', 'Terdapat lapangan basket, futsal, dan juga voli', 'Gallery-2023-11-23_00-38-44.jpg', '2023-11-06 16:30:22', 1, '2023-11-23 06:38:44', 56, '2024-03-27 08:10:57', 1, 1),
(5, 3, 'Ruang bermain', 'Ruang bermain untuk anak-anak', 'Gallery-2023-11-23_00-38-38.jpg', '2023-11-06 16:49:33', 1, '2023-11-23 06:38:38', 56, '2024-03-27 08:10:55', 1, 1),
(6, 5, 'Pakiran', 'parkiran motor kelurahan', 'Gallery-2023-11-23_01-56-34.jpg', '2023-11-23 07:56:34', 1, NULL, NULL, '2024-03-27 08:10:59', 1, 1),
(7, 9, 'Parkir Motor', 'Parkir motor untuk pelanggan GTT', 'Gallery-2024-05-10_10-04-17.jpg', '2024-05-10 15:04:17', 1, NULL, NULL, NULL, NULL, 0),
(8, 10, 'Produk', 'Tahu Takwa', 'Gallery-2024-05-10_10-04-40.png', '2024-05-10 15:04:40', 1, NULL, NULL, NULL, NULL, 0),
(9, 8, 'Lando', 'Parkir motor untuk pelanggan GTT', 'Gallery-2024-05-11_05-19-23.jpg', '2024-05-11 10:19:23', 1, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(100) DEFAULT NULL,
  `created_date` DATETIME DEFAULT CURRENT_TIMESTAMP(),
  `created_by` INT(11) DEFAULT NULL,
  `updated_date` DATETIME DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `deleted_date` DATETIME DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `is_deleted` TINYINT(1) DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_produk`
--

INSERT INTO `kategori_produk` (`id`, `name`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`, `is_deleted`) VALUES
(1, 'Basah', '2024-03-22 10:45:06', 1, '2024-03-25 08:08:45', 1, '2024-04-02 09:03:10', 1, 1),
(2, 'Basah', '2024-03-25 08:06:01', 1, NULL, NULL, '2024-03-25 08:07:35', 1, 1),
(3, 'Kering', '2024-03-25 08:09:00', 1, NULL, NULL, '2024-04-02 09:03:08', 1, 1),
(4, 'Basah', '2024-04-25 10:01:39', 1, '2024-05-15 07:56:03', 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `message_user`
--

CREATE TABLE `message_user` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(100) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `message` TEXT DEFAULT NULL,
  `date_send` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `status` TINYINT(1) DEFAULT 1,
  `is_deleted` TINYINT(1) DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message_user`
--

INSERT INTO `message_user` (`id`, `name`, `email`, `message`, `date_send`, `status`, `is_deleted`) VALUES
(7, 'awda', 'desnatha@gmail.com', 'wdada', '2024-05-10 07:56:54', 3, 0),
(8, 'Desnatha', 'desnatha@gmail.com', 'dedede', '2024-05-15 05:39:45', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ongkir`
--

CREATE TABLE `ongkir` (
  `id_ongkir` INT(11) NOT NULL,
  `nama_ekspedisi` VARCHAR(255) DEFAULT NULL,
  `harga_ongkir` VARCHAR(255) DEFAULT NULL,
  `harga_berat` VARCHAR(255) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` INT(11) NOT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) DEFAULT NULL,
  `nama_pelanggan` VARCHAR(255) DEFAULT NULL,
  `alamat` VARCHAR(255) DEFAULT NULL,
  `no_hp` VARCHAR(255) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` INT(11) NOT NULL,
  `id_category_product` INT(11) DEFAULT NULL,
  `title` VARCHAR(100) DEFAULT NULL,
  `description` VARCHAR(100) DEFAULT NULL,
  `price` VARCHAR(100) DEFAULT NULL,
  `weight` VARCHAR(100) DEFAULT NULL,
  `image` VARCHAR(100) DEFAULT NULL,
  `total_stok` VARCHAR(100) DEFAULT NULL,
  `created_date` DATETIME DEFAULT CURRENT_TIMESTAMP(),
  `created_by` INT(11) DEFAULT NULL,
  `updated_date` DATETIME DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `deleted_date` DATETIME DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `id_category_product`, `title`, `description`, `price`, `weight`, `image`, `total_stok`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`, `is_deleted`) VALUES
(18, 4, 'Malin Kundang', 'Tahu Takwa', 'Rp. 200.000', '7', 'Product-2024-06-04_08-11-54.jpg', '10', '2024-06-04 13:11:54', 1, NULL, NULL, NULL, NULL, 0),
(19, 4, 'Laskar Pelangi', 'Parkir motor untuk pelanggan GTT', 'Rp. 25.000', '2', 'Product-2024-06-05_02-37-22.jpg', NULL, '2024-06-05 07:37:22', 1, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reply_message`
--

CREATE TABLE `reply_message` (
  `id` INT(11) NOT NULL,
  `id_message` INT(11) DEFAULT NULL,
  `message` TEXT DEFAULT NULL,
  `reply_by` INT(11) DEFAULT NULL,
  `date_send` DATETIME DEFAULT CURRENT_TIMESTAMP()
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reply_message`
--

INSERT INTO `reply_message` (`id`, `id_message`, `message`, `reply_by`, `date_send`) VALUES
(11, 7, 'okey', 1, '2024-05-12 11:41:11'),
(12, 8, 'sudah', 1, '2024-05-15 12:40:42');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `st_log_login`
--

CREATE TABLE `st_log_login` (
  `id` INT(11) NOT NULL,
  `ip_address` VARCHAR(20) DEFAULT NULL,
  `date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP()
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `st_log_login`
--

INSERT INTO `st_log_login` (`id`, `ip_address`, `date`) VALUES
(134, '::1', '2024-03-04 01:25:17'),
(135, '::1', '2024-03-05 04:21:56'),
(136, '::1', '2024-03-07 08:01:16'),
(137, '::1', '2024-03-07 08:03:28'),
(138, '::1', '2024-03-08 01:10:07'),
(139, '::1', '2024-03-09 03:15:08'),
(140, '::1', '2024-03-09 03:15:59'),
(141, '::1', '2024-03-18 01:04:27'),
(142, '::1', '2024-03-18 03:56:25'),
(143, '::1', '2024-03-18 03:59:44'),
(144, '::1', '2024-03-22 01:15:02'),
(145, '::1', '2024-03-22 03:42:02'),
(146, '::1', '2024-03-22 07:12:03'),
(147, '::1', '2024-03-25 01:03:38'),
(148, '::1', '2024-03-26 07:18:25'),
(149, '::1', '2024-03-27 00:43:32'),
(150, '::1', '2024-04-01 03:43:45'),
(151, '::1', '2024-04-02 01:27:36'),
(152, '::1', '2024-04-02 01:45:16'),
(153, '::1', '2024-04-02 01:57:00'),
(154, '::1', '2024-04-02 04:38:55'),
(155, '::1', '2024-04-03 00:44:24'),
(156, '::1', '2024-04-17 02:24:35'),
(157, '::1', '2024-04-22 02:18:32'),
(158, '::1', '2024-04-22 05:34:48'),
(159, '::1', '2024-04-23 03:28:56'),
(160, '::1', '2024-04-24 00:53:11'),
(161, '::1', '2024-04-24 06:13:27'),
(162, '::1', '2024-04-25 02:52:28'),
(163, '::1', '2024-04-26 00:46:08'),
(164, '::1', '2024-04-27 05:35:14'),
(165, '::1', '2024-04-27 05:48:31'),
(166, '::1', '2024-04-27 05:49:09'),
(167, '::1', '2024-04-29 00:51:49'),
(168, '::1', '2024-04-30 01:31:07'),
(169, '::1', '2024-05-01 03:09:11'),
(170, '::1', '2024-05-03 03:01:08'),
(171, '::1', '2024-05-03 05:46:37'),
(172, '::1', '2024-05-05 10:56:53'),
(173, '::1', '2024-05-05 11:10:37'),
(174, '::1', '2024-05-05 11:55:06'),
(175, '::1', '2024-05-08 02:34:27'),
(176, '::1', '2024-05-10 01:46:32'),
(177, '::1', '2024-05-10 07:17:56'),
(178, '::1', '2024-05-11 03:18:32'),
(179, '::1', '2024-05-12 04:26:38'),
(180, '::1', '2024-05-12 04:59:01'),
(181, '::1', '2024-05-12 05:08:49'),
(182, '::1', '2024-05-12 06:53:32'),
(183, '::1', '2024-05-12 06:57:00'),
(184, '::1', '2024-05-12 06:59:41'),
(185, '::1', '2024-05-12 07:04:11'),
(186, '::1', '2024-05-12 07:05:10'),
(187, '::1', '2024-05-12 07:07:08'),
(188, '::1', '2024-05-13 01:17:34'),
(189, '::1', '2024-05-13 02:43:24'),
(190, '::1', '2024-05-13 02:45:48'),
(191, '::1', '2024-05-13 03:03:32'),
(192, '::1', '2024-05-13 03:56:43'),
(193, '::1', '2024-05-13 06:43:21'),
(194, '::1', '2024-05-13 06:46:24'),
(195, '::1', '2024-05-13 06:53:28'),
(196, '::1', '2024-05-13 06:53:41'),
(197, '::1', '2024-05-13 06:59:00'),
(198, '::1', '2024-05-13 06:59:03'),
(199, '::1', '2024-05-13 06:59:17'),
(200, '::1', '2024-05-13 06:59:22'),
(201, '::1', '2024-05-13 07:02:17'),
(202, '::1', '2024-05-13 07:02:59'),
(203, '::1', '2024-05-13 08:29:37'),
(204, '::1', '2024-05-15 00:25:20'),
(205, '192.168.40.69', '2024-05-15 02:33:20'),
(206, '::1', '2024-05-15 05:37:02'),
(207, '::1', '2024-05-16 03:49:43'),
(208, '::1', '2024-05-20 03:40:43'),
(209, '::1', '2024-05-20 04:11:26'),
(210, '::1', '2024-05-25 07:48:17'),
(211, '::1', '2024-05-25 07:49:44'),
(212, '::1', '2024-05-26 04:29:24'),
(213, '::1', '2024-05-26 05:09:30'),
(214, '::1', '2024-05-26 05:15:20'),
(215, '::1', '2024-05-27 02:40:34'),
(216, '::1', '2024-05-30 00:53:17'),
(217, '::1', '2024-05-30 02:27:09'),
(218, '::1', '2024-06-03 12:26:15'),
(219, '::1', '2024-06-04 01:07:40'),
(220, '::1', '2024-06-04 05:31:30'),
(221, '::1', '2024-06-04 06:19:36'),
(222, '::1', '2024-06-04 21:03:19'),
(223, '::1', '2024-06-05 00:26:46'),
(224, '::1', '2024-06-05 00:36:48'),
(225, '::1', '2024-06-05 01:42:36'),
(226, '::1', '2024-06-05 02:48:08'),
(227, '::1', '2024-06-10 04:57:59'),
(228, '::1', '2024-06-10 04:58:04'),
(229, '::1', '2024-06-11 03:27:39'),
(230, '::1', '2024-06-11 03:28:18'),
(231, '::1', '2024-06-11 04:24:41'),
(232, '::1', '2024-06-12 12:06:18'),
(233, '::1', '2024-06-12 12:06:42'),
(234, '::1', '2024-06-12 12:10:08'),
(235, '::1', '2024-06-12 12:20:51'),
(236, '::1', '2024-06-12 12:21:32'),
(237, '::1', '2024-06-14 04:37:16'),
(238, '::1', '2024-06-14 04:38:21'),
(239, '::1', '2024-06-14 07:03:06'),
(240, '::1', '2024-06-15 03:34:04'),
(241, '::1', '2024-06-15 17:25:44'),
(242, '::1', '2024-06-15 17:51:29'),
(243, '::1', '2024-06-15 18:04:50'),
(244, '::1', '2024-06-15 18:16:36'),
(245, '::1', '2024-06-15 18:32:13'),
(246, '::1', '2024-06-15 19:57:54');

-- --------------------------------------------------------

--
-- Table structure for table `st_user`
--

CREATE TABLE `st_user` (
  `id` INT(11) NOT NULL,
  `id_credential` INT(11) DEFAULT NULL,
  `name` VARCHAR(100) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `phone_number` VARCHAR(13) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `province` VARCHAR(100) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `image` VARCHAR(100) DEFAULT 'default.jpeg',
  `username` VARCHAR(100) DEFAULT NULL,
  `password` TEXT DEFAULT NULL,
  `last_login` TIMESTAMP NULL DEFAULT NULL,
  `created_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `created_by` INT(11) DEFAULT NULL,
  `updated_date` TIMESTAMP NULL DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `deleted_date` TIMESTAMP NULL DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `is_deleted` TINYINT(1) DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `st_user`
--

INSERT INTO `st_user` (`id`, `id_credential`, `name`, `email`, `phone_number`, `address`, `province`, `city`, `image`, `username`, `password`, `last_login`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`, `is_deleted`) VALUES
(1, 2, 'Desnatha Satria', 'satriadesnatha@gmail.com', '082245146996', 'JL Tirtoudan Raya', NULL, NULL, 'superadmin-2024-06-12_14-13-45.jpg', 'superadmin', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '2024-06-15 18:30:53', '2023-10-27 02:10:26', NULL, '2024-06-12 12:13:45', 1, NULL, NULL, 0),
(53, 3, 'Tegar Darmawan', 'tegardarmawan@gmail.com', '08167525332', 'Jalan Diponegoro 86, Kota Batu Batu Jawa Timur Indonesia', NULL, NULL, 'tegar_-_2023-11-22_17-28-43.jpg', 'tegar', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '2023-11-23 00:39:33', '2023-11-18 06:58:19', NULL, '2023-11-22 21:31:55', 1, '2024-03-22 07:15:46', 1, 1),
(57, 3, 'Lando', 'DesnathaLand99@gmail.com', '08253647322', 'desa tosaren', NULL, NULL, 'lando_-_2023-11-23_01-51-29.jpg', 'lando', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '2023-11-23 00:53:09', '2023-11-23 00:50:29', NULL, '2023-11-23 00:51:29', 57, '2024-03-09 04:05:48', 1, 1),
(58, 3, 'Desnatha', 'desnatha@gmail.com', '345345345', 'wad', NULL, NULL, 'desnathas_-_2024-06-12_14-13-55.png', 'desnathas', 'eb045d78d273107348b0300c01d29b7552d622abbc6faf81b3ec55359aa9950c', '2024-06-11 04:24:30', '2023-11-24 00:57:48', NULL, '2024-06-12 12:13:55', 58, '2024-03-09 04:05:41', 1, 1),
(59, 2, 'Lintang Windy Pratama', 'lintang@gmail.com', '08118393847', 'Jl Griyo udan tirto permai', NULL, NULL, 'lintangsuper-2024-03-18_02-09-30.jpg', 'lintangsuper', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', NULL, '2024-03-18 01:09:30', 1, NULL, NULL, '2024-03-18 01:23:44', 1, 1),
(60, 3, 'Tegar Darmawan', 'tegar@gmail.com', '082283922292', 'Jl Griyo udan tirto permai', NULL, NULL, 'tegardarma-2024-03-18_02-12-02.jpg', 'tegardarma', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', NULL, '2024-03-18 01:12:02', 1, NULL, NULL, '2024-03-18 01:23:42', 1, 1),
(63, 1, 'Frankie', 'frankie@gmail.com', '08883866931', 'Jl Griyo udan tirto permai', NULL, NULL, '@frank31-2024-03-18_04-57-38.jpg', '@frank31', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', NULL, '2024-03-18 03:57:38', 1, '2024-03-18 03:58:25', 1, '2024-03-22 01:16:52', 1, 1),
(64, 1, 'Jihan Cahya Firmana', 'lisulare@gmail.com', '082245146996', 'Kediri', NULL, NULL, 'jihan-2024-04-01_06-21-04.jpg', 'jihan', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', NULL, '2024-04-01 04:21:04', 1, NULL, NULL, '2024-04-02 01:59:01', 1, 1),
(65, 3, 'Desnatha', 'desnatha@gmail.com', '082245146996', 'Kediri', NULL, NULL, 'lando123-2024-06-12_14-18-49.jpeg', 'lando123', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', NULL, '2024-05-12 06:53:05', NULL, '2024-06-12 12:18:49', 1, '2024-06-12 12:20:59', 1, 1),
(66, 3, 'Desnatha Satria Lando Arisukma', 'desnathaas99@gmail.com', '082245146996', 'Jl Tirtoudan Raya', '11', '444', 'lando1234_-_2024-06-12_14-22-00.png', 'testing', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', NULL, '2024-06-12 12:21:29', NULL, '2024-06-15 16:54:40', 66, NULL, NULL, 0),
(67, 3, 'testing2', 'testing2@gmail.com', '0811111111', NULL, NULL, NULL, 'default.jpeg', 'testing2', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', NULL, '2024-06-15 18:16:30', NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` INT(11) NOT NULL,
  `id_produk` INT(11) DEFAULT NULL,
  `nama_supplier` VARCHAR(100) DEFAULT NULL,
  `stok` VARCHAR(100) DEFAULT NULL,
  `created_date` DATETIME DEFAULT CURRENT_TIMESTAMP(),
  `created_by` INT(11) DEFAULT NULL,
  `updated_date` DATETIME DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `deleted_date` DATETIME DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `id_produk`, `nama_supplier`, `stok`, `created_date`, `created_by`, `updated_date`, `updated_by`, `deleted_date`, `deleted_by`, `is_deleted`) VALUES
(46, 18, 'Gujilo', '5', '2024-06-04 13:12:04', 1, NULL, NULL, NULL, NULL, 0),
(47, 18, 'Gujilo', '5', '2024-06-04 13:12:14', 1, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` INT(11) NOT NULL,
  `id_produk` INT(11) DEFAULT NULL,
  `id_pelanggan` INT(11) DEFAULT NULL,
  `harga_transaksi` VARCHAR(255) DEFAULT NULL,
  `alamat` VARCHAR(255) DEFAULT NULL,
  `status_pembayaran` VARCHAR(100) DEFAULT NULL,
  `status_pengiriman` VARCHAR(100) DEFAULT NULL,
  `created_date` DATETIME DEFAULT CURRENT_TIMESTAMP(),
  `created_by` INT(11) DEFAULT NULL,
  `updated_date` DATETIME DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `deleted_date` DATETIME DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `is_deleted` TINYINT(1) DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administration`
--
ALTER TABLE `administration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_letter` (`id_letter`);

--
-- Indexes for table `app_credential`
--
ALTER TABLE `app_credential`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_menu`
--
ALTER TABLE `app_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carousel_menu`
--
ALTER TABLE `carousel_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`id_company`);

--
-- Indexes for table `gallery_category`
--
ALTER TABLE `gallery_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_image`
--
ALTER TABLE `gallery_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`);

--
-- Indexes for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_user`
--
ALTER TABLE `message_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ongkir`
--
ALTER TABLE `ongkir`
  ADD PRIMARY KEY (`id_ongkir`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reply_message`
--
ALTER TABLE `reply_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_message` (`id_message`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `st_log_login`
--
ALTER TABLE `st_log_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `st_user`
--
ALTER TABLE `st_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_credential` (`id_credential`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administration`
--
ALTER TABLE `administration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `app_credential`
--
ALTER TABLE `app_credential`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `app_menu`
--
ALTER TABLE `app_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `carousel_menu`
--
ALTER TABLE `carousel_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `id_company` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery_category`
--
ALTER TABLE `gallery_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gallery_image`
--
ALTER TABLE `gallery_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `message_user`
--
ALTER TABLE `message_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `reply_message`
--
ALTER TABLE `reply_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `st_log_login`
--
ALTER TABLE `st_log_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `st_user`
--
ALTER TABLE `st_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administration`
--
ALTER TABLE `administration`
  ADD CONSTRAINT `administration_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `st_user` (`id`),
  ADD CONSTRAINT `administration_ibfk_2` FOREIGN KEY (`id_letter`) REFERENCES `letter` (`id`);

--
-- Constraints for table `gallery_image`
--
ALTER TABLE `gallery_image`
  ADD CONSTRAINT `gallery_image_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `gallery_category` (`id`);

--
-- Constraints for table `reply_message`
--
ALTER TABLE `reply_message`
  ADD CONSTRAINT `reply_message_ibfk_1` FOREIGN KEY (`id_message`) REFERENCES `message_user` (`id`);

--
-- Constraints for table `st_user`
--
ALTER TABLE `st_user`
  ADD CONSTRAINT `st_user_ibfk_1` FOREIGN KEY (`id_credential`) REFERENCES `app_credential` (`id`);

--
-- Constraints for table `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `supplier_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
