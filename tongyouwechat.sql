-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: tongyou_wechat_dev
-- ------------------------------------------------------
-- Server version	5.7.11

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
-- Table structure for table `wx_auth_group`
--

DROP TABLE IF EXISTS `wx_auth_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wx_auth_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_auth_group`
--

LOCK TABLES `wx_auth_group` WRITE;
/*!40000 ALTER TABLE `wx_auth_group` DISABLE KEYS */;
INSERT INTO `wx_auth_group` (`id`, `title`, `status`, `rules`) VALUES (1,'客户',1,''),(2,'工程师',1,'');
/*!40000 ALTER TABLE `wx_auth_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wx_auth_group_access`
--

DROP TABLE IF EXISTS `wx_auth_group_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wx_auth_group_access` (
  `uid` int(10) unsigned NOT NULL,
  `group_id` tinyint(3) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_auth_group_access`
--

LOCK TABLES `wx_auth_group_access` WRITE;
/*!40000 ALTER TABLE `wx_auth_group_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `wx_auth_group_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wx_auth_rule`
--

DROP TABLE IF EXISTS `wx_auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wx_auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_auth_rule`
--

LOCK TABLES `wx_auth_rule` WRITE;
/*!40000 ALTER TABLE `wx_auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `wx_auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wx_category`
--

DROP TABLE IF EXISTS `wx_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wx_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) DEFAULT NULL,
  `desc` text,
  `position` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_category`
--

LOCK TABLES `wx_category` WRITE;
/*!40000 ALTER TABLE `wx_category` DISABLE KEYS */;
INSERT INTO `wx_category` (`id`, `title`, `desc`, `position`) VALUES (1,'魔法砸球系列1','添加一些描述信息试试，更多\r\n更多行\r\n更更多',1),(2,'炫彩滑梯系列',NULL,2),(3,'幻境沙海系列',NULL,3),(4,'炫酷地带系列',NULL,4),(5,'妙笔涂鸦系列',NULL,5),(6,'动感蹦床系列',NULL,6),(7,'互动攀岩系列',NULL,7),(8,'索套英雄团系列','this is test2',8),(9,'测试分类',NULL,10);
/*!40000 ALTER TABLE `wx_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wx_config`
--

DROP TABLE IF EXISTS `wx_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wx_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '平台名称',
  `keywords` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '平台关键词',
  `description` varchar(600) CHARACTER SET utf8 NOT NULL COMMENT '平台描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk COMMENT='全局配置表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_config`
--

LOCK TABLES `wx_config` WRITE;
/*!40000 ALTER TABLE `wx_config` DISABLE KEYS */;
INSERT INTO `wx_config` (`id`, `name`, `keywords`, `description`) VALUES (1,'大连童游科技','大连童游科技','大连童游科技');
/*!40000 ALTER TABLE `wx_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wx_doctrine_cache`
--

DROP TABLE IF EXISTS `wx_doctrine_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wx_doctrine_cache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(256) DEFAULT NULL,
  `data` varchar(1024) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_doctrine_cache`
--

LOCK TABLES `wx_doctrine_cache` WRITE;
/*!40000 ALTER TABLE `wx_doctrine_cache` DISABLE KEYS */;
INSERT INTO `wx_doctrine_cache` (`id`, `label`, `data`, `lifetime`, `created_at`) VALUES (83,'overtrue.wechat.jsapi_ticket.wxc4a9b776dfa6840d','HoagFKDcsGMVCIY2vOjf9h6kfgXGan1DGJJkF_YRXJ1ifMk0bvWpmuQs7nZJhfNQ_Wz4fxIYAIF3On8K0TjkCA',6700,1499991417),(82,'easywechat.common.access_token.wxc4a9b776dfa6840d','6eq-alHjeyJ0A_NsaWTyy_vgLt90ce-7RT5tVEyG0-thyNG1EJRqeNzYv_GIXCOUroYUFRIURfMs0vc6-X5V9FNbNxxFP3-kcP52zY0iFF8Q1xxCBuKcr67HwibygO7DPGViAIAFWL',5700,1499991349);
/*!40000 ALTER TABLE `wx_doctrine_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wx_machine`
--

DROP TABLE IF EXISTS `wx_machine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wx_machine` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) NOT NULL COMMENT '微信openid',
  `customer_id` int(11) NOT NULL COMMENT '客户id',
  `engineer_id` int(11) NOT NULL COMMENT '工程师id',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `machine_code` varchar(128) NOT NULL COMMENT '机器id',
  `permanent_code` varchar(50) NOT NULL COMMENT '永久码',
  `temporary_code` varchar(50) NOT NULL COMMENT '临时码',
  `pactivated_by` int(11) NOT NULL DEFAULT '0',
  `pactivated_at` datetime DEFAULT NULL,
  `tactivated_by` int(11) NOT NULL DEFAULT '0',
  `tactivated_at` datetime DEFAULT NULL,
  `created_at` int(11) DEFAULT '0' COMMENT '工程师扫码计数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=gbk COMMENT='机器码表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_machine`
--

LOCK TABLES `wx_machine` WRITE;
/*!40000 ALTER TABLE `wx_machine` DISABLE KEYS */;
/*!40000 ALTER TABLE `wx_machine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wx_member`
--

DROP TABLE IF EXISTS `wx_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wx_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(15) CHARACTER SET utf8 NOT NULL COMMENT '用户名',
  `password` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '密码',
  `telephone` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '电话',
  `login_ip` varchar(15) CHARACTER SET utf8 NOT NULL COMMENT '登录ip',
  `login_time` datetime NOT NULL COMMENT '登录时间',
  `login_count` int(11) NOT NULL COMMENT '登录次数',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `address` varchar(256) DEFAULT NULL,
  `openid` varchar(128) DEFAULT NULL,
  `headimgurl` varchar(128) DEFAULT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=gbk COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_member`
--

LOCK TABLES `wx_member` WRITE;
/*!40000 ALTER TABLE `wx_member` DISABLE KEYS */;
INSERT INTO `wx_member` (`id`, `username`, `password`, `telephone`, `login_ip`, `login_time`, `login_count`, `status`, `address`, `openid`, `headimgurl`, `group_id`) VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e','','127.0.0.1','2017-07-10 21:50:20',68,1,NULL,NULL,NULL,0),(2,'test','','13312345678','127.0.0.1','2017-07-12 14:22:12',3,1,'','','',1),(32,'韓梦羚✨✨','','15942603481','127.0.0.1','2017-07-13 14:52:26',2,1,'中国辽宁大连','oO3rq1HbgyEoto6H1Pt_G-b7-xzc','http://wx.qlogo.cn/mmhead/Q3auHgzwzM5B4y9DWTiaLoTJEYtVAfmbfowvibx4uroIsCuwcekrZq3g/0',1),(31,'云','','18941119918','127.0.0.1','2017-07-13 15:53:57',2,1,'中国辽宁大连','oO3rq1I6d-pSbXK_a5WQZImz_zMU','http://wx.qlogo.cn/mmopen/bzZ0Qq6Jbmq8LJfKic9pPqzP1qC43Nw30OaSJNSuiaiaQVGfttItUauDFq9eyXlzHicXRQ85eGpZicT3gliaNNQRjApq9R1pfWY7B1',1);
/*!40000 ALTER TABLE `wx_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wx_order`
--

DROP TABLE IF EXISTS `wx_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wx_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL DEFAULT '0',
  `machine_id` varchar(45) DEFAULT NULL,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品分类ID，便于查找产品的名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wx_order`
--

LOCK TABLES `wx_order` WRITE;
/*!40000 ALTER TABLE `wx_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `wx_order` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-14  8:52:03
