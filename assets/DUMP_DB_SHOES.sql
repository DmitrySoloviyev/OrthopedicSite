-- MySQL dump 10.13  Distrib 5.5.23, for Win32 (x86)
--
-- Host: localhost    Database: SHOES
-- ------------------------------------------------------
-- Server version	5.5.23

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
-- Current Database: `SHOES`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `SHOES` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `SHOES`;

--
-- Table structure for table `AnkleVolume`
--

DROP TABLE IF EXISTS `AnkleVolume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AnkleVolume` (
  `AnkleVolumeID` char(4) NOT NULL,
  `AnkleVolumeValue` float(3,1) unsigned NOT NULL,
  PRIMARY KEY (`AnkleVolumeID`),
  KEY `AnkleVolumeValue` (`AnkleVolumeValue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AnkleVolume`
--

LOCK TABLES `AnkleVolume` WRITE;
/*!40000 ALTER TABLE `AnkleVolume` DISABLE KEYS */;
INSERT INTO `AnkleVolume` VALUES ('a100',10.0),('a105',10.5),('a110',11.0),('a115',11.5),('a120',12.0),('a125',12.5),('a130',13.0),('a135',13.5),('a140',14.0),('a145',14.5),('a150',15.0),('a155',15.5),('a160',16.0),('a165',16.5),('a170',17.0),('a175',17.5),('a180',18.0),('a185',18.5),('a190',19.0),('a195',19.5),('a200',20.0),('a205',20.5),('a210',21.0),('a215',21.5),('a220',22.0),('a225',22.5),('a230',23.0),('a235',23.5),('a240',24.0),('a245',24.5),('a250',25.0),('a255',25.5),('a260',26.0),('a265',26.5),('a270',27.0),('a275',27.5),('a280',28.0),('a285',28.5),('a290',29.0),('a295',29.5),('a300',30.0),('a305',30.5),('a310',31.0),('a315',31.5),('a320',32.0),('a325',32.5),('a330',33.0),('a335',33.5),('a340',34.0),('a345',34.5),('a350',35.0),('a355',35.5),('a360',36.0),('a365',36.5),('a370',37.0),('a375',37.5),('a380',38.0),('a385',38.5),('a390',39.0),('a395',39.5),('a400',40.0),('a405',40.5),('a410',41.0),('a415',41.5),('a420',42.0),('a425',42.5),('a430',43.0),('a435',43.5),('a440',44.0),('a445',44.5),('a450',45.0),('a455',45.5),('a460',46.0),('a465',46.5),('a470',47.0),('a475',47.5),('a480',48.0),('a485',48.5),('a490',49.0),('a495',49.5),('a500',50.0);
/*!40000 ALTER TABLE `AnkleVolume` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Customers`
--

DROP TABLE IF EXISTS `Customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Customers` (
  `CustomerID` int unsigned NOT NULL AUTO_INCREMENT,
  `CustomerSN` varchar(30) NOT NULL,
  `CustomerFN` varchar(30) NOT NULL,
  `CustomerP` varchar(30) NOT NULL,
  PRIMARY KEY (`CustomerID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Employees`
--

DROP TABLE IF EXISTS `Employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Employees` (
  `EmployeeID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeSN` varchar(30) NOT NULL,
  `EmployeeFN` varchar(30) NOT NULL,
  `EmployeeP` varchar(30) NOT NULL,
  `STATUS` enum('Работает','Уволен') NOT NULL DEFAULT 'Работает',
  PRIMARY KEY (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Height`
--

DROP TABLE IF EXISTS `Height`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Height` (
  `HeightID` char(3) NOT NULL,
  `HeightValue` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`HeightID`),
  KEY `HeightValue` (`HeightValue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Height`
--

LOCK TABLES `Height` WRITE;
/*!40000 ALTER TABLE `Height` DISABLE KEYS */;
INSERT INTO `Height` VALUES ('h0',0),('h7',7),('h8',8),('h9',9),('h10',10),('h11',11),('h12',12),('h13',13),('h14',14),('h15',15),('h16',16),('h17',17),('h18',18),('h19',19),('h20',20),('h21',21),('h22',22),('h23',23),('h24',24),('h25',25),('h26',26),('h27',27),('h28',28),('h29',29),('h30',30),('h31',31),('h32',32),('h33',33),('h34',34),('h35',35),('h36',36),('h37',37),('h38',38),('h39',39),('h40',40);
/*!40000 ALTER TABLE `Height` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `KvVolume`
--

DROP TABLE IF EXISTS `KvVolume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `KvVolume` (
  `KvVolumeID` char(4) NOT NULL,
  `KvVolumeValue` float(3,1) unsigned NOT NULL,
  PRIMARY KEY (`KvVolumeID`),
  KEY `KvVolumeValue` (`KvVolumeValue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `KvVolume`
--

LOCK TABLES `KvVolume` WRITE;
/*!40000 ALTER TABLE `KvVolume` DISABLE KEYS */;
INSERT INTO `KvVolume` VALUES ('k150',15.0),('k155',15.5),('k160',16.0),('k165',16.5),('k170',17.0),('k175',17.5),('k180',18.0),('k185',18.5),('k190',19.0),('k195',19.5),('k200',20.0),('k205',20.5),('k210',21.0),('k215',21.5),('k220',22.0),('k225',22.5),('k230',23.0),('k235',23.5),('k240',24.0),('k245',24.5),('k250',25.0),('k255',25.5),('k260',26.0),('k265',26.5),('k270',27.0),('k275',27.5),('k280',28.0),('k285',28.5),('k290',29.0),('k295',29.5),('k300',30.0),('k305',30.5),('k310',31.0),('k315',31.5),('k320',32.0),('k325',32.5),('k330',33.0),('k335',33.5),('k340',34.0),('k345',34.5),('k350',35.0),('k355',35.5),('k360',36.0),('k365',36.5),('k370',37.0),('k375',37.5),('k380',38.0),('k385',38.5),('k390',39.0),('k395',39.5),('k400',40.0),('k405',40.5),('k410',41.0),('k415',41.5),('k420',42.0),('k425',42.5),('k430',43.0),('k435',43.5),('k440',44.0),('k445',44.5),('k450',45.0),('k455',45.5),('k460',46.0),('k465',46.5),('k470',47.0),('k475',47.5),('k480',48.0),('k485',48.5),('k490',49.0),('k495',49.5),('k500',50.0),('k505',50.5),('k510',51.0),('k515',51.5),('k520',52.0),('k525',52.5),('k530',53.0),('k535',53.5),('k540',54.0),('k545',54.5),('k550',55.0),('k555',55.5),('k560',56.0),('k565',56.5),('k570',57.0),('k575',57.5),('k580',58.0),('k585',58.5),('k590',59.0),('k595',59.5),('k600',60.0),('k605',60.5),('k610',61.0),('k615',61.5),('k620',62.0),('k625',62.5),('k630',63.0),('k635',63.5),('k640',64.0),('k645',64.5),('k650',65.0),('k655',65.5),('k660',66.0),('k665',66.5),('k670',67.0),('k675',67.5),('k680',68.0),('k685',68.5),('k690',69.0),('k695',69.5),('k700',70.0);
/*!40000 ALTER TABLE `KvVolume` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Materials`
--

DROP TABLE IF EXISTS `Materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Materials` (
  `MaterialID` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `MaterialValue` varchar(30) NOT NULL,
  PRIMARY KEY (`MaterialID`),
  KEY `MaterialValue` (`MaterialValue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Materials`
--

LOCK TABLES `Materials` WRITE;
/*!40000 ALTER TABLE `Materials` DISABLE KEYS */;
INSERT INTO `Materials` (`MaterialValue`) VALUES ('КП'),('Траспира'),('Мех Натуральный'),('Мех Искусственный'),('Мех Полушерстяной');
/*!40000 ALTER TABLE `Materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Models`
--

DROP TABLE IF EXISTS `Models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Models` (
  `ModelID` int unsigned NOT NULL AUTO_INCREMENT,
  `ModelName` varchar(6) NOT NULL,
  `ModelDescription` varchar(255) NOT NULL DEFAULT 'нет описания',
  `ModelPicture` varchar(64) NOT NULL DEFAULT 'assets/OrthopedicGallery/ortho.jpg',
  `DateModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ModelID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Orders`
--

DROP TABLE IF EXISTS `Orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Orders` (
  `OrderID` varchar(10) NOT NULL,
  `ModelID` int unsigned NOT NULL,
  `SizeLEFT` char(3) NOT NULL,
  `SizeRIGHT` char(3) NOT NULL,
  `UrkLEFT` char(4) NOT NULL,
  `UrkRIGHT` char(4) NOT NULL,
  `MaterialID` tinyint unsigned NOT NULL,
  `HeightLEFT` char(3) NOT NULL,
  `HeightRIGHT` char(3) NOT NULL,
  `TopVolumeLEFT` char(4) NOT NULL,
  `TopVolumeRIGHT` char(4) NOT NULL,
  `AnkleVolumeLEFT` char(4) NOT NULL,
  `AnkleVolumeRIGHT` char(4) NOT NULL,
  `KvVolumeLEFT` char(4) NOT NULL,
  `KvVolumeRIGHT` char(4) NOT NULL,
  `CustomerID` int unsigned NOT NULL,
  `EmployeeID` tinyint(3) unsigned NOT NULL,
  `Date` datetime NOT NULL,
  `Comment` varchar(255) NOT NULL DEFAULT 'нет',
  PRIMARY KEY (`OrderID`),
  KEY `ModelID` (`ModelID`),
  KEY `SizeLEFT` (`SizeLEFT`),
  KEY `SizeRIGHT` (`SizeRIGHT`),
  KEY `UrkLEFT` (`UrkLEFT`),
  KEY `UrkRIGHT` (`UrkRIGHT`),
  KEY `MaterialID` (`MaterialID`),
  KEY `HeightLEFT` (`HeightLEFT`),
  KEY `HeightRIGHT` (`HeightRIGHT`),
  KEY `TopVolumeLEFT` (`TopVolumeLEFT`),
  KEY `TopVolumeRIGHT` (`TopVolumeRIGHT`),
  KEY `AnkleVolumeLEFT` (`AnkleVolumeLEFT`),
  KEY `AnkleVolumeRIGHT` (`AnkleVolumeRIGHT`),
  KEY `KvVolumeLEFT` (`KvVolumeLEFT`),
  KEY `KvVolumeRIGHT` (`KvVolumeRIGHT`),
  KEY `CustomerID` (`CustomerID`),
  KEY `EmployeeID` (`EmployeeID`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`ModelID`) REFERENCES `Models` (`ModelID`),
  CONSTRAINT `orders_ibfk_10` FOREIGN KEY (`TopVolumeRIGHT`) REFERENCES `TopVolume` (`TopVolumeID`),
  CONSTRAINT `orders_ibfk_11` FOREIGN KEY (`AnkleVolumeLEFT`) REFERENCES `AnkleVolume` (`AnkleVolumeID`),
  CONSTRAINT `orders_ibfk_12` FOREIGN KEY (`AnkleVolumeRIGHT`) REFERENCES `AnkleVolume` (`AnkleVolumeID`),
  CONSTRAINT `orders_ibfk_13` FOREIGN KEY (`KvVolumeLEFT`) REFERENCES `KvVolume` (`KvVolumeID`),
  CONSTRAINT `orders_ibfk_14` FOREIGN KEY (`KvVolumeRIGHT`) REFERENCES `KvVolume` (`KvVolumeID`),
  CONSTRAINT `orders_ibfk_15` FOREIGN KEY (`CustomerID`) REFERENCES `Customers` (`CustomerID`),
  CONSTRAINT `orders_ibfk_16` FOREIGN KEY (`EmployeeID`) REFERENCES `Employees` (`EmployeeID`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`SizeLEFT`) REFERENCES `Sizes` (`SizeID`),
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`SizeRIGHT`) REFERENCES `Sizes` (`SizeID`),
  CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`UrkLEFT`) REFERENCES `Urk` (`UrkID`),
  CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`UrkRIGHT`) REFERENCES `Urk` (`UrkID`),
  CONSTRAINT `orders_ibfk_6` FOREIGN KEY (`MaterialID`) REFERENCES `Materials` (`MaterialID`),
  CONSTRAINT `orders_ibfk_7` FOREIGN KEY (`HeightLEFT`) REFERENCES `Height` (`HeightID`),
  CONSTRAINT `orders_ibfk_8` FOREIGN KEY (`HeightRIGHT`) REFERENCES `Height` (`HeightID`),
  CONSTRAINT `orders_ibfk_9` FOREIGN KEY (`TopVolumeLEFT`) REFERENCES `TopVolume` (`TopVolumeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Sizes`
--

DROP TABLE IF EXISTS `Sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Sizes` (
  `SizeID` char(3) NOT NULL,
  `SizeValue` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`SizeID`),
  KEY `SizeValue` (`SizeValue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sizes`
--

LOCK TABLES `Sizes` WRITE;
/*!40000 ALTER TABLE `Sizes` DISABLE KEYS */;
INSERT INTO `Sizes` VALUES ('s15',15),('s16',16),('s17',17),('s18',18),('s19',19),('s20',20),('s21',21),('s22',22),('s23',23),('s24',24),('s25',25),('s26',26),('s27',27),('s28',28),('s29',29),('s30',30),('s31',31),('s32',32),('s33',33),('s34',34),('s35',35),('s36',36),('s37',37),('s38',38),('s39',39),('s40',40),('s41',41),('s42',42),('s43',43),('s44',44),('s45',45),('s46',46),('s47',47),('s48',48),('s49',49);
/*!40000 ALTER TABLE `Sizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TopVolume`
--

DROP TABLE IF EXISTS `TopVolume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TopVolume` (
  `TopVolumeID` char(4) NOT NULL,
  `TopVolumeValue` float(3,1) unsigned NOT NULL,
  PRIMARY KEY (`TopVolumeID`),
  KEY `TopVolumeValue` (`TopVolumeValue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TopVolume`
--

LOCK TABLES `TopVolume` WRITE;
/*!40000 ALTER TABLE `TopVolume` DISABLE KEYS */;
INSERT INTO `TopVolume` VALUES ('t100',10.0),('t105',10.5),('t110',11.0),('t115',11.5),('t120',12.0),('t125',12.5),('t130',13.0),('t135',13.5),('t140',14.0),('t145',14.5),('t150',15.0),('t155',15.5),('t160',16.0),('t165',16.5),('t170',17.0),('t175',17.5),('t180',18.0),('t185',18.5),('t190',19.0),('t195',19.5),('t200',20.0),('t205',20.5),('t210',21.0),('t215',21.5),('t220',22.0),('t225',22.5),('t230',23.0),('t235',23.5),('t240',24.0),('t245',24.5),('t250',25.0),('t255',25.5),('t260',26.0),('t265',26.5),('t270',27.0),('t275',27.5),('t280',28.0),('t285',28.5),('t290',29.0),('t295',29.5),('t300',30.0),('t305',30.5),('t310',31.0),('t315',31.5),('t320',32.0),('t325',32.5),('t330',33.0),('t335',33.5),('t340',34.0),('t345',34.5),('t350',35.0),('t355',35.5),('t360',36.0),('t365',36.5),('t370',37.0),('t375',37.5),('t380',38.0),('t385',38.5),('t390',39.0),('t395',39.5),('t400',40.0),('t405',40.5),('t410',41.0),('t415',41.5),('t420',42.0),('t425',42.5),('t430',43.0),('t435',43.5),('t440',44.0),('t445',44.5),('t450',45.0),('t455',45.5),('t460',46.0),('t465',46.5),('t470',47.0),('t475',47.5),('t480',48.0),('t485',48.5),('t490',49.0),('t495',49.5),('t500',50.0);
/*!40000 ALTER TABLE `TopVolume` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Urk`
--

DROP TABLE IF EXISTS `Urk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Urk` (
  `UrkID` char(4) NOT NULL,
  `UrkValue` smallint(3) unsigned NOT NULL,
  PRIMARY KEY (`UrkID`),
  KEY `UrkValue` (`UrkValue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Urk`
--

LOCK TABLES `Urk` WRITE;
/*!40000 ALTER TABLE `Urk` DISABLE KEYS */;
INSERT INTO `Urk` VALUES ('u100',100),('u101',101),('u102',102),('u103',103),('u104',104),('u105',105),('u106',106),('u107',107),('u108',108),('u109',109),('u110',110),('u111',111),('u112',112),('u113',113),('u114',114),('u115',115),('u116',116),('u117',117),('u118',118),('u119',119),('u120',120),('u121',121),('u122',122),('u123',123),('u124',124),('u125',125),('u126',126),('u127',127),('u128',128),('u129',129),('u130',130),('u131',131),('u132',132),('u133',133),('u134',134),('u135',135),('u136',136),('u137',137),('u138',138),('u139',139),('u140',140),('u141',141),('u142',142),('u143',143),('u144',144),('u145',145),('u146',146),('u147',147),('u148',148),('u149',149),('u150',150),('u151',151),('u152',152),('u153',153),('u154',154),('u155',155),('u156',156),('u157',157),('u158',158),('u159',159),('u160',160),('u161',161),('u162',162),('u163',163),('u164',164),('u165',165),('u166',166),('u167',167),('u168',168),('u169',169),('u170',170),('u171',171),('u172',172),('u173',173),('u174',174),('u175',175),('u176',176),('u177',177),('u178',178),('u179',179),('u180',180),('u181',181),('u182',182),('u183',183),('u184',184),('u185',185),('u186',186),('u187',187),('u188',188),('u189',189),('u190',190),('u191',191),('u192',192),('u193',193),('u194',194),('u195',195),('u196',196),('u197',197),('u198',198),('u199',199),('u200',200),('u201',201),('u202',202),('u203',203),('u204',204),('u205',205),('u206',206),('u207',207),('u208',208),('u209',209),('u210',210),('u211',211),('u212',212),('u213',213),('u214',214),('u215',215),('u216',216),('u217',217),('u218',218),('u219',219),('u220',220),('u221',221),('u222',222),('u223',223),('u224',224),('u225',225),('u226',226),('u227',227),('u228',228),('u229',229),('u230',230),('u231',231),('u232',232),('u233',233),('u234',234),('u235',235),('u236',236),('u237',237),('u238',238),('u239',239),('u240',240),('u241',241),('u242',242),('u243',243),('u244',244),('u245',245),('u246',246),('u247',247),('u248',248),('u249',249),('u250',250),('u251',251),('u252',252),('u253',253),('u254',254),('u255',255),('u256',256),('u257',257),('u258',258),('u259',259),('u260',260),('u261',261),('u262',262),('u263',263),('u264',264),('u265',265),('u266',266),('u267',267),('u268',268),('u269',269),('u270',270),('u271',271),('u272',272),('u273',273),('u274',274),('u275',275),('u276',276),('u277',277),('u278',278),('u279',279),('u280',280),('u281',281),('u282',282),('u283',283),('u284',284),('u285',285),('u286',286),('u287',287),('u288',288),('u289',289),('u290',290),('u291',291),('u292',292),('u293',293),('u294',294),('u295',295),('u296',296),('u297',297),('u298',298),('u299',299),('u300',300),('u301',301),('u302',302),('u303',303),('u304',304),('u305',305),('u306',306),('u307',307),('u308',308),('u309',309),('u310',310),('u311',311),('u312',312),('u313',313),('u314',314),('u315',315),('u316',316),('u317',317),('u318',318),('u319',319),('u320',320),('u321',321),('u322',322),('u323',323),('u324',324),('u325',325),('u326',326),('u327',327),('u328',328),('u329',329),('u330',330),('u331',331),('u332',332),('u333',333),('u334',334),('u335',335),('u336',336),('u337',337),('u338',338),('u339',339),('u340',340),('u341',341),('u342',342),('u343',343),('u344',344),('u345',345),('u346',346),('u347',347),('u348',348),('u349',349),('u350',350),('u351',351),('u352',352),('u353',353),('u354',354),('u355',355),('u356',356),('u357',357),('u358',358),('u359',359),('u360',360),('u361',361),('u362',362),('u363',363),('u364',364),('u365',365),('u366',366),('u367',367),('u368',368),('u369',369),('u370',370),('u371',371),('u372',372),('u373',373),('u374',374),('u375',375),('u376',376),('u377',377),('u378',378),('u379',379),('u380',380),('u381',381),('u382',382),('u383',383),('u384',384),('u385',385),('u386',386),('u387',387),('u388',388),('u389',389),('u390',390),('u391',391),('u392',392),('u393',393),('u394',394),('u395',395),('u396',396),('u397',397),('u398',398),('u399',399),('u400',400);
/*!40000 ALTER TABLE `Urk` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-08-31 13:40:55
