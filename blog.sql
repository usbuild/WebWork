/*
Navicat MySQL Data Transfer

Source Server         : mysql@localhost
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2012-10-25 21:36:35
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
  PRIMARY KEY (`id`),
  KEY `FK_OWNER` (`owner`),
  CONSTRAINT `FK_OWNER` FOREIGN KEY (`owner`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of blog
-- ----------------------------

-- ----------------------------
-- Table structure for `feed`
-- ----------------------------
DROP TABLE IF EXISTS `feed`;
CREATE TABLE `feed` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of feed
-- ----------------------------

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_EMAIL` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('5', 'usbuild', 'i@lecoding.com', 'eea1a7e595cc6be2d2fc7ae023a59b2e315b038b', '7a79b5d804f92ae5d586f96b7fd418563f918564', 'http://img.cnbeta.com/topics/linux.gif');
