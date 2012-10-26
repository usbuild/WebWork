/*
Navicat MySQL Data Transfer

Source Server         : mysql@localhost
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2012-10-26 21:43:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `blog`
-- ----------------------------
DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `owner` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '/images/avatar.png',
  PRIMARY KEY (`id`),
  KEY `FK_OWNER` (`owner`),
  CONSTRAINT `FK_OWNER` FOREIGN KEY (`owner`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of blog
-- ----------------------------
INSERT INTO `blog` VALUES ('1', '失乐园', '5', '/images/avatar.png');

-- ----------------------------
-- Table structure for `follow_blog`
-- ----------------------------
DROP TABLE IF EXISTS `follow_blog`;
CREATE TABLE `follow_blog` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_BLOG_ID` (`blog_id`),
  KEY `FK_USER_ID` (`user_id`),
  CONSTRAINT `FK_BLOG_ID` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of follow_blog
-- ----------------------------
INSERT INTO `follow_blog` VALUES ('1', '5', '1');

-- ----------------------------
-- Table structure for `follow_tag`
-- ----------------------------
DROP TABLE IF EXISTS `follow_tag`;
CREATE TABLE `follow_tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tag` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_BLOG_ID` (`tag`) USING BTREE,
  KEY `FK_USER_ID` (`user_id`) USING BTREE,
  CONSTRAINT `follow_tag_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of follow_tag
-- ----------------------------
INSERT INTO `follow_tag` VALUES ('1', '5', '你好');

-- ----------------------------
-- Table structure for `post`
-- ----------------------------
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `poster` int(11) DEFAULT NULL,
  `content` text,
  `type` enum('link','refer','image','text') NOT NULL DEFAULT 'text',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tag` text,
  `summary` text,
  PRIMARY KEY (`id`),
  KEY `FK_POSTER` (`poster`),
  CONSTRAINT `FK_POSTER` FOREIGN KEY (`poster`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of post
-- ----------------------------
INSERT INTO `post` VALUES ('4', '1', '{\"title\":\"\\u4f60\\u597d\",\"content\":\"<p>\\u4e16\\u754c<\\/p>\"}', 'text', '2012-10-26 11:23:10', '[\"hello\",\"world\"]', null);
INSERT INTO `post` VALUES ('5', '1', '{\"title\":\"shijei\",\"content\":\"<p>asdof<br \\/><\\/p>\"}', 'text', '2012-10-26 12:31:43', '[\"nihao\"]', null);
INSERT INTO `post` VALUES ('6', '1', '{\"title\":\"\\u4f60\\u597d\",\"content\":\"<p>\\u4e16\\u754c<br \\/><\\/p>\"}', 'text', '2012-10-26 12:34:19', '[\"\\u4f60\\u597d\",\"\\u4e16\\u754c\"]', null);
INSERT INTO `post` VALUES ('7', '1', '{\"title\":\"helloworld\",\"content\":\"<p>helloworld<br \\/><\\/p>\"}', 'text', '2012-10-26 12:42:40', '[\"hello\",\"world\"]', null);

-- ----------------------------
-- Table structure for `tag`
-- ----------------------------
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) CHARACTER SET utf8 NOT NULL,
  `post` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_POST_ID` (`post`),
  CONSTRAINT `FK_POST_ID` FOREIGN KEY (`post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tag
-- ----------------------------
INSERT INTO `tag` VALUES ('1', 'hello', '7');
INSERT INTO `tag` VALUES ('2', 'world', '7');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(64) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'http://img.cnbeta.com/topics/linux.gif',
  `blog` int(11) DEFAULT NULL COMMENT '默认blog',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_EMAIL` (`email`) USING BTREE,
  KEY `FK_BLOG` (`blog`),
  CONSTRAINT `FK_BLOG` FOREIGN KEY (`blog`) REFERENCES `blog` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('5', 'usbuild', 'i@lecoding.com', 'eea1a7e595cc6be2d2fc7ae023a59b2e315b038b', '7a79b5d804f92ae5d586f96b7fd418563f918564', 'http://img.cnbeta.com/topics/linux.gif', '1');
