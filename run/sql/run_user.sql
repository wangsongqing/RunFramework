/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.5.53 : Database - run_user
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE `run_user`;

USE `run_user`;

/*Table structure for table `run_manage_log` */

DROP TABLE IF EXISTS `run_manage_log`;

CREATE TABLE `run_manage_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned NOT NULL,
  `admin_name` varchar(50) NOT NULL DEFAULT '',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `created` int(11) unsigned NOT NULL,
  `phone` varchar(11) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

/*Data for the table `run_manage_log` */

insert  into `run_manage_log`(`id`,`admin_id`,`admin_name`,`ip`,`created`,`phone`) values (1,3,'wsq','127.0.0.1',1495180195,'18201197922'),(2,3,'wsq','127.0.0.1',1495181581,'18201197922'),(3,1,'admin','127.0.0.1',1495420052,'18201197923'),(4,3,'wsq','127.0.0.1',1495420535,'18201197922'),(5,3,'wsq','127.0.0.1',1495436422,'18201197922'),(6,3,'wsq','127.0.0.1',1495453390,'18201197922'),(7,3,'wsq','127.0.0.1',1495453403,'18201197922'),(8,3,'wsq','127.0.0.1',1495453543,'18201197922'),(9,3,'wsq','127.0.0.1',1495620078,'18201197922'),(10,1,'admin','127.0.0.1',1495682515,'18201197923'),(11,1,'admin','127.0.0.1',1495682821,'18201197923'),(12,1,'admin','127.0.0.1',1496980391,'18201197923'),(13,1,'admin','127.0.0.1',1497234160,'18201197923'),(14,1,'admin','127.0.0.1',1497322523,'18201197923'),(24,1,'admin','127.0.0.1',1497410416,'18201197923'),(23,1,'admin','127.0.0.1',1497403907,'18201197923'),(25,1,'admin','127.0.0.1',1497491431,'18201197923'),(26,1,'admin','127.0.0.1',1499303288,'18201197923'),(27,1,'admin','127.0.0.1',1499323947,'18201197923'),(28,1,'admin','127.0.0.1',1499392440,'18201197923');

/*Table structure for table `run_manage_user` */

DROP TABLE IF EXISTS `run_manage_user`;

CREATE TABLE `run_manage_user` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `admin_name` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员帐号',
  `realname` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员真实姓名',
  `salt` varchar(6) DEFAULT NULL COMMENT '随机字段',
  `type` tinyint(1) unsigned NOT NULL COMMENT '后台类型  1管理后台，2运营后台，3财务后台',
  `mobile` varchar(11) DEFAULT NULL COMMENT '绑定电话',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属用户组ID',
  `group_name` varchar(24) NOT NULL DEFAULT '' COMMENT '所属用户组名',
  `operate_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作人ID',
  `operate_name` varchar(24) NOT NULL DEFAULT '' COMMENT '操作人用户名',
  `created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作时间',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '账户状态，0停用，1正常，-1锁定',
  `operation_time` int(10) DEFAULT '0' COMMENT '最后操作时间',
  `lock_reason` varchar(50) DEFAULT NULL COMMENT '锁定原因',
  `lock_time` int(10) unsigned DEFAULT NULL COMMENT '锁定时间',
  `unlock_time` int(10) unsigned DEFAULT NULL COMMENT '解锁时间',
  PRIMARY KEY (`admin_id`),
  KEY `uId` (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='后台用户表';

/*Data for the table `run_manage_user` */

insert  into `run_manage_user`(`admin_id`,`admin_name`,`realname`,`salt`,`type`,`mobile`,`password`,`group_id`,`group_name`,`operate_id`,`operate_name`,`created`,`status`,`operation_time`,`lock_reason`,`lock_time`,`unlock_time`) values (1,'admin','run222','vlgr',3,'18201197923','4ae38e51cef30061c496e9ebd74717bb',13,'财务后台_财务',1,'admin',1489630596,1,0,NULL,NULL,NULL),(6,'wsq','jimmy','fpjc',0,'15000000011','09da0d8e6c69a00b81ab156cc66b3a8b',0,'',0,'',1499394940,1,0,NULL,NULL,NULL);

