-- MariaDB dump 10.19  Distrib 10.4.25-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ppcvo3
-- ------------------------------------------------------
-- Server version	10.4.25-MariaDB

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
-- Table structure for table `animals`
--

DROP TABLE IF EXISTS `animals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `animals` (
  `animalID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `classificationID` int(11) NOT NULL,
  `color` varchar(20) NOT NULL,
  `sex` varchar(6) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `noHeads` int(11) DEFAULT NULL,
  `regDate` date DEFAULT NULL,
  `regNumber` varchar(50) DEFAULT NULL,
  `clientID` int(11) NOT NULL,
  `insertDate` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`animalID`),
  KEY `fk_clients_anims_CLIENTS_idx` (`clientID`),
  KEY `fk_Animals_classification1_idx` (`classificationID`),
  CONSTRAINT `fk_Animals_classification1` FOREIGN KEY (`classificationID`) REFERENCES `classifications` (`classificationID`),
  CONSTRAINT `fk_clients_anims_CLIENTS` FOREIGN KEY (`clientID`) REFERENCES `clients` (`clientID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animals`
--

LOCK TABLES `animals` WRITE;
/*!40000 ALTER TABLE `animals` DISABLE KEYS */;
INSERT INTO `animals` VALUES (6,'Coco',6,'White','Female','2021-06-15',1,'2022-11-27','0934231',12,'2021-12-07'),(7,'Ashe',7,'Black and White','Female','2021-04-27',1,'2022-11-27','13413ease1',12,'2022-12-07'),(8,'Marie',8,'White','Female','2021-06-15',1,'2022-11-27','14121413412',12,'2022-12-07'),(9,'Ferra',9,'Tricolor','Male','2021-06-15',1,'2022-11-27','432jaeaw',12,'2022-12-07'),(10,'Morgan',10,'Brown','Male','2015-10-27',1,'2022-11-27','234112233',12,'2022-12-07'),(11,'Cotton',11,'White','Male','2022-02-21',1,'2022-11-27','12341221',13,'2022-12-07'),(12,'Sugar',12,'Orange','Male','2014-08-29',1,'2020-06-16','123314',13,'2022-12-07'),(13,'Oreo',13,'Black','Female','2021-02-11',1,'2022-11-09','123123ad',15,'2022-12-07'),(14,'Peanut',14,'brown','Female','2022-11-01',1,'2022-11-26','',16,'2022-12-07'),(15,'charlie',15,'balck, brown, white','Male','2019-01-28',1,'0000-00-00','',17,'2022-12-07'),(16,'shirra',16,'white','Female','2022-12-10',1,'2022-11-29','693827532',17,'2022-12-07'),(17,'Marie',17,'White','Male','2015-06-06',1,'2022-12-06','2314512',18,'2022-12-07');
/*!40000 ALTER TABLE `animals` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `Delete Animal Data: Field Visitations` BEFORE DELETE ON `animals` FOR EACH ROW BEGIN
/*Delete Field Visitations record associated with Animal record*/
DELETE from field_visititations
WHERE field_visititations.animalID = OLD.animalID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `Delete Animal Data: Walk-In Transactions` BEFORE DELETE ON `animals` FOR EACH ROW BEGIN
/*Delete Walk-In Transactions record associated with Animal record*/
DELETE from walk_in_transactions
WHERE walk_in_transactions.animalID = OLD.animalID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `Delete Animal Data: Classification` AFTER DELETE ON `animals` FOR EACH ROW BEGIN
/*Delete classification record associated with Animal record*/
DELETE from classifications
WHERE classifications.classificationID = OLD.classificationID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `barangays`
--

DROP TABLE IF EXISTS `barangays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barangays` (
  `barangayID` int(11) NOT NULL AUTO_INCREMENT,
  `brgy_name` varchar(100) NOT NULL,
  PRIMARY KEY (`barangayID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barangays`
--

LOCK TABLES `barangays` WRITE;
/*!40000 ALTER TABLE `barangays` DISABLE KEYS */;
INSERT INTO `barangays` VALUES (17,'Tagburos'),(18,'San Miguel'),(19,'Matiyaga'),(20,'Maunlad'),(21,'San Manuel');
/*!40000 ALTER TABLE `barangays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classifications`
--

DROP TABLE IF EXISTS `classifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classifications` (
  `classificationID` int(11) NOT NULL AUTO_INCREMENT,
  `breed` varchar(45) DEFAULT NULL,
  `species` varchar(45) NOT NULL,
  PRIMARY KEY (`classificationID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classifications`
--

LOCK TABLES `classifications` WRITE;
/*!40000 ALTER TABLE `classifications` DISABLE KEYS */;
INSERT INTO `classifications` VALUES (6,'Persian','Feline'),(7,'Khao Manee','Feline'),(8,'Khao Manee','Feline'),(9,'Khao Manee','Feline'),(10,'Mix','Canine'),(11,'Something','Feline'),(12,'Orange Tabby','Feline'),(13,'Shih Tzu','Canine'),(14,'Domestic cat','Feline'),(15,'husky','Canine'),(16,'husky','Canine'),(17,'Khao Manee','Felis');
/*!40000 ALTER TABLE `classifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `clientID` int(11) NOT NULL AUTO_INCREMENT,
  `fName` varchar(50) NOT NULL,
  `mName` varchar(45) DEFAULT NULL,
  `lName` varchar(45) NOT NULL,
  `birthdate` date NOT NULL,
  `sex` varchar(6) NOT NULL,
  `addressID` int(11) NOT NULL,
  `cNumber` varchar(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `insertDate` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`clientID`),
  KEY `fk_client_Clients_Addresses1_idx` (`addressID`),
  CONSTRAINT `fk_client_Clients_Addresses1` FOREIGN KEY (`addressID`) REFERENCES `clients_addresses` (`addressID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (12,'Dan','Mauie','Dueñas','2000-04-28','Male',12,'+6392130735','duenasmauie@gmail.com','2022-12-07'),(13,'Catherine','Limco','Suaib','2000-06-11','Male',13,'+6392130735','suaibcatherine@gmail.com','2022-12-07'),(14,'Andrew','Echo','Beta','2001-06-05','Male',14,'+6392130735','creepy@email.com','2022-12-07'),(15,'Rochelle','Something','Dueñas','2000-06-25','Male',15,'','rochelle@gmail.com','2022-12-07'),(16,'Jayrah','Mabulay','Bautista','2000-09-22','Female',16,'09457904003','bautistajayrah@gmail.com','2022-12-07'),(17,'Elmer','Oghayon','Rubio','1999-10-15','Male',17,'09158444092','elmerrubiojr25@gmail.com','2022-12-07'),(18,'John','Mark','Martinez','2000-06-21','Male',18,'','john@email.com','2022-12-07');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `Delete Client Data: Animals` BEFORE DELETE ON `clients` FOR EACH ROW BEGIN
DELETE FROM animals
WHERE animals.clientID = OLD.clientID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `Delete Client Data: Address` AFTER DELETE ON `clients` FOR EACH ROW BEGIN
/*Delete client address associated with the client*/
DELETE FROM clients_addresses
WHERE clients_addresses.addressID = OLD.addressID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `clients_addresses`
--

DROP TABLE IF EXISTS `clients_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients_addresses` (
  `addressID` int(11) NOT NULL AUTO_INCREMENT,
  `Specific_add` varchar(100) DEFAULT NULL,
  `barangayID` int(11) NOT NULL,
  PRIMARY KEY (`addressID`),
  KEY `fk_Clients_Addresses_barangays1_idx` (`barangayID`),
  CONSTRAINT `fk_Clients_Addresses_barangays1` FOREIGN KEY (`barangayID`) REFERENCES `barangays` (`barangayID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients_addresses`
--

LOCK TABLES `clients_addresses` WRITE;
/*!40000 ALTER TABLE `clients_addresses` DISABLE KEYS */;
INSERT INTO `clients_addresses` VALUES (12,'Block 27, Lot 12, Pathmosville Subdivision',17),(13,'',18),(14,'',18),(15,'',19),(16,'Abueg street',20),(17,'Villa Grande',17),(18,'',21);
/*!40000 ALTER TABLE `clients_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultation_types`
--

DROP TABLE IF EXISTS `consultation_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consultation_types` (
  `ctID` int(11) NOT NULL AUTO_INCREMENT,
  `Type_Description` varchar(45) NOT NULL,
  PRIMARY KEY (`ctID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultation_types`
--

LOCK TABLES `consultation_types` WRITE;
/*!40000 ALTER TABLE `consultation_types` DISABLE KEYS */;
INSERT INTO `consultation_types` VALUES (1,'Animal Health'),(2,'Vaccination'),(3,'Routine Service');
/*!40000 ALTER TABLE `consultation_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `field_visititations`
--

DROP TABLE IF EXISTS `field_visititations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `field_visititations` (
  `consultationID` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `clinicalSign` tinytext DEFAULT NULL,
  `disease` tinytext DEFAULT NULL,
  `activity` tinytext DEFAULT NULL,
  `medication` tinytext DEFAULT NULL,
  `remarks` tinytext NOT NULL,
  `animalID` int(11) NOT NULL,
  `vaccineID` int(11) DEFAULT NULL,
  `ctID` int(11) NOT NULL,
  `personnelID` int(11) NOT NULL,
  `barangayID` int(11) NOT NULL,
  PRIMARY KEY (`consultationID`),
  KEY `fk_history_Registered_animals1_idx` (`animalID`),
  KEY `fk_Animals_Visitations_vaccine1_idx` (`vaccineID`),
  KEY `fk_Animals_Visitations_Consultation_Types1_idx` (`ctID`),
  KEY `fk_Animals_Visitations_Personnel1_idx` (`personnelID`),
  KEY `fk_Field_Visititations_barangays1_idx` (`barangayID`),
  CONSTRAINT `fk_Animals_Visitations_Consultation_Types10` FOREIGN KEY (`ctID`) REFERENCES `consultation_types` (`ctID`),
  CONSTRAINT `fk_Animals_Visitations_Personnel10` FOREIGN KEY (`personnelID`) REFERENCES `personnel` (`personnelID`),
  CONSTRAINT `fk_Animals_Visitations_vaccine10` FOREIGN KEY (`vaccineID`) REFERENCES `vaccines` (`vaccineID`),
  CONSTRAINT `fk_Field_Visititations_barangays1` FOREIGN KEY (`barangayID`) REFERENCES `barangays` (`barangayID`),
  CONSTRAINT `fk_history_Registered_animals10` FOREIGN KEY (`animalID`) REFERENCES `animals` (`animalID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field_visititations`
--

LOCK TABLES `field_visititations` WRITE;
/*!40000 ALTER TABLE `field_visititations` DISABLE KEYS */;
/*!40000 ALTER TABLE `field_visititations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passwordreset`
--

DROP TABLE IF EXISTS `passwordreset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passwordreset` (
  `pwdresetID` int(11) NOT NULL AUTO_INCREMENT,
  `pwdresetEmail` varchar(50) NOT NULL,
  `selector` text NOT NULL,
  `token` longtext NOT NULL,
  `expiration` varchar(15) NOT NULL,
  PRIMARY KEY (`pwdresetID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passwordreset`
--

LOCK TABLES `passwordreset` WRITE;
/*!40000 ALTER TABLE `passwordreset` DISABLE KEYS */;
/*!40000 ALTER TABLE `passwordreset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personnel`
--

DROP TABLE IF EXISTS `personnel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personnel` (
  `personnelID` int(11) NOT NULL AUTO_INCREMENT,
  `fName` varchar(45) NOT NULL,
  `mName` varchar(45) NOT NULL,
  `lName` varchar(45) NOT NULL,
  `licenseNo` varchar(45) DEFAULT NULL,
  `designation` varchar(45) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`personnelID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personnel`
--

LOCK TABLES `personnel` WRITE;
/*!40000 ALTER TABLE `personnel` DISABLE KEYS */;
INSERT INTO `personnel` VALUES (3,'Jan','V.','Escalona','1231234','Veterinarian','active');
/*!40000 ALTER TABLE `personnel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(9) NOT NULL,
  `fName` varchar(45) NOT NULL,
  `mName` varchar(45) DEFAULT NULL,
  `lName` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` longtext NOT NULL,
  `cNumber` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','Dan Mauie','','Duenas','duenasmauie@gmail.com','$2y$10$r7fue7ZVvuFC9QIRp0qnBOykge041nmtkvn3i8.vUufW1/sTicR3e',''),(2,'personnel','Dan Mauie','Tagala','Duenas','duenasmauie@gmail.com','$2y$10$r7fue7ZVvuFC9QIRp0qnBOykge041nmtkvn3i8.vUufW1/sTicR3e','12344');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaccines`
--

DROP TABLE IF EXISTS `vaccines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vaccines` (
  `vaccineID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `batchNumber` bigint(20) NOT NULL,
  `source` varchar(45) NOT NULL,
  PRIMARY KEY (`vaccineID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaccines`
--

LOCK TABLES `vaccines` WRITE;
/*!40000 ALTER TABLE `vaccines` DISABLE KEYS */;
INSERT INTO `vaccines` VALUES (5,'Aasd3',2341,'Apsdfeq'),(6,'A4',12341,'Somewhere42'),(7,'Something',231231,'2131');
/*!40000 ALTER TABLE `vaccines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `walk_in_transactions`
--

DROP TABLE IF EXISTS `walk_in_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `walk_in_transactions` (
  `consultationID` int(11) NOT NULL AUTO_INCREMENT,
  `ctID` int(11) NOT NULL,
  `date` date NOT NULL,
  `clinicalSign` tinytext DEFAULT NULL,
  `tentativeDiagnosis` tinytext DEFAULT NULL,
  `prescription` tinytext DEFAULT NULL,
  `treatment` tinytext NOT NULL,
  `disease` tinytext DEFAULT NULL,
  `vaccineID` int(11) DEFAULT NULL,
  `remarks` tinytext NOT NULL,
  `personnelID` int(11) NOT NULL,
  `animalID` int(11) NOT NULL,
  PRIMARY KEY (`consultationID`),
  KEY `fk_history_Registered_animals1_idx` (`animalID`),
  KEY `fk_Animals_Visitations_vaccine1_idx` (`vaccineID`),
  KEY `fk_Animals_Visitations_Consultation_Types1_idx` (`ctID`),
  KEY `fk_Animals_Visitations_Personnel1_idx` (`personnelID`),
  CONSTRAINT `fk_Animals_Visitations_Consultation_Types1` FOREIGN KEY (`ctID`) REFERENCES `consultation_types` (`ctID`),
  CONSTRAINT `fk_Animals_Visitations_Personnel1` FOREIGN KEY (`personnelID`) REFERENCES `personnel` (`personnelID`),
  CONSTRAINT `fk_Animals_Visitations_vaccine1` FOREIGN KEY (`vaccineID`) REFERENCES `vaccines` (`vaccineID`),
  CONSTRAINT `fk_history_Registered_animals1` FOREIGN KEY (`animalID`) REFERENCES `animals` (`animalID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `walk_in_transactions`
--

LOCK TABLES `walk_in_transactions` WRITE;
/*!40000 ALTER TABLE `walk_in_transactions` DISABLE KEYS */;
INSERT INTO `walk_in_transactions` VALUES (8,2,'2022-11-27',NULL,NULL,NULL,'','Rabies',5,'Vaccinated',3,11),(9,2,'2022-11-29',NULL,NULL,NULL,'','rabies',6,'Vaccinated',3,6),(10,2,'2022-12-06',NULL,NULL,NULL,'','Rabies',7,'vaccinated',3,17);
/*!40000 ALTER TABLE `walk_in_transactions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-10 16:15:38
