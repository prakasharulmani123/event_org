/*
SQLyog Ultimate v8.55 
MySQL - 5.6.14 : Database - event_org
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `evt_event` */

DROP TABLE IF EXISTS `evt_event`;

CREATE TABLE `evt_event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_users` tinytext NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `modified_at` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `evt_event` */

/*Table structure for table `evt_role` */

DROP TABLE IF EXISTS `evt_role`;

CREATE TABLE `evt_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `rank` smallint(6) DEFAULT '100',
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `modified_at` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `evt_role` */

insert  into `evt_role`(`role_id`,`role_name`,`rank`,`status`,`created_at`,`created_by`,`modified_at`,`modified_by`) values (1,'admin',1,'1','2015-08-31 13:43:23','0000-00-00 00:00:00',NULL,NULL);

/*Table structure for table `evt_timing` */

DROP TABLE IF EXISTS `evt_timing`;

CREATE TABLE `evt_timing` (
  `timing_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `timing_start` time NOT NULL,
  `timing_end` time NOT NULL,
  `timing_notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `modified_at` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`timing_id`),
  KEY `FK_evt_timings_event` (`event_id`),
  CONSTRAINT `FK_evt_timings_event` FOREIGN KEY (`event_id`) REFERENCES `evt_event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `evt_timing` */

/*Table structure for table `evt_user` */

DROP TABLE IF EXISTS `evt_user`;

CREATE TABLE `evt_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_lastname` varchar(50) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phone` varchar(50) DEFAULT NULL,
  `user_address` text,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `modified_at` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `FK_evt_user` (`role_id`),
  CONSTRAINT `FK_evt_user` FOREIGN KEY (`role_id`) REFERENCES `evt_role` (`role_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `evt_user` */

insert  into `evt_user`(`user_id`,`username`,`password_hash`,`password_reset_token`,`user_firstname`,`user_lastname`,`role_id`,`user_email`,`user_phone`,`user_address`,`status`,`created_at`,`created_by`,`modified_at`,`modified_by`) values (1,'admin','be2ce3b45176df1d3e41e35d6aa0ea9a44b56b3575e15ebc6da0d3da7793489b9eb718dc2cfe7f5f2bc61151ad4ffc70ba4d234520ed51735fa98ec878ddc27b',NULL,'Admin','admin',1,'admin@admin.com',NULL,NULL,'1','2015-08-31 13:43:41','0000-00-00 00:00:00',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
