-- MySQL dump 10.16  Distrib 10.1.16-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: TP3_PHP
-- ------------------------------------------------------
-- Server version	10.1.16-MariaDB

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
-- Table structure for table `avis`
--

DROP TABLE IF EXISTS `avis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avis` (
  `per_num` int(11) NOT NULL,
  `per_per_num` int(11) NOT NULL,
  `par_num` int(11) NOT NULL,
  `avi_comm` varchar(300) COLLATE utf8_bin NOT NULL,
  `avi_note` int(11) NOT NULL,
  `avi_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`per_num`,`per_per_num`,`par_num`),
  KEY `FK_PESONNE2_AVIS` (`per_per_num`),
  KEY `FK_PRCOURS_AVIS` (`par_num`),
  CONSTRAINT `FK_PERSONNE_AVIS` FOREIGN KEY (`per_num`) REFERENCES `personne` (`per_num`),
  CONSTRAINT `FK_PESONNE2_AVIS` FOREIGN KEY (`per_per_num`) REFERENCES `personne` (`per_num`),
  CONSTRAINT `FK_PRCOURS_AVIS` FOREIGN KEY (`par_num`) REFERENCES `parcours` (`par_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avis`
--

LOCK TABLES `avis` WRITE;
/*!40000 ALTER TABLE `avis` DISABLE KEYS */;
INSERT INTO `avis` VALUES (1,3,1,'Voyage agréable ',5,'2020-09-29 09:54:52'),(3,38,5,'Ce conducteur n\'est pas ponctuel ',1,'2020-10-01 09:54:52'),(38,53,10,'A recommander',5,'2020-11-05 09:54:52'),(39,1,4,'Voyage agréable',4,'2020-11-06 09:54:52'),(39,52,7,'On se demande comment il a fait pour avoir son permis. A éviter',2,'2020-11-06 09:54:52'),(52,1,11,'Je recommande',4,'2020-11-19 09:54:52'),(52,38,10,'Le conducteur ne respecte pas les limitations de vitesse, nous avons été pris en chasse par les CRS',1,'2020-11-19 09:54:52'),(53,3,4,'Quel voyage. Personne ponctuelle et agréable',5,'2020-11-20 09:54:52');
/*!40000 ALTER TABLE `avis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departement`
--

DROP TABLE IF EXISTS `departement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departement` (
  `dep_num` int(11) NOT NULL AUTO_INCREMENT,
  `dep_nom` varchar(30) NOT NULL,
  `vil_num` int(11) NOT NULL,
  PRIMARY KEY (`dep_num`),
  KEY `vil_num` (`vil_num`),
  CONSTRAINT `departement_ibfk_1` FOREIGN KEY (`vil_num`) REFERENCES `ville` (`vil_num`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departement`
--

LOCK TABLES `departement` WRITE;
/*!40000 ALTER TABLE `departement` DISABLE KEYS */;
INSERT INTO `departement` VALUES (1,'Informatique',7),(2,'GEA',6),(3,'GEA',7),(4,'SRC',7),(5,'HSE',5),(6,'Génie civil',16);
/*!40000 ALTER TABLE `departement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `division`
--

DROP TABLE IF EXISTS `division`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `division` (
  `div_num` int(11) NOT NULL AUTO_INCREMENT,
  `div_nom` varchar(30) NOT NULL,
  PRIMARY KEY (`div_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `division`
--

LOCK TABLES `division` WRITE;
/*!40000 ALTER TABLE `division` DISABLE KEYS */;
INSERT INTO `division` VALUES (1,'Année 1'),(2,'Année 2'),(3,'Année Spéciale'),(4,'Licence Professionnelle');
/*!40000 ALTER TABLE `division` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etudiant` (
  `per_num` int(11) NOT NULL,
  `dep_num` int(11) NOT NULL,
  `div_num` int(11) NOT NULL,
  PRIMARY KEY (`per_num`),
  KEY `dep_num` (`dep_num`),
  KEY `div_num` (`div_num`),
  CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`per_num`) REFERENCES `personne` (`per_num`),
  CONSTRAINT `etudiant_ibfk_2` FOREIGN KEY (`dep_num`) REFERENCES `departement` (`dep_num`),
  CONSTRAINT `etudiant_ibfk_3` FOREIGN KEY (`div_num`) REFERENCES `division` (`div_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudiant`
--

LOCK TABLES `etudiant` WRITE;
/*!40000 ALTER TABLE `etudiant` DISABLE KEYS */;
INSERT INTO `etudiant` VALUES (3,6,2),(38,6,1),(39,2,4),(53,2,1),(54,3,2);
/*!40000 ALTER TABLE `etudiant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fonction`
--

DROP TABLE IF EXISTS `fonction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fonction` (
  `fon_num` int(11) NOT NULL AUTO_INCREMENT,
  `fon_libelle` varchar(30) NOT NULL,
  PRIMARY KEY (`fon_num`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fonction`
--

LOCK TABLES `fonction` WRITE;
/*!40000 ALTER TABLE `fonction` DISABLE KEYS */;
INSERT INTO `fonction` VALUES (1,'Directeur'),(2,'Chef de département'),(3,'Technicien'),(4,'Secrétaire'),(5,'Ingénieur'),(6,'Imprimeur'),(7,'Enseignant'),(8,'Chercheur');
/*!40000 ALTER TABLE `fonction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parcours`
--

DROP TABLE IF EXISTS `parcours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parcours` (
  `par_num` int(11) NOT NULL AUTO_INCREMENT,
  `par_km` float NOT NULL,
  `vil_num1` int(11) NOT NULL,
  `vil_num2` int(11) NOT NULL,
  PRIMARY KEY (`par_num`),
  KEY `vil1` (`vil_num1`),
  KEY `vil2` (`vil_num2`),
  CONSTRAINT `parcours_ibfk_2` FOREIGN KEY (`vil_num1`) REFERENCES `ville` (`vil_num`),
  CONSTRAINT `parcours_ibfk_3` FOREIGN KEY (`vil_num2`) REFERENCES `ville` (`vil_num`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parcours`
--

LOCK TABLES `parcours` WRITE;
/*!40000 ALTER TABLE `parcours` DISABLE KEYS */;
INSERT INTO `parcours` VALUES (1,500,10,11),(2,100,7,5),(3,225,8,13),(4,300,5,13),(5,345,15,11),(7,45,15,16),(8,0,15,5),(9,0,15,5),(10,100,15,5),(11,12,10,6);
/*!40000 ALTER TABLE `parcours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personne`
--

DROP TABLE IF EXISTS `personne`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personne` (
  `per_num` int(11) NOT NULL AUTO_INCREMENT,
  `per_nom` varchar(30) NOT NULL,
  `per_prenom` varchar(30) NOT NULL,
  `per_tel` char(14) NOT NULL,
  `per_mail` varchar(30) NOT NULL,
  `per_login` varchar(20) NOT NULL,
  `per_pwd` varchar(100) NOT NULL,
  PRIMARY KEY (`per_num`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personne`
--

LOCK TABLES `personne` WRITE;
/*!40000 ALTER TABLE `personne` DISABLE KEYS */;
INSERT INTO `personne` VALUES (1,'Marley','Bob','0555555555','Bob@unilim.fr','Bob','f326d7fbaadddd53965fbd12d5a6bdaebf1932cd'),(3,'Duchemin','Paul','0555555555','paul@yahoo.fr','Paul','f326d7fbaadddd53965fbd12d5a6bdaebf1932cd'),(38,'Michu','Marcel','0555555555','Michu@sfr.fr','Marcel','f326d7fbaadddd53965fbd12d5a6bdaebf1932cd'),(39,'Renard','Pierrot','0655555555','Pierrot@gmail.fr','sql','f326d7fbaadddd53965fbd12d5a6bdaebf1932cd'),(52,'Adam','Pomme','0555775555','Pomme@apple.com','Pomme','f326d7fbaadddd53965fbd12d5a6bdaebf1932cd'),(53,'Delmas','Sophie','0789562314','Sophie@unilim.fr','Soso','f326d7fbaadddd53965fbd12d5a6bdaebf1932cd'),(54,'Dupuy','Pascale','0554565859','pascale@free.fr','Pascale','f326d7fbaadddd53965fbd12d5a6bdaebf1932cd');
/*!40000 ALTER TABLE `personne` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propose`
--

DROP TABLE IF EXISTS `propose`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `propose` (
  `par_num` int(11) NOT NULL,
  `per_num` int(11) NOT NULL,
  `pro_date` date NOT NULL,
  `pro_time` time NOT NULL,
  `pro_place` int(11) NOT NULL,
  `pro_sens` tinyint(1) NOT NULL COMMENT '0 : vil1 -> vil2 1: vil2 -> vil1',
  PRIMARY KEY (`par_num`,`per_num`,`pro_date`,`pro_time`),
  KEY `per_num` (`per_num`),
  CONSTRAINT `propose_ibfk_1` FOREIGN KEY (`par_num`) REFERENCES `parcours` (`par_num`),
  CONSTRAINT `propose_ibfk_2` FOREIGN KEY (`per_num`) REFERENCES `personne` (`per_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propose`
--

LOCK TABLES `propose` WRITE;
/*!40000 ALTER TABLE `propose` DISABLE KEYS */;
INSERT INTO `propose` VALUES (1,1,'2020-10-31','17:57:00',4,0),(1,1,'2020-10-31','17:57:14',1,0),(1,1,'2020-11-03','08:15:14',7,0),(1,1,'2020-11-04','18:29:43',3,1),(1,1,'2020-11-06','15:46:20',4,0),(1,1,'2020-12-29','13:14:34',5,1),(1,1,'2020-12-29','13:15:11',100,0),(1,39,'2020-11-04','21:07:42',0,1),(1,52,'2020-10-31','17:57:00',5,0),(1,52,'2020-10-31','17:57:14',2,0),(1,52,'2020-11-03','08:15:14',8,0),(1,52,'2020-11-04','18:29:43',4,1),(1,52,'2020-11-04','21:07:42',1,1),(1,52,'2020-11-06','15:46:20',5,0),(1,52,'2020-12-29','13:14:34',6,1),(1,52,'2020-12-29','13:15:11',101,0),(2,1,'2020-12-29','09:51:54',3,1),(2,1,'2020-12-29','12:18:29',5,1),(2,1,'2020-12-29','12:31:09',9,0),(2,1,'2020-12-29','13:11:20',66,1),(2,1,'2020-12-29','14:01:16',88,1),(2,1,'2020-12-30','13:12:18',1,1),(2,1,'2020-12-30','13:13:18',1,0),(2,52,'2020-12-29','09:51:54',4,1),(2,52,'2020-12-29','12:18:29',6,1),(2,52,'2020-12-29','12:31:09',10,0),(2,52,'2020-12-29','13:11:20',67,1),(2,52,'2020-12-29','14:01:16',89,1),(2,52,'2020-12-30','13:12:18',2,1),(2,52,'2020-12-30','13:13:18',2,0),(3,1,'2020-10-31','17:58:53',4,1),(3,1,'2020-10-31','17:59:04',5,0),(3,1,'2020-11-04','18:38:41',2,0),(3,52,'2020-10-31','17:58:53',5,1),(3,52,'2020-10-31','17:59:04',6,0),(3,52,'2020-11-04','18:38:41',3,0),(4,1,'2020-11-03','17:06:51',3,0),(4,1,'2020-12-28','14:51:20',2,0),(4,1,'2020-12-29','13:22:50',66,0),(4,52,'2020-11-03','17:06:51',4,0),(4,52,'2020-12-28','14:51:20',3,0),(4,52,'2020-12-29','13:22:50',67,0),(5,1,'2020-01-12','21:00:54',3,0),(5,1,'2020-01-13','21:48:29',3,0),(5,1,'2020-01-14','19:19:16',3,0),(5,1,'2020-11-05','15:37:00',3,0),(5,52,'2020-01-12','21:00:54',4,0),(5,52,'2020-01-13','21:48:29',4,0),(5,52,'2020-01-14','19:19:16',4,0),(5,52,'2020-11-05','15:37:00',4,0),(8,1,'2020-01-23','16:33:08',3,0),(8,52,'2020-01-23','16:33:08',4,0),(11,1,'2020-12-28','13:25:36',4,1),(11,1,'2020-12-29','09:50:26',3,1),(11,52,'2020-12-28','13:25:36',5,1),(11,52,'2020-12-29','09:50:26',4,1);
/*!40000 ALTER TABLE `propose` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salarie`
--

DROP TABLE IF EXISTS `salarie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salarie` (
  `per_num` int(11) NOT NULL,
  `sal_telprof` varchar(20) NOT NULL,
  `fon_num` int(11) NOT NULL,
  PRIMARY KEY (`per_num`),
  KEY `fon_num` (`fon_num`),
  CONSTRAINT `salarie_ibfk_1` FOREIGN KEY (`per_num`) REFERENCES `personne` (`per_num`),
  CONSTRAINT `salarie_ibfk_2` FOREIGN KEY (`fon_num`) REFERENCES `fonction` (`fon_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salarie`
--

LOCK TABLES `salarie` WRITE;
/*!40000 ALTER TABLE `salarie` DISABLE KEYS */;
INSERT INTO `salarie` VALUES (1,'0123456978',4),(52,'0666666666',8);
/*!40000 ALTER TABLE `salarie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ville`
--

DROP TABLE IF EXISTS `ville`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ville` (
  `vil_num` int(11) NOT NULL AUTO_INCREMENT,
  `vil_nom` varchar(100) NOT NULL,
  PRIMARY KEY (`vil_num`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ville`
--

LOCK TABLES `ville` WRITE;
/*!40000 ALTER TABLE `ville` DISABLE KEYS */;
INSERT INTO `ville` VALUES (5,'Tulle'),(6,'Brive'),(7,'Limoges'),(8,'Guéret'),(9,'Périgueux'),(10,'Bordeaux'),(11,'Paris'),(12,'Toulouse'),(13,'Lyon'),(14,'Poitiers'),(15,'Ambazac'),(16,'Egletons');
/*!40000 ALTER TABLE `ville` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-05  9:49:01
