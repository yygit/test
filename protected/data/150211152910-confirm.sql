/*
MySQL Backup
Source Server Version: 5.5.25
Source Database: sakila
Date: 11.02.2015 15:29:11
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
--  Table structure for `confirm`
-- ----------------------------
DROP TABLE IF EXISTS `confirm`;
CREATE TABLE `confirm` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(128) NOT NULL,
  `code` varchar(64) NOT NULL,
  `isconfirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `confirm` VALUES ('1','prohor','12345','1'), ('2','prohor1','123','0');
