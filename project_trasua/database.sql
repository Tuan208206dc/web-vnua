/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.32-MariaDB : Database - db_trasua
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_trasua` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `db_trasua`;

/*Table structure for table `chi_tiet_don_hang` */

DROP TABLE IF EXISTS `chi_tiet_don_hang`;

CREATE TABLE `chi_tiet_don_hang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `don_hang_id` int(11) NOT NULL,
  `mon_uong_id` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `don_gia` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `don_hang_id` (`don_hang_id`),
  KEY `mon_uong_id` (`mon_uong_id`),
  CONSTRAINT `chi_tiet_don_hang_ibfk_1` FOREIGN KEY (`don_hang_id`) REFERENCES `don_hang` (`id`),
  CONSTRAINT `chi_tiet_don_hang_ibfk_2` FOREIGN KEY (`mon_uong_id`) REFERENCES `mon_uong` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `chi_tiet_don_hang` */

insert  into `chi_tiet_don_hang`(`id`,`don_hang_id`,`mon_uong_id`,`so_luong`,`don_gia`) values 
(1,1,2,1,35000.00),
(2,2,1,1,30000.00),
(3,2,2,1,35000.00),
(4,3,5,1,35000.00),
(5,3,2,1,35000.00);

/*Table structure for table `don_hang` */

DROP TABLE IF EXISTS `don_hang`;

CREATE TABLE `don_hang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten_khach` varchar(100) NOT NULL,
  `so_dien_thoai` varchar(15) NOT NULL,
  `dia_chi` varchar(255) NOT NULL,
  `tong_tien` decimal(10,2) NOT NULL,
  `trang_thai` varchar(30) DEFAULT 'Chờ xác nhận',
  `ngay_dat` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `don_hang` */

insert  into `don_hang`(`id`,`ten_khach`,`so_dien_thoai`,`dia_chi`,`tong_tien`,`trang_thai`,`ngay_dat`) values 
(1,'du','0342365304','d',35000.00,'Chờ xác nhận','2026-10-14 21:26:34'),
(2,'linh','0384903253','l',65000.00,'Chờ xác nhận','2026-10-14 21:54:16'),
(3,'Nguyễn Diêu Linh','0384903253','32 đào nguyên a',70000.00,'Chờ xác nhận','2026-10-14 22:02:42');

/*Table structure for table `mon_uong` */

DROP TABLE IF EXISTS `mon_uong`;

CREATE TABLE `mon_uong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten_mon` varchar(100) NOT NULL,
  `gia` decimal(10,2) NOT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `trang_thai` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `mon_uong` */

insert  into `mon_uong`(`id`,`ten_mon`,`gia`,`hinh_anh`,`mo_ta`,`trang_thai`) values 
(1,'Trà sữa truyền thống',30000.00,NULL,'Trà sữa thơm ngon',1),
(2,'Trà sữa trân châu đường đen',35000.00,NULL,'Trân châu đường đen dai ngon',1),
(3,'Trà đào cam sả',30001.00,'','Trà trái cây thanh mát',1),
(4,'Trà vải',30000.00,NULL,'Trà vải thơm ngọt',1),
(5,'Matcha latte',35000.00,NULL,'Matcha kết hợp sữa tươi',1),
(6,'Trà sữa khoai môn',35001.00,'','',1);

/*Table structure for table `tai_khoan_admin` */

DROP TABLE IF EXISTS `tai_khoan_admin`;

CREATE TABLE `tai_khoan_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten_dang_nhap` varchar(50) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ten_dang_nhap` (`ten_dang_nhap`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tai_khoan_admin` */

insert  into `tai_khoan_admin`(`id`,`ten_dang_nhap`,`mat_khau`) values 
(1,'admin','admin123');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
