/*
Navicat MySQL Data Transfer

Source Server         : mysql@localhost
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2012-11-24 20:09:14
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
INSERT INTO `blog` VALUES ('9', '', '美女热图', '6', '/images/avatar.png');
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
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of comment
-- ----------------------------
INSERT INTO `comment` VALUES ('65', '1', null, 'hello', '38', '2012-11-09 21:17:16');
INSERT INTO `comment` VALUES ('66', '1', null, 'bucuo', '51', '2012-11-10 15:41:00');
INSERT INTO `comment` VALUES ('71', '1', null, 'hello', '50', '2012-11-10 21:06:36');
INSERT INTO `comment` VALUES ('72', '1', null, '好啊', '50', '2012-11-10 21:07:02');
INSERT INTO `comment` VALUES ('73', '1', null, '不错', '50', '2012-11-10 21:07:16');
INSERT INTO `comment` VALUES ('74', '1', null, '不错', '50', '2012-11-10 21:12:54');
INSERT INTO `comment` VALUES ('75', '1', null, '好听', '50', '2012-11-11 09:47:32');
INSERT INTO `comment` VALUES ('76', '9', null, 'asdf', '65', '2012-11-13 21:05:46');
INSERT INTO `comment` VALUES ('77', '1', null, '不错', '32', '2012-11-13 21:48:21');
INSERT INTO `comment` VALUES ('78', '1', null, '不错', '36', '2012-11-13 21:51:00');
INSERT INTO `comment` VALUES ('79', '1', null, '不错', '58', '2012-11-13 21:51:56');
INSERT INTO `comment` VALUES ('80', '1', null, 'nihao', '66', '2012-11-23 12:33:25');

-- ----------------------------
-- Table structure for `cowriter`
-- ----------------------------
DROP TABLE IF EXISTS `cowriter`;
CREATE TABLE `cowriter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_CO_BLOG` (`blog_id`),
  KEY `FK_CO_USER` (`user_id`),
  CONSTRAINT `FK_CO_BLOG` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_CO_USER` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cowriter
-- ----------------------------
INSERT INTO `cowriter` VALUES ('10', '1', '6');
INSERT INTO `cowriter` VALUES ('13', '9', '5');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of follow_blog
-- ----------------------------
INSERT INTO `follow_blog` VALUES ('2', '6', '1');
INSERT INTO `follow_blog` VALUES ('3', '6', '9');
INSERT INTO `follow_blog` VALUES ('5', '8', '11');
INSERT INTO `follow_blog` VALUES ('7', '8', '14');
INSERT INTO `follow_blog` VALUES ('14', '5', '9');
INSERT INTO `follow_blog` VALUES ('15', '5', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of follow_tag
-- ----------------------------
INSERT INTO `follow_tag` VALUES ('8', '5', 'nihao');
INSERT INTO `follow_tag` VALUES ('9', '6', 'fasdfasd');
INSERT INTO `follow_tag` VALUES ('10', '6', 'asdfasd');
INSERT INTO `follow_tag` VALUES ('11', '6', 'a');
INSERT INTO `follow_tag` VALUES ('12', '6', 'asfasdf');
INSERT INTO `follow_tag` VALUES ('13', '5', 'sadfa');
INSERT INTO `follow_tag` VALUES ('14', '5', 'gfre');
INSERT INTO `follow_tag` VALUES ('15', '5', 'asdfsad');
INSERT INTO `follow_tag` VALUES ('16', '5', 'asdfasd');
INSERT INTO `follow_tag` VALUES ('17', '5', 'wefrwae');

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of like
-- ----------------------------
INSERT INTO `like` VALUES ('1', '40', '1', '2012-11-10 10:25:49');
INSERT INTO `like` VALUES ('16', '50', '1', '2012-11-11 16:09:57');
INSERT INTO `like` VALUES ('17', '58', '1', '2012-11-13 16:58:59');
INSERT INTO `like` VALUES ('18', '65', '1', '2012-11-14 10:53:01');

-- ----------------------------
-- Table structure for `post`
-- ----------------------------
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `head` text CHARACTER SET utf8,
  `content` text CHARACTER SET utf8,
  `type` enum('music','video','image','repost','link','text') NOT NULL DEFAULT 'text',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tag` text CHARACTER SET utf8 NOT NULL,
  `repost_id` bigint(20) DEFAULT NULL,
  `isdel` int(1) NOT NULL DEFAULT '0',
  `writer` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_PT_BLOG` (`blog_id`),
  KEY `FK_RP_POST` (`repost_id`),
  KEY `FK_PT_WRITER` (`writer`),
  CONSTRAINT `FK_PT_BLOG` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_PT_WRITER` FOREIGN KEY (`writer`) REFERENCES `cowriter` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `FK_RP_POST` FOREIGN KEY (`repost_id`) REFERENCES `post` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of post
-- ----------------------------
INSERT INTO `post` VALUES ('32', '1', '[{\"url\":\"\\/blog\\/upload\\/20121110\\/Penguins%20%284%29.jpg\",\"desc\":\"\"},{\"url\":\"\\/blog\\/upload\\/20121110\\/Koala%20%282%29.jpg\",\"desc\":\"asdf\"}]', '<p>很美图asdfsdf</p>', 'image', '2012-11-09 12:49:36', '[\"asdf\",\"sadfg\",\"sdfasdf\"]', null, '0', null);
INSERT INTO `post` VALUES ('35', '9', '{\"song_id\":\"2051307\",\"song_name\":\"\\u4e3a\\u4f60\\u5199\\u8bd7\",\"artist_id\":\"958\",\"artist_name\":\"\\u5434\\u514b\\u7fa4\",\"album_id\":\"167391\",\"album_name\":\"\\u4e3a\\u4f60\\u5199\\u8bd7\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img58\\/958\\/167391_1.jpg\"}', '<p>xxoo<br /></p>', 'music', '2012-11-09 17:35:58', '[]', null, '0', null);
INSERT INTO `post` VALUES ('36', '1', 'hello text', '<p>hello text<br /></p>', 'text', '2012-11-09 19:49:40', '[]', null, '0', null);
INSERT INTO `post` VALUES ('37', '9', 'hello world', '<p>hello world<br /></p>', 'text', '2012-11-09 20:22:38', '[\"nihao\"]', null, '0', null);
INSERT INTO `post` VALUES ('38', '1', 'asdfas', '<p>asdfasdasrefwae<br /></p>', 'text', '2012-11-09 20:42:06', '[\"sadfsadfsd\",\"asdfsad\"]', null, '0', null);
INSERT INTO `post` VALUES ('39', '1', '{\"song_id\":\"380241\",\"song_name\":\"\\u6696\\u6696\",\"artist_id\":\"1836\",\"artist_name\":\"\\u6881\\u9759\\u8339\",\"album_id\":\"10061\",\"album_name\":\"\\u4eb2\\u4eb2\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img36\\/1836\\/10061_1.jpg\"}', '<p>hello 好听啊~~~<br /></p>', 'music', '2012-11-10 09:41:28', '[\"hello\",\"~~~\"]', null, '0', null);
INSERT INTO `post` VALUES ('40', '9', '{\"song_id\":\"380275\",\"song_name\":\"\\u7231\\u4f60\\u4e0d\\u662f\\u4e24\\u4e09\\u5929\",\"artist_id\":\"1836\",\"artist_name\":\"\\u6881\\u9759\\u8339\",\"album_id\":\"10068\",\"album_name\":\"\\u604b\\u7231\\u7684\\u529b\\u91cf\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img36\\/1836\\/100681338427452_1.jpg\"}', '<p>静茹<br /></p>', 'music', '2012-11-10 09:44:22', '[]', null, '0', null);
INSERT INTO `post` VALUES ('50', '9', '{\"song_id\":\"3341399\",\"song_name\":\"\\u6c38\\u9060++\",\"artist_id\":\"54994\",\"artist_name\":\"\\u7fbd\\u7530\\u88d5\\u7f8e\",\"album_id\":\"301971\",\"album_name\":\"\\u5fc3\\u3092\\u958b\\u3044\\u3066~ZARD+Piano+Classics~+\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img94\\/54994\\/301971_1.jpg\"}', '<p>好听<br /></p>', 'music', '2012-11-10 14:12:58', '[]', null, '0', null);
INSERT INTO `post` VALUES ('51', '1', '50', '<blockquote><p>不错</p></blockquote>', 'repost', '2012-11-10 14:16:07', '[\"\\u7fbd\\u7530\\u88d5\\u7f8e\",\"\\u94a2\\u7434\"]', '50', '0', null);
INSERT INTO `post` VALUES ('52', '1', '50', '<p>好喜欢！<br />来自：<a href=\"/blog/blog/view\">未命名</a><br /></p><blockquote><p>好听<br /></p></blockquote>', 'repost', '2012-11-10 18:46:46', '[\"\\u6c38\\u8fdc\"]', '50', '0', null);
INSERT INTO `post` VALUES ('53', '9', '52', '<p>真的很好听<br />来自：<a href=\"/blog/blog/view\">失乐园</a><br /></p><blockquote><p>好喜欢！<br />来自：<a href=\"/blog/blog/view\">未命名</a><br /></p><blockquote><p>好听<br /></p></blockquote></blockquote>', 'repost', '2012-11-10 18:50:44', '[]', '50', '0', null);
INSERT INTO `post` VALUES ('54', '11', 'hello', '<p>hello<br /></p>', 'text', '2012-11-10 21:23:35', '[\"hello\",\"word\"]', null, '0', null);
INSERT INTO `post` VALUES ('55', '14', '{\"song_id\":\"1769019781\",\"song_name\":\"\\u5361\\u519c\",\"artist_id\":\"63111\",\"artist_name\":\"\\u5229\\u672a\\u4eba\\u5ba4\\u5185\\u4e50\\u56e2\",\"album_id\":\"339137\",\"album_name\":\"\\u8f6c\\u89d2\\u542c\\u89c1\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img11\\/63111\\/3391371248935144_1.jpg\"}', '<p>看看<br /></p>', 'music', '2012-11-10 21:34:53', '[\"\\u5361\\u519c\"]', null, '0', null);
INSERT INTO `post` VALUES ('57', '1', '{\"type\":\"tudou\",\"originUrl\":\"http://www.tudou.com/albumplay/nDZX3rQhcdk/RKwIgZ3\",\"title\":\"就算是哥哥有爱就没问题了对吧-第1集\",\"img\":\"http://i2.tdimg.com/154/013/575/m35.jpg\",\"flashUrl\":\"http://www.tudou.com/a/nDZX3rQhcdk/&iid=154013575/v.swf\"}', '<p>就算是哥哥有爱就没问题了对吧-第1集</p>', 'video', '2012-11-13 16:01:04', '[]', null, '0', null);
INSERT INTO `post` VALUES ('58', '1', '{\"type\":\"bili\",\"originUrl\":\"http://bilibili.smgbb.cn/video/av391885/\",\"title\":\"【岚aya】JBF后续曲-Answer\",\"img\":\"http://i0.hdslb.com/u_f/75177cea586b73ca5acf1daee2d45257.jpg\",\"flashUrl\":\"http://static.hdslb.com/miniloader.swf?aid=391885\"}', '<p>【中二病】长门消失了也要恋爱</p>', 'video', '2012-11-13 16:12:22', '[]', null, '0', null);
INSERT INTO `post` VALUES ('59', '1', '{\"type\":\"youku\",\"originUrl\":\"http://v.youku.com/v_show/id_XNDcyODA5NTg0.html\",\"img\":\"http://g3.ykimg.com/0100641F46509B80FABE4B02145CCE150FA210-D142-1143-7AE1-C80AA190C914\",\"title\":\"中二病也要谈恋爱！\",\"flashUrl\":\"http://player.youku.com/player.php/sid/XNDcyODA5NTg0/v.swf\"}', '<p>中二病也要谈恋爱！</p>', 'video', '2012-11-13 16:15:11', '[]', null, '0', null);
INSERT INTO `post` VALUES ('60', '9', '59', '<p>不错啊<br />来自：<a href=\"/blog/blog/view\">失乐园</a><br /></p><blockquote><p>中二病也要谈恋爱！</p></blockquote>', 'repost', '2012-11-13 16:22:35', '[]', '59', '0', null);
INSERT INTO `post` VALUES ('61', '9', '58', '<p>长门是谁？<br />来自：<a href=\"/blog/blog/view\">失乐园</a><br /></p><blockquote><p>【中二病】长门消失了也要恋爱</p></blockquote>', 'repost', '2012-11-13 16:22:58', '[]', '58', '0', null);
INSERT INTO `post` VALUES ('63', '1', '58', '<p><br/></p>什么', 'repost', '2012-11-13 16:52:38', '[]', '58', '0', null);
INSERT INTO `post` VALUES ('65', '1', '{\"title\":\"14\\u820d\",\"link\":\"http:\\/\\/baidu.com\"}', '<p>aswfraeasdf<br /></p>', 'link', '2012-11-13 20:43:17', '[\"sagfvasdf\"]', null, '1', null);
INSERT INTO `post` VALUES ('66', '9', '65', '<p><br />来自：<a href=\"/blog/blog/view\">失乐园</a><br /></p><blockquote><p>aswfraeasdf<br /></p></blockquote>', 'repost', '2012-11-13 21:04:53', '[]', '65', '0', null);
INSERT INTO `post` VALUES ('73', '9', 'AFR', '<p>SADF<br /></p>', 'text', '2012-11-23 19:42:48', '[\"ASDFASD\"]', null, '0', null);
INSERT INTO `post` VALUES ('74', '9', '{\"song_id\":\"2073745\",\"song_name\":\"Hello\",\"artist_id\":\"23351\",\"artist_name\":\"Tristan+Prettyman\",\"album_id\":\"168084\",\"album_name\":\"Hello\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img51\\/23351\\/168084_1.jpg\"}', '<p>sdfasdfFSDASFD<br /></p>', 'music', '2012-11-23 19:48:47', '[\"jj\"]', null, '0', null);
INSERT INTO `post` VALUES ('75', '1', 'hello', '<p>helloo<br /></p>', 'text', '2012-11-23 19:49:15', '[\"sdf\"]', null, '0', null);
INSERT INTO `post` VALUES ('76', '9', '{\"title\":\"\\u767e\\u5ea6\",\"link\":\"http:\\/\\/baidu.com\"}', '<p>baidu link &nbsp; &nbsp;<br /></p>', 'link', '2012-11-23 20:51:45', '[\"baidu\",\"\\u5ea6\\u5a18\"]', null, '0', '5');
INSERT INTO `post` VALUES ('77', '9', 'SDF', '<p>SDF<br /></p>', 'text', '2012-11-23 21:31:23', '[\"ASDFASD\"]', null, '0', '5');
INSERT INTO `post` VALUES ('78', '1', '{\"song_id\":\"1770989638\",\"song_name\":\"Hello\",\"artist_id\":\"109790\",\"artist_name\":\"Hello+Venus\",\"album_id\":\"511737\",\"album_name\":\"Venus\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img90\\/109790\\/5117371336552449_1.jpg\"}', '<p>agtr<br /></p><br>感谢<a href=\"/blog/view/9\" target=\"_blank\">美女热图</a>的投递 :-)', 'music', '2012-11-24 20:08:02', '[\"srgsdfg\"]', null, '0', null);

-- ----------------------------
-- Table structure for `request`
-- ----------------------------
DROP TABLE IF EXISTS `request`;
CREATE TABLE `request` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `head` text CHARACTER SET utf8 NOT NULL,
  `content` text,
  `tag` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sender` int(11) NOT NULL,
  `state` enum('pass','deny','pending') NOT NULL DEFAULT 'pending',
  `type` enum('video','music','image','link','text') NOT NULL DEFAULT 'text',
  PRIMARY KEY (`id`),
  KEY `FK_REQ_BLOG` (`blog_id`),
  KEY `FK_REQ_SENDER` (`sender`),
  CONSTRAINT `FK_REQ_BLOG` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_REQ_SENDER` FOREIGN KEY (`sender`) REFERENCES `user` (`blog`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of request
-- ----------------------------
INSERT INTO `request` VALUES ('2', '9', 'asdf', '<p>asdfasdfa<br /></p>', '[\"awefrwaerf\"]', '2012-11-24 18:33:22', '1', 'pending', 'text');
INSERT INTO `request` VALUES ('5', '1', '{\"song_id\":\"1770989638\",\"song_name\":\"Hello\",\"artist_id\":\"109790\",\"artist_name\":\"Hello+Venus\",\"album_id\":\"511737\",\"album_name\":\"Venus\",\"album_logo\":\"http:\\/\\/img.xiami.com\\/.\\/images\\/album\\/img90\\/109790\\/5117371336552449_1.jpg\"}', '<p>agtr<br /></p>', '[\"srgsdfg\"]', '2012-11-24 19:58:20', '9', 'pending', 'music');

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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

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
INSERT INTO `tag` VALUES ('41', 'sagfvasdf', '65');
INSERT INTO `tag` VALUES ('48', 'ASDFASD', '73');
INSERT INTO `tag` VALUES ('49', 'jj', '74');
INSERT INTO `tag` VALUES ('50', 'sdf', '75');
INSERT INTO `tag` VALUES ('51', 'jj', '74');
INSERT INTO `tag` VALUES ('52', 'baidu', '76');
INSERT INTO `tag` VALUES ('53', '度娘', '76');
INSERT INTO `tag` VALUES ('54', 'ASDFASD', '77');

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
