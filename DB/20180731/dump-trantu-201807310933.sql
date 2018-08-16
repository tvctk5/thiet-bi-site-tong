-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: trantu
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `device`
--

DROP TABLE IF EXISTS `device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL DEFAULT 'obj-slider',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `flavor` varchar(20) DEFAULT NULL,
  `amplitude` int(6) DEFAULT '0',
  `icon` varchar(15) DEFAULT 'fa-wrench',
  `value` varchar(500) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `objid` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `device`
--

LOCK TABLES `device` WRITE;
/*!40000 ALTER TABLE `device` DISABLE KEYS */;
INSERT INTO `device` VALUES (1,'obj-vao','Dien luoi',0,NULL,0,'fa-wrench','1','vao_dien_luoi'),(2,'obj-vao','Dien may no',0,NULL,0,'fa-wrench','0','vao_dien_may_no'),(3,'obj-vao','Dien tong dai',0,NULL,0,'fa-wrench','1','vao_tong_dai'),(4,'obj-vao','Nhiet do cao',0,NULL,0,'fa-wrench','1','vao_nhiet_do_cao'),(5,'obj-vao','DC thap',0,NULL,0,'fa-wrench','0','vao_dc_thap'),(6,'obj-vao','Canh bao chay',0,NULL,0,'fa-wrench','0','vao_canh_bao_chay'),(7,'obj-vao','CB cua',0,NULL,0,'fa-wrench','0','vao_cb_cua'),(8,'obj-vao','CB cap',0,NULL,0,'fa-wrench','1','vao_cb_cap'),(9,'obj-ra','Khoa may no',0,'flavor-violet',0,'fa-wrench','','ra_khoa_may_no'),(10,'obj-de-may-no','De may no',0,'flavor-violet',5,'fa-wrench',NULL,'ra_de_may_no'),(11,'obj-radiobutton','Cau dao',1,'flavor-violet',0,'fa-wrench','0','ra_cau_dao'),(12,'obj-radiobutton','Ra 1',0,'flavor-violet',0,'fa-wrench','0','ra_1'),(13,'obj-ra','Ra 2',1,'flavor-violet',0,'fa-wrench',NULL,'ra_2'),(14,'obj-ra','Ra 3',1,'flavor-violet',0,'fa-wrench',NULL,'ra_3'),(15,'obj-ra','Ra 4',0,'flavor-violet',0,'fa-wrench',NULL,'ra_4'),(16,'obj-ra','Ra 5',0,'flavor-violet',0,'fa-wrench',NULL,'ra_5');
/*!40000 ALTER TABLE `device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `device_host`
--

DROP TABLE IF EXISTS `device_host`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device_host` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostId` int(11) NOT NULL,
  `deviceId` int(11) NOT NULL,
  `state` tinyint(4) DEFAULT '0',
  `amplitude` int(11) DEFAULT NULL,
  `value` varchar(500) COLLATE utf8_unicode_ci DEFAULT '0',
  `updatedate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `device_host`
--

LOCK TABLES `device_host` WRITE;
/*!40000 ALTER TABLE `device_host` DISABLE KEYS */;
INSERT INTO `device_host` VALUES (81,11,1,0,0,'1','2018-07-16 09:40:32'),(82,11,2,0,0,'1','2018-07-16 09:40:32'),(83,11,3,0,0,'1','2018-07-16 09:40:32'),(84,11,4,0,0,'1','2018-07-16 09:40:32'),(85,11,5,0,0,'1','2018-07-16 09:40:32'),(86,11,6,0,0,'1','2018-07-16 09:40:32'),(87,11,7,0,0,'1','2018-07-16 09:40:32'),(88,11,8,0,0,'1','2018-07-16 09:40:32'),(89,11,9,1,0,'','2018-07-16 09:40:32'),(90,11,10,0,7,'','2018-07-16 09:40:32'),(91,11,11,1,0,'1','2018-07-16 09:40:32'),(92,11,12,0,0,'1','2018-07-16 09:40:32'),(93,11,13,1,0,'','2018-07-16 09:40:32'),(94,11,14,1,0,'','2018-07-16 09:40:32'),(95,11,15,1,0,'','2018-07-16 09:40:32'),(96,11,16,1,0,'','2018-07-16 09:40:32');
/*!40000 ALTER TABLE `device_host` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `deviceid` int(11) NOT NULL,
  `value` varchar(100) DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `hostid` int(11) DEFAULT NULL,
  `device_hostid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
