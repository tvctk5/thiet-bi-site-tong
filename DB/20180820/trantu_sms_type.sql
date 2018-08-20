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
-- Table structure for table `sms_type`
--

DROP TABLE IF EXISTS `sms_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `sms_type` (
  `id` int(11) NOT NULL,
  `name` varchar(145) NOT NULL,
  `message` varchar(250) DEFAULT NULL,
  `deviceId` int(11) DEFAULT NULL,
  `allowsendsms` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_type`
--

LOCK TABLES `sms_type` WRITE;
/*!40000 ALTER TABLE `sms_type` DISABLE KEYS */;
INSERT INTO `sms_type` VALUES (10,'Mất điện lưới','Mất điện lưới',1,1),(11,'Có điện lưới','Có điện lưới',1,1),(20,'Tắt điện máy nổ','Máy nổ tắt',2,1),(21,'Chạy máy nổ','Máy nổ chạy',2,1),(30,'Điện tổng đài','Điện tổng đài tắt',3,1),(31,'Điện tổng đài','Điện tổng đài bật',3,1),(40,'Nhiệt độ cao','Nhiệt độ tăng cao',4,1),(41,'Nhiệt độ cao','Nhiệt độ bình thường',4,1),(50,'DC thap','DC thap0',5,1),(51,'DC thap','DC thap1',5,1),(60,'Canh bao chay','Canh bao chay0',6,1),(61,'Canh bao chay','Canh bao chay1',6,1),(70,'CB cua','CB cua0',7,1),(71,'CB cua','CB cua1',7,1),(80,'CB cap','CB cap0',8,1),(81,'CB cap','CB cap1',8,1);
/*!40000 ALTER TABLE `sms_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-20  8:10:10
