CREATE DATABASE  IF NOT EXISTS `ksw` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `ksw`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: ksw
-- ------------------------------------------------------
-- Server version	5.5.21

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
-- Table structure for table `eve_status`
--

DROP TABLE IF EXISTS `eve_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eve_status` (
  `statusID` tinyint(4) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`statusID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eve_status`
--

LOCK TABLES `eve_status` WRITE;
/*!40000 ALTER TABLE `eve_status` DISABLE KEYS */;
INSERT INTO `eve_status` VALUES (0,'筹备'),(1,'生产'),(2,'完成');
/*!40000 ALTER TABLE `eve_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eve_eventcolumns`
--

DROP TABLE IF EXISTS `eve_eventcolumns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eve_eventcolumns` (
  `eventid` int(11) NOT NULL,
  `projectid` int(11) NOT NULL,
  PRIMARY KEY (`eventid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eve_eventcolumns`
--

LOCK TABLES `eve_eventcolumns` WRITE;
/*!40000 ALTER TABLE `eve_eventcolumns` DISABLE KEYS */;
/*!40000 ALTER TABLE `eve_eventcolumns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eve_job`
--

DROP TABLE IF EXISTS `eve_job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eve_job` (
  `jobid` int(11) NOT NULL,
  `job` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`jobid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eve_job`
--

LOCK TABLES `eve_job` WRITE;
/*!40000 ALTER TABLE `eve_job` DISABLE KEYS */;
INSERT INTO `eve_job` VALUES (0,'制造'),(1,'发明'),(2,'拷贝'),(3,'采购'),(4,'运输');
/*!40000 ALTER TABLE `eve_job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eve_event`
--

DROP TABLE IF EXISTS `eve_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eve_event` (
  `eventid` int(11) NOT NULL,
  `jobid` varchar(45) DEFAULT NULL COMMENT '类型ID (制造,发明,等)',
  `amount` int(11) DEFAULT NULL,
  `done` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`eventid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eve_event`
--

LOCK TABLES `eve_event` WRITE;
/*!40000 ALTER TABLE `eve_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `eve_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eve_project`
--

DROP TABLE IF EXISTS `eve_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eve_project` (
  `projectID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `Comment` varchar(45) DEFAULT NULL,
  `creat_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`projectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eve_project`
--

LOCK TABLES `eve_project` WRITE;
/*!40000 ALTER TABLE `eve_project` DISABLE KEYS */;
/*!40000 ALTER TABLE `eve_project` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-10-15 15:26:05
