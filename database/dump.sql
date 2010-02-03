-- MySQL dump 10.11
--
-- Host: localhost    Database: bald4thecure_dev
-- ------------------------------------------------------
-- Server version	5.0.75-0ubuntu10.2

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
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `cities` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city_leaderboards`
--

DROP TABLE IF EXISTS `city_leaderboards`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_leaderboards` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `city` varchar(255) NOT NULL,
  `total` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `city_leaderboards`
--

LOCK TABLES `city_leaderboards` WRITE;
/*!40000 ALTER TABLE `city_leaderboards` DISABLE KEYS */;
/*!40000 ALTER TABLE `city_leaderboards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city_leaderboards_loading`
--

DROP TABLE IF EXISTS `city_leaderboards_loading`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_leaderboards_loading` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `city` varchar(255) NOT NULL,
  `total` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `city_leaderboards_loading`
--

LOCK TABLES `city_leaderboards_loading` WRITE;
/*!40000 ALTER TABLE `city_leaderboards_loading` DISABLE KEYS */;
/*!40000 ALTER TABLE `city_leaderboards_loading` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `photos` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `user_id` smallint(5) unsigned NOT NULL,
  `type` char(4) NOT NULL,
  `url` varchar(255) NOT NULL,
  `width` smallint(5) unsigned NOT NULL,
  `height` smallint(5) unsigned NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `page` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `users_id_fk` (`user_id`),
  CONSTRAINT `users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `photos`
--

LOCK TABLES `photos` WRITE;
/*!40000 ALTER TABLE `photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pledges`
--

DROP TABLE IF EXISTS `pledges`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `pledges` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `user_id` smallint(5) unsigned default NULL,
  `shaver_user_id` smallint(5) unsigned NOT NULL,
  `amount` smallint(5) unsigned NOT NULL,
  `reason` varchar(140) default NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `fk1` (`shaver_user_id`),
  CONSTRAINT `fk1` FOREIGN KEY (`shaver_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `pledges`
--

LOCK TABLES `pledges` WRITE;
/*!40000 ALTER TABLE `pledges` DISABLE KEYS */;
/*!40000 ALTER TABLE `pledges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recruits`
--

DROP TABLE IF EXISTS `recruits`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `recruits` (
  `recruiter` smallint(5) unsigned NOT NULL,
  `recruitee` smallint(5) unsigned NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`recruiter`,`recruitee`),
  KEY `recruits_recruitee` (`recruitee`),
  CONSTRAINT `recruits_recruitee` FOREIGN KEY (`recruitee`) REFERENCES `users` (`id`),
  CONSTRAINT `recruits_user_fk` FOREIGN KEY (`recruiter`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `recruits`
--

LOCK TABLES `recruits` WRITE;
/*!40000 ALTER TABLE `recruits` DISABLE KEYS */;
/*!40000 ALTER TABLE `recruits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_pledge_leaderboards`
--

DROP TABLE IF EXISTS `user_pledge_leaderboards`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_pledge_leaderboards` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `user_id` smallint(5) unsigned NOT NULL,
  `total` smallint(5) unsigned NOT NULL,
  `city_id` smallint(5) unsigned NOT NULL,
  `username` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id_loading_fk` (`user_id`),
  CONSTRAINT `user_id_loading_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user_pledge_leaderboards`
--

LOCK TABLES `user_pledge_leaderboards` WRITE;
/*!40000 ALTER TABLE `user_pledge_leaderboards` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_pledge_leaderboards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_pledge_leaderboards_loading`
--

DROP TABLE IF EXISTS `user_pledge_leaderboards_loading`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_pledge_leaderboards_loading` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `user_id` smallint(5) unsigned NOT NULL,
  `total` smallint(5) unsigned NOT NULL,
  `city_id` smallint(5) unsigned NOT NULL,
  `username` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id_fk` (`user_id`),
  CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user_pledge_leaderboards_loading`
--

LOCK TABLES `user_pledge_leaderboards_loading` WRITE;
/*!40000 ALTER TABLE `user_pledge_leaderboards_loading` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_pledge_leaderboards_loading` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_recruit_leaderboards`
--

DROP TABLE IF EXISTS `user_recruit_leaderboards`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_recruit_leaderboards` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `user_id` smallint(5) unsigned NOT NULL,
  `total` smallint(5) unsigned NOT NULL,
  `city_id` smallint(5) unsigned NOT NULL,
  `username` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  PRIMARY KEY  USING BTREE (`id`),
  KEY `user_id_fk` USING BTREE (`user_id`),
  CONSTRAINT `user_recruit_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user_recruit_leaderboards`
--

LOCK TABLES `user_recruit_leaderboards` WRITE;
/*!40000 ALTER TABLE `user_recruit_leaderboards` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_recruit_leaderboards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_recruit_leaderboards_loading`
--

DROP TABLE IF EXISTS `user_recruit_leaderboards_loading`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_recruit_leaderboards_loading` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `user_id` smallint(5) unsigned NOT NULL,
  `total` smallint(5) unsigned NOT NULL,
  `city_id` smallint(5) unsigned NOT NULL,
  `username` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  PRIMARY KEY  USING BTREE (`id`),
  KEY `user_id_fk` USING BTREE (`user_id`),
  CONSTRAINT `user_recruit_load_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user_recruit_leaderboards_loading`
--

LOCK TABLES `user_recruit_leaderboards_loading` WRITE;
/*!40000 ALTER TABLE `user_recruit_leaderboards_loading` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_recruit_leaderboards_loading` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `users` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `username` varchar(80) NOT NULL,
  `twitter_id` int(10) unsigned NOT NULL,
  `name` varchar(80) NOT NULL,
  `city` varchar(80) NOT NULL,
  `avatar` varchar(255) default NULL,
  `twitter_oauth_token` varchar(255) default NULL,
  `twitter_oauth_token_secret` varchar(255) default NULL,
  `pledges_total` int(10) unsigned NOT NULL default '0',
  `city_id` smallint(5) unsigned NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_friends`
--

DROP TABLE IF EXISTS `users_friends`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `users_friends` (
  `user_id` smallint(5) unsigned NOT NULL,
  `friend_user_id` smallint(5) unsigned default NULL,
  `friend_twitter_id` int(10) unsigned NOT NULL,
  `friend_username` varchar(80) NOT NULL,
  PRIMARY KEY  (`user_id`,`friend_twitter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `users_friends`
--

LOCK TABLES `users_friends` WRITE;
/*!40000 ALTER TABLE `users_friends` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_friends` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-02-03  3:11:49
