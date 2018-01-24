/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50635
 Source Host           : localhost
 Source Database       : yunzhi

 Target Server Type    : MySQL
 Target Server Version : 50635
 File Encoding         : utf-8

 Date: 01/24/2018 11:31:04 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `yunzhi_course`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_course`;
CREATE TABLE `yunzhi_course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_course`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_course` VALUES ('1', 'thinkphp5入门实例', '0', '0'), ('2', 'angularjs入门实例', '0', '0'), ('3', 'vue入门实例', '0', '0'), ('4', 'lavarel入门实例', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_klass`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_klass`;
CREATE TABLE `yunzhi_klass` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '名称',
  `teacher_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '教师ID',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_klass`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_klass` VALUES ('1', '实验1班', '3', '0', '1466493790'), ('2', '实验2班', '4', '0', '0'), ('3', '实验3班', '1', '0', '0'), ('4', '实验4班', '2', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_klass_course`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_klass_course`;
CREATE TABLE `yunzhi_klass_course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `klass_id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_klass_course`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_klass_course` VALUES ('2', '1', '2', '0', '0'), ('4', '2', '2', '0', '0'), ('6', '4', '2', '0', '0'), ('32', '2', '1', '0', '0'), ('9', '1', '3', '0', '0'), ('10', '2', '3', '0', '0'), ('11', '1', '4', '0', '0'), ('12', '2', '4', '0', '0'), ('31', '1', '1', '0', '0'), ('7', '3', '4', '0', '0'), ('33', '3', '1', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_student`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_student`;
CREATE TABLE `yunzhi_student` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '姓名',
  `num` varchar(40) NOT NULL DEFAULT '',
  `sex` tinyint(2) NOT NULL DEFAULT '0',
  `klass_id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(40) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_student`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_student` VALUES ('1', '徐琳杰', '111', '0', '4', 'xulinjie@yunzhiclub.com', '1970', '1516539304'), ('2', '魏静云', '112', '1', '2', 'weijingyun@yunzhiclub.com', '0', '0'), ('3', '刘茜', '113', '0', '2', 'liuxi@yunzhiclub.com', '0', '0'), ('4', '李甜', '114', '1', '1', 'litian@yunzhiclub.com', '0', '0'), ('5', '李翠彬', '115', '1', '3', 'licuibin@yunzhiclub.com', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `yunzhi_teacher`
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_teacher`;
CREATE TABLE `yunzhi_teacher` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT '' COMMENT '姓名',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0男，1女',
  `username` varchar(16) NOT NULL COMMENT '用户名',
  `email` varchar(30) DEFAULT '' COMMENT '邮箱',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `password` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `yunzhi_teacher`
-- ----------------------------
BEGIN;
INSERT INTO `yunzhi_teacher` VALUES ('2', '张五', '1', 'zhangwu', 'zhangwu@163.com', '1516434578', '1516434578', '5f67ea9991744a45432175cac508884ddc23b1c8'), ('1', '王五', '0', 'wangwu', 'wangwu@163.com', '1515641172', '1515663257', '5f67ea9991744a45432175cac508884ddc23b1c8'), ('4', '张六', '0', 'zhangliu', 'zhangliu@163.com', '1516434633', '1516434633', '5f67ea9991744a45432175cac508884ddc23b1c8'), ('3', '李四', '0', 'lisi', 'lisi@163.com', '1516365561', '1516365561', '5f67ea9991744a45432175cac508884ddc23b1c8');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
