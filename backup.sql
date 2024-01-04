-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: room
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.27-MariaDB

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
-- Table structure for table `invitation_tokens`
--

DROP TABLE IF EXISTS `invitation_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invitation_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(150) NOT NULL,
  `associated_email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `associated_email` (`associated_email`),
  KEY `idx_token` (`token`),
  CONSTRAINT `invitation_tokens_ibfk_1` FOREIGN KEY (`associated_email`) REFERENCES `teachers` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=339 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invitation_tokens`
--

LOCK TABLES `invitation_tokens` WRITE;
/*!40000 ALTER TABLE `invitation_tokens` DISABLE KEYS */;
INSERT INTO `invitation_tokens` VALUES (313,'2023-2024-b54nLzFFG33gDP1','marcoangelo.quanico@gmail.com'),(319,'2024-2025-RIQArJwXAmuvWrh','pass.num.2015@gmail.com'),(320,'2024-2025-OIKABmEpsCN9Vci',NULL),(321,'2024-2025-lECiGWyWlZVocF6',NULL),(322,'2024-2025-OQqiVZCkBqdrYg4',NULL),(323,'2024-2025-riceXpc0eW8UB71',NULL),(324,'2024-2025-IzFIy41huysRFYl',NULL),(325,'2024-2025-EzD8p9ffjWFJOOA',NULL),(326,'2024-2025-SOZPrBs5CqtVt5l',NULL),(327,'2024-2025-dqWqcSF1xdEhcAC',NULL),(328,'2024-2025-7vSTTIBVDYiI6CG',NULL),(329,'2024-2025-U194o0G2v9EmGtq',NULL),(330,'2024-2025-wFpKi3Ld2pbd8xa',NULL),(331,'2024-spVPAD1cKFvwbPL',NULL),(332,'2024-WSregorT1OZQKNL',NULL),(333,'2024-OEpfAiD1shhNq3c',NULL),(334,'2024-qsIU5emJdR8IvEM',NULL),(335,'2024-pthCj2C3oEIQ1ey',NULL),(336,'2024-B5JoaOwAXDcdaGa',NULL),(337,'2024-YK6Ul2Lvcz0t2T3',NULL),(338,'2024-P4lqhBeZDxYQjJO',NULL);
/*!40000 ALTER TABLE `invitation_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laura_archived_messages`
--

DROP TABLE IF EXISTS `laura_archived_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laura_archived_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_message_id` int(11) DEFAULT NULL,
  `archived_message` text DEFAULT NULL,
  `deletion_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `archived_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laura_archived_messages`
--

