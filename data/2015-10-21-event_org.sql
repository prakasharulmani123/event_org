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
USE `event_org`;

/*Table structure for table `evt_deviceinfos` */

DROP TABLE IF EXISTS `evt_deviceinfos`;

CREATE TABLE `evt_deviceinfos` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` char(64) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created-date` datetime DEFAULT NULL,
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `evt_deviceinfos` */

/*Table structure for table `evt_event` */

DROP TABLE IF EXISTS `evt_event`;

CREATE TABLE `evt_event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `evt_event` */

insert  into `evt_event`(`event_id`,`event_name`,`event_date`,`status`,`created_at`,`created_by`,`modified_at`,`modified_by`) values (10,'John marraige2','2015-09-18','1','2015-09-09 12:01:52',1,'2015-09-09 12:02:42',1),(11,'Abe Marraige','2015-09-12','1','2015-09-09 13:20:27',1,'0000-00-00 00:00:00',NULL),(14,'Jhon Weeding','2015-12-01','1','2015-10-05 03:36:56',1,'0000-00-00 00:00:00',NULL),(15,'Rajendran','2015-10-06','1','2015-10-05 04:22:35',1,'0000-00-00 00:00:00',NULL),(16,'Udhya Wedding','2016-01-08','1','2015-10-13 01:07:27',1,'0000-00-00 00:00:00',NULL),(17,'Harry\' wedding','2015-10-31','1','2015-10-13 01:31:38',1,'0000-00-00 00:00:00',NULL),(18,'Vcreators','2015-10-21','1','2015-10-20 19:25:18',1,'0000-00-00 00:00:00',NULL);

/*Table structure for table `evt_event_history` */

DROP TABLE IF EXISTS `evt_event_history`;

CREATE TABLE `evt_event_history` (
  `event_hist_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_list_id` int(11) NOT NULL,
  `event_hist_reason` text NOT NULL,
  `event_hist_time_separator` enum('+','-') NOT NULL DEFAULT '+',
  `event_hist_excess_time` time NOT NULL,
  `event_hist_from` time NOT NULL COMMENT 'Old time',
  `event_hist_to` time NOT NULL COMMENT 'Old time',
  `event_hist_new_from` time NOT NULL,
  `event_hist_new_to` time NOT NULL,
  `event_hist_type` enum('MT','PT') DEFAULT 'MT',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`event_hist_id`),
  KEY `FK_evt_event_history_list` (`event_list_id`),
  CONSTRAINT `FK_evt_event_history_list` FOREIGN KEY (`event_list_id`) REFERENCES `evt_event_lists` (`timing_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `evt_event_history` */

insert  into `evt_event_history`(`event_hist_id`,`event_list_id`,`event_hist_reason`,`event_hist_time_separator`,`event_hist_excess_time`,`event_hist_from`,`event_hist_to`,`event_hist_new_from`,`event_hist_new_to`,`event_hist_type`,`created_at`,`created_by`,`modified_at`,`modified_by`) values (1,28,'Test','-','00:10:00','10:00:00','10:50:00','10:00:00','10:40:00','MT','2015-09-09 19:14:45',2,'0000-00-00 00:00:00',NULL),(2,28,'asd asda','+','00:10:00','10:00:00','10:40:00','10:00:00','10:50:00','PT','2015-09-09 19:15:05',2,'0000-00-00 00:00:00',NULL),(3,29,'asd asdasd','+','00:15:00','10:50:00','12:05:00','10:50:00','12:20:00','PT','2015-09-09 19:15:17',2,'0000-00-00 00:00:00',NULL);

/*Table structure for table `evt_event_lists` */

DROP TABLE IF EXISTS `evt_event_lists`;

