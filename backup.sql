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
) ENGINE=InnoDB AUTO_INCREMENT=361 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invitation_tokens`
--

LOCK TABLES `invitation_tokens` WRITE;
/*!40000 ALTER TABLE `invitation_tokens` DISABLE KEYS */;
INSERT INTO `invitation_tokens` VALUES (313,'2023-2024-b54nLzFFG33gDP1','marcoangelo.quanico@gmail.com'),(319,'2024-2025-RIQArJwXAmuvWrh','pass.num.2015@gmail.com');
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
-- Table structure for table `laura_private_message`
--

DROP TABLE IF EXISTS `laura_private_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laura_private_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `to` varchar(150) NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  CONSTRAINT `laura_private_message_ibfk_1` FOREIGN KEY (`to`) REFERENCES `teachers` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laura_private_message`
--

LOCK TABLES `laura_private_message` WRITE;
/*!40000 ALTER TABLE `laura_private_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `laura_private_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preprocessed_room_schedule`
--

DROP TABLE IF EXISTS `preprocessed_room_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preprocessed_room_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_week` varchar(10) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `token` varchar(150) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `token` (`token`),
  KEY `subject_id` (`subject_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `preprocessed_room_schedule_ibfk_1` FOREIGN KEY (`token`) REFERENCES `invitation_tokens` (`token`),
  CONSTRAINT `preprocessed_room_schedule_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  CONSTRAINT `preprocessed_room_schedule_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preprocessed_room_schedule`
--

LOCK TABLES `preprocessed_room_schedule` WRITE;
/*!40000 ALTER TABLE `preprocessed_room_schedule` DISABLE KEYS */;
/*!40000 ALTER TABLE `preprocessed_room_schedule` ENABLE KEYS */;
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
  `start_time` date DEFAULT NULL,
  `end_time` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_status`
--

LOCK TABLES `program_status` WRITE;
/*!40000 ALTER TABLE `program_status` DISABLE KEYS */;
INSERT INTO `program_status` VALUES (1,0,'2023-11-20','2023-12-23');
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
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room` (
  `code` varchar(10) NOT NULL,
  `floor_level` int(11) NOT NULL,
  `has_projector` tinyint(1) DEFAULT 0,
  `seat_count` int(11) DEFAULT 0,
  `type` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `idx_room_id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` VALUES ('B102',1,0,0,'laboratory',1),('B202',2,0,0,'laboratory',2),('B203',2,0,0,'laboratory',3),('B204',2,0,0,'discussion',4),('B205',2,0,0,'discussion',5),('B206',2,0,0,'discussion',6),('B207',2,0,0,'discussion',7),('B208',2,0,0,'discussion',8),('B302',3,0,0,'discussion',9),('B303',3,0,0,'discussion',10),('B304',3,0,0,'discussion',11),('B305',3,0,0,'discussion',12),('B307',3,0,0,'discussion',13),('B308',3,0,0,'discussion',14),('B103',1,0,0,'laboratory',15);
/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `code` varchar(25) NOT NULL,
  `units` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_subject_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7294 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher_preferred_schedule`
--

LOCK TABLES `teacher_preferred_schedule` WRITE;
/*!40000 ALTER TABLE `teacher_preferred_schedule` DISABLE KEYS */;
INSERT INTO `teacher_preferred_schedule` VALUES (6952,'Saturday','07:30:00','07:59:00','2023-2024-b54nLzFFG33gDP1',1),(6953,'Saturday','08:00:00','08:29:00','2023-2024-b54nLzFFG33gDP1',1),(6954,'Saturday','08:30:00','08:59:00','2023-2024-b54nLzFFG33gDP1',1),(6955,'Saturday','09:00:00','09:29:00','2023-2024-b54nLzFFG33gDP1',1),(6956,'Saturday','09:30:00','09:59:00','2023-2024-b54nLzFFG33gDP1',1),(6957,'Saturday','10:00:00','10:29:00','2023-2024-b54nLzFFG33gDP1',1),(6958,'Saturday','10:30:00','10:59:00','2023-2024-b54nLzFFG33gDP1',1),(6959,'Saturday','11:00:00','11:29:00','2023-2024-b54nLzFFG33gDP1',1),(6960,'Saturday','11:30:00','11:59:00','2023-2024-b54nLzFFG33gDP1',1),(6961,'Saturday','12:00:00','12:29:00','2023-2024-b54nLzFFG33gDP1',1),(6962,'Saturday','12:30:00','12:59:00','2023-2024-b54nLzFFG33gDP1',1),(6963,'Saturday','13:00:00','13:29:00','2023-2024-b54nLzFFG33gDP1',1),(6964,'Saturday','13:30:00','13:59:00','2023-2024-b54nLzFFG33gDP1',1),(6965,'Saturday','14:00:00','14:29:00','2023-2024-b54nLzFFG33gDP1',1),(6966,'Saturday','14:30:00','14:59:00','2023-2024-b54nLzFFG33gDP1',1),(6967,'Saturday','15:00:00','15:29:00','2023-2024-b54nLzFFG33gDP1',1),(6968,'Saturday','15:30:00','15:59:00','2023-2024-b54nLzFFG33gDP1',1),(6969,'Saturday','16:00:00','16:29:00','2023-2024-b54nLzFFG33gDP1',1),(6970,'Saturday','16:30:00','16:59:00','2023-2024-b54nLzFFG33gDP1',1),(6971,'Saturday','17:00:00','17:29:00','2023-2024-b54nLzFFG33gDP1',1),(6972,'Saturday','17:30:00','17:59:00','2023-2024-b54nLzFFG33gDP1',1),(6973,'Saturday','18:00:00','18:29:00','2023-2024-b54nLzFFG33gDP1',1),(6974,'Saturday','18:30:00','18:59:00','2023-2024-b54nLzFFG33gDP1',1),(6975,'Saturday','19:00:00','19:29:00','2023-2024-b54nLzFFG33gDP1',1),(6976,'Saturday','19:30:00','19:59:00','2023-2024-b54nLzFFG33gDP1',1),(6977,'Saturday','20:00:00','20:29:00','2023-2024-b54nLzFFG33gDP1',1),(6978,'Saturday','20:30:00','20:59:00','2023-2024-b54nLzFFG33gDP1',1),(7191,'Thursday','07:30:00','07:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7192,'Friday','07:30:00','07:59:00','2024-2025-RIQArJwXAmuvWrh',1),(7193,'Saturday','07:30:00','07:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7194,'Wednesday','08:00:00','08:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7195,'Thursday','08:00:00','08:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7196,'Friday','08:00:00','08:29:00','2024-2025-RIQArJwXAmuvWrh',1),(7197,'Saturday','08:00:00','08:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7198,'Wednesday','08:30:00','08:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7199,'Thursday','08:30:00','08:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7200,'Friday','08:30:00','08:59:00','2024-2025-RIQArJwXAmuvWrh',1),(7201,'Saturday','08:30:00','08:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7202,'Wednesday','09:00:00','09:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7203,'Thursday','09:00:00','09:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7204,'Friday','09:00:00','09:29:00','2024-2025-RIQArJwXAmuvWrh',1),(7205,'Saturday','09:00:00','09:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7206,'Wednesday','09:30:00','09:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7207,'Thursday','09:30:00','09:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7208,'Friday','09:30:00','09:59:00','2024-2025-RIQArJwXAmuvWrh',1),(7209,'Saturday','09:30:00','09:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7210,'Wednesday','10:00:00','10:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7211,'Thursday','10:00:00','10:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7212,'Friday','10:00:00','10:29:00','2024-2025-RIQArJwXAmuvWrh',1),(7213,'Saturday','10:00:00','10:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7214,'Wednesday','10:30:00','10:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7215,'Thursday','10:30:00','10:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7216,'Friday','10:30:00','10:59:00','2024-2025-RIQArJwXAmuvWrh',1),(7217,'Saturday','10:30:00','10:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7218,'Wednesday','11:00:00','11:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7219,'Thursday','11:00:00','11:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7220,'Friday','11:00:00','11:29:00','2024-2025-RIQArJwXAmuvWrh',1),(7221,'Saturday','11:00:00','11:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7222,'Wednesday','11:30:00','11:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7223,'Thursday','11:30:00','11:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7224,'Friday','11:30:00','11:59:00','2024-2025-RIQArJwXAmuvWrh',1),(7225,'Saturday','11:30:00','11:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7226,'Wednesday','12:00:00','12:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7227,'Thursday','12:00:00','12:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7228,'Friday','12:00:00','12:29:00','2024-2025-RIQArJwXAmuvWrh',1),(7229,'Saturday','12:00:00','12:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7230,'Wednesday','12:30:00','12:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7231,'Thursday','12:30:00','12:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7232,'Friday','12:30:00','12:59:00','2024-2025-RIQArJwXAmuvWrh',1),(7233,'Saturday','12:30:00','12:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7234,'Wednesday','13:00:00','13:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7235,'Thursday','13:00:00','13:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7236,'Friday','13:00:00','13:29:00','2024-2025-RIQArJwXAmuvWrh',1),(7237,'Saturday','13:00:00','13:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7238,'Wednesday','13:30:00','13:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7239,'Thursday','13:30:00','13:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7240,'Friday','13:30:00','13:59:00','2024-2025-RIQArJwXAmuvWrh',1),(7241,'Saturday','13:30:00','13:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7242,'Wednesday','14:00:00','14:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7243,'Thursday','14:00:00','14:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7244,'Friday','14:00:00','14:29:00','2024-2025-RIQArJwXAmuvWrh',1),(7245,'Saturday','14:00:00','14:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7246,'Wednesday','14:30:00','14:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7247,'Thursday','14:30:00','14:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7248,'Friday','14:30:00','14:59:00','2024-2025-RIQArJwXAmuvWrh',1),(7249,'Saturday','14:30:00','14:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7250,'Wednesday','15:00:00','15:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7251,'Thursday','15:00:00','15:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7252,'Friday','15:00:00','15:29:00','2024-2025-RIQArJwXAmuvWrh',1),(7253,'Saturday','15:00:00','15:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7254,'Wednesday','15:30:00','15:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7255,'Thursday','15:30:00','15:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7256,'Friday','15:30:00','15:59:00','2024-2025-RIQArJwXAmuvWrh',1),(7257,'Saturday','15:30:00','15:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7258,'Wednesday','16:00:00','16:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7259,'Thursday','16:00:00','16:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7260,'Friday','16:00:00','16:29:00','2024-2025-RIQArJwXAmuvWrh',1),(7261,'Saturday','16:00:00','16:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7262,'Wednesday','16:30:00','16:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7263,'Thursday','16:30:00','16:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7264,'Friday','16:30:00','16:59:00','2024-2025-RIQArJwXAmuvWrh',1),(7265,'Saturday','16:30:00','16:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7266,'Wednesday','17:00:00','17:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7267,'Thursday','17:00:00','17:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7268,'Friday','17:00:00','17:29:00','2024-2025-RIQArJwXAmuvWrh',1),(7269,'Saturday','17:00:00','17:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7270,'Wednesday','17:30:00','17:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7271,'Thursday','17:30:00','17:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7272,'Friday','17:30:00','17:59:00','2024-2025-RIQArJwXAmuvWrh',1),(7273,'Saturday','17:30:00','17:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7274,'Wednesday','18:00:00','18:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7275,'Thursday','18:00:00','18:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7276,'Friday','18:00:00','18:29:00','2024-2025-RIQArJwXAmuvWrh',1),(7277,'Saturday','18:00:00','18:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7278,'Wednesday','18:30:00','18:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7279,'Thursday','18:30:00','18:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7280,'Friday','18:30:00','18:59:00','2024-2025-RIQArJwXAmuvWrh',1),(7281,'Saturday','18:30:00','18:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7282,'Wednesday','19:00:00','19:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7283,'Thursday','19:00:00','19:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7284,'Friday','19:00:00','19:29:00','2024-2025-RIQArJwXAmuvWrh',1),(7285,'Saturday','19:00:00','19:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7286,'Wednesday','19:30:00','19:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7287,'Thursday','19:30:00','19:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7288,'Friday','19:30:00','19:59:00','2024-2025-RIQArJwXAmuvWrh',1),(7289,'Saturday','19:30:00','19:59:00','2024-2025-RIQArJwXAmuvWrh',0),(7290,'Wednesday','20:00:00','20:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7291,'Thursday','20:00:00','20:29:00','2024-2025-RIQArJwXAmuvWrh',0),(7292,'Friday','20:00:00','20:29:00','2024-2025-RIQArJwXAmuvWrh',1),(7293,'Saturday','20:00:00','20:29:00','2024-2025-RIQArJwXAmuvWrh',0);
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

-- Dump completed on 2024-01-14  3:56:25