LOCK TABLES `laura_archived_messages` WRITE;
/*!40000 ALTER TABLE `laura_archived_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `laura_archived_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laura_messages`
--

DROP TABLE IF EXISTS `laura_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laura_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `message_type` varchar(30) NOT NULL,
  `deletion_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laura_messages`
--

LOCK TABLES `laura_messages` WRITE;
/*!40000 ALTER TABLE `laura_messages` DISABLE KEYS */;
INSERT INTO `laura_messages` VALUES (1,'Set your schedules before the start of semester or given deadline, thank you.','pre-semester','2023-12-20 17:22:04');
/*!40000 ALTER TABLE `laura_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program_status`
--

DROP TABLE IF EXISTS `program_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `program_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_ongoing` tinyint(1) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_status`
--

LOCK TABLES `program_status` WRITE;
/*!40000 ALTER TABLE `program_status` DISABLE KEYS */;
INSERT INTO `program_status` VALUES (1,0,'2023-12-20 17:51:15','2023-12-20 18:12:29');
/*!40000 ALTER TABLE `program_status` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = cp850 */ ;
/*!50003 SET character_set_results = cp850 */ ;
/*!50003 SET collation_connection  = cp850_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER prevent_insert_trigger
BEFORE INSERT ON program_status
FOR EACH ROW
BEGIN
    
    IF 1 = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Inserts into this table are not allowed';
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `room_schedules`
--

DROP TABLE IF EXISTS `room_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `reserver` varchar(150) NOT NULL,
  `is_fixed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reserver` (`reserver`),
  CONSTRAINT `fk_reserver` FOREIGN KEY (`reserver`) REFERENCES `teachers` (`full_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_schedules`
--

LOCK TABLES `room_schedules` WRITE;
/*!40000 ALTER TABLE `room_schedules` DISABLE KEYS */;
/*!40000 ALTER TABLE `room_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `code` varchar(10) NOT NULL,
  `floor_level` int(11) NOT NULL,
  `has_projector` tinyint(1) DEFAULT 0,
  `seat_count` int(11) DEFAULT 0,
  `type` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES ('B102',1,0,0,'laboratory',1),('B202',2,0,0,'laboratory',2),('B203',2,0,0,'laboratory',3),('B204',2,0,0,'discussion',4),('B205',2,0,0,'discussion',5),('B206',2,0,0,'discussion',6),('B207',2,0,0,'discussion',7),('B208',2,0,0,'discussion',8),('B302',3,0,0,'discussion',9),('B303',3,0,0,'discussion',10),('B304',3,0,0,'discussion',11),('B305',3,0,0,'discussion',12),('B307',3,0,0,'discussion',13),('B308',3,0,0,'discussion',14),('B103',1,0,0,'laboratory',15);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `super_admin`
--

DROP TABLE IF EXISTS `super_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `super_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_password` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `super_admin`
--

LOCK TABLES `super_admin` WRITE;
/*!40000 ALTER TABLE `super_admin` DISABLE KEYS */;
INSERT INTO `super_admin` VALUES (1,'Laura','1234');
/*!40000 ALTER TABLE `super_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_status`
--

DROP TABLE IF EXISTS `system_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_status` (
  `is_system_on` tinyint(1) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  KEY `admin_password` (`admin_password`),
  CONSTRAINT `system_status_ibfk_1` FOREIGN KEY (`admin_password`) REFERENCES `super_admin` (`password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_status`
--

LOCK TABLES `system_status` WRITE;
/*!40000 ALTER TABLE `system_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher_preferred_schedule`
--

DROP TABLE IF EXISTS `teacher_preferred_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teacher_preferred_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day_of_week` varchar(10) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `token` varchar(150) DEFAULT NULL,
  `is_restricted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_preferred_schedule_id` (`id`),
  KEY `fk_teacher_schedule_token` (`token`),
  CONSTRAINT `fk_teacher_schedule_token` FOREIGN KEY (`token`) REFERENCES `invitation_tokens` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=6952 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher_preferred_schedule`
--

LOCK TABLES `teacher_preferred_schedule` WRITE;
/*!40000 ALTER TABLE `teacher_preferred_schedule` DISABLE KEYS */;
INSERT INTO `teacher_preferred_schedule` VALUES (6855,'Monday','07:30:00','07:59:00','2023-2024-b54nLzFFG33gDP1',0),(6856,'Tuesday','07:30:00','07:59:00','2023-2024-b54nLzFFG33gDP1',0),(6857,'Wednesday','07:30:00','07:59:00','2023-2024-b54nLzFFG33gDP1',0),(6858,'Thursday','07:30:00','07:59:00','2023-2024-b54nLzFFG33gDP1',0),(6859,'Saturday','07:30:00','07:59:00','2023-2024-b54nLzFFG33gDP1',0),(6860,'Monday','08:00:00','08:29:00','2023-2024-b54nLzFFG33gDP1',1),(6861,'Tuesday','08:00:00','08:29:00','2023-2024-b54nLzFFG33gDP1',1),(6862,'Wednesday','08:00:00','08:29:00','2023-2024-b54nLzFFG33gDP1',0),(6863,'Thursday','08:00:00','08:29:00','2023-2024-b54nLzFFG33gDP1',1),(6864,'Friday','08:00:00','08:29:00','2023-2024-b54nLzFFG33gDP1',1),(6865,'Saturday','08:00:00','08:29:00','2023-2024-b54nLzFFG33gDP1',1),(6866,'Monday','08:30:00','08:59:00','2023-2024-b54nLzFFG33gDP1',0),(6867,'Wednesday','08:30:00','08:59:00','2023-2024-b54nLzFFG33gDP1',0),(6868,'Saturday','08:30:00','08:59:00','2023-2024-b54nLzFFG33gDP1',0),(6869,'Wednesday','09:00:00','09:29:00','2023-2024-b54nLzFFG33gDP1',0),(6870,'Saturday','09:00:00','09:29:00','2023-2024-b54nLzFFG33gDP1',0),(6871,'Monday','09:30:00','09:59:00','2023-2024-b54nLzFFG33gDP1',0),(6872,'Wednesday','09:30:00','09:59:00','2023-2024-b54nLzFFG33gDP1',0),(6873,'Saturday','09:30:00','09:59:00','2023-2024-b54nLzFFG33gDP1',0),(6874,'Monday','10:00:00','10:29:00','2023-2024-b54nLzFFG33gDP1',0),(6875,'Wednesday','10:00:00','10:29:00','2023-2024-b54nLzFFG33gDP1',0),(6876,'Saturday','10:00:00','10:29:00','2023-2024-b54nLzFFG33gDP1',0),(6877,'Monday','10:30:00','10:59:00','2023-2024-b54nLzFFG33gDP1',0),(6878,'Wednesday','10:30:00','10:59:00','2023-2024-b54nLzFFG33gDP1',0),(6879,'Saturday','10:30:00','10:59:00','2023-2024-b54nLzFFG33gDP1',0),(6880,'Monday','11:00:00','11:29:00','2023-2024-b54nLzFFG33gDP1',0),(6881,'Wednesday','11:00:00','11:29:00','2023-2024-b54nLzFFG33gDP1',0),(6882,'Saturday','11:00:00','11:29:00','2023-2024-b54nLzFFG33gDP1',0),(6883,'Monday','11:30:00','11:59:00','2023-2024-b54nLzFFG33gDP1',0),(6884,'Wednesday','11:30:00','11:59:00','2023-2024-b54nLzFFG33gDP1',0),(6885,'Saturday','11:30:00','11:59:00','2023-2024-b54nLzFFG33gDP1',0),(6886,'Wednesday','12:00:00','12:29:00','2023-2024-b54nLzFFG33gDP1',0),(6887,'Wednesday','12:30:00','12:59:00','2023-2024-b54nLzFFG33gDP1',0),(6888,'Monday','13:00:00','13:29:00','2023-2024-b54nLzFFG33gDP1',0),(6889,'Wednesday','13:00:00','13:29:00','2023-2024-b54nLzFFG33gDP1',0),(6890,'Thursday','13:00:00','13:29:00','2023-2024-b54nLzFFG33gDP1',0),(6891,'Saturday','13:00:00','13:29:00','2023-2024-b54nLzFFG33gDP1',0),(6892,'Monday','13:30:00','13:59:00','2023-2024-b54nLzFFG33gDP1',0),(6893,'Wednesday','13:30:00','13:59:00','2023-2024-b54nLzFFG33gDP1',0),(6894,'Thursday','13:30:00','13:59:00','2023-2024-b54nLzFFG33gDP1',0),(6895,'Saturday','13:30:00','13:59:00','2023-2024-b54nLzFFG33gDP1',0),(6896,'Monday','14:00:00','14:29:00','2023-2024-b54nLzFFG33gDP1',0),(6897,'Wednesday','14:00:00','14:29:00','2023-2024-b54nLzFFG33gDP1',0),(6898,'Thursday','14:00:00','14:29:00','2023-2024-b54nLzFFG33gDP1',0),(6899,'Saturday','14:00:00','14:29:00','2023-2024-b54nLzFFG33gDP1',0),(6900,'Monday','14:30:00','14:59:00','2023-2024-b54nLzFFG33gDP1',0),(6901,'Wednesday','14:30:00','14:59:00','2023-2024-b54nLzFFG33gDP1',0),(6902,'Thursday','14:30:00','14:59:00','2023-2024-b54nLzFFG33gDP1',0),(6903,'Saturday','14:30:00','14:59:00','2023-2024-b54nLzFFG33gDP1',0),(6904,'Monday','15:00:00','15:29:00','2023-2024-b54nLzFFG33gDP1',0),(6905,'Wednesday','15:00:00','15:29:00','2023-2024-b54nLzFFG33gDP1',0),(6906,'Thursday','15:00:00','15:29:00','2023-2024-b54nLzFFG33gDP1',0),(6907,'Saturday','15:00:00','15:29:00','2023-2024-b54nLzFFG33gDP1',0),(6908,'Monday','15:30:00','15:59:00','2023-2024-b54nLzFFG33gDP1',0),(6909,'Wednesday','15:30:00','15:59:00','2023-2024-b54nLzFFG33gDP1',0),(6910,'Thursday','15:30:00','15:59:00','2023-2024-b54nLzFFG33gDP1',0),(6911,'Saturday','15:30:00','15:59:00','2023-2024-b54nLzFFG33gDP1',0),(6912,'Monday','16:00:00','16:29:00','2023-2024-b54nLzFFG33gDP1',0),(6913,'Wednesday','16:00:00','16:29:00','2023-2024-b54nLzFFG33gDP1',0),(6914,'Thursday','16:00:00','16:29:00','2023-2024-b54nLzFFG33gDP1',0),(6915,'Saturday','16:00:00','16:29:00','2023-2024-b54nLzFFG33gDP1',0),(6916,'Monday','16:30:00','16:59:00','2023-2024-b54nLzFFG33gDP1',0),(6917,'Wednesday','16:30:00','16:59:00','2023-2024-b54nLzFFG33gDP1',0),(6918,'Thursday','16:30:00','16:59:00','2023-2024-b54nLzFFG33gDP1',0),(6919,'Saturday','16:30:00','16:59:00','2023-2024-b54nLzFFG33gDP1',0),(6920,'Monday','17:00:00','17:29:00','2023-2024-b54nLzFFG33gDP1',0),(6921,'Wednesday','17:00:00','17:29:00','2023-2024-b54nLzFFG33gDP1',0),(6922,'Thursday','17:00:00','17:29:00','2023-2024-b54nLzFFG33gDP1',0),(6923,'Saturday','17:00:00','17:29:00','2023-2024-b54nLzFFG33gDP1',0),(6924,'Monday','17:30:00','17:59:00','2023-2024-b54nLzFFG33gDP1',0),(6925,'Wednesday','17:30:00','17:59:00','2023-2024-b54nLzFFG33gDP1',0),(6926,'Thursday','17:30:00','17:59:00','2023-2024-b54nLzFFG33gDP1',0),(6927,'Saturday','17:30:00','17:59:00','2023-2024-b54nLzFFG33gDP1',0),(6928,'Monday','18:00:00','18:29:00','2023-2024-b54nLzFFG33gDP1',0),(6929,'Wednesday','18:00:00','18:29:00','2023-2024-b54nLzFFG33gDP1',0),(6930,'Thursday','18:00:00','18:29:00','2023-2024-b54nLzFFG33gDP1',0),(6931,'Saturday','18:00:00','18:29:00','2023-2024-b54nLzFFG33gDP1',0),(6932,'Monday','18:30:00','18:59:00','2023-2024-b54nLzFFG33gDP1',0),(6933,'Wednesday','18:30:00','18:59:00','2023-2024-b54nLzFFG33gDP1',0),(6934,'Thursday','18:30:00','18:59:00','2023-2024-b54nLzFFG33gDP1',0),(6935,'Saturday','18:30:00','18:59:00','2023-2024-b54nLzFFG33gDP1',0),(6936,'Monday','19:00:00','19:29:00','2023-2024-b54nLzFFG33gDP1',0),(6937,'Wednesday','19:00:00','19:29:00','2023-2024-b54nLzFFG33gDP1',0),(6938,'Thursday','19:00:00','19:29:00','2023-2024-b54nLzFFG33gDP1',0),(6939,'Saturday','19:00:00','19:29:00','2023-2024-b54nLzFFG33gDP1',0),(6940,'Monday','19:30:00','19:59:00','2023-2024-b54nLzFFG33gDP1',0),(6941,'Wednesday','19:30:00','19:59:00','2023-2024-b54nLzFFG33gDP1',0),(6942,'Thursday','19:30:00','19:59:00','2023-2024-b54nLzFFG33gDP1',0),(6943,'Saturday','19:30:00','19:59:00','2023-2024-b54nLzFFG33gDP1',0),(6944,'Monday','20:00:00','20:29:00','2023-2024-b54nLzFFG33gDP1',0),(6945,'Wednesday','20:00:00','20:29:00','2023-2024-b54nLzFFG33gDP1',0),(6946,'Thursday','20:00:00','20:29:00','2023-2024-b54nLzFFG33gDP1',0),(6947,'Saturday','20:00:00','20:29:00','2023-2024-b54nLzFFG33gDP1',0),(6948,'Monday','20:30:00','20:59:00','2023-2024-b54nLzFFG33gDP1',0),(6949,'Wednesday','20:30:00','20:59:00','2023-2024-b54nLzFFG33gDP1',0),(6950,'Thursday','20:30:00','20:59:00','2023-2024-b54nLzFFG33gDP1',0),(6951,'Saturday','20:30:00','20:59:00','2023-2024-b54nLzFFG33gDP1',0);
/*!40000 ALTER TABLE `teacher_preferred_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `username` varchar(150) DEFAULT NULL,
  `token` varchar(150) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `is_fulltime` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_full_name` (`full_name`),
  KEY `idx_email` (`email`),
  KEY `fk_teacher_token` (`token`),
  KEY `idx_is_fulltime` (`is_fulltime`),
  CONSTRAINT `fk_teacher_token` FOREIGN KEY (`token`) REFERENCES `invitation_tokens` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (9,'Marco','Quanico','Marco Quanico','marcoangelo.quanico@gmail.com','admin','2023-2024-b54nLzFFG33gDP1','1234',0),(10,'Marco','Quanico','Marco Quanico','pass.num.2015@gmail.com','ikhu','2024-2025-RIQArJwXAmuvWrh','1234',0);
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-05  3:02:49
