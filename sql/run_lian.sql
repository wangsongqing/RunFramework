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

/*Table structure for table `run_lian` 连连看数据表结构和数据 */

DROP TABLE IF EXISTS `run_lian`;

CREATE TABLE `run_lian` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `telephone` char(11) NOT NULL COMMENT '用户手机号',
  `lian_num` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '连接图标个数',
  `is_floop` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0:未使用翻倍卡,1:使用翻倍卡',
  `score` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '本次连连看获得分数',
  `nick` varchar(20) NOT NULL DEFAULT '' COMMENT '用户的昵称',
  `pcapital` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '成长金金额',
  `red_bag` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '现金红包金额',
  `credit` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '宝贝豆',
  `red_invest` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '投资红包金额',
  `join_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '参与类型 0免费 1充值 2邀请',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `created` (`created`),
  KEY `join_type` (`join_type`),
  KEY `score` (`score`)
) ENGINE=InnoDB AUTO_INCREMENT=512 DEFAULT CHARSET=utf8 COMMENT='连连看游戏参与记录表';

/*Data for the table `run_lian` */

insert  into `run_lian`(`id`,`user_id`,`telephone`,`lian_num`,`is_floop`,`score`,`nick`,`pcapital`,`red_bag`,`credit`,`red_invest`,`join_type`,`created`,`updated`) values (407,1065777,'18201197923',20000,0,75000,'小松','0.00','10.05',0,'5.00',0,1509514186,1509514186),(408,1065777,'18201197923',20000,0,75000,'小松','0.00','10.05',0,'55.00',0,1509514242,1509514242),(409,1065777,'18201197923',2,0,8,'小松','0.00','0.01',0,'5.00',0,1509525499,1509525499),(410,1065777,'18201197923',1,0,3,'小松','0.00','0.00',0,'55.00',0,1509526999,1509526999),(411,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'5.00',0,1509528644,1509528644),(412,1065777,'18201197923',3,0,8,'小松','0.00','0.01',0,'55.00',0,1509528797,1509528797),(413,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'55.00',0,1509595047,1509595047),(414,1065777,'18201197923',6,0,15,'小松','0.00','0.02',0,'5.00',0,1509595114,1509595114),(415,1065777,'18201197923',2,0,5,'小松','0.00','0.01',0,'5.00',0,1509600109,1509600109),(416,1065777,'18201197923',2,0,5,'小松','0.00','0.00',0,'5.00',0,1509600344,1509600344),(417,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'5.00',0,1509614439,1509614439),(418,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'5.00',0,1509615886,1509615886),(419,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'55.00',0,1509679256,1509679256),(420,1065777,'18201197923',0,0,0,'小松','0.00','0.00',0,'5.00',0,1509679299,1509679299),(421,1065777,'18201197923',3,0,7,'小松','0.00','0.00',0,'5.00',0,1509680719,1509680719),(422,1065777,'18201197923',5,0,12,'小松','0.00','0.01',0,'5.00',0,1509680790,1509680790),(423,1065777,'18201197923',0,0,0,'小松','0.00','0.00',0,'55.00',0,1509686641,1509686641),(424,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'5.00',0,1509691565,1509691565),(425,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'5.00',0,1509691733,1509691733),(426,1065777,'18201197923',6,0,15,'小松','0.00','0.02',0,'55.00',1,1509696024,1509696024),(427,1065777,'18201197923',3,0,7,'小松','0.00','0.00',0,'5.00',1,1509696427,1509696427),(428,1066056,'18201197924',8,0,20,'小宝','0.00','0.02',0,'5.00',0,1509696536,1509696536),(429,1066056,'18201197924',7,0,17,'小宝','0.00','0.02',0,'55.00',2,1509697095,1509697095),(430,1066056,'18201197924',5,0,12,'小宝','0.00','0.01',0,'55.00',2,1509697291,1509697291),(431,1066101,'18201197935',5,0,12,'','0.00','0.01',0,'55.00',0,1509697501,1509697501),(432,1065777,'18201197923',6,0,15,'小松','0.00','0.02',0,'5.00',0,1509936000,1509936000),(433,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'5.00',3,1509936080,1509936080),(434,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'5.00',3,1509940349,1509940349),(435,1065777,'18201197923',0,0,0,'小松','0.00','0.00',0,'5.00',3,1509940371,1509940371),(436,1065777,'18201197923',5,0,12,'小松','0.00','0.01',0,'5.00',3,1509940508,1509940508),(437,1065777,'18201197923',6,0,15,'小松','0.00','0.02',0,'5.00',3,1509940631,1509940631),(438,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'5.00',3,1509945832,1509945832),(439,1065777,'18201197923',7,0,17,'小松','0.00','0.02',0,'5.00',3,1509946174,1509946174),(440,1065777,'18201197923',7,0,17,'小松','0.00','0.02',0,'55.00',0,1509946455,1509946455),(441,1065777,'18201197923',2,0,5,'小松','0.00','0.00',0,'5.00',0,1509946480,1509946480),(442,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'5.00',0,1509948413,1509948413),(443,1065777,'18201197923',7,0,17,'小松','0.00','0.02',0,'55.00',0,1509948892,1509948892),(444,1065777,'18201197923',1,0,2,'小松','0.00','0.00',0,'5.00',0,1509948955,1509948955),(445,1065777,'18201197923',3,0,7,'小松','0.00','0.00',0,'5.00',0,1509949045,1509949045),(446,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'55.00',3,1509949187,1509949187),(447,1065777,'18201197923',5,0,12,'小松','0.00','0.01',0,'5.00',3,1509949253,1509949253),(448,1065777,'18201197923',5,0,12,'小松','0.00','0.01',0,'5.00',3,1509949424,1509949424),(449,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'55.00',3,1509949526,1509949526),(450,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'55.00',0,1509953071,1509953071),(451,1065777,'18201197923',2,1,7,'小松','0.00','0.00',0,'5.00',0,1509957635,1509957635),(452,1065777,'18201197923',27,1,100,'小松','0.00','0.10',0,'5.00',0,1509958109,1509958109),(453,1065777,'18201197923',0,0,0,'小松','0.00','0.00',0,'55.00',0,1510017877,1510017877),(454,1065777,'18201197923',1,0,2,'小松','0.00','0.00',0,'5.00',0,1510018072,1510018072),(455,1065777,'18201197923',2,0,5,'小松','0.00','0.00',0,'5.00',0,1510018347,1510018347),(456,1065777,'18201197923',2,0,5,'小松','0.00','0.00',0,'55.00',0,1510018354,1510018354),(457,1065777,'18201197923',2,0,5,'小松','0.00','0.00',0,'55.00',0,1510018404,1510018404),(458,1065777,'18201197923',1,0,2,'小松','0.00','0.00',0,'5.00',0,1510018549,1510018549),(459,1065777,'18201197923',2,0,5,'小松','0.00','0.00',0,'5.00',0,1510018748,1510018748),(460,1065777,'18201197923',5,0,12,'小松','0.00','0.01',0,'55.00',0,1510018788,1510018788),(461,973535,'18628389500',7,0,17,'qwe','0.00','0.02',0,'5.00',0,1510022981,1510022981),(462,1065777,'18201197923',5,0,12,'小松','0.00','0.01',0,'5.00',0,1510025860,1510025860),(463,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'5.00',0,1510026449,1510026449),(464,973529,'18628050520',8,0,20,'ds','0.00','0.02',0,'5.00',0,1510032090,1510032090),(465,973529,'18628050520',5,0,12,'ds','0.00','0.01',0,'5.00',0,1510032218,1510032218),(466,973529,'18628050520',4,0,10,'ds','0.00','0.01',0,'5.00',0,1510032237,1510032237),(467,973529,'18628050520',6,0,15,'ds','0.00','0.02',0,'5.00',0,1510032846,1510032846),(468,973529,'18628050520',9,0,22,'ds','0.00','0.02',0,'5.00',0,1510032864,1510032864),(469,973535,'18628389500',3,0,7,'qwe','0.00','0.00',0,'5.00',0,1510037158,1510037158),(470,1065777,'18201197923',1,0,2,'小松','0.00','0.00',0,'5.00',0,1510040253,1510040253),(471,1065777,'18201197923',6,0,15,'小松','0.00','0.02',0,'2.00',0,1510041277,1510041277),(472,1065777,'18201197923',8,0,20,'小松','0.00','0.02',0,'2.00',0,1510041303,1510041303),(473,1065777,'18201197923',3,0,7,'小松','0.00','0.00',0,'2.00',0,1510041527,1510041527),(474,1065777,'18201197923',3,0,7,'小松','0.00','0.00',0,'2.00',0,1510041782,1510041782),(475,1065777,'18201197923',5,0,12,'小松','0.00','0.01',0,'2.00',1,1510041957,1510041957),(476,1065777,'18201197923',3,0,7,'小松','0.00','0.00',0,'2.00',2,1510042061,1510042061),(477,1065777,'18201197923',4,0,10,'小松','0.00','0.01',0,'5.00',0,1510044363,1510044363),(478,1065777,'18201197923',7,0,17,'小松','0.00','0.02',0,'2.00',0,1510044476,1510044476),(479,1066112,'18201197936',2,0,5,'','0.00','0.00',0,'2.00',0,1510044525,1510044525),(480,1066112,'18201197936',4,0,10,'','0.00','0.01',0,'55.00',0,1510044565,1510044565),(481,973529,'18628050520',5,0,12,'ds','0.00','0.01',0,'55.00',0,1510044823,1510044823),(482,1066112,'18201197936',1,0,2,'','0.00','0.00',0,'2.00',0,1510045755,1510045755),(483,1066112,'18201197936',3,0,7,'','0.00','0.00',0,'2.00',0,1510046012,1510046012),(484,1066112,'18201197936',2,0,5,'','0.00','0.00',0,'5.00',0,1510047171,1510047171),(485,1066112,'18201197936',3,0,7,'','0.00','0.00',0,'5.00',0,1510047206,1510047206),(486,1065777,'18201197923',6,0,15,'小松','0.00','0.02',0,'5.00',3,1510048016,1510048016),(487,1065777,'18201197923',6,0,15,'小松','0.00','0.02',0,'5.00',0,1510109380,1510109380),(488,1065777,'18201197923',3,0,7,'小松','0.00','0.00',0,'0.00',0,1510222419,1510222419),(489,1065777,'18201197923',4,0,10,'小松','10.00','0.01',0,'0.00',0,1510222576,1510222576),(490,1065777,'18201197923',4,0,10,'小松','10.00','0.00',0,'0.00',0,1510222888,1510222888),(491,1065777,'18201197923',3,0,7,'小松','7.00','7.00',7,'0.00',0,1510223250,1510223250),(492,1065777,'18201197923',2,0,5,'小松','5.00','5.00',5,'0.00',0,1510223426,1510223426),(493,1065777,'18201197923',3,0,7,'小松','0.00','7.00',7,'0.00',0,1510223517,1510223517),(494,973529,'18628050520',0,0,0,'ds','0.00','0.00',0,'55.00',0,1510724968,1510724968),(495,973529,'18628050520',2,0,5,'ds','0.00','5.00',1605,'0.00',0,1510734383,1510734383),(496,973529,'18628050520',3,0,8,'ds','0.00','8.00',2568,'0.00',0,1510734593,1510734593),(497,973529,'18628050520',6,0,16,'ds','0.00','16.00',5136,'0.00',0,1510734668,1510734668),(498,973529,'18628050520',4,0,10,'ds','0.00','10.00',3210,'0.00',0,1510734701,1510734701),(499,973529,'18628050520',4,0,10,'ds','0.00','10.00',3210,'0.00',0,1510734719,1510734719),(500,973529,'18628050520',9,0,24,'ds','0.00','24.00',7704,'0.00',0,1510734735,1510734735),(501,973529,'18628050520',6,0,16,'ds','0.00','16.00',5136,'0.00',0,1510734751,1510734751),(502,1066019,'15208430592',5,0,13,'erb','0.00','13.00',0,'55.00',0,1510738787,1510738787),(503,1066019,'15208430592',5,0,13,'erb','0.00','13.00',4173,'0.00',0,1510738805,1510738805),(504,973529,'18628050520',2,0,5,'ds','0.00','5.00',1605,'0.00',0,1510741685,1510741685),(505,973529,'18628050520',4,0,10,'ds','0.00','10.00',3210,'0.00',0,1510741702,1510741702),(506,973529,'18628050520',4,0,10,'ds','0.00','10.00',3210,'0.00',0,1510741718,1510741718),(507,973529,'18628050520',3,0,8,'ds','0.00','8.00',2568,'0.00',0,1510741928,1510741928),(508,973529,'18628050520',7,0,14,'ds','0.00','16.80',0,'10.00',0,1511316638,1511316638),(509,973529,'18628050520',4,0,8,'ds','0.00','9.60',2568,'0.00',0,1511317445,1511317445),(510,973540,'15828352340',3,0,6,'小宝呼啦','0.00','7.20',0,'20.00',3,1512026752,1512026752),(511,1065728,'13333666111',2,0,4,'小宝','0.00','4.80',0,'55.00',3,1512093174,1512093174);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
