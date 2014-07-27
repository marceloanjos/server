-- MySQL dump 10.13  Distrib 5.5.38, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: PluginBotSvr
-- ------------------------------------------------------
-- Server version	5.5.38-0ubuntu0.14.04.1

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
-- Table structure for table `Device`
--

DROP TABLE IF EXISTS `Device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Device` (
  `idDevice` bigint(20) NOT NULL AUTO_INCREMENT,
  `OperatingSystemID` bigint(20) NOT NULL,
  `Bits` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `IPAddress` varchar(255) DEFAULT NULL,
  `DateInstalled` datetime DEFAULT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `DateMissing` datetime DEFAULT NULL,
  `UpdateInterval` int(11) DEFAULT NULL,
  `isMissing` tinyint(4) DEFAULT NULL,
  `Description` text,
  PRIMARY KEY (`idDevice`),
  UNIQUE KEY `idDevice_UNIQUE` (`idDevice`),
  KEY `fk_Device_1` (`OperatingSystemID`),
  CONSTRAINT `fk_Device_1` FOREIGN KEY (`OperatingSystemID`) REFERENCES `OperatingSystem` (`idOperatingSystem`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Holds information about devices';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Device`
--

LOCK TABLES `Device` WRITE;
/*!40000 ALTER TABLE `Device` DISABLE KEYS */;
/*!40000 ALTER TABLE `Device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Group`
--

DROP TABLE IF EXISTS `Group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Group` (
  `idGroup` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` text,
  PRIMARY KEY (`idGroup`),
  UNIQUE KEY `idGroup_UNIQUE` (`idGroup`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Holds information about the groups';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Group`
--

LOCK TABLES `Group` WRITE;
/*!40000 ALTER TABLE `Group` DISABLE KEYS */;
/*!40000 ALTER TABLE `Group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `GroupDevice`
--

DROP TABLE IF EXISTS `GroupDevice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GroupDevice` (
  `idGroupDevice` bigint(20) NOT NULL AUTO_INCREMENT,
  `GroupID` bigint(20) NOT NULL,
  `DeviceID` bigint(20) NOT NULL,
  PRIMARY KEY (`idGroupDevice`),
  UNIQUE KEY `idGroupDevice_UNIQUE` (`idGroupDevice`),
  KEY `fk_GroupDevice_1` (`GroupID`),
  KEY `fk_GroupDevice_2` (`DeviceID`),
  CONSTRAINT `fk_GroupDevice_1` FOREIGN KEY (`GroupID`) REFERENCES `Group` (`idGroup`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_GroupDevice_2` FOREIGN KEY (`DeviceID`) REFERENCES `Device` (`idDevice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='holds information about devices linked to the groups';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GroupDevice`
--

LOCK TABLES `GroupDevice` WRITE;
/*!40000 ALTER TABLE `GroupDevice` DISABLE KEYS */;
/*!40000 ALTER TABLE `GroupDevice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `GroupPlugin`
--

DROP TABLE IF EXISTS `GroupPlugin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GroupPlugin` (
  `idGroupPlugin` bigint(20) NOT NULL AUTO_INCREMENT,
  `GroupID` bigint(20) NOT NULL,
  `PluginID` bigint(20) NOT NULL,
  PRIMARY KEY (`idGroupPlugin`),
  UNIQUE KEY `idGroupPlugin_UNIQUE` (`idGroupPlugin`),
  KEY `fk_GroupPlugin_1` (`GroupID`),
  KEY `fk_GroupPlugin_2` (`PluginID`),
  CONSTRAINT `fk_GroupPlugin_1` FOREIGN KEY (`GroupID`) REFERENCES `Group` (`idGroup`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_GroupPlugin_2` FOREIGN KEY (`PluginID`) REFERENCES `Plugin` (`idPlugin`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Holds information abou the plugins linked to a group';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GroupPlugin`
--

LOCK TABLES `GroupPlugin` WRITE;
/*!40000 ALTER TABLE `GroupPlugin` DISABLE KEYS */;
/*!40000 ALTER TABLE `GroupPlugin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `GroupPolicy`
--

DROP TABLE IF EXISTS `GroupPolicy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GroupPolicy` (
  `idGroupPolicy` bigint(20) NOT NULL AUTO_INCREMENT,
  `GroupID` bigint(20) NOT NULL,
  `PolicyID` bigint(20) NOT NULL,
  PRIMARY KEY (`idGroupPolicy`),
  UNIQUE KEY `idGroupPolicy_UNIQUE` (`idGroupPolicy`),
  KEY `fk_GroupPolicy_1` (`GroupID`),
  KEY `fk_GroupPolicy_2` (`PolicyID`),
  CONSTRAINT `fk_GroupPolicy_1` FOREIGN KEY (`GroupID`) REFERENCES `Group` (`idGroup`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_GroupPolicy_2` FOREIGN KEY (`PolicyID`) REFERENCES `Policy` (`idPolicy`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Holds information about the group policies';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GroupPolicy`
--

LOCK TABLES `GroupPolicy` WRITE;
/*!40000 ALTER TABLE `GroupPolicy` DISABLE KEYS */;
/*!40000 ALTER TABLE `GroupPolicy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Log`
--

DROP TABLE IF EXISTS `Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Log` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `DeviceID` bigint(20) NOT NULL,
  `EventDate` datetime NOT NULL,
  `IPAddress` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  PRIMARY KEY (`idLog`),
  UNIQUE KEY `idLog_UNIQUE` (`idLog`),
  KEY `fk_Log_1` (`DeviceID`),
  CONSTRAINT `fk_Log_1` FOREIGN KEY (`DeviceID`) REFERENCES `Device` (`idDevice`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Log`
--

LOCK TABLES `Log` WRITE;
/*!40000 ALTER TABLE `Log` DISABLE KEYS */;
/*!40000 ALTER TABLE `Log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Login`
--

DROP TABLE IF EXISTS `Login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Login` (
  `idLogin` bigint(20) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `DateLogin` datetime DEFAULT NULL,
  `isEnabled` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idLogin`),
  UNIQUE KEY `idLogin_UNIQUE` (`idLogin`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Users that are allowed to log into an account';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Login`
--

LOCK TABLES `Login` WRITE;
/*!40000 ALTER TABLE `Login` DISABLE KEYS */;
/*!40000 ALTER TABLE `Login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OperatingSystem`
--

DROP TABLE IF EXISTS `OperatingSystem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OperatingSystem` (
  `idOperatingSystem` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  PRIMARY KEY (`idOperatingSystem`),
  UNIQUE KEY `idOperatingSystem_UNIQUE` (`idOperatingSystem`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Holds information about the operating systems supported';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OperatingSystem`
--

LOCK TABLES `OperatingSystem` WRITE;
/*!40000 ALTER TABLE `OperatingSystem` DISABLE KEYS */;
INSERT INTO `OperatingSystem` VALUES (2,'Windows'),(3,'Linux'),(4,'Mac'),(5,'iPhone'),(6,'Android');
/*!40000 ALTER TABLE `OperatingSystem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Plugin`
--

DROP TABLE IF EXISTS `Plugin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Plugin` (
  `idPlugin` bigint(20) NOT NULL AUTO_INCREMENT,
  `PluginFileID` bigint(20) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `Description` text,
  PRIMARY KEY (`idPlugin`),
  UNIQUE KEY `idPlugin_UNIQUE` (`idPlugin`),
  KEY `fk_Plugin_1` (`PluginFileID`),
  CONSTRAINT `fk_Plugin_1` FOREIGN KEY (`PluginFileID`) REFERENCES `PluginFile` (`idPluginFile`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='Holds information about the plug configuration for the account';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Plugin`
--

LOCK TABLES `Plugin` WRITE;
/*!40000 ALTER TABLE `Plugin` DISABLE KEYS */;
/*!40000 ALTER TABLE `Plugin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PluginFile`
--

DROP TABLE IF EXISTS `PluginFile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PluginFile` (
  `idPluginFile` bigint(20) NOT NULL AUTO_INCREMENT,
  `OperatingSystemID` bigint(20) NOT NULL,
  `Bits` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `URL` varchar(255) NOT NULL,
  `DateReleased` datetime NOT NULL,
  `Version` varchar(255) NOT NULL,
  `Size` int(11) NOT NULL,
  `ShortDescription` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  PRIMARY KEY (`idPluginFile`),
  UNIQUE KEY `idPluginFile_UNIQUE` (`idPluginFile`),
  KEY `fk_PluginFile_1` (`OperatingSystemID`),
  CONSTRAINT `fk_PluginFile_1` FOREIGN KEY (`OperatingSystemID`) REFERENCES `OperatingSystem` (`idOperatingSystem`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='Holds information about the available plugins';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PluginFile`
--

LOCK TABLES `PluginFile` WRITE;
/*!40000 ALTER TABLE `PluginFile` DISABLE KEYS */;
/*!40000 ALTER TABLE `PluginFile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PluginItem`
--

DROP TABLE IF EXISTS `PluginItem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PluginItem` (
  `idPluginItem` bigint(20) NOT NULL AUTO_INCREMENT,
  `PluginID` bigint(20) NOT NULL,
  `PluginOptionID` bigint(20) NOT NULL,
  `Value` varchar(255) NOT NULL,
  PRIMARY KEY (`idPluginItem`),
  UNIQUE KEY `idPluginItem_UNIQUE` (`idPluginItem`),
  KEY `fk_PluginItem_1` (`PluginOptionID`),
  KEY `fk_PluginItem_2` (`PluginID`),
  CONSTRAINT `fk_PluginItem_1` FOREIGN KEY (`PluginID`) REFERENCES `Plugin` (`idPlugin`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_PluginItem_2` FOREIGN KEY (`PluginOptionID`) REFERENCES `PluginOption` (`idPluginOption`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Plugin Option Items';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PluginItem`
--

LOCK TABLES `PluginItem` WRITE;
/*!40000 ALTER TABLE `PluginItem` DISABLE KEYS */;
/*!40000 ALTER TABLE `PluginItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PluginOption`
--

DROP TABLE IF EXISTS `PluginOption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PluginOption` (
  `idPluginOption` bigint(20) NOT NULL AUTO_INCREMENT,
  `PluginFileID` bigint(20) NOT NULL,
  `ValueTypeID` bigint(20) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Default` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  PRIMARY KEY (`idPluginOption`),
  UNIQUE KEY `idPluginOption_UNIQUE` (`idPluginOption`),
  KEY `fk_PluginOption_1` (`PluginFileID`),
  KEY `fk_PluginOption_2` (`ValueTypeID`),
  CONSTRAINT `fk_PluginOption_1` FOREIGN KEY (`PluginFileID`) REFERENCES `PluginFile` (`idPluginFile`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_PluginOption_2` FOREIGN KEY (`ValueTypeID`) REFERENCES `ValueType` (`idValueType`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COMMENT='Holds information about the plugin options';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PluginOption`
--

LOCK TABLES `PluginOption` WRITE;
/*!40000 ALTER TABLE `PluginOption` DISABLE KEYS */;
/*!40000 ALTER TABLE `PluginOption` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Policy`
--

DROP TABLE IF EXISTS `Policy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Policy` (
  `idPolicy` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` text,
  `PolicyTriggerID` bigint(20) NOT NULL,
  `PolicyActionID` bigint(20) NOT NULL,
  `TriggerValue1` varchar(255) DEFAULT NULL,
  `ActionValue1` varchar(255) DEFAULT NULL,
  `ActionValue2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idPolicy`),
  UNIQUE KEY `idPolicy_UNIQUE` (`idPolicy`),
  KEY `fk_Policy_1` (`PolicyTriggerID`),
  KEY `fk_Policy_2` (`PolicyActionID`),
  CONSTRAINT `fk_Policy_1` FOREIGN KEY (`PolicyTriggerID`) REFERENCES `PolicyTrigger` (`idPolicyTrigger`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_Policy_2` FOREIGN KEY (`PolicyActionID`) REFERENCES `PolicyAction` (`idPolicyAction`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Policy`
--

LOCK TABLES `Policy` WRITE;
/*!40000 ALTER TABLE `Policy` DISABLE KEYS */;
/*!40000 ALTER TABLE `Policy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PolicyAction`
--

DROP TABLE IF EXISTS `PolicyAction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PolicyAction` (
  `idPolicyAction` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Label1` varchar(255) NOT NULL,
  `Label2` varchar(255) NOT NULL,
  `hasValue1` tinyint(4) NOT NULL,
  `hasValue2` tinyint(4) NOT NULL,
  `ValueTypeID1` bigint(20) NOT NULL,
  `ValueTypeID2` bigint(20) NOT NULL,
  `Default1` varchar(255) NOT NULL,
  `Default2` varchar(255) NOT NULL,
  PRIMARY KEY (`idPolicyAction`),
  UNIQUE KEY `idPolicyAction_UNIQUE` (`idPolicyAction`),
  KEY `fk_PolicyAction_1` (`ValueTypeID1`),
  KEY `fk_PolicyAction_2` (`ValueTypeID2`),
  CONSTRAINT `fk_PolicyAction_1` FOREIGN KEY (`ValueTypeID1`) REFERENCES `ValueType` (`idValueType`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_PolicyAction_2` FOREIGN KEY (`ValueTypeID2`) REFERENCES `ValueType` (`idValueType`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PolicyAction`
--

LOCK TABLES `PolicyAction` WRITE;
/*!40000 ALTER TABLE `PolicyAction` DISABLE KEYS */;
INSERT INTO `PolicyAction` VALUES (1,'Command','Run a command on the command line','Command','NULL',1,0,1,1,'','NULL'),(2,'Missing','Flag the device as missing','Missing','NULL',0,0,1,1,'NULL','NULL'),(3,'Encrypt','Encrypt a file','Path','Password',1,1,1,1,'',''),(4,'Delete','Delete a file or folder','Path','NULL',1,0,1,1,'','NULL'),(5,'Copy','Copy a file or folder','Source','Destination',1,1,1,1,'',''),(6,'Move','Move a file or folder','Source','Destination',1,1,1,1,'',''),(7,'Download','Download a file via HTTP','URL','Destination',1,1,1,1,'http://',''),(8,'Install','Install a plugin','Path','NULL',1,0,1,1,'','NULL'),(9,'Uninstall','Uninstall a plugin','Plugin','NULL',1,0,7,1,'','NULL'),(10,'Start','Start a plugin','Plugin','NULL',1,0,7,1,'','NULL'),(11,'Stop','Stops a plugin','Plugin','NULL',1,0,7,1,'','NULL'),(12,'Restart','Restarts a plugin','Plugin','NULL',1,0,7,1,'','NULL'),(13,'Decrypt','Decrypt a file','Path','Password',1,1,1,1,'',''),(14,'Compress','Compress a file or folder','Source','Zip',1,1,1,1,'',''),(15,'Decompress','Decompress a file or folder','Destination','Zip',1,1,1,1,'',''),(16,'StopAll','Stops all the plugins','StopAll','NULL',0,0,1,1,'',''),(17,'StartAll','Starts all the plugins','StartAll','NULL',0,0,1,1,'',''),(18,'Quit','Quits the application','Quit','NULL',0,0,1,1,'',''),(19,'RestartAll','Restarts all the plugins','RestartAll','NULL',0,0,1,1,'',''),(20,'Launch','Launches a process and does not wait for it to finish','Launch','NULL',1,0,1,1,'','');
/*!40000 ALTER TABLE `PolicyAction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PolicyTrigger`
--

DROP TABLE IF EXISTS `PolicyTrigger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PolicyTrigger` (
  `idPolicyTrigger` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Label1` varchar(255) NOT NULL,
  `hasValue1` tinyint(4) NOT NULL,
  `ValueTypeID1` bigint(20) NOT NULL,
  `Default1` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idPolicyTrigger`),
  UNIQUE KEY `idPolicyTrigger_UNIQUE` (`idPolicyTrigger`),
  KEY `fk_PolicyTrigger_1` (`ValueTypeID1`),
  CONSTRAINT `fk_PolicyTrigger_1` FOREIGN KEY (`ValueTypeID1`) REFERENCES `ValueType` (`idValueType`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PolicyTrigger`
--

LOCK TABLES `PolicyTrigger` WRITE;
/*!40000 ALTER TABLE `PolicyTrigger` DISABLE KEYS */;
INSERT INTO `PolicyTrigger` VALUES (1,'Missing','The Device is missing','Missing',0,1,''),(2,'Mask','The device does not match a network mask','Mask',1,10,'192.168.1.*'),(3,'Date','A specific date has past','Date',1,2,''),(4,'Time','A specific time has past','Time',1,3,''),(5,'DateTime','A specific date and time has past','DateTime',1,6,''),(6,'Days','Days since the last contact with the device','Days',1,4,'30'),(7,'StartUp','When the program is started on the device','Startup',0,1,''),(12,'Update','When the program updates on the device','Update',0,1,'');
/*!40000 ALTER TABLE `PolicyTrigger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tutorial`
--

DROP TABLE IF EXISTS `Tutorial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tutorial` (
  `idTutorial` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Path` varchar(255) DEFAULT NULL,
  `VideoURL` varchar(255) DEFAULT NULL,
  `Description` text NOT NULL,
  PRIMARY KEY (`idTutorial`),
  UNIQUE KEY `idTutorial_UNIQUE` (`idTutorial`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1 COMMENT='Holds information about the site tutorials';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tutorial`
--

LOCK TABLES `Tutorial` WRITE;
/*!40000 ALTER TABLE `Tutorial` DISABLE KEYS */;
INSERT INTO `Tutorial` VALUES (1,'Welcome','site/index','site-index','Welcome to the site.'),(2,'Updating a Group','group/update','group-update','How to update a group'),(3,'EULA','site/eula','site-eula','End user agreement'),(4,'Logins','login/index','login-index','What are logins'),(5,'Devices in a group','group/device','group-device','How to manage devices in agroup'),(6,'Viewing tutorials','tutorial/view','tutorial-view','How to view tutorials'),(7,'Updating policies','policy/update','policy-update','How to update policies'),(8,'Creating logins','login/create','login-create','How to create logins'),(9,'Creating a group','group/create','group-create','How ot create a group'),(10,'Viewing logins','login/view','login-view','How to view logins'),(11,'Viewing logs','log/view','log-view','How to view logs'),(12,'Updating a device','device/update','device-update','How to update a device'),(13,'Terms of service','site/tos','site-tos','Terms of Service'),(14,'Group pPlugins','group/plugins','group-plugins','How to manage plugins linked to a group'),(15,'Uploading plugins','plugin/submitions','plugin-submitions','How to install plugins into the repository'),(16,'Updating logins','login/update','login-update','How to update logins'),(17,'Viewing plugins','plugin/view','plugin-view','How to view the details of a plugin'),(18,'Browsing plugins','plugin/browse','plugin-browse','How to browse the local plugin repository'),(19,'Privacy policy','site/privacy','site-privacy','Privacy policy'),(20,'Updating plugins','plugin/update','plugin-update','How to update a plugin'),(21,'Viewing a group','group/view','group-view','How to view a group'),(22,'Understanding polcies','policy/index','policy-index','Learn about policies'),(23,'Understanding devices','device/index','device-index','Learn about devices'),(24,'Viewing a device','device/view','device-view','How to view a device'),(25,'Logs','log/index','log-index','How to search logs'),(26,'Setup wizard','site/index','site-index','Description'),(27,'Creating plugins','plugin/create','plugin-create','How to create a plugin'),(28,'Manage devices','device/manage','device-manage','How to manage devices'),(29,'Viewing policies','policy/view','policy-view','How to view policies'),(30,'Understanding plugins','plugin/index','plugin-index','Learn about plugins'),(31,'Manage logins','login/admin','login-admin','How to manage logins'),(32,'Viewing plugin details','plugin/details','plugin-details','How to view plugin details'),(33,'Understanding groups','group/index','group-index','Learn about groups'),(34,'Creating devices','device/create','device-create','How to create devices'),(35,'Manage plugins','plugin/admin','plugin-admin','Learn how to manage plugins'),(36,'Manage policies','policy/admin','policy-admin','Learn how to manage policies'),(37,'Support','site/support','site-support','Support options'),(38,'Searching tutorials','tutorial/index','tutorial-index','How to search the tutorials'),(39,'Viewing tutorials','tutorial/view','tutorial-view','How to view tutorials'),(40,'Legal information','site/legal','site-legal','Legal information'),(41,'Group policies','group/policy','group-policy','Learn how to manage group policies'),(42,'Creating policies','policy/create','policy-create','Learn how to create policies'),(43,'Uploading plugins','plugin/submit','plugin-submit','How to upload a plugin to the local repository'),(44,'Manage groups','group/admin','group-admin','How to manage groups');
/*!40000 ALTER TABLE `Tutorial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ValueType`
--

DROP TABLE IF EXISTS `ValueType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ValueType` (
  `idValueType` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  PRIMARY KEY (`idValueType`),
  UNIQUE KEY `idValueType_UNIQUE` (`idValueType`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='Holds information about value types';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ValueType`
--

LOCK TABLES `ValueType` WRITE;
/*!40000 ALTER TABLE `ValueType` DISABLE KEYS */;
INSERT INTO `ValueType` VALUES (1,'String'),(2,'Date'),(3,'Time'),(4,'Number'),(5,'Boolean'),(6,'DateTime'),(7,'Plugin'),(8,'File'),(9,'Folder'),(10,'IPMask');
/*!40000 ALTER TABLE `ValueType` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-27 14:59:16
