/*
SQLyog Community v13.2.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - gtt
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `administration` */

DROP TABLE IF EXISTS `administration`;

CREATE TABLE `administration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_letter` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `file_name` varchar(100) DEFAULT NULL,
  `submit_date` datetime DEFAULT current_timestamp(),
  `finish_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_letter` (`id_letter`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `administration` */

insert  into `administration`(`id`,`id_user`,`id_letter`,`status`,`file_name`,`submit_date`,`finish_date`) values 
(93,53,3,2,NULL,'2023-11-22 21:07:05','2023-11-23 21:53:21'),
(94,53,2,3,NULL,'2023-11-22 21:22:54',NULL),
(95,57,2,3,NULL,'2023-11-23 07:52:40',NULL);

/*Table structure for table `app_credential` */

DROP TABLE IF EXISTS `app_credential`;

CREATE TABLE `app_credential` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `app_credential` */

insert  into `app_credential`(`id`,`name`,`created_date`,`created_by`,`updated_date`,`updated_by`,`deleted_date`,`deleted_by`,`is_deleted`) values 
(1,'admin','2023-10-27 09:10:01',NULL,NULL,NULL,NULL,NULL,0),
(2,'super admin','2023-10-29 09:03:50',NULL,NULL,NULL,NULL,NULL,0),
(3,'pelanggan','2023-10-29 09:03:57',NULL,NULL,NULL,NULL,NULL,0);

/*Table structure for table `app_menu` */

DROP TABLE IF EXISTS `app_menu`;

CREATE TABLE `app_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=255 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `app_menu` */

insert  into `app_menu`(`id`,`id_parent`,`name`,`description`,`icon`,`link`,`sort`,`type`,`is_admin`,`created_date`,`created_by`,`updated_date`,`updated_by`,`deleted_date`,`deleted_by`,`is_deleted`) values 
(1,1,'Dashboard','Menu untuk dashboard admin','nav-icon fa-solid fa-house fa-lg\r\n','/dashboard',1,1,1,'2023-11-03 12:16:37',NULL,NULL,NULL,NULL,NULL,0),
(2,3,'Kelola Komponen','Menu dropdown untuk kelola komponen yang akan ditampilkan pada menu user masyarakat','nav-icon fa-solid fa-wand-magic-sparkles','#',2,2,1,'2023-11-03 12:48:45',NULL,NULL,NULL,NULL,NULL,0),
(4,3,'Kelola Carousel','Menu child dari dropdown kelola home',NULL,'/manage-carousel',2,3,1,'2023-11-03 12:54:08',NULL,NULL,NULL,NULL,NULL,0),
(6,2,'Kelola Profil User','Menu untuk kelola user baik admin, superadmin, atau masyarakat\r\n','nav-icon fa-solid fa-users','/profil-admin',3,1,1,'2023-11-03 12:18:51',NULL,NULL,NULL,NULL,NULL,0),
(7,4,'Kelola Profil UMKM','Menu kelola profil UMKM','nav-icon fa-solid fa-building-columns','/manage-company-profile',2,1,1,'2023-11-03 12:46:34',NULL,NULL,NULL,NULL,NULL,0),
(8,3,'Kritik & Saran','Menu untuk kelola kritik dan saran\r\n','nav-icon fa-solid fa-comments','/message-user',4,1,1,'2023-11-05 14:15:12',NULL,NULL,NULL,NULL,NULL,0),
(239,3,'Kelola Kategori Galeri','Menu child dari dropdown kelola home\r\n',NULL,'/manage-category-gallery',2,3,1,'2023-11-06 11:12:01',NULL,NULL,NULL,NULL,NULL,0),
(240,3,'Kelola Detail Galeri','Menu child dari dropdown kelola home',NULL,'/manage-gallery',2,3,1,'2023-11-06 11:29:56',NULL,NULL,NULL,NULL,NULL,0),
(247,5,'Produk','Menu untuk Kelola Produk','nav-icon fa-regular fa-folder-open','#',2,2,1,'2024-03-18 09:56:06',NULL,NULL,NULL,NULL,NULL,0),
(248,5,'Kelola Produk','Menu child dari Produk\r\n','nav-icon fa-solid fa-folder','/manage-product',2,3,1,'2024-03-18 09:58:45',NULL,NULL,NULL,NULL,NULL,0),
(249,5,'Kelola Kategori Produk','Menu Child dari Produk\r\n',NULL,'/manage-category-product',2,3,1,'2024-03-18 10:00:00',NULL,NULL,NULL,NULL,NULL,0),
(250,6,'Kelola Transaksi','Menu untuk mengelola transaksi','nav-icon fa-solid fa-gear','#',2,2,1,'2024-03-18 10:03:03',NULL,NULL,NULL,NULL,NULL,0),
(251,6,'Kelola Pembelian','Menu child dari Kelola Transaksi',NULL,'/manage-purchase',2,3,1,'2024-03-18 10:04:11',NULL,NULL,NULL,NULL,NULL,0),
(252,6,'Kelola History','Menu child dari kelola transaksi\r\n',NULL,'/manage-history',2,3,1,'2024-03-18 10:05:22',NULL,NULL,NULL,NULL,NULL,0),
(254,7,'Supplier','Menu Supplier untuk kelola stok\\\r\n','nav-icon fa-solid fa-pen-to-square','/manage-supplier',2,1,1,'2024-04-22 09:56:57',NULL,NULL,NULL,NULL,NULL,0);

/*Table structure for table `carousel_menu` */

DROP TABLE IF EXISTS `carousel_menu`;

CREATE TABLE `carousel_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `carousel_menu` */

insert  into `carousel_menu`(`id`,`title`,`sub_title`,`image`,`created_date`,`created_by`,`updated_date`,`updated_by`,`deleted_date`,`deleted_by`,`is_deleted`) values 
(4,'Judul Ulasan','Sub Ulasan','Carousel-2023-11-16_01-38-14.png','2023-11-16 07:38:14',1,NULL,NULL,'2023-11-23 04:32:06',1,1),
(5,'Rapat Kulo','Jaranan','Carousel-2023-11-22_22-33-50.jpg','2023-11-23 04:33:50',1,'2024-05-16 11:26:28',1,NULL,NULL,0),
(6,'Slogan Burengan','Burengan Reborn','Carousel-2023-11-22_22-36-04.jpg','2023-11-23 04:36:04',1,NULL,NULL,'2023-11-23 07:05:13',56,1),
(7,'Rapat','Rapat dengan mahasiswa PSDKU POLINEMA','Carousel-2023-11-23_01-17-47.jpg','2023-11-23 07:05:09',56,'2023-11-23 07:17:47',56,NULL,NULL,0),
(8,'Fasilitas','Ruang tunggu kelurahan','Carousel-2023-11-23_01-55-04.jpg','2023-11-23 07:55:04',1,NULL,NULL,'2023-11-23 07:55:21',1,1),
(9,'Seni Budaya','GTT','Carousel-2024-05-15_07-38-16.png','2024-05-15 12:38:17',1,NULL,NULL,'2024-05-16 11:02:54',1,1);

/*Table structure for table `ci_sessions` */

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ci_sessions` */

/*Table structure for table `company_profile` */

DROP TABLE IF EXISTS `company_profile`;

CREATE TABLE `company_profile` (
  `id_company` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(150) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `embed_address` text DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `logo_footer` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_company`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `company_profile` */

insert  into `company_profile`(`id_company`,`company_name`,`address`,`province`,`city`,`phone_number`,`email`,`embed_address`,`company_logo`,`logo_footer`,`created_date`,`created_by`,`updated_date`,`updated_by`,`deleted_date`,`deleted_by`,`is_deleted`) values 
(1,'GTT','Jl. Pamenang No.1, Besok, Toyoresmi, Kec. Ngasem, Kabupaten Kediri','11','179','085233175312','Gttkediri@yahoo.co.id','https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15811.474021979933!2d111.9880199!3d-7.8037427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e785a02bd6effb7%3A0xf175d81d9ce79ff6!2sGtt%20Pusat%20Oleh%20Oleh!5e0!3m2!1sen!2sid!4v1715326784423!5m2!1sen!2sid','company_2024-05-01_07-27-43.png',NULL,'2023-08-09 08:52:27',NULL,'2024-06-16 01:29:57',1,NULL,NULL,0);

/*Table structure for table `gallery_category` */

DROP TABLE IF EXISTS `gallery_category`;

CREATE TABLE `gallery_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `gallery_category` */

insert  into `gallery_category`(`id`,`name`,`created_date`,`created_by`,`updated_date`,`updated_by`,`deleted_date`,`deleted_by`,`is_deleted`) values 
(3,'Ruangan','2023-11-06 11:28:58',1,'2023-11-23 06:38:25',56,'2024-03-27 08:10:43',1,1),
(4,'Fasilitas','2023-11-06 11:29:08',1,NULL,NULL,'2024-03-27 08:10:46',1,1),
(5,'Kantin','2023-11-23 07:55:48',1,NULL,NULL,'2024-03-27 08:10:48',1,1),
(6,'ktok','2024-03-05 11:45:55',1,NULL,NULL,'2024-03-27 08:10:50',1,1),
(7,'Basah','2024-03-22 08:32:09',1,NULL,NULL,'2024-03-22 08:32:38',1,1),
(8,'Ruang Samping','2024-05-10 15:03:02',1,'2024-05-10 15:03:10',1,NULL,NULL,0),
(9,'Tempat Parkir','2024-05-10 15:03:24',1,NULL,NULL,NULL,NULL,0),
(10,'Lobby','2024-05-10 15:03:32',1,NULL,NULL,NULL,NULL,0);

/*Table structure for table `gallery_image` */

DROP TABLE IF EXISTS `gallery_image`;

CREATE TABLE `gallery_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_category` (`id_category`),
  CONSTRAINT `gallery_image_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `gallery_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `gallery_image` */

insert  into `gallery_image`(`id`,`id_category`,`title`,`description`,`image`,`created_date`,`created_by`,`updated_date`,`updated_by`,`deleted_date`,`deleted_by`,`is_deleted`) values 
(4,4,'Lapangan','Terdapat lapangan basket, futsal, dan juga voli','Gallery-2023-11-23_00-38-44.jpg','2023-11-06 16:30:22',1,'2023-11-23 06:38:44',56,'2024-03-27 08:10:57',1,1),
(5,3,'Ruang bermain','Ruang bermain untuk anak-anak','Gallery-2023-11-23_00-38-38.jpg','2023-11-06 16:49:33',1,'2023-11-23 06:38:38',56,'2024-03-27 08:10:55',1,1),
(6,5,'Pakiran','parkiran motor kelurahan','Gallery-2023-11-23_01-56-34.jpg','2023-11-23 07:56:34',1,NULL,NULL,'2024-03-27 08:10:59',1,1),
(7,9,'Parkir Motor','Parkir motor untuk pelanggan GTT','Gallery-2024-05-10_10-04-17.jpg','2024-05-10 15:04:17',1,NULL,NULL,NULL,NULL,0),
(8,10,'Produk','Tahu Takwa','Gallery-2024-05-10_10-04-40.png','2024-05-10 15:04:40',1,NULL,NULL,NULL,NULL,0),
(9,8,'Lando','Parkir motor untuk pelanggan GTT','Gallery-2024-05-11_05-19-23.jpg','2024-05-11 10:19:23',1,NULL,NULL,NULL,NULL,0);

/*Table structure for table `kategori_produk` */

DROP TABLE IF EXISTS `kategori_produk`;

CREATE TABLE `kategori_produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kategori_produk` */

insert  into `kategori_produk`(`id`,`name`,`created_date`,`created_by`,`updated_date`,`updated_by`,`deleted_date`,`deleted_by`,`is_deleted`) values 
(1,'Basah','2024-03-22 10:45:06',1,'2024-03-25 08:08:45',1,'2024-04-02 09:03:10',1,1),
(2,'Basah','2024-03-25 08:06:01',1,NULL,NULL,'2024-03-25 08:07:35',1,1),
(3,'Kering','2024-03-25 08:09:00',1,NULL,NULL,'2024-04-02 09:03:08',1,1),
(4,'Basah','2024-04-25 10:01:39',1,'2024-05-15 07:56:03',1,NULL,NULL,0);

/*Table structure for table `message_user` */

DROP TABLE IF EXISTS `message_user`;

CREATE TABLE `message_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date_send` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 1,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `message_user` */

insert  into `message_user`(`id`,`name`,`email`,`message`,`date_send`,`status`,`is_deleted`) values 
(7,'awda','desnatha@gmail.com','wdada','2024-05-10 14:56:54',3,0),
(8,'Desnatha','desnatha@gmail.com','dedede','2024-05-15 12:39:45',3,0);

/*Table structure for table `ongkir` */

DROP TABLE IF EXISTS `ongkir`;

CREATE TABLE `ongkir` (
  `id_ongkir` int(11) NOT NULL,
  `nama_ekspedisi` varchar(255) DEFAULT NULL,
  `harga_ongkir` varchar(255) DEFAULT NULL,
  `harga_berat` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_ongkir`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ongkir` */

/*Table structure for table `pelanggan` */

DROP TABLE IF EXISTS `pelanggan`;

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama_pelanggan` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pelanggan` */

/*Table structure for table `produk` */

DROP TABLE IF EXISTS `produk`;

CREATE TABLE `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_category_product` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `price` varchar(100) DEFAULT NULL,
  `weight` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `total_stok` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `produk` */

insert  into `produk`(`id`,`id_category_product`,`title`,`description`,`price`,`weight`,`image`,`total_stok`,`created_date`,`created_by`,`updated_date`,`updated_by`,`deleted_date`,`deleted_by`,`is_deleted`) values 
(18,4,'Malin Kundang','Tahu Takwa','Rp. 200.000','7','Product-2024-06-04_08-11-54.jpg','10','2024-06-04 13:11:54',1,NULL,NULL,NULL,NULL,0),
(19,4,'Laskar Pelangi','Parkir motor untuk pelanggan GTT','Rp. 25.000','2','Product-2024-06-05_02-37-22.jpg',NULL,'2024-06-05 07:37:22',1,NULL,NULL,NULL,NULL,0);

/*Table structure for table `reply_message` */

DROP TABLE IF EXISTS `reply_message`;

CREATE TABLE `reply_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_message` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `reply_by` int(11) DEFAULT NULL,
  `date_send` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_message` (`id_message`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `reply_message` */

insert  into `reply_message`(`id`,`id_message`,`message`,`reply_by`,`date_send`) values 
(11,7,'okey',1,'2024-05-12 11:41:11'),
(12,8,'sudah',1,'2024-05-15 12:40:42');

/*Table structure for table `shopping_cart` */

DROP TABLE IF EXISTS `shopping_cart`;

CREATE TABLE `shopping_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `shopping_cart` */

/*Table structure for table `st_log_login` */

DROP TABLE IF EXISTS `st_log_login`;

CREATE TABLE `st_log_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(20) DEFAULT NULL,
  `date` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `st_log_login` */

insert  into `st_log_login`(`id`,`ip_address`,`date`) values 
(134,'::1','2024-03-04 08:25:17'),
(135,'::1','2024-03-05 11:21:56'),
(136,'::1','2024-03-07 15:01:16'),
(137,'::1','2024-03-07 15:03:28'),
(138,'::1','2024-03-08 08:10:07'),
(139,'::1','2024-03-09 10:15:08'),
(140,'::1','2024-03-09 10:15:59'),
(141,'::1','2024-03-18 08:04:27'),
(142,'::1','2024-03-18 10:56:25'),
(143,'::1','2024-03-18 10:59:44'),
(144,'::1','2024-03-22 08:15:02'),
(145,'::1','2024-03-22 10:42:02'),
(146,'::1','2024-03-22 14:12:03'),
(147,'::1','2024-03-25 08:03:38'),
(148,'::1','2024-03-26 14:18:25'),
(149,'::1','2024-03-27 07:43:32'),
(150,'::1','2024-04-01 10:43:45'),
(151,'::1','2024-04-02 08:27:36'),
(152,'::1','2024-04-02 08:45:16'),
(153,'::1','2024-04-02 08:57:00'),
(154,'::1','2024-04-02 11:38:55'),
(155,'::1','2024-04-03 07:44:24'),
(156,'::1','2024-04-17 09:24:35'),
(157,'::1','2024-04-22 09:18:32'),
(158,'::1','2024-04-22 12:34:48'),
(159,'::1','2024-04-23 10:28:56'),
(160,'::1','2024-04-24 07:53:11'),
(161,'::1','2024-04-24 13:13:27'),
(162,'::1','2024-04-25 09:52:28'),
(163,'::1','2024-04-26 07:46:08'),
(164,'::1','2024-04-27 12:35:14'),
(165,'::1','2024-04-27 12:48:31'),
(166,'::1','2024-04-27 12:49:09'),
(167,'::1','2024-04-29 07:51:49'),
(168,'::1','2024-04-30 08:31:07'),
(169,'::1','2024-05-01 10:09:11'),
(170,'::1','2024-05-03 10:01:08'),
(171,'::1','2024-05-03 12:46:37'),
(172,'::1','2024-05-05 17:56:53'),
(173,'::1','2024-05-05 18:10:37'),
(174,'::1','2024-05-05 18:55:06'),
(175,'::1','2024-05-08 09:34:27'),
(176,'::1','2024-05-10 08:46:32'),
(177,'::1','2024-05-10 14:17:56'),
(178,'::1','2024-05-11 10:18:32'),
(179,'::1','2024-05-12 11:26:38'),
(180,'::1','2024-05-12 11:59:01'),
(181,'::1','2024-05-12 12:08:49'),
(182,'::1','2024-05-12 13:53:32'),
(183,'::1','2024-05-12 13:57:00'),
(184,'::1','2024-05-12 13:59:41'),
(185,'::1','2024-05-12 14:04:11'),
(186,'::1','2024-05-12 14:05:10'),
(187,'::1','2024-05-12 14:07:08'),
(188,'::1','2024-05-13 08:17:34'),
(189,'::1','2024-05-13 09:43:24'),
(190,'::1','2024-05-13 09:45:48'),
(191,'::1','2024-05-13 10:03:32'),
(192,'::1','2024-05-13 10:56:43'),
(193,'::1','2024-05-13 13:43:21'),
(194,'::1','2024-05-13 13:46:24'),
(195,'::1','2024-05-13 13:53:28'),
(196,'::1','2024-05-13 13:53:41'),
(197,'::1','2024-05-13 13:59:00'),
(198,'::1','2024-05-13 13:59:03'),
(199,'::1','2024-05-13 13:59:17'),
(200,'::1','2024-05-13 13:59:22'),
(201,'::1','2024-05-13 14:02:17'),
(202,'::1','2024-05-13 14:02:59'),
(203,'::1','2024-05-13 15:29:37'),
(204,'::1','2024-05-15 07:25:20'),
(205,'192.168.40.69','2024-05-15 09:33:20'),
(206,'::1','2024-05-15 12:37:02'),
(207,'::1','2024-05-16 10:49:43'),
(208,'::1','2024-05-20 10:40:43'),
(209,'::1','2024-05-20 11:11:26'),
(210,'::1','2024-05-25 14:48:17'),
(211,'::1','2024-05-25 14:49:44'),
(212,'::1','2024-05-26 11:29:24'),
(213,'::1','2024-05-26 12:09:30'),
(214,'::1','2024-05-26 12:15:20'),
(215,'::1','2024-05-27 09:40:34'),
(216,'::1','2024-05-30 07:53:17'),
(217,'::1','2024-05-30 09:27:09'),
(218,'::1','2024-06-03 19:26:15'),
(219,'::1','2024-06-04 08:07:40'),
(220,'::1','2024-06-04 12:31:30'),
(221,'::1','2024-06-04 13:19:36'),
(222,'::1','2024-06-05 04:03:19'),
(223,'::1','2024-06-05 07:26:46'),
(224,'::1','2024-06-05 07:36:48'),
(225,'::1','2024-06-05 08:42:36'),
(226,'::1','2024-06-05 09:48:08'),
(227,'::1','2024-06-10 11:57:59'),
(228,'::1','2024-06-10 11:58:04'),
(229,'::1','2024-06-11 10:27:39'),
(230,'::1','2024-06-11 10:28:18'),
(231,'::1','2024-06-11 11:24:41'),
(232,'::1','2024-06-12 19:06:18'),
(233,'::1','2024-06-12 19:06:42'),
(234,'::1','2024-06-12 19:10:08'),
(235,'::1','2024-06-12 19:20:51'),
(236,'::1','2024-06-12 19:21:32'),
(237,'::1','2024-06-14 11:37:16'),
(238,'::1','2024-06-14 11:38:21'),
(239,'::1','2024-06-14 14:03:06'),
(240,'::1','2024-06-15 10:34:04'),
(241,'::1','2024-06-16 00:25:44'),
(242,'::1','2024-06-16 00:51:29'),
(243,'::1','2024-06-16 01:04:50'),
(244,'::1','2024-06-16 01:16:36'),
(245,'::1','2024-06-16 01:32:13'),
(246,'::1','2024-06-16 02:57:54'),
(247,'::1','2024-06-16 11:23:15'),
(248,'::1','2024-06-16 12:49:32'),
(249,'::1','2024-06-16 14:21:47'),
(250,'::1','2024-06-16 14:41:42'),
(251,'::1','2024-06-16 19:09:30'),
(252,'::1','2024-06-16 19:16:45'),
(253,'::1','2024-06-16 19:42:15'),
(254,'::1','2024-06-16 19:43:47'),
(255,'::1','2024-06-16 20:48:30'),
(256,'::1','2024-06-17 08:00:03'),
(257,'::1','2024-06-17 08:00:42'),
(258,'::1','2024-06-17 09:02:53'),
(259,'::1','2024-06-17 09:05:02'),
(260,'::1','2024-06-17 09:42:21');

/*Table structure for table `st_user` */

DROP TABLE IF EXISTS `st_user`;

CREATE TABLE `st_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_credential` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(13) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT 'default.jpeg',
  `username` varchar(100) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_credential` (`id_credential`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `st_user` */

insert  into `st_user`(`id`,`id_credential`,`name`,`email`,`phone_number`,`address`,`province`,`city`,`image`,`username`,`password`,`last_login`,`created_date`,`created_by`,`updated_date`,`updated_by`,`deleted_date`,`deleted_by`,`is_deleted`) values 
(1,2,'Desnatha Satria','satriadesnatha@gmail.com','082245146996','JL Tirtoudan Raya',NULL,NULL,'superadmin-2024-06-12_14-13-45.jpg','superadmin','ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f','2024-06-16 01:30:53','2023-10-27 09:10:26',NULL,'2024-06-12 19:13:45',1,NULL,NULL,0),
(53,3,'Tegar Darmawan','tegardarmawan@gmail.com','08167525332','Jalan Diponegoro 86, Kota Batu Batu Jawa Timur Indonesia',NULL,NULL,'tegar_-_2023-11-22_17-28-43.jpg','tegar','ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f','2023-11-23 07:39:33','2023-11-18 13:58:19',NULL,'2023-11-23 04:31:55',1,'2024-03-22 14:15:46',1,1),
(57,3,'Lando n','DesnathaLand99@gmail.com','08253647322','desa tosaren',NULL,NULL,'lando_-_2023-11-23_01-51-29.jpg','lando','ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f','2023-11-23 07:53:09','2023-11-23 07:50:29',NULL,'2023-11-23 07:51:29',57,'2024-03-09 11:05:48',1,1),
(58,3,'Desnatha n','desnatha@gmail.com','345345345','wad',NULL,NULL,'desnathas_-_2024-06-12_14-13-55.png','desnathas','eb045d78d273107348b0300c01d29b7552d622abbc6faf81b3ec55359aa9950c','2024-06-11 11:24:30','2023-11-24 07:57:48',NULL,'2024-06-12 19:13:55',58,'2024-03-09 11:05:41',1,1),
(59,2,'Lintang Windy Pratama','lintang@gmail.com','08118393847','Jl Griyo udan tirto permai',NULL,NULL,'lintangsuper-2024-03-18_02-09-30.jpg','lintangsuper','ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f',NULL,'2024-03-18 08:09:30',1,NULL,NULL,'2024-03-18 08:23:44',1,1),
(60,3,'Tegar Darmawan','tegar@gmail.com','082283922292','Jl Griyo udan tirto permai',NULL,NULL,'tegardarma-2024-03-18_02-12-02.jpg','tegardarma','ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f',NULL,'2024-03-18 08:12:02',1,NULL,NULL,'2024-03-18 08:23:42',1,1),
(63,1,'Frankie','frankie@gmail.com','08883866931','Jl Griyo udan tirto permai',NULL,NULL,'@frank31-2024-03-18_04-57-38.jpg','@frank31','ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f',NULL,'2024-03-18 10:57:38',1,'2024-03-18 10:58:25',1,'2024-03-22 08:16:52',1,1),
(64,1,'Jihan Cahya Firmana','lisulare@gmail.com','082245146996','Kediri',NULL,NULL,'jihan-2024-04-01_06-21-04.jpg','jihan','ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f',NULL,'2024-04-01 11:21:04',1,NULL,NULL,'2024-04-02 08:59:01',1,1),
(65,3,'Desnatha','desnatha@gmail.com','082245146996','Kediri',NULL,NULL,'lando123-2024-06-12_14-18-49.jpeg','lando123','ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f',NULL,'2024-05-12 13:53:05',NULL,'2024-06-12 19:18:49',1,'2024-06-12 19:20:59',1,1),
(66,3,'Desnatha Satria Lando Arisukma','desnathaas99@gmail.com','082245146996','Jl Tirtoudan Raya','11','444','lando1234_-_2024-06-12_14-22-00.png','testing','ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f',NULL,'2024-06-12 19:21:29',NULL,'2024-06-15 23:54:40',66,NULL,NULL,0),
(67,3,'testing2','testing2@gmail.com','0811111111',NULL,NULL,NULL,'default.jpeg','testing2','ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f',NULL,'2024-06-16 01:16:30',NULL,NULL,NULL,NULL,NULL,0);

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) DEFAULT NULL,
  `nama_supplier` varchar(100) DEFAULT NULL,
  `stok` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_produk` (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `supplier` */

insert  into `supplier`(`id`,`id_produk`,`nama_supplier`,`stok`,`created_date`,`created_by`,`updated_date`,`updated_by`,`deleted_date`,`deleted_by`,`is_deleted`) values 
(46,18,'Gujilo','5','2024-06-04 13:12:04',1,NULL,NULL,NULL,NULL,0),
(47,18,'Gujilo','5','2024-06-04 13:12:14',1,NULL,NULL,NULL,NULL,0);

/*Table structure for table `transaksi` */

DROP TABLE IF EXISTS `transaksi`;

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `harga_transaksi` varchar(255) DEFAULT NULL,
  `tgl_pembelian` datetime DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_produk` (`id_produk`),
  KEY `id_pelanggan` (`id_pelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `transaksi` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
