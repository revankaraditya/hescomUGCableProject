-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: newHescom
-- ------------------------------------------------------
-- Server version	8.0.37-0ubuntu0.22.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `fault_records`
--

DROP TABLE IF EXISTS `fault_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fault_records` (
  `FID` int NOT NULL AUTO_INCREMENT,
  `CID` int NOT NULL,
  `UID` int NOT NULL,
  `FAULT_CODE` varchar(64) NOT NULL,
  `FAULT_TITLE` text NOT NULL,
  `FEEDER_NAME` text,
  `FROM` text,
  `TO` text,
  `REASON` longtext,
  `DTC_NAME` text,
  `RMU_LOCATION` text,
  `CRDATE` date NOT NULL,
  `STATUS` int NOT NULL,
  PRIMARY KEY (`FID`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fault_records`
--

LOCK TABLES `fault_records` WRITE;
/*!40000 ALTER TABLE `fault_records` DISABLE KEYS */;
INSERT INTO `fault_records` VALUES (102,1,4,'2024-06-190658','Cable Damage 1234','Shahapur So','Acharya Galli','Bichu Galli','Rain','','','2024-06-19',0),(103,10,4,'2024-06-210155','Test 3','Tilakwadi','','','','','Near panchamrut','2024-06-21',0),(104,6,4,'2024-06-210204','Fault at Tilakwadi','','GIT','KLE','','IDK','','2024-06-21',0),(105,11,5,'2024-06-210200','test999','abc','','','','','def','2024-06-21',0),(106,7,4,'2024-06-211242','Cable Damage near GIT','','GIT main gate','Raghvendra cafe','','Majgav','','2024-06-21',0),(107,3,4,'2024-06-210154','Cable damage at KLE IT','Angol','benco','KLE','Truck over wire','','','2024-06-21',0),(108,7,4,'2024-06-210223','Cable cut at GIT','','GIT','KLE','','Majgav','','2024-06-21',0),(110,1,4,'2024-06-280408','Fault at nnnnn','uhbhwavyd','adadaada','asdfadfa','cdssfsdf','','','2024-06-28',0),(111,1,4,'2024-07-011032','Test Fault Details 1','Shahapur','garden','temple','heavy rain','','','2024-07-01',0),(112,2,4,'2024-07-011105','Test 11','ayodhya','benco','Bichu Galli','a','','','2024-07-01',0),(113,7,4,'2024-07-010142','Fault123','','Konwal Galli','Shankar bakery','','Shravani','','2024-07-01',0),(114,11,5,'2024-07-010212','No Light at INOX','Aditya','','','','','Shahapur','2024-07-01',0),(115,10,4,'20240701100','z','z','','','','','z','2024-07-01',0),(116,6,4,'20240701101','m','','m','m','','m','','2024-07-01',0),(117,10,4,'20240701001','s','s','','','','','s','2024-07-01',0),(118,6,4,'20240701001','p','','p','p','','p','','2024-07-01',0),(119,1,4,'20240701001','k','k','k','k','k','','','2024-07-01',0);
/*!40000 ALTER TABLE `fault_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fault_resolution_steps`
--

DROP TABLE IF EXISTS `fault_resolution_steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fault_resolution_steps` (
  `SLNO` int NOT NULL AUTO_INCREMENT,
  `CID` int NOT NULL,
  `FSID` int NOT NULL,
  `NAME` text NOT NULL,
  PRIMARY KEY (`SLNO`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fault_resolution_steps`
--

LOCK TABLES `fault_resolution_steps` WRITE;
/*!40000 ALTER TABLE `fault_resolution_steps` DISABLE KEYS */;
INSERT INTO `fault_resolution_steps` VALUES (1,0,1,'Cable fault located'),(2,0,2,'Cable Damaged by 3rd party awaiting for repair'),(3,0,3,'Repair pending due to road cutting permission'),(4,0,4,'Repair pending due to no spare parts'),(5,0,5,'Cable joint completed pending for charge'),(6,0,6,'Cable joint completed, line charged'),(7,0,7,'RMU repaired'),(8,0,8,'Line charged OK'),(9,1,1,'Cable fault located'),(10,1,2,'Cable Damaged by 3rd party awaiting for repair'),(11,1,3,'Repair pending due to road cutting permission'),(12,1,4,'Repair pending due to no spare parts'),(13,1,5,'Cable joint completed pending for charge'),(14,1,6,'Cable joint completed, line charged'),(15,1,7,'RMU repaired'),(16,1,8,'Line charged OK'),(17,2,1,'Cable fault located'),(18,2,2,'Cable Damaged by 3rd party awaiting for repair'),(19,2,3,'Repair pending due to road cutting permission'),(20,2,4,'Repair pending due to no spare parts'),(21,2,5,'Cable joint completed pending for charge'),(22,2,6,'Cable joint completed, line charged'),(23,2,7,'RMU repaired'),(24,2,8,'Line charged OK'),(25,3,1,'Cable fault located'),(26,3,2,'Cable Damaged by 3rd party awaiting for repair'),(27,3,3,'Repair pending due to road cutting permission'),(28,3,4,'Repair pending due to no spare parts'),(29,3,5,'Cable joint completed pending for charge'),(30,3,6,'Cable joint completed, line charged'),(31,3,7,'RMU repaired'),(32,3,8,'Line charged OK'),(33,4,1,'Cable fault located'),(34,4,2,'Cable Damaged by 3rd party awaiting for repair'),(35,4,3,'Repair pending due to road cutting permission'),(36,4,4,'Repair pending due to no spare parts'),(37,4,5,'Cable joint completed pending for charge'),(38,4,6,'Cable joint completed, line charged'),(39,4,7,'RMU repaired'),(40,4,8,'Line charged OK'),(41,5,1,'Cable fault located'),(42,5,2,'Cable Damaged by 3rd party awaiting for repair'),(43,5,3,'Repair pending due to road cutting permission'),(44,5,4,'Repair pending due to no spare parts'),(45,5,5,'Cable joint completed pending for charge'),(46,5,6,'Cable joint completed, line charged'),(47,5,7,'RMU repaired'),(48,5,8,'Line charged OK'),(49,6,1,'Cable fault located'),(50,6,2,'Cable Damaged by 3rd party awaiting for repair'),(51,6,3,'Repair pending due to road cutting permission'),(52,6,4,'Repair pending due to no spare parts'),(53,6,5,'Cable joint completed pending for charge'),(54,6,6,'Cable joint completed, line charged'),(55,6,7,'RMU repaired'),(56,6,8,'Line charged OK'),(57,7,1,'Cable fault located'),(58,7,2,'Cable Damaged by 3rd party awaiting for repair'),(59,7,3,'Repair pending due to road cutting permission'),(60,7,4,'Repair pending due to no spare parts'),(61,7,5,'Cable joint completed pending for charge'),(62,7,6,'Cable joint completed, line charged'),(63,7,7,'RMU repaired'),(64,7,8,'Line charged OK'),(65,8,1,'Cable fault located'),(66,8,2,'Cable Damaged by 3rd party awaiting for repair'),(67,8,3,'Repair pending due to road cutting permission'),(68,8,4,'Repair pending due to no spare parts'),(69,8,5,'Cable joint completed pending for charge'),(70,8,6,'Cable joint completed, line charged'),(71,8,7,'RMU repaired'),(72,8,8,'Line charged OK'),(73,9,1,'Cable fault located'),(74,9,2,'Cable Damaged by 3rd party awaiting for repair'),(75,9,3,'Repair pending due to road cutting permission'),(76,9,4,'Repair pending due to no spare parts'),(77,9,5,'Cable joint completed pending for charge'),(78,9,6,'Cable joint completed, line charged'),(79,9,7,'RMU repaired'),(80,9,8,'Line charged OK'),(81,10,1,'Cable fault located'),(82,10,2,'Cable Damaged by 3rd party awaiting for repair'),(83,10,3,'Repair pending due to road cutting permission'),(84,10,4,'Repair pending due to no spare parts'),(85,10,5,'Cable joint completed pending for charge'),(86,10,6,'Cable joint completed, line charged'),(87,10,7,'RMU repaired'),(88,10,8,'Line charged OK'),(89,11,1,'Cable fault located'),(90,11,2,'Cable Damaged by 3rd party awaiting for repair'),(91,11,3,'Repair pending due to road cutting permission'),(92,11,4,'Repair pending due to no spare parts'),(93,11,5,'Cable joint completed pending for charge'),(94,11,6,'Cable joint completed, line charged'),(95,11,7,'RMU repaired'),(96,11,8,'Line charged OK');
/*!40000 ALTER TABLE `fault_resolution_steps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fault_status`
--

DROP TABLE IF EXISTS `fault_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fault_status` (
  `SLNO` int NOT NULL AUTO_INCREMENT,
  `FID` int NOT NULL,
  `CID` int NOT NULL,
  `FSID` int NOT NULL,
  `MDATE` date NOT NULL,
  `STATUS` int NOT NULL,
  PRIMARY KEY (`SLNO`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fault_status`
--

LOCK TABLES `fault_status` WRITE;
/*!40000 ALTER TABLE `fault_status` DISABLE KEYS */;
INSERT INTO `fault_status` VALUES (2,102,1,1,'2024-06-19',1),(6,102,1,2,'2024-06-21',1),(7,102,1,3,'2024-06-21',1),(13,103,10,1,'2024-06-21',1),(14,103,10,2,'2024-06-21',1),(15,103,10,3,'2024-06-21',1),(16,103,10,4,'2024-06-21',1),(17,103,10,5,'2024-06-21',1),(18,103,10,6,'2024-06-21',1),(19,103,10,7,'2024-06-21',1),(20,103,10,8,'2024-06-21',1),(21,104,6,1,'2024-06-21',1),(22,104,6,2,'2024-06-21',1),(23,104,6,3,'2024-06-21',1),(24,104,6,4,'2024-06-21',1),(25,104,6,5,'2024-06-21',1),(26,104,6,6,'2024-06-21',1),(27,104,6,7,'2024-06-21',1),(28,104,6,8,'2024-06-21',1),(29,105,11,1,'2024-06-21',1),(30,106,7,1,'2024-06-21',1),(31,106,7,2,'2024-06-21',1),(32,106,7,3,'2024-06-21',1),(33,106,7,4,'2024-06-21',1),(34,106,7,5,'2024-06-21',1),(35,106,7,6,'2024-06-21',1),(36,106,7,7,'2024-06-21',1),(37,106,7,8,'2024-06-21',1),(38,107,3,1,'2024-06-21',1),(39,107,3,2,'2024-06-21',1),(40,105,11,2,'2024-06-21',1),(41,107,3,3,'2024-06-21',1),(42,107,3,4,'2024-06-21',1),(43,107,3,5,'2024-06-21',1),(44,107,3,6,'2024-06-21',1),(45,107,3,7,'2024-06-21',1),(46,107,3,8,'2024-06-21',1),(49,108,7,1,'2024-06-21',1),(50,108,7,2,'2024-06-21',1),(51,108,7,3,'2024-06-21',1),(52,108,7,4,'2024-06-21',1),(53,108,7,5,'2024-06-21',1),(54,108,7,6,'2024-06-21',1),(55,108,7,7,'2024-06-21',1),(56,108,7,8,'2024-06-21',1),(58,110,1,1,'2024-06-28',1),(59,110,1,2,'2024-06-28',1),(60,110,1,3,'2024-06-28',1),(61,110,1,4,'2024-06-28',1),(62,110,1,5,'2024-06-28',1),(63,110,1,6,'2024-06-28',1),(64,110,1,7,'2024-06-28',1),(65,110,1,8,'2024-06-28',1),(66,102,1,7,'2024-07-01',1),(67,102,1,4,'2024-07-01',1),(68,102,1,8,'2024-07-01',1),(69,111,1,1,'2024-07-01',1),(70,111,1,2,'2024-07-01',1),(71,111,1,3,'2024-07-01',1),(72,111,1,7,'2024-07-01',1),(73,111,1,4,'2024-07-01',1),(74,111,1,5,'2024-07-01',1),(75,111,1,6,'2024-07-01',1),(76,111,1,8,'2024-07-01',1),(77,112,2,1,'2024-07-01',1),(78,112,2,4,'2024-07-01',1),(79,112,2,3,'2024-07-01',1),(80,113,7,1,'2024-07-01',1),(81,113,7,7,'2024-07-01',1),(82,113,7,8,'2024-07-01',1),(83,112,2,8,'2024-07-01',1),(84,114,11,1,'2024-07-01',1),(85,114,11,7,'2024-07-01',1),(86,114,11,8,'2024-07-01',1),(87,105,11,8,'2024-07-01',1),(88,115,10,1,'2024-07-01',1),(89,116,6,1,'2024-07-01',1),(90,117,10,1,'2024-07-01',1),(91,118,6,1,'2024-07-01',1),(92,119,1,1,'2024-07-01',1),(93,119,1,8,'2024-07-01',1),(94,115,10,8,'2024-07-01',1),(95,116,6,8,'2024-07-01',1),(96,117,10,8,'2024-07-01',1),(97,118,6,8,'2024-07-01',1);
/*!40000 ALTER TABLE `fault_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `primary_fault_category`
--

DROP TABLE IF EXISTS `primary_fault_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `primary_fault_category` (
  `PFID` int NOT NULL AUTO_INCREMENT,
  `PFNAME` varchar(255) NOT NULL,
  PRIMARY KEY (`PFID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `primary_fault_category`
--

LOCK TABLES `primary_fault_category` WRITE;
/*!40000 ALTER TABLE `primary_fault_category` DISABLE KEYS */;
INSERT INTO `primary_fault_category` VALUES (1,'11KV Cable'),(2,'L.T. Cable'),(3,'RMU Fault');
/*!40000 ALTER TABLE `primary_fault_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secondary_fault_category`
--

DROP TABLE IF EXISTS `secondary_fault_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `secondary_fault_category` (
  `CID` int NOT NULL AUTO_INCREMENT,
  `FNAME` varchar(255) NOT NULL,
  `PFID` int NOT NULL,
  PRIMARY KEY (`CID`),
  KEY `PFID` (`PFID`),
  CONSTRAINT `secondary_fault_category_ibfk_1` FOREIGN KEY (`PFID`) REFERENCES `primary_fault_category` (`PFID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secondary_fault_category`
--

LOCK TABLES `secondary_fault_category` WRITE;
/*!40000 ALTER TABLE `secondary_fault_category` DISABLE KEYS */;
INSERT INTO `secondary_fault_category` VALUES (1,'11KV 400sqmm UG Cable',1),(2,'11KV 240sqmm UG Cable',1),(3,'11KV 95sqmm UG Cable',1),(4,'1.1KV 240sqmm UG Cable',2),(5,'1.1KV 180sqmm UG Cable',2),(6,'1.1KV 150sqmm UG Cable',2),(7,'1.1KV 95sqmm UG Cable',2),(8,'RMU breaker jam',3),(9,'RMU flash over',3),(10,'RMU not tripping',3),(11,'RMU noicy',3);
/*!40000 ALTER TABLE `secondary_fault_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stored_month`
--

DROP TABLE IF EXISTS `stored_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stored_month` (
  `slno` int NOT NULL,
  `month` int DEFAULT NULL,
  `count` int DEFAULT NULL,
  PRIMARY KEY (`slno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stored_month`
--

LOCK TABLES `stored_month` WRITE;
/*!40000 ALTER TABLE `stored_month` DISABLE KEYS */;
INSERT INTO `stored_month` VALUES (1,7,3);
/*!40000 ALTER TABLE `stored_month` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `UID` int NOT NULL AUTO_INCREMENT,
  `UTNO` int NOT NULL,
  `NAME` varchar(64) NOT NULL,
  `EMAIL` varchar(64) NOT NULL,
  `USERNAME` varchar(64) NOT NULL,
  `PASSWORD` varchar(64) NOT NULL,
  `PHONE` bigint NOT NULL,
  `CDATE` datetime DEFAULT NULL,
  PRIMARY KEY (`UID`),
  KEY `UTNO` (`UTNO`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`UTNO`) REFERENCES `usertype` (`UTNO`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'Supervisor1','supervisor1@example.com','supervisor1','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00'),(2,1,'Supervisor2','supervisor2@example.com','supervisor2','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00'),(3,1,'Supervisor3','supervisor3@example.com','supervisor3','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00'),(4,2,'SectionOfficer1','sectionofficer1@example.com','sectionofficer1','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00'),(5,2,'SectionOfficer2','sectionofficer2@example.com','sectionofficer2','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00'),(6,2,'SectionOfficer3','sectionofficer3@example.com','sectionofficer3','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00'),(7,2,'SectionOfficer4','sectionofficer4@example.com','sectionofficer4','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00'),(8,2,'SectionOfficer5','sectionofficer5@example.com','sectionofficer5','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00'),(9,2,'SectionOfficer6','sectionofficer6@example.com','sectionofficer6','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00'),(10,2,'SectionOfficer7','sectionofficer7@example.com','sectionofficer7','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00'),(11,2,'SectionOfficer8','sectionofficer8@example.com','sectionofficer8','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00'),(12,2,'SectionOfficer9','sectionofficer9@example.com','sectionofficer9','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00'),(13,3,'UGCableOperator','ugcableoperator@example.com','ugcableoperator','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00'),(15,4,'Admin','admin@example.com','admin','5f4dcc3b5aa765d61d8327deb882cf99',123456789,'2024-06-01 00:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertype`
--

DROP TABLE IF EXISTS `usertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usertype` (
  `UTNO` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`UTNO`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertype`
--

LOCK TABLES `usertype` WRITE;
/*!40000 ALTER TABLE `usertype` DISABLE KEYS */;
INSERT INTO `usertype` VALUES (1,'Supervisor'),(2,'Section Officer'),(3,'UG Cable'),(4,'Admin');
/*!40000 ALTER TABLE `usertype` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-04  1:26:07
