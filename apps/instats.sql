# Host: localhost  (Version 5.5.5-10.1.9-MariaDB)
# Date: 2020-10-08 13:27:22
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "browsers"
#

DROP TABLE IF EXISTS `browsers`;
CREATE TABLE `browsers` (
  `browserid` int(10) NOT NULL AUTO_INCREMENT,
  `browsername` varchar(110) DEFAULT '',
  `total` int(10) DEFAULT NULL,
  PRIMARY KEY (`browserid`),
  UNIQUE KEY `browsername` (`browsername`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "browsers"
#


#
# Structure for table "colors"
#

DROP TABLE IF EXISTS `colors`;
CREATE TABLE `colors` (
  `colorid` int(10) NOT NULL AUTO_INCREMENT,
  `colorname` varchar(20) NOT NULL DEFAULT '',
  `total` int(10) DEFAULT NULL,
  PRIMARY KEY (`colorid`),
  UNIQUE KEY `colorname` (`colorname`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "colors"
#


#
# Structure for table "config"
#

DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int(10) NOT NULL,
  `c_imageloc` varchar(200) DEFAULT NULL,
  `c_filterip` varchar(200) DEFAULT NULL,
  `c_showlinks` tinyint(1) NOT NULL DEFAULT '0',
  `c_refthisserver` tinyint(1) NOT NULL DEFAULT '0',
  `c_strippathparameters` tinyint(1) NOT NULL DEFAULT '0',
  `c_strippathprotocol` tinyint(1) NOT NULL DEFAULT '0',
  `c_striprefparameters` tinyint(1) NOT NULL DEFAULT '0',
  `c_striprefprotocol` tinyint(1) NOT NULL DEFAULT '0',
  `c_stripreffile` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(20) NOT NULL DEFAULT 'en_us',
  `forcelogin` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `test` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "config"
#

/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'/assets/insyapixel.png','1.2.3.4,1.2.3.5',1,1,0,0,0,0,0,'en-us',0);
/*!40000 ALTER TABLE `config` ENABLE KEYS */;

#
# Structure for table "keywords"
#

DROP TABLE IF EXISTS `keywords`;
CREATE TABLE `keywords` (
  `keyid` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  PRIMARY KEY (`keyid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "keywords"
#


#
# Structure for table "langs"
#

DROP TABLE IF EXISTS `langs`;
CREATE TABLE `langs` (
  `langid` int(11) NOT NULL AUTO_INCREMENT,
  `langname` varchar(50) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  PRIMARY KEY (`langid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "langs"
#

INSERT INTO `langs` VALUES (1,'tr-TR',349);

#
# Structure for table "oses"
#

DROP TABLE IF EXISTS `oses`;
CREATE TABLE `oses` (
  `osid` int(10) NOT NULL AUTO_INCREMENT,
  `osname` varchar(20) NOT NULL DEFAULT '',
  `total` int(10) DEFAULT NULL,
  PRIMARY KEY (`osid`),
  UNIQUE KEY `osname` (`osname`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "oses"
#


#
# Structure for table "paths"
#

DROP TABLE IF EXISTS `paths`;
CREATE TABLE `paths` (
  `pathid` int(10) NOT NULL AUTO_INCREMENT,
  `pathname` varchar(250) NOT NULL DEFAULT '',
  `total` int(10) DEFAULT NULL,
  PRIMARY KEY (`pathid`),
  UNIQUE KEY `pathname` (`pathname`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "paths"
#


#
# Structure for table "refs"
#

DROP TABLE IF EXISTS `refs`;
CREATE TABLE `refs` (
  `refid` int(10) NOT NULL AUTO_INCREMENT,
  `refname` varchar(250) NOT NULL DEFAULT '',
  `total` int(10) DEFAULT NULL,
  PRIMARY KEY (`refid`),
  UNIQUE KEY `referencename` (`refname`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "refs"
#


#
# Structure for table "resolutions"
#

DROP TABLE IF EXISTS `resolutions`;
CREATE TABLE `resolutions` (
  `resid` int(10) NOT NULL AUTO_INCREMENT,
  `resname` varchar(10) NOT NULL DEFAULT '',
  `total` int(10) DEFAULT NULL,
  PRIMARY KEY (`resid`),
  UNIQUE KEY `resname` (`resname`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "resolutions"
#


#
# Structure for table "stats"
#

DROP TABLE IF EXISTS `stats`;
CREATE TABLE `stats` (
  `statid` int(10) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `ip` varchar(20) DEFAULT NULL,
  `osid` int(10) NOT NULL DEFAULT '0',
  `colorid` int(10) NOT NULL DEFAULT '0',
  `browserid` int(10) NOT NULL DEFAULT '0',
  `resid` int(10) NOT NULL DEFAULT '0',
  `keyid` int(11) DEFAULT '0',
  `pathid` int(10) NOT NULL DEFAULT '0',
  `refid` int(10) NOT NULL DEFAULT '0',
  `langid` int(10) DEFAULT '0',
  `uagentid` int(10) DEFAULT '0',
  `visitorid` int(10) DEFAULT '0',
  PRIMARY KEY (`statid`)
) ENGINE=MyISAM AUTO_INCREMENT=406 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Data for table "stats"
#


#
# Structure for table "uagents"
#

DROP TABLE IF EXISTS `uagents`;
CREATE TABLE `uagents` (
  `uagentid` int(11) NOT NULL AUTO_INCREMENT,
  `uagentname` varchar(255) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  PRIMARY KEY (`uagentid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "uagents"
#


#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `level` int(1) NOT NULL DEFAULT '1' COMMENT '// 3 admin //2 editor //1 viewer //0 ban',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "users"
#


#
# Structure for table "visitors"
#

DROP TABLE IF EXISTS `visitors`;
CREATE TABLE `visitors` (
  `visitorid` int(11) NOT NULL AUTO_INCREMENT,
  `visitorname` varchar(30) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  PRIMARY KEY (`visitorid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "visitors"
#


#
# View "groupipsbydate"
#

DROP VIEW IF EXISTS `groupipsbydate`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `groupipsbydate`
  AS
SELECT
  `ip`, `date`
FROM
  `stats`
GROUP BY
  `ip`, `date`;

#
# View "groupipsbyhouranddate"
#

DROP VIEW IF EXISTS `groupipsbyhouranddate`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `groupipsbyhouranddate`
  AS
SELECT
  TIME_FORMAT(`time`, '%h') AS 'hour', `ip`, `date`
FROM
  `stats`
GROUP BY
  TIME_FORMAT(`time`, '%h'), `ip`, `date`
ORDER BY TIME_FORMAT(`time`, '%h');

#
# View "topipsperday"
#

DROP VIEW IF EXISTS `topipsperday`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `topipsperday`
  AS
SELECT
  COUNT(`ip`) AS 'total', `date`
FROM
  `groupipsbydate`
GROUP BY
  `date`
ORDER BY COUNT(`ip`) DESC;

#
# View "toppageviewsperday"
#

DROP VIEW IF EXISTS `toppageviewsperday`;
CREATE
  ALGORITHM = UNDEFINED
  VIEW `toppageviewsperday`
  AS
SELECT
  COUNT(`ip`) AS 'total', `date`
FROM
  `stats`
GROUP BY
  `date`
ORDER BY COUNT(`ip`) DESC;
