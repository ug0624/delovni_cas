-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: delovni_cas
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `arrival_times`
--

DROP TABLE IF EXISTS `arrival_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `arrival_times` (
  `arrival_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `arrival_time` datetime DEFAULT NULL,
  PRIMARY KEY (`arrival_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `arrival_times_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arrival_times`
--

LOCK TABLES `arrival_times` WRITE;
/*!40000 ALTER TABLE `arrival_times` DISABLE KEYS */;
INSERT INTO `arrival_times` VALUES (1,1,'2024-01-19 08:30:00'),(2,2,'2024-01-19 09:15:00'),(3,3,'2024-01-19 08:00:00'),(4,4,'2024-01-19 09:30:00'),(5,5,'2024-01-19 08:45:00'),(6,1,'2024-01-19 08:30:00'),(7,1,'2024-01-19 08:30:00'),(8,1,'2022-02-19 09:00:00'),(9,1,'2021-02-19 09:00:00'),(10,1,'2021-02-19 09:00:00'),(11,2,'2021-02-19 09:00:00'),(12,1,'2024-01-19 09:00:00'),(13,1,'2024-01-19 09:00:00'),(14,1,'2024-01-19 09:00:00'),(15,1,'2024-01-19 09:30:00'),(16,5,'2024-01-19 09:00:00'),(17,11,'2024-01-19 09:00:00');
/*!40000 ALTER TABLE `arrival_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departure_times`
--

DROP TABLE IF EXISTS `departure_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departure_times` (
  `departure_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `departure_time` datetime DEFAULT NULL,
  PRIMARY KEY (`departure_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `departure_times_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departure_times`
--

LOCK TABLES `departure_times` WRITE;
/*!40000 ALTER TABLE `departure_times` DISABLE KEYS */;
INSERT INTO `departure_times` VALUES (1,1,'2024-01-19 17:30:00'),(2,2,'2024-01-19 17:30:00'),(3,3,'2024-01-19 17:30:00'),(4,1,'2024-01-19 17:30:00'),(5,1,'2024-01-18 17:30:00'),(6,2,'2024-01-18 17:30:00'),(7,3,'2024-01-18 17:30:00'),(8,1,'2024-02-19 09:00:00'),(9,1,'2024-01-19 17:30:00'),(10,1,'2024-01-19 17:30:00'),(11,2,'2024-01-19 09:30:00'),(12,11,'2024-01-19 17:00:00');
/*!40000 ALTER TABLE `departure_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'Ana','Novak','Programer','ana.novak@example.com','securepassword1'),(2,'Borut','Kovač','Oblikovalec','borut.kovac@example.com','securepassword2'),(3,'Cilka','Zupan','Projektni vodja','cilka.zupan@example.com','securepassword3'),(4,'David','Lah','Sistemski analitik','david.lah@example.com','securepassword4'),(5,'Eva','Kos','Razvijalec QA','eva.kos@example.com','securepassword5'),(6,'John','Doe','Developer','john.doe@example.com','$2y$10$RF/WUDqZOiZnGSe2X2VYnecj7ioEscCt5iUTajEbUSqgkqpUFnIha'),(7,'John','Doe','Software Developer','john.doe@example.com','$2y$10$G8x7wJfkpx4bk4bzXAhpquSY.HEK6Zd.AJjga.qzd3aNgctf3UsWW'),(8,'John','Doe','Software Developer','john.doe@example.com','$2y$10$nsUHCpKB7evSCRl2O2XtWeyPthvqOlMCDASB2Qi6.rORyPFQvf4bq'),(9,'John','Doe','Software Developer','john.doe@example.com','$2y$10$Fh6qsEqRjE7ASFz76reGbeNXwjIqj7j5CiWTGU/H.uKN.T4e7uFsq'),(10,'John','Doe','Software Developer','john.doe@example.com','$2y$10$Q0bfjwIOxxNHdSqZqpWNQumnig3tFIRnzcbCTnUQVo.Hy2JQiqKl.'),(11,'Alice','Smith','Data Analyst','alice.smith@example.com','$2y$10$ZwTRDxs6R8/1W8QVezVazOE9WFOqMMI5OnIeqP/NMnzCvLz5p1DU6'),(12,'John','Doe','Developer','john.doe@example.com','$2y$10$4dlSR9qnldXuVDuQmg1htuU5kGr.ShtPS73dM60tlZxZDt.Yd3YbK');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_records`
--

DROP TABLE IF EXISTS `leave_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_records` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `leave_date` date DEFAULT NULL,
  `leave_type` enum('sick_leave','vacation') NOT NULL,
  PRIMARY KEY (`leave_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `leave_records_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_records`
--

LOCK TABLES `leave_records` WRITE;
/*!40000 ALTER TABLE `leave_records` DISABLE KEYS */;
INSERT INTO `leave_records` VALUES (1,3,'2024-01-20','vacation'),(2,3,'2020-01-19','sick_leave');
/*!40000 ALTER TABLE `leave_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lunch_records`
--

DROP TABLE IF EXISTS `lunch_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lunch_records` (
  `lunch_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `lunch_date` date DEFAULT NULL,
  PRIMARY KEY (`lunch_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `lunch_records_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lunch_records`
--

LOCK TABLES `lunch_records` WRITE;
/*!40000 ALTER TABLE `lunch_records` DISABLE KEYS */;
INSERT INTO `lunch_records` VALUES (1,3,'2025-01-19'),(2,3,'2024-01-18'),(3,3,'2024-01-18'),(4,3,'2020-01-18'),(5,3,'2024-01-20'),(6,3,'2024-01-20');
/*!40000 ALTER TABLE `lunch_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'urban','$2a$12$NgVouedOPrE9kfblk3jT4ebU8s7zmxMjS4ZLIGI2LRYszRdCsLN5C');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-22  9:47:31
