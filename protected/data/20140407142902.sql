/*
MySQL Backup
Source Server Version: 5.5.25
Source Database: sakila
Date: 07.04.2014 14:29:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
--  Table structure for `car`
-- ----------------------------
DROP TABLE IF EXISTS `car`;
CREATE TABLE `car` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `task`
-- ----------------------------
DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `done` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `tbl_auth_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_auth_assignment`;
CREATE TABLE `tbl_auth_assignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` int(11) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `fk_auth_assignment_userid` (`userid`),
  CONSTRAINT `fk_auth_assignment_itemname` FOREIGN KEY (`itemname`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_auth_assignment_userid` FOREIGN KEY (`userid`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tbl_auth_item`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_auth_item`;
CREATE TABLE `tbl_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tbl_auth_item_child`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_auth_item_child`;
CREATE TABLE `tbl_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `fk_auth_item_child_child` (`child`),
  CONSTRAINT `fk_auth_item_child_child` FOREIGN KEY (`child`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_auth_item_child_parent` FOREIGN KEY (`parent`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tbl_comment`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_comment`;
CREATE TABLE `tbl_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `issue_id` int(11) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comment_issue` (`issue_id`),
  KEY `fk_comment_owner` (`create_user_id`),
  KEY `fk_comment_update_user` (`update_user_id`),
  CONSTRAINT `fk_comment_issue` FOREIGN KEY (`issue_id`) REFERENCES `tbl_issue` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_comment_owner` FOREIGN KEY (`create_user_id`) REFERENCES `tbl_user` (`id`),
  CONSTRAINT `fk_comment_update_user` FOREIGN KEY (`update_user_id`) REFERENCES `tbl_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tbl_issue`
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tbl_migration`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_migration`;
CREATE TABLE `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `tbl_project`
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
  `completed` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_project_create_user` (`create_user_id`),
  KEY `fk_project_update_user` (`update_user_id`),
  CONSTRAINT `fk_project_create_user` FOREIGN KEY (`create_user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_project_update_user` FOREIGN KEY (`update_user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tbl_project_user_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_project_user_assignment`;
CREATE TABLE `tbl_project_user_assignment` (
  `project_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `role` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`project_id`,`user_id`),
  KEY `fk_user_project` (`user_id`),
  KEY `fk_project_user_role` (`role`),
  CONSTRAINT `fk_project_user` FOREIGN KEY (`project_id`) REFERENCES `tbl_project` (`id`),
  CONSTRAINT `fk_project_user_role` FOREIGN KEY (`role`) REFERENCES `tbl_auth_item` (`name`) ON UPDATE CASCADE,
  CONSTRAINT `fk_user_project` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tbl_sys_message`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_sys_message`;
CREATE TABLE `tbl_sys_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sys_message_owner` (`create_user_id`),
  KEY `fk_sys_message_update_user` (`update_user_id`),
  KEY `idx_sys_message_update_time` (`update_time`),
  CONSTRAINT `fk_sys_message_owner` FOREIGN KEY (`create_user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_sys_message_update_user` FOREIGN KEY (`update_user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `tbl_user`
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `car` VALUES ('1','Ford Focus','FamilyCar'), ('2','Opel Astra','FamilyCar'), ('3','Kia Ceed','FamilyCar'), ('4','Porsche Boxster','SportCar'), ('5','Ferrari 550','SportCar'), ('6','Ford Focus','FamilyCar'), ('7','Opel Astra','FamilyCar'), ('8','Kia Ceed','FamilyCar'), ('9','Porsche Boxster','SportCar'), ('10','Ferrari 550','SportCar'), ('11','Ferrari 554','sport1');
INSERT INTO `task` VALUES ('4','title #1','0'), ('5','title #2','0');
INSERT INTO `tbl_auth_assignment` VALUES ('adminManagement','5',NULL,NULL), ('member','1','return isset($params[\"project\"]) && $params[\"project\"]->allowCurrentUser(\"member\");','N;'), ('owner','4','return isset($params[\"project\"]) && $params[\"project\"]->allowCurrentUser(\"owner\");','N;');
INSERT INTO `tbl_auth_item` VALUES ('admin','2','admin',NULL,'N;'), ('adminManagement','0','access to the application administration functionality',NULL,'N;'), ('createIssue','0','create a new issue',NULL,'N;'), ('createProject','0','create a new project',NULL,'N;'), ('createUser','0','create a new user',NULL,'N;'), ('deleteIssue','0','delete an issue from a project',NULL,'N;'), ('deleteProject','0','delete a project',NULL,'N;'), ('deleteUser','0','remove a user from a project',NULL,'N;'), ('member','2','',NULL,'N;'), ('owner','2','',NULL,'N;'), ('reader','2','',NULL,'N;'), ('readIssue','0','read issue information',NULL,'N;'), ('readProject','0','read project information',NULL,'N;'), ('readUser','0','read user profile information',NULL,'N;'), ('updateIssue','0','update issue information',NULL,'N;'), ('updateProject','0','update project information',NULL,'N;'), ('updateUser','0','update a users information',NULL,'N;');
INSERT INTO `tbl_auth_item_child` VALUES ('admin','adminManagement'), ('member','createIssue'), ('owner','createProject'), ('owner','createUser'), ('member','deleteIssue'), ('owner','deleteProject'), ('owner','deleteUser'), ('owner','member'), ('admin','owner'), ('member','reader'), ('reader','readIssue'), ('reader','readProject'), ('reader','readUser'), ('member','updateIssue'), ('owner','updateProject'), ('owner','updateUser');
INSERT INTO `tbl_comment` VALUES ('2','another one  !! ','10','2013-12-02 14:10:07','1','2013-12-02 18:23:46','1'), ('28','testing comment for this issue','11','2013-12-03 09:38:56','1','2013-12-03 12:44:59','1'), ('31','changed owner to \'demo\'','10','2013-12-03 12:24:19','1','2013-12-03 12:24:19','1'), ('32','\'demo\' has accepted this issue','10','2013-12-03 12:24:38','1','2013-12-03 12:24:38','1'), ('34','Just created this little issue for the bug I have found recently.','12','2013-12-03 12:34:46','1','2013-12-03 12:44:22','1'), ('55','got it, starting to fix','13','2013-12-05 10:08:47','4','2013-12-05 10:08:47','4'), ('56','done yet?','13','2013-12-05 12:18:52','1','2013-12-05 12:18:52','1'), ('57','just testing the comment','10','2013-12-06 10:02:46','4','2013-12-06 10:02:46','4'), ('69','another testing by demo','10','2013-12-08 18:32:08','4','2013-12-08 18:32:08','4'), ('70','another reply to demo by admin','10','2013-12-08 18:42:07','1','2013-12-08 18:42:07','1'), ('71','just commenting ','12','2013-12-09 11:01:30','4','2013-12-09 11:01:30','4');
INSERT INTO `tbl_issue` VALUES ('10','another issue','this is the <b>description</b> for \'anotehr issue\' this is description for \'anotehr issue\' this is description for \'anotehr issue\' this is description for \'anotehr issue\' this is description for \'anotehr issue\' this is description for \'anotehr issue\' this is description for \'anotehr issue\' this is description for \'anotehr issue\' this is description for \'anotehr issue\' this is description for \'anotehr issue\' this is description for \'anotehr issue\' ','4','0','1','4','1','2013-11-28 20:45:08','1','2013-12-03 12:33:09','1'), ('11','issue 1 for proj 2','issue 1 for proj 2 issue 1 for proj 2 issue 1 for proj 2 issue 1 for proj 2 issue 1 for proj 2 issue 1 for proj 2 issue 1 for proj 2 issue 1 for proj 2 ','5','0','1','1','1','2013-11-29 14:39:59','1','2013-11-29 14:39:59','1'), ('12','Name for issue #12','description for issue #12 description for issue #12 description for issue #12 description for issue #12 description for issue #12 description for issue #12 description for issue #12 description for issue #12 description for issue #12 description for issue #12 description for issue #12 description for issue #12 description for issue #12 description for issue #12 ','4','0','1','4','1','2013-12-03 12:26:36','1','2013-12-05 12:57:07','1'), ('13','another bug found','another bug found another bug found another bug found another bug found another bug found another bug found another bug found another bug found another bug found another bug found another bug found another bug found another bug found another bug found ','4','0','1','4','1','2013-12-05 10:08:23','4','2013-12-05 10:08:23','4');
INSERT INTO `tbl_migration` VALUES ('m000000_000000_base','1384537482'), ('m120509_224029_create_project_table_yy','1385027335'), ('m120511_173401_create_issue_user_and_assignment_tables_yy','1385027335'), ('m120511_173402_add_fk_to_project','1385027335'), ('m120511_173403_add_sample_data','1385027335'), ('m120619_015239_create_rbac_tables','1385399403'), ('m120620_020255_add_role_to_tbl_project_user_assignment','1385399540'), ('m120921_015630_create_user_comments_table','1385981359'), ('m120925_220414_create_system_messages_table','1386848611');
INSERT INTO `tbl_project` VALUES ('4','Project 1','description for <b>project</b> #1 description for project #1 description for project #1 description for project #1 description for project #1 description for project #1 description for project #1 description for project #1 description for project #1 description for project #1 description for project #1 description for project #1 ',NULL,'1','2014-04-07 14:08:18','1','0'), ('5','Project 2','Peoject 2 Peoject 2 Peoject 2 Peoject 2 Peoject 2 Peoject 2 Peoject 2 Peoject 2 Peoject 2 ','2013-11-29 14:30:40','1','2014-04-07 14:05:03','1','0');
INSERT INTO `tbl_project_user_assignment` VALUES ('4','1','member'), ('5','1','member'), ('4','4','owner');
INSERT INTO `tbl_sys_message` VALUES ('1','Hello users! This is Admin speaking!','2013-12-12 18:25:24','1','2013-12-18 16:22:35','1');
INSERT INTO `tbl_user` VALUES ('1','admin','admin@sample.com','21232f297a57a5a743894a0e4a801fc3','2014-04-07 12:29:25',NULL,'1','2013-11-21 17:26:14','1'), ('4','demo','demo@sample.com','fe01ce2a7fbac8fafaed7c982a04e229','2014-04-07 11:29:18','2013-11-27 15:00:09','1','2013-12-08 18:08:38','4'), ('5','user','user@example.com','ee11cbb19052e40b07aac0ca060c23ee','2013-12-18 11:23:25','2013-12-05 17:14:08','1','2013-12-05 17:14:08','1');
