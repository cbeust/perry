-- MySQL dump 10.11
--
-- Host: db63a.pair.com    Database: cedric_logs
-- ------------------------------------------------------
-- Server version	5.0.89-log

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
-- Table structure for table `cycles`
--

DROP TABLE IF EXISTS `cycles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cycles` (
  `number` int(11) NOT NULL default '0',
  `german_title` varchar(80) default NULL,
  `english_title` varchar(80) default NULL,
  `short_title` varchar(40) default NULL,
  `start` int(11) default NULL,
  `end` int(11) default NULL,
  PRIMARY KEY  (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `hefte`
--

DROP TABLE IF EXISTS `hefte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hefte` (
  `number` int(11) NOT NULL default '0',
  `title` varchar(80) default NULL,
  `author` varchar(60) default NULL,
  `published` date default NULL,
  PRIMARY KEY  (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `date` varchar(30) NOT NULL default '',
  `testng` int(11) default NULL,
  `testng_dl` int(11) default NULL,
  `ejbgen` int(11) default NULL,
  `ejbgen_dl` int(11) default NULL,
  `weblog` int(11) default NULL,
  `weblog_rss` int(11) default NULL,
  `weblog_html` int(11) default NULL,
  `perry` int(11) default NULL,
  `testng_eclipse_dl` int(11) default NULL,
  `testng_eclipse_dl2` int(11) default NULL,
  PRIMARY KEY  (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pending`
--

DROP TABLE IF EXISTS `pending`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pending` (
  `id` int(11) NOT NULL auto_increment,
  `number` int(11) default NULL,
  `german_title` varchar(80) default NULL,
  `author` varchar(60) default NULL,
  `published` varchar(60) default NULL,
  `english_title` varchar(80) default NULL,
  `author_name` varchar(60) default NULL,
  `author_email` varchar(60) default NULL,
  `date_summary` varchar(40) default NULL,
  `summary` mediumtext,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `summaries`
--

DROP TABLE IF EXISTS `summaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `summaries` (
  `number` int(11) NOT NULL default '0',
  `english_title` varchar(80) default NULL,
  `author_name` varchar(60) default NULL,
  `author_email` varchar(60) default NULL,
  `date` varchar(40) default NULL,
  `summary` mediumtext,
  `time` varchar(20) default NULL,
  PRIMARY KEY  (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `t`
--

DROP TABLE IF EXISTS `t`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t` (
  `number` int(11) NOT NULL default '0',
  `date` varchar(40) default NULL,
  `time` varchar(40) default NULL,
  `t` varchar(20) default NULL,
  PRIMARY KEY  (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `login` varchar(40),
  `name` varchar(80),
  `level` int(2) default 5,
  `email` varchar(60),
  PRIMARY KEY  (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dump completed on 2010-01-31 20:43:40
