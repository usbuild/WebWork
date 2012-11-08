/*
Navicat MySQL Data Transfer

Source Server         : mysql@localhost
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2012-11-08 21:51:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `blog`
-- ----------------------------
DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(30) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '未命名',
  `owner` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '/images/avatar.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_DOMAIN` (`domain`) USING BTREE,
  KEY `FK_OWNER` (`owner`),
  CONSTRAINT `FK_OWNER` FOREIGN KEY (`owner`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of blog
-- ----------------------------
INSERT INTO `blog` VALUES ('1', 'usbuild', '失乐园', '5', '/upload/avatar/avatar-13523686764514.jpg');
INSERT INTO `blog` VALUES ('8', 'usblog', '师乐园', '5', '/images/avatar.png');

-- ----------------------------
-- Table structure for `comment`
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_OWNER_POST` (`blog_id`),
  KEY `FK_TO_POST` (`post_id`),
  CONSTRAINT `FK_OWNER_POST` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_TO_POST` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of comment
-- ----------------------------
INSERT INTO `comment` VALUES ('1', '1', '好听！', '27', '0000-00-00 00:00:00');
INSERT INTO `comment` VALUES ('2', '1', '真不错', '27', '0000-00-00 00:00:00');
INSERT INTO `comment` VALUES ('3', '1', 'nihao shijie', '27', '2012-11-08 19:29:46');
INSERT INTO `comment` VALUES ('4', '1', 'ddd', '27', '2012-11-08 20:24:52');
INSERT INTO `comment` VALUES ('5', '1', 'ddd', '27', '2012-11-08 20:25:09');
INSERT INTO `comment` VALUES ('6', '1', '真好听', '27', '2012-11-08 20:25:37');
INSERT INTO `comment` VALUES ('7', '1', '你好', '27', '2012-11-08 20:26:48');
INSERT INTO `comment` VALUES ('8', '1', 'sss', '27', '2012-11-08 20:32:33');
INSERT INTO `comment` VALUES ('9', '1', 'dddasdf', '27', '2012-11-08 20:32:46');
INSERT INTO `comment` VALUES ('10', '1', 'ssdfasd', '27', '2012-11-08 20:33:18');
INSERT INTO `comment` VALUES ('11', '1', 'ergtaergase', '27', '2012-11-08 20:33:31');
INSERT INTO `comment` VALUES ('12', '1', 'asddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', '27', '2012-11-08 20:33:43');
INSERT INTO `comment` VALUES ('13', '1', 'sarfawfe', '27', '2012-11-08 20:43:00');
INSERT INTO `comment` VALUES ('14', '1', 'asdfasd', '27', '2012-11-08 20:52:29');
INSERT INTO `comment` VALUES ('15', '1', 'hello', '27', '2012-11-08 20:55:33');
INSERT INTO `comment` VALUES ('16', '1', 'sadfasdf', '27', '2012-11-08 20:55:37');
INSERT INTO `comment` VALUES ('17', '1', 'asdfasd', '27', '2012-11-08 20:56:00');
INSERT INTO `comment` VALUES ('18', '1', 's打发似的', '27', '2012-11-08 20:56:20');
INSERT INTO `comment` VALUES ('19', '1', '你好啊', '27', '2012-11-08 20:56:40');
INSERT INTO `comment` VALUES ('20', '1', 'hello', '27', '2012-11-08 20:57:29');
INSERT INTO `comment` VALUES ('21', '1', 'hello', '27', '2012-11-08 20:57:33');
INSERT INTO `comment` VALUES ('22', '1', 'hello', '27', '2012-11-08 20:57:53');
INSERT INTO `comment` VALUES ('23', '1', '你好', '27', '2012-11-08 21:14:15');
INSERT INTO `comment` VALUES ('24', '1', '撒旦发射的', '27', '2012-11-08 21:16:21');
INSERT INTO `comment` VALUES ('25', '1', 'asdf', '27', '2012-11-08 21:16:50');
INSERT INTO `comment` VALUES ('26', '1', 'test', '26', '2012-11-08 21:34:51');
INSERT INTO `comment` VALUES ('27', '1', 'asdfasdf', '27', '2012-11-08 21:51:33');

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
-- Table structure for `like`
-- ----------------------------
DROP TABLE IF EXISTS `like`;
CREATE TABLE `like` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_LK_BLOG` (`blog_id`),
  KEY `FK_LK_POST` (`post_id`),
  CONSTRAINT `FK_LK_BLOG` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_LK_POST` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of like
-- ----------------------------
INSERT INTO `like` VALUES ('1', '27', '1', '2012-11-08 21:50:41');

-- ----------------------------
-- Table structure for `post`
-- ----------------------------
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `poster` int(11) DEFAULT NULL,
  `content` text,
  `type` enum('music','video','image','text') NOT NULL DEFAULT 'text',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tag` text,
  PRIMARY KEY (`id`),
  KEY `FK_POSTER` (`poster`),
  CONSTRAINT `FK_POSTER` FOREIGN KEY (`poster`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of post
-- ----------------------------
INSERT INTO `post` VALUES ('4', '1', '{\"title\":\"\\u4f60\\u597d\",\"content\":\"<p>\\u4e16\\u754c<\\/p>\"}', 'text', '2012-10-26 11:23:10', '[\"hello\",\"world\"]');
INSERT INTO `post` VALUES ('5', '1', '{\"title\":\"shijei\",\"content\":\"<p>asdof<br \\/><\\/p>\"}', 'text', '2012-10-26 12:31:43', '[\"nihao\"]');
INSERT INTO `post` VALUES ('6', '1', '{\"title\":\"\\u4f60\\u597d\",\"content\":\"<p>\\u4e16\\u754c<br \\/><\\/p>\"}', 'text', '2012-10-26 12:34:19', '[\"\\u4f60\\u597d\",\"\\u4e16\\u754c\"]');
INSERT INTO `post` VALUES ('7', '1', '{\"title\":\"helloworld\",\"content\":\"<p>helloworld<br \\/><\\/p>\"}', 'text', '2012-10-26 12:42:40', '[\"hello\",\"world\"]');
INSERT INTO `post` VALUES ('20', '1', '{\"title\":[{\"url\":\"\\/blog\\/upload\\/20121102\\/Chrysanthemum%20%288%29.jpg\",\"desc\":\"\"}],\"content\":\"\"}', 'image', '2012-11-02 16:24:24', '[\"asdf\",\"aregtar\"]');
INSERT INTO `post` VALUES ('21', '1', '{\"title\":\"asdf\",\"content\":\"<p>asfs<br \\/><\\/p>\"}', 'text', '2012-11-02 16:28:46', '[\"szfg\",\"zrsdg\"]');
INSERT INTO `post` VALUES ('22', '1', '{\"title\":\"asdfg\",\"content\":\"<p>dfg<br \\/><\\/p>\"}', 'text', '2012-11-05 14:51:25', '[\"\"]');
INSERT INTO `post` VALUES ('23', '1', '{\"title\":[{\"url\":\"\\/blog\\/upload\\/20121105\\/Desert.jpg\",\"desc\":\"saf\"},{\"url\":\"\\/blog\\/upload\\/20121105\\/Chrysanthemum.jpg\",\"desc\":\"sdf\"}],\"content\":\"<p>szdf<br \\/><\\/p>\"}', 'image', '2012-11-05 14:51:51', '[\"\"]');
INSERT INTO `post` VALUES ('24', '8', '{\"title\":\"Adf\",\"content\":\"<p>asfer<br \\/><\\/p>\"}', 'text', '2012-11-05 21:49:02', '[\"\"]');
INSERT INTO `post` VALUES ('25', '1', '{\"title\":{\"song_id\":\"380241\",\"song_name\":\"\\u6696\\u6696\",\"artist_id\":\"1836\",\"artist_name\":\"\\u6881\\u9759\\u8339\",\"album_id\":\"10061\",\"album_name\":\"\\u4eb2\\u4eb2\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img36\\/1836\\/10061_1.jpg\"},\"content\":\"\"}', 'music', '2012-11-07 20:52:05', '[\"\"]');
INSERT INTO `post` VALUES ('26', '1', '{\"title\":{\"song_id\":\"1770001647\",\"song_name\":\"\\u5c0f\\u624b\\u62c9\\u5927\\u624b\",\"artist_id\":\"1836\",\"artist_name\":\"\\u6881\\u9759\\u8339\",\"album_id\":\"422852\",\"album_name\":\"\\u73b0\\u5728\\u5f00\\u59cb\\u6211\\u7231\\u4f60\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img36\\/1836\\/4228521297226918_1.jpg\"},\"content\":\"<p>love \\u9759\\u8339<br \\/><\\/p>\"}', 'music', '2012-11-07 21:03:27', '[\"\"]');
INSERT INTO `post` VALUES ('27', '1', '{\"title\":{\"song_id\":\"143408\",\"song_name\":\"\\u9047\\u89c1\",\"artist_id\":\"2132\",\"artist_name\":\"\\u5b59\\u71d5\\u59ff\",\"album_id\":\"11654\",\"album_name\":\"\\u7ecf\\u5178\\u5168\\u7eaa\\u5f55(\\u4e3b\\u6253\\u7cbe\\u534e\\u7248)\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img32\\/2132\\/11654_1.jpg\"},\"content\":\"<p style=\\\"text-align:center;\\\">love <strong>\\u71d5\\u59ff<\\/strong><br \\/><\\/p>\"}', 'music', '2012-11-07 21:09:28', '[\"\"]');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tag
-- ----------------------------
INSERT INTO `tag` VALUES ('1', 'hello', '7');
INSERT INTO `tag` VALUES ('2', 'world', '7');
INSERT INTO `tag` VALUES ('3', 'asdf', '20');
INSERT INTO `tag` VALUES ('4', 'aregtar', '20');
INSERT INTO `tag` VALUES ('5', 'szfg', '21');
INSERT INTO `tag` VALUES ('6', 'zrsdg', '21');

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
INSERT INTO `user` VALUES ('5', 'usbuild', 'i@lecoding.com', 'dd1d3f9db21c852aa5ce97e5a9f64165ecee7ed0', '5629ea7a39bb6f9782fa38a64522166c2ea4b0d0', 'http://img.cnbeta.com/topics/linux.gif', '1');
