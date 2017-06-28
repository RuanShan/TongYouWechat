-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 06 月 28 日 21:10
-- 服务器版本: 5.5.40
-- PHP 版本: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `tongyouerweimasaomiao`
--

-- --------------------------------------------------------

--
-- 表的结构 `think_auth_group`
--

CREATE TABLE IF NOT EXISTS `think_auth_group` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `think_auth_group`
--

INSERT INTO `think_auth_group` (`id`, `title`, `status`, `rules`) VALUES
(1, '客户', 1, ''),
(2, '工程师', 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `think_auth_group_access`
--

CREATE TABLE IF NOT EXISTS `think_auth_group_access` (
  `uid` int(10) unsigned NOT NULL,
  `group_id` tinyint(3) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_auth_group_access`
--

INSERT INTO `think_auth_group_access` (`uid`, `group_id`) VALUES
(2, 1),
(3, 2);

-- --------------------------------------------------------

--
-- 表的结构 `think_auth_rule`
--

CREATE TABLE IF NOT EXISTS `think_auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `think_config`
--

CREATE TABLE IF NOT EXISTS `think_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '平台名称',
  `keywords` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '平台关键词',
  `description` varchar(600) CHARACTER SET utf8 NOT NULL COMMENT '平台描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='全局配置表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `think_config`
--

INSERT INTO `think_config` (`id`, `name`, `keywords`, `description`) VALUES
(1, '大连童游科技', '大连童游科技', '大连童游科技');

-- --------------------------------------------------------

--
-- 表的结构 `think_machine`
--

CREATE TABLE IF NOT EXISTS `think_machine` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) NOT NULL COMMENT '微信openid',
  `customer_id` int(11) NOT NULL COMMENT '客户id',
  `engineer_id` int(11) NOT NULL COMMENT '工程师id',
  `machine_id` varchar(30) NOT NULL COMMENT '机器id',
  `permanent_code` varchar(50) NOT NULL COMMENT '永久码',
  `temporary_code` varchar(50) NOT NULL COMMENT '临时码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='机器码表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `think_machine`
--

INSERT INTO `think_machine` (`id`, `openid`, `customer_id`, `engineer_id`, `machine_id`, `permanent_code`, `temporary_code`) VALUES
(1, '', 2, 3, '45678', '44545454545', '44545454545');

-- --------------------------------------------------------

--
-- 表的结构 `think_member`
--

CREATE TABLE IF NOT EXISTS `think_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(15) CHARACTER SET utf8 NOT NULL COMMENT '用户名',
  `password` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '密码',
  `telephone` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '电话',
  `login_ip` varchar(15) CHARACTER SET utf8 NOT NULL COMMENT '登录ip',
  `login_time` datetime NOT NULL COMMENT '登录时间',
  `login_count` int(11) NOT NULL COMMENT '登录次数',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='用户表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `think_member`
--

INSERT INTO `think_member` (`id`, `username`, `password`, `telephone`, `login_ip`, `login_time`, `login_count`, `status`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '', '0.0.0.0', '2017-06-27 21:18:52', 63, 1),
(2, '张三', '', '13245656789', '', '0000-00-00 00:00:00', 0, 1),
(3, '王五', '', '1345456767', '', '0000-00-00 00:00:00', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