CREATE TABLE `evt_event_lists` (
  `timing_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `list_title` varchar(255) NOT NULL,
  `list_role` int(11) NOT NULL,
  `timing_start` time NOT NULL,
  `timing_end` time NOT NULL,
  `timing_notes` text,
  `event_type` enum('FX','FL') NOT NULL DEFAULT 'FL',
  `event_adjusted` enum('Y','N') DEFAULT 'N',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`timing_id`),
  KEY `FK_evt_timings_event` (`event_id`),
  CONSTRAINT `FK_evt_timings_event` FOREIGN KEY (`event_id`) REFERENCES `evt_event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

/*Data for the table `evt_event_lists` */

insert  into `evt_event_lists`(`timing_id`,`event_id`,`list_title`,`list_role`,`timing_start`,`timing_end`,`timing_notes`,`event_type`,`event_adjusted`,`created_at`,`created_by`,`modified_at`,`modified_by`) values (28,10,'Makeup23232',2,'14:00:00','10:50:00','sdsds\nsds\nd','FL','Y','2015-09-09 12:01:52',1,'2015-09-09 19:15:05',2),(29,10,'Decoration',2,'10:50:00','12:20:00','XXXXXXX','FL','Y','2015-09-09 12:01:52',1,'2015-09-09 19:15:17',2),(30,10,'Others',1,'12:00:00','12:30:00','dsadsad','FX','N','2015-09-09 12:01:52',1,'2015-09-09 12:02:42',1),(31,10,'Travelling to groom photoshoot',2,'13:00:00','02:00:00','asasas','FX','N','2015-09-09 12:02:42',1,'0000-00-00 00:00:00',NULL),(32,11,'Stage decoration',3,'10:00:00','12:00:00','Test test test','FL','N','2015-09-09 13:20:27',1,'0000-00-00 00:00:00',NULL),(33,11,'Travelling to groom photoshoot',4,'02:30:00','02:00:00','hhhh','FL','N','2015-09-09 13:20:27',1,'0000-00-00 00:00:00',NULL),(34,10,'sdsadsad',4,'12:05:00','12:30:00',NULL,'FL','N','2015-09-17 17:04:35',1,'0000-00-00 00:00:00',NULL),(35,14,'Marriage Function',6,'10:00:00','00:00:00',NULL,'FL','N','2015-10-05 03:39:25',1,'0000-00-00 00:00:00',NULL),(36,14,'Mehndi Functions',1,'16:00:00','00:00:00',NULL,'FL','N','2015-10-05 03:40:47',1,'0000-00-00 00:00:00',NULL),(37,11,'Camera Event',3,'16:40:00','00:00:00',NULL,'FL','N','2015-10-05 04:14:46',1,'0000-00-00 00:00:00',NULL),(38,15,'Event1',3,'10:00:00','00:00:00',NULL,'FL','N','2015-10-05 04:23:46',1,'0000-00-00 00:00:00',NULL),(39,15,'Event 2',2,'11:00:00','00:00:00',NULL,'FL','N','2015-10-05 04:24:07',1,'0000-00-00 00:00:00',NULL),(40,16,'Bridal',2,'09:35:00','00:00:00',NULL,'FL','N','2015-10-13 01:07:57',1,'0000-00-00 00:00:00',NULL),(41,16,'Groom Mackup',3,'10:30:00','00:00:00',NULL,'FL','N','2015-10-13 01:08:19',1,'0000-00-00 00:00:00',NULL),(42,16,'Wedding',4,'11:35:00','00:00:00',NULL,'FL','N','2015-10-13 01:08:32',1,'0000-00-00 00:00:00',NULL),(43,16,'Groom',3,'09:55:00','00:00:00',NULL,'FL','N','2015-10-13 01:09:58',1,'0000-00-00 00:00:00',NULL),(44,17,'bridal make up',7,'09:30:00','00:00:00','delay','FL','N','2015-10-13 01:32:15',1,'0000-00-00 00:00:00',NULL),(45,17,'bridal make up',3,'21:00:00','00:00:00',NULL,'FL','N','2015-10-13 01:32:32',1,'0000-00-00 00:00:00',NULL),(46,17,'bridal make up',4,'09:30:00','00:00:00','delay','FL','N','2015-10-13 01:36:46',1,'0000-00-00 00:00:00',NULL),(47,17,'bridal make up',3,'09:00:00','00:00:00',NULL,'FL','N','2015-10-13 01:47:54',1,'0000-00-00 00:00:00',NULL),(48,18,'event1',2,'08:10:00','00:00:00',NULL,'FL','N','2015-10-20 19:25:45',1,'0000-00-00 00:00:00',NULL),(49,18,'event5',3,'22:00:00','00:00:00',NULL,'FL','N','2015-10-20 19:26:04',1,'0000-00-00 00:00:00',NULL),(50,18,'event2',4,'11:00:00','00:00:00',NULL,'FL','N','2015-10-20 19:26:38',1,'0000-00-00 00:00:00',NULL),(51,18,'event3',6,'12:00:00','00:00:00',NULL,'FX','N','2015-10-20 19:28:26',1,'0000-00-00 00:00:00',NULL),(52,18,'event4',7,'15:00:00','00:00:00',NULL,'FL','N','2015-10-20 19:29:14',1,'0000-00-00 00:00:00',NULL);

/*Table structure for table `evt_event_vendors` */

DROP TABLE IF EXISTS `evt_event_vendors`;

CREATE TABLE `evt_event_vendors` (
  `evt_vendor` int(11) NOT NULL AUTO_INCREMENT,
  `ev_event_id` int(11) NOT NULL,
  `evt_vendor_name` varchar(100) NOT NULL,
  `evt_vendor_email` varchar(100) NOT NULL,
  `evt_vendor_phone` varchar(100) NOT NULL,
  `evt_vendor_role` int(11) NOT NULL,
  `is_status` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`evt_vendor`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `evt_event_vendors` */

insert  into `evt_event_vendors`(`evt_vendor`,`ev_event_id`,`evt_vendor_name`,`evt_vendor_email`,`evt_vendor_phone`,`evt_vendor_role`,`is_status`,`created_at`,`created_by`) values (1,10,'AAAA','sasa@fsdsd.com','113121',3,'1','2015-09-18 18:21:08',1),(2,10,'sdsd','sasa@fsdsd.com','113121',2,'1','2015-09-18 18:12:57',1),(3,10,'tretret','trtrttr@fsdsd.com','43242342343',2,'1','2015-09-18 13:17:35',1),(4,11,'Rajendran','ceo@arkinfotec.com','98948374338`',3,'1','2015-10-05 04:20:45',1),(5,15,'Ariv','ceo@arkinfotec.com','1234456789',2,'1','2015-10-05 04:23:10',1),(6,16,'Udhaya1','test@test.com','1231231231',2,'1','2015-10-13 01:11:36',1),(7,16,'Udhaya2','ceo@arkinfotec.com','1231231231',3,'1','2015-10-13 01:11:47',1),(8,17,'harry','a@yopmail.com','2342432342',6,'1','2015-10-13 01:34:10',1),(9,16,'Rajendran','ceo@arkinfotec.com','98948374338',6,'1','2015-10-13 02:03:49',1),(10,16,'Udhaya 5','test@test.com','1231231231888',4,'1','2015-10-14 02:49:48',1),(11,16,'Udhaya6','test@test.com','1231231231',2,'1','2015-10-14 02:50:02',1);

/*Table structure for table `evt_role` */

DROP TABLE IF EXISTS `evt_role`;

CREATE TABLE `evt_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `rank` smallint(6) DEFAULT '100',
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `evt_role` */

insert  into `evt_role`(`role_id`,`role_name`,`rank`,`status`,`created_at`,`created_by`,`modified_at`,`modified_by`) values (1,'admin',1,'1','2015-08-31 13:43:23',0,'2015-10-13 00:58:10',1),(2,'Flowerist',200,'1','2015-09-04 11:57:45',0,NULL,NULL),(3,'Camera man',100,'1','2015-09-04 11:57:52',0,NULL,NULL),(4,'Stage Decorater',100,'1','2015-09-04 11:57:58',0,NULL,NULL),(6,'Bride Makupman',100,'1','2015-09-05 12:45:46',2,'0000-00-00 00:00:00',NULL),(7,'makeup artist',100,'1','2015-10-13 01:22:32',1,'0000-00-00 00:00:00',NULL);

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
  `user_company` varchar(100) DEFAULT NULL,
  `user_address` text,
  `user_avatar` text,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `FK_evt_user` (`role_id`),
  CONSTRAINT `FK_evt_user` FOREIGN KEY (`role_id`) REFERENCES `evt_role` (`role_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `evt_user` */

insert  into `evt_user`(`user_id`,`username`,`password_hash`,`password_reset_token`,`user_firstname`,`user_lastname`,`role_id`,`user_email`,`user_phone`,`user_company`,`user_address`,`user_avatar`,`status`,`created_at`,`created_by`,`modified_at`,`modified_by`) values (1,'admin','263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62',NULL,'Admin','admin',1,'admin@admin.com','123456789','','','\\user\\cfd0b141f520d1c381a27c7585c214fa.jpg','1','2015-08-31 13:43:41',0,'2015-10-05 12:43:00',1),(3,'rajesh','263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62',NULL,'Rajesh','',6,'prakash.paramanandam@arkinfotec1.com','956665982','','',NULL,'1','2015-09-05 12:46:14',2,'2015-10-05 02:02:47',1),(4,'rajend_ran','768bd5dfc34ee2b4c7ba31ae4b406239c00115b38e2051a78b9e700fed8faa6e4927d86df625ef2e2ff0d5ada9bed3d8cf1b7191c7d596991f25798a9052da3d',NULL,'rajendran','Subramanian',3,'ceo@arkinfotec.com','9894837443','Ark','etst',NULL,'1','2015-10-13 01:06:19',1,'0000-00-00 00:00:00',NULL),(5,'gayatri','28c96737b2d65743b517bb9cd40145a8fe9ef59f58782ee41509c2bd52f7932941cfcd4f86cbe777f1513533b7d9cfc19558baef78c3dbaf113ffd14fbcb4127',NULL,'Gayatri','Subramanian',2,'gayatri@arkinfotec.com','1231231234','Ark','test',NULL,'1','2015-10-13 01:06:59',1,'0000-00-00 00:00:00',NULL),(6,'Hermione','20ad0de0d50a9585ef7528d50e6d9805b7a8edb4402382898bbdcee20193d22658dbefd70675f31a95bc5632b4ab59f7f5073e1875a47dda2d77ea6c4c7ad3a4',NULL,'Hermione','Granger',7,'a@yopmail.com','12212121','ark','hi',NULL,'1','2015-10-13 01:30:54',1,'0000-00-00 00:00:00',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
