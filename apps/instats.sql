# Host: localhost  (Version: 5.5.5-10.1.9-MariaDB)
# Date: 2016-03-27 23:20:20
# Generator: MySQL-Front 5.3  (Build 5.16)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "browsers"
#

DROP TABLE IF EXISTS `browsers`;
CREATE TABLE `browsers` (
  `BrowserID` int(10) NOT NULL AUTO_INCREMENT,
  `BrowserName` varchar(110) DEFAULT '',
  `Total` int(10) DEFAULT NULL,
  PRIMARY KEY (`BrowserID`),
  UNIQUE KEY `BrowserName` (`BrowserName`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "browsers"
#

/*!40000 ALTER TABLE `browsers` DISABLE KEYS */;
/*!40000 ALTER TABLE `browsers` ENABLE KEYS */;

#
# Structure for table "colors"
#

DROP TABLE IF EXISTS `colors`;
CREATE TABLE `colors` (
  `ColorID` int(10) NOT NULL AUTO_INCREMENT,
  `ColorName` varchar(20) NOT NULL DEFAULT '',
  `Total` int(10) DEFAULT NULL,
  PRIMARY KEY (`ColorID`),
  UNIQUE KEY `ColorName` (`ColorName`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "colors"
#

/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;

#
# Structure for table "config"
#

DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `ID` int(10) NOT NULL,
  `C_ImageLoc` varchar(200) DEFAULT NULL,
  `C_FilterIP` varchar(200) DEFAULT NULL,
  `C_Showlinks` tinyint(1) NOT NULL DEFAULT '0',
  `C_RefThisServer` tinyint(1) NOT NULL DEFAULT '0',
  `C_StripPathParameters` tinyint(1) NOT NULL DEFAULT '0',
  `C_StripPathProtocol` tinyint(1) NOT NULL DEFAULT '0',
  `C_StripRefParameters` tinyint(1) NOT NULL DEFAULT '0',
  `C_StripRefProtocol` tinyint(1) NOT NULL DEFAULT '0',
  `C_StripRefFile` tinyint(1) NOT NULL DEFAULT '0',
  `Language` varchar(20) NOT NULL DEFAULT 'en_US',
  UNIQUE KEY `test` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "config"
#

/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'/assets/insyapixel.png','1.2.3.4,1.2.3.5',1,1,0,0,0,0,0,'en-us');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;

#
# Structure for table "oses"
#

DROP TABLE IF EXISTS `oses`;
CREATE TABLE `oses` (
  `OsID` int(10) NOT NULL AUTO_INCREMENT,
  `OsName` varchar(20) NOT NULL DEFAULT '',
  `Total` int(10) DEFAULT NULL,
  PRIMARY KEY (`OsID`),
  UNIQUE KEY `OsName` (`OsName`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "oses"
#

/*!40000 ALTER TABLE `oses` DISABLE KEYS */;
/*!40000 ALTER TABLE `oses` ENABLE KEYS */;

#
# Structure for table "paths"
#

DROP TABLE IF EXISTS `paths`;
CREATE TABLE `paths` (
  `PathID` int(10) NOT NULL AUTO_INCREMENT,
  `PathName` varchar(250) NOT NULL DEFAULT '',
  `Total` int(10) DEFAULT NULL,
  PRIMARY KEY (`PathID`),
  UNIQUE KEY `PathName` (`PathName`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "paths"
#

/*!40000 ALTER TABLE `paths` DISABLE KEYS */;
/*!40000 ALTER TABLE `paths` ENABLE KEYS */;

#
# Structure for table "refs"
#

DROP TABLE IF EXISTS `refs`;
CREATE TABLE `refs` (
  `RefID` int(10) NOT NULL AUTO_INCREMENT,
  `RefName` varchar(250) NOT NULL DEFAULT '',
  `Total` int(10) DEFAULT NULL,
  PRIMARY KEY (`RefID`),
  UNIQUE KEY `ReferenceName` (`RefName`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "refs"
#

/*!40000 ALTER TABLE `refs` DISABLE KEYS */;
/*!40000 ALTER TABLE `refs` ENABLE KEYS */;

#
# Structure for table "resolutions"
#

DROP TABLE IF EXISTS `resolutions`;
CREATE TABLE `resolutions` (
  `ResID` int(10) NOT NULL AUTO_INCREMENT,
  `ResName` varchar(10) NOT NULL DEFAULT '',
  `Total` int(10) DEFAULT NULL,
  PRIMARY KEY (`ResID`),
  UNIQUE KEY `ResName` (`ResName`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "resolutions"
#

/*!40000 ALTER TABLE `resolutions` DISABLE KEYS */;
/*!40000 ALTER TABLE `resolutions` ENABLE KEYS */;

#
# Structure for table "stats"
#

DROP TABLE IF EXISTS `stats`;
CREATE TABLE `stats` (
  `StatID` int(10) NOT NULL AUTO_INCREMENT,
  `Date` date NOT NULL DEFAULT '0000-00-00',
  `Time` time NOT NULL DEFAULT '00:00:00',
  `IP` varchar(20) DEFAULT NULL,
  `OsID` int(10) NOT NULL DEFAULT '0',
  `ColorID` int(10) NOT NULL DEFAULT '0',
  `BrowserID` int(10) NOT NULL DEFAULT '0',
  `ResID` int(10) NOT NULL DEFAULT '0',
  `PathID` int(10) NOT NULL DEFAULT '0',
  `RefID` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`StatID`)
) ENGINE=MyISAM AUTO_INCREMENT=145 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "stats"
#

/*!40000 ALTER TABLE `stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `stats` ENABLE KEYS */;

#
# Structure for table "groupipsbydate"
#

DROP VIEW IF EXISTS `groupipsbydate`;
CREATE VIEW `groupipsbydate` AS 
  select `stats`.`IP` AS `IP`,`stats`.`Date` AS `Date` from `stats` group by `stats`.`IP`,`stats`.`Date`;

#
# Structure for table "groupipsbyhouranddate"
#

DROP VIEW IF EXISTS `groupipsbyhouranddate`;
CREATE VIEW `groupipsbyhouranddate` AS 
  select time_format(`stats`.`Time`,'%h') AS `Hour`,`stats`.`IP` AS `IP`,`stats`.`Date` AS `Date` from `stats` group by time_format(`stats`.`Time`,'%h'),`stats`.`IP`,`stats`.`Date` order by time_format(`stats`.`Time`,'%h');

#
# Structure for table "topipsperday"
#

DROP VIEW IF EXISTS `topipsperday`;
CREATE VIEW `topipsperday` AS 
  select count(`groupipsbydate`.`IP`) AS `Total`,`groupipsbydate`.`Date` AS `Date` from `groupipsbydate` group by `groupipsbydate`.`Date` order by count(`groupipsbydate`.`IP`) desc;

#
# Structure for table "toppageviewsperday"
#

DROP VIEW IF EXISTS `toppageviewsperday`;
CREATE VIEW `toppageviewsperday` AS 
  select count(`stats`.`IP`) AS `Total`,`stats`.`Date` AS `Date` from `stats` group by `stats`.`Date` order by count(`stats`.`IP`) desc;
