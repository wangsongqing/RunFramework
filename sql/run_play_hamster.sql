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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`run_user` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `run_user`;

/*Table structure for table `run_play_hamster` 打地鼠小游戏 */

DROP TABLE IF EXISTS `run_play_hamster`;

CREATE TABLE `run_play_hamster` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `telephone` char(11) NOT NULL COMMENT '用户手机号',
  `nick` varchar(64) NOT NULL DEFAULT '' COMMENT '宝宝昵称',
  `rounds` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '当前第几轮',
  `times` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '第几轮第几次',
  `sys_mouse_num` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '本轮最大地鼠数',
  `mouse_num` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '打中地鼠数',
  `baby_num` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '打中宝宝数',
  `score` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '实际得分数',
  `sub_score` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '提交分数',
  `pcapital` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '获得特权本金',
  `red` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '现金红包',
  `credit` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '宝贝豆',
  `is_extra` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '额外获得0否 1是',
  `is_receive` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否领取0否 1是',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `pcapital` (`pcapital`),
  KEY `created` (`created`)
) ENGINE=MyISAM AUTO_INCREMENT=1945982 DEFAULT CHARSET=utf8 COMMENT='打地鼠成绩记录表';

/*Data for the table `run_play_hamster` */

insert  into `run_play_hamster`(`id`,`user_id`,`telephone`,`nick`,`rounds`,`times`,`sys_mouse_num`,`mouse_num`,`baby_num`,`score`,`sub_score`,`pcapital`,`red`,`credit`,`is_extra`,`is_receive`,`created`,`updated`) values (0,9,'18408279143','和她',1,1,0,17,0,0,0,'85.00','0.00',0,0,0,1451279031,1451279031),(2,9,'18408279143','和她',1,2,0,21,0,0,0,'105.00','0.00',0,0,1,1451279129,1451279129),(3,29,'13408496093','言言',1,1,0,33,0,0,0,'165.00','0.00',0,0,1,1451279279,1451279279),(4,29,'13408496093','言言',1,2,0,31,0,0,0,'155.00','0.00',0,0,0,1451279326,1451279326),(5,10,'18581830303','小逗比',1,1,0,41,1,0,0,'195.00','0.00',0,0,1,1451279333,1451279333),(6,69414,'13508085537','小宝',1,1,0,14,0,0,0,'70.00','0.00',0,0,0,1451279435,1451279435),(7,60033,'18200356705','贝拉',1,1,0,22,0,0,0,'110.00','0.00',0,0,1,1451279441,1451279441),(8,69414,'13508085537','小宝',1,2,0,20,0,0,0,'100.00','0.00',0,0,1,1451279479,1451279479),(9,60033,'18200356705','贝拉',1,2,0,18,0,0,0,'90.00','0.00',0,0,0,1451279482,1451279482),(10,6,'13880530820','菩提',1,1,0,25,0,0,0,'125.00','0.00',0,0,0,1451279661,1451279661),(11,6,'13880530820','菩提',1,2,0,27,1,0,0,'125.00','0.00',0,0,1,1451279712,1451279712),(12,3,'13881839979','小超哥',1,1,0,35,1,0,0,'165.00','0.00',0,0,0,1451280599,1451280599),(13,3,'13881839979','小超哥',1,2,0,39,0,0,0,'195.00','0.00',0,0,1,1451280647,1451280647),(14,15,'13550123219','倪妮',1,1,0,33,1,0,0,'155.00','0.00',0,0,0,1451280929,1451280929),(15,19,'18628389546','萱萱',1,1,0,38,0,0,0,'190.00','0.00',0,0,1,1451280959,1451280959),(16,15,'13550123219','倪妮',1,2,0,35,0,0,0,'175.00','0.00',0,0,1,1451280974,1451280974),(17,13,'18683619832','源儿',1,1,0,36,0,0,0,'180.00','0.00',0,0,0,1451281007,1451281007),(18,19,'18628389546','萱萱',1,2,0,35,0,0,0,'175.00','0.00',0,0,0,1451281009,1451281009);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