INSERT INTO `history` VALUES (1,2,'0','2018-05-19 16:16:18','2018-05-31 15:30:21','2018-05-19 16:16:18','2018-05-31 15:30:21',NULL,NULL),(2,4,'0','2018-05-19 16:16:18','2018-05-31 15:28:58','2018-05-19 16:16:18','2018-05-31 15:28:58',NULL,NULL),(3,8,'0','2018-05-19 16:16:18','2018-05-31 15:28:58','2018-05-19 16:16:18','2018-05-31 15:28:58',NULL,NULL),(4,1,'0','2018-05-31 15:25:56','2018-05-31 15:29:45','2018-05-31 15:25:56','2018-05-31 15:29:45',NULL,NULL),(5,3,'0','2018-05-31 15:25:56','2018-05-31 15:31:24','2018-05-31 15:25:56','2018-05-31 15:31:24',NULL,NULL),(6,2,'0','2018-05-31 15:28:58','2018-05-31 15:30:21','2018-05-31 15:28:58','2018-05-31 15:30:21',NULL,NULL),(7,1,'1','2018-05-31 15:30:21',NULL,'2018-05-31 15:30:21',NULL,NULL,NULL),(8,3,'0','2018-05-31 15:30:21','2018-05-31 15:31:24','2018-05-31 15:30:21','2018-05-31 15:31:24',NULL,NULL),(9,4,'1','2018-05-31 15:30:21',NULL,'2018-05-31 15:30:21',NULL,NULL,NULL),(10,8,'1','2018-05-31 15:30:21',NULL,'2018-05-31 15:30:21',NULL,NULL,NULL),(16,81,'1','2018-07-16 16:51:31',NULL,'2018-07-16 16:51:31',NULL,11,NULL),(17,82,'1','2018-07-16 16:51:31',NULL,'2018-07-16 16:51:31',NULL,11,NULL),(18,84,'1','2018-07-16 16:51:31',NULL,'2018-07-16 16:51:31',NULL,11,NULL),(19,85,'1','2018-07-16 16:51:31',NULL,'2018-07-16 16:51:31',NULL,11,NULL),(20,87,'1','2018-07-16 16:51:31',NULL,'2018-07-16 16:51:31',NULL,11,NULL),(21,1,'0','2018-07-16 16:55:19','2018-07-16 16:55:52','2018-07-16 16:55:19','2018-07-16 16:55:52',11,NULL),(22,2,'0','2018-07-16 16:55:19','2018-07-16 16:55:52','2018-07-16 16:55:19','2018-07-16 16:55:52',11,NULL),(23,4,'0','2018-07-16 16:55:19','2018-07-16 16:55:52','2018-07-16 16:55:19','2018-07-16 16:55:52',11,NULL),(24,5,'0','2018-07-16 16:55:19','2018-07-16 16:55:52','2018-07-16 16:55:19','2018-07-16 16:55:52',11,NULL),(25,7,'0','2018-07-16 16:55:19','2018-07-16 16:55:52','2018-07-16 16:55:19','2018-07-16 16:55:52',11,NULL),(26,3,'0','2018-07-16 16:55:52','2018-07-16 16:56:53','2018-07-16 16:55:52','2018-07-16 16:56:53',11,NULL),(27,6,'0','2018-07-16 16:55:52','2018-07-16 16:56:53','2018-07-16 16:55:52','2018-07-16 16:56:53',11,NULL),(28,8,'0','2018-07-16 16:55:52','2018-07-16 16:56:53','2018-07-16 16:55:52','2018-07-16 16:56:53',11,NULL),(29,1,'0','2018-07-16 16:56:53','2018-07-16 18:13:02','2018-07-16 16:56:53','2018-07-16 18:13:02',11,NULL),(30,2,'0','2018-07-16 16:56:53','2018-07-16 18:13:02','2018-07-16 16:56:53','2018-07-16 18:13:02',11,NULL),(31,4,'0','2018-07-16 16:56:53','2018-07-16 18:13:02','2018-07-16 16:56:53','2018-07-16 18:13:02',11,NULL),(32,5,'0','2018-07-16 16:56:53','2018-07-16 18:13:02','2018-07-16 16:56:53','2018-07-16 18:13:02',11,NULL),(33,7,'0','2018-07-16 16:56:53','2018-07-16 18:13:02','2018-07-16 16:56:53','2018-07-16 18:13:02',11,NULL),(34,3,'1','2018-07-16 18:13:02',NULL,'2018-07-16 18:13:02',NULL,11,NULL),(35,6,'1','2018-07-16 18:13:02',NULL,'2018-07-16 18:13:02',NULL,11,NULL),(36,8,'1','2018-07-16 18:13:02',NULL,'2018-07-16 18:13:02',NULL,11,NULL);
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `host`
--

DROP TABLE IF EXISTS `host`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `host` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) NOT NULL,
  `url` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `host`
--

LOCK TABLES `host` WRITE;
/*!40000 ALTER TABLE `host` DISABLE KEYS */;
INSERT INTO `host` VALUES (3,'Tráº¡m 3','000000000','http://localhost/thiet-bi-site-thanh-phan/'),(4,'Tráº¡m 4','1252365','http://localhost/thiet-bi-site-thanh-phan/'),(5,'12421','412412','http://localhost/thiet-bi-site-thanh-phan/'),(11,'Tráº¡m 5','095235623','http://localhost/thiet-bi-site-thanh-phan/');
/*!40000 ALTER TABLE `host` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` VALUES (1,'Quyền A'),(2,'Quyền B');
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  `createdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(200) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `isAdmin` smallint(6) NOT NULL DEFAULT '0' COMMENT '0: Default | 1: Admin',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'cantv','cantv','2352356236',1,'2018-05-06 09:39:21','2018-05-06 09:39:21','Can','8d2c31cf-7ef8-4bfc-9c31-906cade93d6e',1),(6,'5','23','5',1,'2018-07-14 17:05:56','2018-07-14 17:05:56','5','8d2c31cf-7ef8-4bfc-9c31-906cade93d6d',0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_host`
--

DROP TABLE IF EXISTS `user_host`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_host` (
  `userId` int(11) NOT NULL,
  `hostId` int(11) NOT NULL,
  `view` smallint(6) NOT NULL DEFAULT '1',
  `control` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_host`
--

LOCK TABLES `user_host` WRITE;
/*!40000 ALTER TABLE `user_host` DISABLE KEYS */;
INSERT INTO `user_host` VALUES (1,3,1,0),(1,4,1,1),(6,5,1,1),(7,3,1,1),(1,11,1,1);
/*!40000 ALTER TABLE `user_host` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_permission`
--

DROP TABLE IF EXISTS `user_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_permission` (
  `userId` int(11) NOT NULL,
  `permissionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permission`
--

LOCK TABLES `user_permission` WRITE;
/*!40000 ALTER TABLE `user_permission` DISABLE KEYS */;
INSERT INTO `user_permission` VALUES (1,1),(1,2);
/*!40000 ALTER TABLE `user_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'trantu'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-07-31  9:33:51
