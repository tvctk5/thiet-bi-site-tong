-- MySQL dump 10.13  Distrib 8.0.12, for Win64 (x86_64)
--
-- Host: localhost    Database: trantu
-- ------------------------------------------------------
-- Server version	8.0.12

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
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
 SET character_set_client = utf8mb4 ;
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-20  8:10:12
