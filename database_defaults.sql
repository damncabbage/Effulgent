-- MySQL dump 10.11
--
-- Host: localhost    Database: smash_prereg_2009
-- ------------------------------------------------------
-- Server version	5.0.51a-3ubuntu5.4

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
-- Table structure for table `bpay_crns`
--

DROP TABLE IF EXISTS `bpay_crns`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `bpay_crns` (
  `crn` varchar(15) NOT NULL,
  `reg_id` varchar(10) default NULL,
  PRIMARY KEY  (`crn`),
  UNIQUE KEY `reg_id` (`reg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;



LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES (1,'BPAY'),(2,'PayPal'),(3,'Money Order'),(4,'Manual');
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `registrations` (
  `reg_id` varchar(10) NOT NULL,
  `reg_time` bigint(20) NOT NULL,
  `ticket_type_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `dob` varchar(10) NOT NULL,
  `sex` varchar(10) default NULL,
  `phone` varchar(50) default NULL,
  `address` varchar(200) default NULL,
  `url_code` varchar(50) NOT NULL,
  `barcode` varchar(13) NOT NULL,
  `newsletter_signup` int(1) NOT NULL default '0',
  `sent_confirmation` int(1) NOT NULL default '0',
  `received_payment` int(1) NOT NULL default '0',
  `sent_receipt` int(1) NOT NULL default '0',
  `sent_ticket` int(1) NOT NULL default '0',
  `payment_method_id` int(11) default NULL,
  `amount_paid` float(5,2) default NULL,
  `notes` text,
  PRIMARY KEY  (`reg_id`),
  UNIQUE KEY `url_code` (`url_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `registrations`
--

LOCK TABLES `registrations` WRITE;
/*!40000 ALTER TABLE `registrations` DISABLE KEYS */;
INSERT INTO `registrations` VALUES ('SM000001',1246216558,0,'Rob Howard','robert.john.howard@gmail.com','1971/1/3','Male','123 123123','Just Another\nAddress','IgnoreThisField,OnlyUsefulForOnlineTicketSales.:-)','BARCODEGOESHERE',0,1,1,1,1,4,10.00,'An example ticketholder.');
/*!40000 ALTER TABLE `registrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_types`
--

DROP TABLE IF EXISTS `ticket_types`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ticket_types` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ticket_types`
--

LOCK TABLES `ticket_types` WRITE;
/*!40000 ALTER TABLE `ticket_types` DISABLE KEYS */;
INSERT INTO `ticket_types` VALUES (1,'Weekend',25),(2,'Saturday Only',15),(3,'Sunday Only',13);
/*!40000 ALTER TABLE `ticket_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticketbooth_registration_scan_log`
--

DROP TABLE IF EXISTS `ticketbooth_registration_scan_log`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ticketbooth_registration_scan_log` (
  `scan_id` int(11) NOT NULL auto_increment,
  `scan_time` bigint(20) NOT NULL,
  `reg_id` varchar(10) NOT NULL,
  `barcode` varchar(13) NOT NULL,
  `username` varchar(100) NOT NULL,
  `confirmed` char(1) NOT NULL default '0',
  `confirm_time` bigint(20) default NULL,
  PRIMARY KEY  (`scan_id`),
  KEY `reg_id` (`reg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `ticketbooth_scan_log`
--

DROP TABLE IF EXISTS `ticketbooth_scan_log`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ticketbooth_scan_log` (
  `scan_id` int(11) NOT NULL auto_increment,
  `scan_time` bigint(20) NOT NULL,
  `reg_id` varchar(10) NOT NULL,
  `barcode` varchar(13) NOT NULL,
  `username` varchar(100) NOT NULL,
  `confirmed` char(1) NOT NULL default '0',
  `confirm_time` bigint(20) default NULL,
  PRIMARY KEY  (`scan_id`),
  KEY `reg_id` (`reg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=832 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `ticketbooth_users`
--

DROP TABLE IF EXISTS `ticketbooth_users`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ticketbooth_users` (
  `username` varchar(50) NOT NULL,
  `is_admin` char(1) NOT NULL default '0',
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ticketbooth_users`
--

LOCK TABLES `ticketbooth_users` WRITE;
/*!40000 ALTER TABLE `ticketbooth_users` DISABLE KEYS */;
INSERT INTO `ticketbooth_users` VALUES ('booth','1');
/*!40000 ALTER TABLE `ticketbooth_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-11-20 10:29:57
