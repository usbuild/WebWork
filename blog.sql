/*
Navicat MySQL Data Transfer

Source Server         : mysql@localhost
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2012-11-10 21:38:48
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of blog
-- ----------------------------
INSERT INTO `blog` VALUES ('1', 'usbuild', '失乐园', '5', '/upload/avatar/avatar-1352551220599.jpg');
INSERT INTO `blog` VALUES ('8', 'usblog', '师乐园', '5', '/images/avatar.png');
INSERT INTO `blog` VALUES ('9', null, '未命名', '6', '/images/avatar.png');
INSERT INTO `blog` VALUES ('11', null, '未命名', '8', '/images/avatar.png');
INSERT INTO `blog` VALUES ('14', 'uspic', '热图', '8', '/images/avatar.png');

-- ----------------------------
-- Table structure for `comment`
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `reply_id` int(11) DEFAULT NULL,
  `content` varchar(255) CHARACTER SET utf8 NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_OWNER_POST` (`blog_id`),
  KEY `FK_TO_POST` (`post_id`),
  KEY `FK_REPLY_BLOG` (`reply_id`) USING BTREE,
  CONSTRAINT `FK_OWNER_POST` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_REPLY_BLOG` FOREIGN KEY (`reply_id`) REFERENCES `blog` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_TO_POST` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of comment
-- ----------------------------
INSERT INTO `comment` VALUES ('65', '1', null, 'hello', '38', '2012-11-09 21:17:16');
INSERT INTO `comment` VALUES ('66', '1', null, 'bucuo', '51', '2012-11-10 15:41:00');
INSERT INTO `comment` VALUES ('71', '1', null, 'hello', '50', '2012-11-10 21:06:36');
INSERT INTO `comment` VALUES ('72', '1', null, '好啊', '50', '2012-11-10 21:07:02');
INSERT INTO `comment` VALUES ('73', '1', null, '不错', '50', '2012-11-10 21:07:16');
INSERT INTO `comment` VALUES ('74', '1', null, '不错', '50', '2012-11-10 21:12:54');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of follow_blog
-- ----------------------------
INSERT INTO `follow_blog` VALUES ('1', '5', '1');
INSERT INTO `follow_blog` VALUES ('2', '6', '1');
INSERT INTO `follow_blog` VALUES ('3', '6', '9');
INSERT INTO `follow_blog` VALUES ('4', '5', '9');
INSERT INTO `follow_blog` VALUES ('5', '8', '11');
INSERT INTO `follow_blog` VALUES ('7', '8', '14');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of like
-- ----------------------------
INSERT INTO `like` VALUES ('1', '40', '1', '2012-11-10 10:25:49');
INSERT INTO `like` VALUES ('15', '50', '1', '2012-11-10 20:37:04');

-- ----------------------------
-- Table structure for `post`
-- ----------------------------
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `head` text CHARACTER SET utf8,
  `content` text CHARACTER SET utf8,
  `type` enum('music','video','image','repost','text') NOT NULL DEFAULT 'text',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tag` text NOT NULL,
  `repost_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_PT_BLOG` (`blog_id`),
  KEY `FK_RP_POST` (`repost_id`),
  CONSTRAINT `FK_RP_POST` FOREIGN KEY (`repost_id`) REFERENCES `post` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `FK_PT_BLOG` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of post
-- ----------------------------
INSERT INTO `post` VALUES ('32', '1', '[{\"url\":\"\\/blog\\/upload\\/20121110\\/Penguins%20%284%29.jpg\",\"desc\":\"\"},{\"url\":\"\\/blog\\/upload\\/20121110\\/Koala%20%282%29.jpg\",\"desc\":\"asdf\"}]', '<p>很美图asdfsdf</p>', 'image', '2012-11-09 12:49:36', '[\"asdf\",\"sadfg\",\"sdfasdf\"]', null);
INSERT INTO `post` VALUES ('35', '9', '{\"song_id\":\"2051307\",\"song_name\":\"\\u4e3a\\u4f60\\u5199\\u8bd7\",\"artist_id\":\"958\",\"artist_name\":\"\\u5434\\u514b\\u7fa4\",\"album_id\":\"167391\",\"album_name\":\"\\u4e3a\\u4f60\\u5199\\u8bd7\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img58\\/958\\/167391_1.jpg\"}', '<p>xxoo<br /></p>', 'music', '2012-11-09 17:35:58', '[]', null);
INSERT INTO `post` VALUES ('36', '1', 'hello text', '<p>hello text<br /></p>', 'text', '2012-11-09 19:49:40', '[]', null);
INSERT INTO `post` VALUES ('37', '9', 'hello world', '<p>hello world<br /></p>', 'text', '2012-11-09 20:22:38', '[\"nihao\"]', null);
INSERT INTO `post` VALUES ('38', '1', 'asdfas', '<p>asdfasdasrefwae<br /></p>', 'text', '2012-11-09 20:42:06', '[\"sadfsadfsd\",\"asdfsad\"]', null);
INSERT INTO `post` VALUES ('39', '1', '{\"song_id\":\"380241\",\"song_name\":\"\\u6696\\u6696\",\"artist_id\":\"1836\",\"artist_name\":\"\\u6881\\u9759\\u8339\",\"album_id\":\"10061\",\"album_name\":\"\\u4eb2\\u4eb2\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img36\\/1836\\/10061_1.jpg\"}', '<p>hello 好听啊~~~<br /></p>', 'music', '2012-11-10 09:41:28', '[\"hello\",\"~~~\"]', null);
INSERT INTO `post` VALUES ('40', '9', '{\"song_id\":\"380275\",\"song_name\":\"\\u7231\\u4f60\\u4e0d\\u662f\\u4e24\\u4e09\\u5929\",\"artist_id\":\"1836\",\"artist_name\":\"\\u6881\\u9759\\u8339\",\"album_id\":\"10068\",\"album_name\":\"\\u604b\\u7231\\u7684\\u529b\\u91cf\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img36\\/1836\\/100681338427452_1.jpg\"}', '<p>静茹<br /></p>', 'music', '2012-11-10 09:44:22', '[]', null);
INSERT INTO `post` VALUES ('41', '1', 'http://v.youku.com/v_show/id_XNDczMjI1NDg0.html', '<p>支持党的决定！<span style=\"color:#444444;font-size:13px;background-color:#efefef;\">我爱共产党</span><br /></p>', 'video', '2012-11-10 10:33:37', '[\"\\u5341\\u516b\\u5927\",\"\\u6211\\u7231\\u5171\\u4ea7\\u515a\"]', null);
INSERT INTO `post` VALUES ('50', '9', '{\"song_id\":\"3341399\",\"song_name\":\"\\u6c38\\u9060++\",\"artist_id\":\"54994\",\"artist_name\":\"\\u7fbd\\u7530\\u88d5\\u7f8e\",\"album_id\":\"301971\",\"album_name\":\"\\u5fc3\\u3092\\u958b\\u3044\\u3066~ZARD+Piano+Classics~+\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img94\\/54994\\/301971_1.jpg\"}', '<p>好听<br /></p>', 'music', '2012-11-10 14:12:58', '[]', null);
INSERT INTO `post` VALUES ('51', '1', '50', '<blockquote><p>不错</p></blockquote>', 'repost', '2012-11-10 14:16:07', '[\"\\u7fbd\\u7530\\u88d5\\u7f8e\",\"\\u94a2\\u7434\"]', '50');
INSERT INTO `post` VALUES ('52', '1', '50', '<p>好喜欢！<br />来自：<a href=\"/blog/blog/view\">未命名</a><br /></p><blockquote><p>好听<br /></p></blockquote>', 'repost', '2012-11-10 18:46:46', '[\"\\u6c38\\u8fdc\"]', '50');
INSERT INTO `post` VALUES ('53', '9', '52', '<p>真的很好听<br />来自：<a href=\"/blog/blog/view\">失乐园</a><br /></p><blockquote><p>好喜欢！<br />来自：<a href=\"/blog/blog/view\">未命名</a><br /></p><blockquote><p>好听<br /></p></blockquote></blockquote>', 'repost', '2012-11-10 18:50:44', '[]', '50');
INSERT INTO `post` VALUES ('54', '11', 'hello', '<p>hello<br /></p>', 'text', '2012-11-10 21:23:35', '[\"hello\",\"word\"]', null);
INSERT INTO `post` VALUES ('55', '14', '{\"song_id\":\"1769019781\",\"song_name\":\"\\u5361\\u519c\",\"artist_id\":\"63111\",\"artist_name\":\"\\u5229\\u672a\\u4eba\\u5ba4\\u5185\\u4e50\\u56e2\",\"album_id\":\"339137\",\"album_name\":\"\\u8f6c\\u89d2\\u542c\\u89c1\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img11\\/63111\\/3391371248935144_1.jpg\"}', '<p>看看<br /></p>', 'music', '2012-11-10 21:34:53', '[\"\\u5361\\u519c\"]', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tag
-- ----------------------------
INSERT INTO `tag` VALUES ('10', 'sadfsadfsd', '38');
INSERT INTO `tag` VALUES ('11', 'asdfsad', '38');
INSERT INTO `tag` VALUES ('12', 'sadfsadfsd', '38');
INSERT INTO `tag` VALUES ('13', 'asdfsad', '38');
INSERT INTO `tag` VALUES ('14', 'nihao', '37');
INSERT INTO `tag` VALUES ('15', 'hello', '39');
INSERT INTO `tag` VALUES ('16', 'hello', '39');
INSERT INTO `tag` VALUES ('17', 'hello', '39');
INSERT INTO `tag` VALUES ('18', '~~~', '39');
INSERT INTO `tag` VALUES ('19', 'hello', '39');
INSERT INTO `tag` VALUES ('20', '~~~', '39');
INSERT INTO `tag` VALUES ('21', '十八大', '41');
INSERT INTO `tag` VALUES ('27', '十八大', '41');
INSERT INTO `tag` VALUES ('28', '我爱共产党', '41');
INSERT INTO `tag` VALUES ('31', 'asdf', '32');
INSERT INTO `tag` VALUES ('32', 'asdf', '32');
INSERT INTO `tag` VALUES ('33', 'asdf', '32');
INSERT INTO `tag` VALUES ('34', 'sadfg', '32');
INSERT INTO `tag` VALUES ('35', 'asdf', '32');
INSERT INTO `tag` VALUES ('36', 'sadfg', '32');
INSERT INTO `tag` VALUES ('37', 'sdfasdf', '32');
INSERT INTO `tag` VALUES ('38', 'hello', '54');
INSERT INTO `tag` VALUES ('39', 'word', '54');
INSERT INTO `tag` VALUES ('40', '卡农', '55');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(64) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'http://img.cnbeta.com/topics/linux.gif',
  `blog` int(11) DEFAULT NULL COMMENT '默认blog',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_EMAIL` (`email`) USING BTREE,
  KEY `FK_BLOG` (`blog`),
  CONSTRAINT `FK_BLOG` FOREIGN KEY (`blog`) REFERENCES `blog` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('5', 'usbuild', 'i@lecoding.com', 'dd1d3f9db21c852aa5ce97e5a9f64165ecee7ed0', '5629ea7a39bb6f9782fa38a64522166c2ea4b0d0', 'http://img.cnbeta.com/topics/linux.gif', '1');
INSERT INTO `user` VALUES ('6', 'usblog', 'y@lecoding.com', '8cb2237d0679ca88db6464eac60da96345513964', 'a7dfc8aca4b3a1d650c9d42f9f87737cff523caf', 'http://img.cnbeta.com/topics/linux.gif', '9');
INSERT INTO `user` VALUES ('8', '有师必有得', 'njuzhangqichao@gmail.com', '1f79227afcf9a9e3e6eb267ed848a7daed469f77', '0454f46ced6f9e577a2e78bfc08e301ababdebe8', 'http://img.cnbeta.com/topics/linux.gif', '11');
