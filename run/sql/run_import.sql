/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.5.53 : Database - run_import
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE `run_import`;

USE `run_import`;

/*Table structure for table `run_import_user` */

DROP TABLE IF EXISTS `run_import_user`;

CREATE TABLE `run_import_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `age` int(11) NOT NULL,
  `addr` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `run_import_user` */

insert  into `run_import_user`(`id`,`name`,`age`,`addr`) values (1,'jimmy',20,'beijing'),(2,'jimmy',20,'beijing'),(3,'jimmy',20,'beijing'),(4,'jimmy',20,'beijing');

