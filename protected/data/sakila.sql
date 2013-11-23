/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50525
Source Host           : localhost:3306
Source Database       : sakila

Target Server Type    : MYSQL
Target Server Version : 50525
File Encoding         : 65001

Date: 2013-11-23 19:13:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tbl_issue`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_issue`;
CREATE TABLE `tbl_issue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `project_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `requester_id` int(11) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_time` datetime DEFAULT NULL,
  `update_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_issue_project` (`project_id`),
  KEY `fk_issue_owner` (`owner_id`),
  KEY `fk_issue_requester` (`requester_id`),
  KEY `fk_issue_create_user` (`create_user_id`),
  KEY `fk_issue_update_user` (`update_user_id`),
  CONSTRAINT `fk_issue_create_user` FOREIGN KEY (`create_user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_issue_owner` FOREIGN KEY (`owner_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_issue_project` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_issue_requester` FOREIGN KEY (`requester_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_issue_update_user` FOREIGN KEY (`update_user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_issue
-- ----------------------------
INSERT INTO `tbl_issue` VALUES ('4', 'another issue', 'sdfasdf ', '4', '1', '2', '1', '3', '2013-11-21 12:29:14', '1', '2013-11-21 17:24:15', '2');
INSERT INTO `tbl_issue` VALUES ('5', 'fdgsdfh', 'sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy sdfhsdf uiyoiuyoiuy ', '4', '0', '0', '3', '1', '2013-11-21 12:42:45', '1', '2013-11-23 15:03:11', '1');
INSERT INTO `tbl_issue` VALUES ('6', 'issue ljkh ', 'added some lkjhlkjh  ', '6', '1', '1', '2', '1', '2013-11-23 15:05:02', '2', '2013-11-23 18:53:54', '2');
INSERT INTO `tbl_issue` VALUES ('7', 'issue another one ', 'lkjh', '6', '1', '1', '1', '1', '2013-11-23 15:05:56', '1', '2013-11-23 15:05:56', '1');
INSERT INTO `tbl_issue` VALUES ('8', 'nice name', 'ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff ffffffff 12345', '7', '1', '1', '2', '2', '2013-11-23 18:57:18', '2', '2013-11-23 19:00:06', '2');

-- ----------------------------
-- Table structure for `tbl_migration`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_migration`;
CREATE TABLE `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_migration
-- ----------------------------
INSERT INTO `tbl_migration` VALUES ('m000000_000000_base', '1384537482');
INSERT INTO `tbl_migration` VALUES ('m120509_224029_create_project_table_yy', '1385027335');
INSERT INTO `tbl_migration` VALUES ('m120511_173401_create_issue_user_and_assignment_tables_yy', '1385027335');
INSERT INTO `tbl_migration` VALUES ('m120511_173402_add_fk_to_project', '1385027335');
INSERT INTO `tbl_migration` VALUES ('m120511_173403_add_sample_data', '1385027335');

-- ----------------------------
-- Table structure for `tbl_project`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_project`;
CREATE TABLE `tbl_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_time` datetime DEFAULT NULL,
  `update_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_project_create_user` (`create_user_id`),
  KEY `fk_project_update_user` (`update_user_id`),
  CONSTRAINT `fk_project_create_user` FOREIGN KEY (`create_user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_project_update_user` FOREIGN KEY (`update_user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_project
-- ----------------------------
INSERT INTO `tbl_project` VALUES ('4', 'Project 1', 'description for project #1', null, '1', '2013-11-21 16:08:46', '1');
INSERT INTO `tbl_project` VALUES ('5', 'dadfgad ', 'asdgfasdg asdgasd ', '2013-11-22 20:00:50', '2', '2013-11-23 18:52:39', '2');
INSERT INTO `tbl_project` VALUES ('6', 'sdgfasdfg ', 'dfsgdfgsdfg ', '2013-11-22 20:10:38', '2', '2013-11-22 20:10:38', '2');
INSERT INTO `tbl_project` VALUES ('7', 'some some ', 'jkhgkjhgkjhgjhg ', '2013-11-23 18:56:10', '1', '2013-11-23 18:56:57', '2');

-- ----------------------------
-- Table structure for `tbl_project_user_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_project_user_assignment`;
CREATE TABLE `tbl_project_user_assignment` (
  `project_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`project_id`,`user_id`),
  KEY `fk_user_project` (`user_id`),
  CONSTRAINT `fk_project_user` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_user_project` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_project_user_assignment
-- ----------------------------
INSERT INTO `tbl_project_user_assignment` VALUES ('4', '1');
INSERT INTO `tbl_project_user_assignment` VALUES ('6', '1');
INSERT INTO `tbl_project_user_assignment` VALUES ('7', '1');
INSERT INTO `tbl_project_user_assignment` VALUES ('5', '2');
INSERT INTO `tbl_project_user_assignment` VALUES ('6', '2');
INSERT INTO `tbl_project_user_assignment` VALUES ('7', '2');
INSERT INTO `tbl_project_user_assignment` VALUES ('4', '3');
INSERT INTO `tbl_project_user_assignment` VALUES ('6', '3');

-- ----------------------------
-- Table structure for `tbl_user`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_time` datetime DEFAULT NULL,
  `update_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('1', 'admin', 'admin@sample.com', '21232f297a57a5a743894a0e4a801fc3', '0000-00-00 00:00:00', null, '1', '2013-11-21 17:26:14', '1');
INSERT INTO `tbl_user` VALUES ('2', 'demo', 'demo@sample.com', 'fe01ce2a7fbac8fafaed7c982a04e229', '0000-00-00 00:00:00', null, '2', '2013-11-23 18:51:39', '1');
INSERT INTO `tbl_user` VALUES ('3', 'user3', 'test3@notanaddress.com', '92877af70a45fd6a2ed7fe81e1236b78', null, null, '1', null, '1');
