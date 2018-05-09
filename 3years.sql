/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : 3years

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2018-05-09 16:47:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `auth_permission`
-- ----------------------------
DROP TABLE IF EXISTS `auth_permission`;
CREATE TABLE `auth_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `resource` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_permission
-- ----------------------------
INSERT INTO `auth_permission` VALUES ('1', '系统设置', 'system', '2018-04-26 11:09:59', '2018-04-26 11:10:02');
INSERT INTO `auth_permission` VALUES ('2', '个人设置', 'user', '2018-04-26 16:15:21', '2018-05-09 16:32:10');
INSERT INTO `auth_permission` VALUES ('6', 'test02', 'test02', '2018-05-07 15:06:55', '2018-05-07 15:06:55');
INSERT INTO `auth_permission` VALUES ('5', 'test01', 'test01', '2018-05-07 15:06:49', '2018-05-07 15:06:49');
INSERT INTO `auth_permission` VALUES ('7', 'test03', 'test03', '2018-05-07 15:06:58', '2018-05-07 15:06:58');
INSERT INTO `auth_permission` VALUES ('8', 'test04', 'test04', '2018-05-07 15:07:01', '2018-05-07 15:07:01');

-- ----------------------------
-- Table structure for `auth_role`
-- ----------------------------
DROP TABLE IF EXISTS `auth_role`;
CREATE TABLE `auth_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_role
-- ----------------------------
INSERT INTO `auth_role` VALUES ('5', '管理员', 'admin', '2018-05-07 16:19:18', '2018-05-07 16:57:57');
INSERT INTO `auth_role` VALUES ('6', '运营人员', 'staff', '2018-05-07 16:20:22', '2018-05-09 16:45:03');
INSERT INTO `auth_role` VALUES ('7', '测试专员', 'test', '2018-05-07 16:20:53', '2018-05-09 16:32:34');
INSERT INTO `auth_role` VALUES ('11', '111', '222', '2018-05-08 17:34:01', '2018-05-09 16:32:42');
INSERT INTO `auth_role` VALUES ('10', '访客', 'visitor', '2018-05-07 16:56:57', '2018-05-09 16:32:52');

-- ----------------------------
-- Table structure for `auth_role_permission`
-- ----------------------------
DROP TABLE IF EXISTS `auth_role_permission`;
CREATE TABLE `auth_role_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) NOT NULL,
  `permission_id` int(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_role_permission
-- ----------------------------
INSERT INTO `auth_role_permission` VALUES ('34', '10', '2', '2018-05-09 16:32:52', '2018-05-09 16:32:52');
INSERT INTO `auth_role_permission` VALUES ('33', '11', '2', '2018-05-09 16:32:42', '2018-05-09 16:32:42');
INSERT INTO `auth_role_permission` VALUES ('31', '7', '2', '2018-05-09 16:32:35', '2018-05-09 16:32:35');
INSERT INTO `auth_role_permission` VALUES ('32', '11', '1', '2018-05-09 16:32:42', '2018-05-09 16:32:42');
INSERT INTO `auth_role_permission` VALUES ('25', '5', '1', '2018-05-07 16:57:57', '2018-05-07 16:57:57');
INSERT INTO `auth_role_permission` VALUES ('24', '5', '2', '2018-05-07 16:57:57', '2018-05-07 16:57:57');
INSERT INTO `auth_role_permission` VALUES ('35', '6', '2', '2018-05-09 16:45:03', '2018-05-09 16:45:03');
INSERT INTO `auth_role_permission` VALUES ('30', '7', '8', '2018-05-09 16:32:35', '2018-05-09 16:32:35');
INSERT INTO `auth_role_permission` VALUES ('29', '7', '7', '2018-05-09 16:32:35', '2018-05-09 16:32:35');
INSERT INTO `auth_role_permission` VALUES ('28', '7', '5', '2018-05-09 16:32:35', '2018-05-09 16:32:35');
INSERT INTO `auth_role_permission` VALUES ('27', '7', '6', '2018-05-09 16:32:35', '2018-05-09 16:32:35');
INSERT INTO `auth_role_permission` VALUES ('36', '6', '6', '2018-05-09 16:45:03', '2018-05-09 16:45:03');
INSERT INTO `auth_role_permission` VALUES ('37', '6', '1', '2018-05-09 16:45:03', '2018-05-09 16:45:03');
INSERT INTO `auth_role_permission` VALUES ('38', '6', '5', '2018-05-09 16:45:03', '2018-05-09 16:45:03');
INSERT INTO `auth_role_permission` VALUES ('39', '6', '7', '2018-05-09 16:45:03', '2018-05-09 16:45:03');
INSERT INTO `auth_role_permission` VALUES ('40', '6', '8', '2018-05-09 16:45:03', '2018-05-09 16:45:03');

-- ----------------------------
-- Table structure for `auth_user`
-- ----------------------------
DROP TABLE IF EXISTS `auth_user`;
CREATE TABLE `auth_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL COMMENT '邮箱',
  `username` varchar(150) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0：禁用，1：启用',
  `is_superuser` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1：超级管理员',
  `last_login` datetime DEFAULT NULL COMMENT '最后登录时间',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_user
-- ----------------------------
INSERT INTO `auth_user` VALUES ('8', 'superuser@superuser.superuser', 'superuser', '$2y$08$/88j3ZehtfVINrE6th2Cwu203Y.2m7NOtFAjy3VKQxqXCdAITFm.i', '1', '1', '2018-05-07 16:18:07', '2018-05-07 16:17:58', null);
INSERT INTO `auth_user` VALUES ('9', 'abc@abc.com', 'wow111111', '$2y$08$E4QlbNRMnHEUe8z6uKb3qu8dJIjg.vFz933AqhrK7uqb7BmCAKgMW', '0', '0', null, '2018-05-07 17:58:38', '2018-05-09 16:45:35');
INSERT INTO `auth_user` VALUES ('11', 'fff@fff.fff', 'ffffff', '$2y$08$vOx3c71DDO7w9d/0tJnugOjaNfb/HoXX6y/F8WxWlDPf0/wS5TY3C', '1', '0', '2018-05-09 16:30:01', '2018-05-09 15:05:53', '2018-05-09 16:45:26');

-- ----------------------------
-- Table structure for `auth_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `auth_user_role`;
CREATE TABLE `auth_user_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_user_role
-- ----------------------------
INSERT INTO `auth_user_role` VALUES ('6', '9', '10', '2018-05-09 16:25:45', '2018-05-09 16:28:18');
INSERT INTO `auth_user_role` VALUES ('7', '11', '6', '2018-05-09 16:33:40', '2018-05-09 16:45:26');

-- ----------------------------
-- Table structure for `follows`
-- ----------------------------
DROP TABLE IF EXISTS `follows`;
CREATE TABLE `follows` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL,
  `headimgurl` varchar(255) DEFAULT NULL,
  `nickname` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `subscribe` tinyint(1) NOT NULL DEFAULT '0',
  `subscribe_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `subscribe_scene` varchar(50) DEFAULT NULL,
  `qr_scene` int(40) DEFAULT NULL,
  `qr_scene_str` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of follows
-- ----------------------------

-- ----------------------------
-- Table structure for `product_attributes`
-- ----------------------------
DROP TABLE IF EXISTS `product_attributes`;
CREATE TABLE `product_attributes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL COMMENT '商品分类ID',
  `name` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_attributes
-- ----------------------------

-- ----------------------------
-- Table structure for `product_categories`
-- ----------------------------
DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE `product_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `p_id` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `sort` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_categories
-- ----------------------------

-- ----------------------------
-- Table structure for `product_items`
-- ----------------------------
DROP TABLE IF EXISTS `product_items`;
CREATE TABLE `product_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL COMMENT '商品规格ID',
  `name` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_items
-- ----------------------------

-- ----------------------------
-- Table structure for `product_products`
-- ----------------------------
DROP TABLE IF EXISTS `product_products`;
CREATE TABLE `product_products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL COMMENT '分类ID',
  `name` varchar(100) NOT NULL COMMENT '商品名称',
  `img` varchar(255) NOT NULL COMMENT '商品图片',
  `original_price` decimal(12,2) DEFAULT '0.00' COMMENT '原价',
  `current_price` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '现价',
  `sold` int(11) NOT NULL DEFAULT '0' COMMENT '已售数量',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0：下架，1：上架',
  `sort` int(11) NOT NULL DEFAULT '0',
  `detail_info` text COMMENT '商品详情',
  `base_info` varchar(255) DEFAULT NULL COMMENT '商品简介',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_products
-- ----------------------------

-- ----------------------------
-- Table structure for `product_products_attributes`
-- ----------------------------
DROP TABLE IF EXISTS `product_products_attributes`;
CREATE TABLE `product_products_attributes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_products_attributes
-- ----------------------------

-- ----------------------------
-- Table structure for `product_products_banners`
-- ----------------------------
DROP TABLE IF EXISTS `product_products_banners`;
CREATE TABLE `product_products_banners` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL COMMENT '商品ID',
  `imgurl` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_products_banners
-- ----------------------------

-- ----------------------------
-- Table structure for `product_products_items`
-- ----------------------------
DROP TABLE IF EXISTS `product_products_items`;
CREATE TABLE `product_products_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_products_items
-- ----------------------------

-- ----------------------------
-- Table structure for `product_skus`
-- ----------------------------
DROP TABLE IF EXISTS `product_skus`;
CREATE TABLE `product_skus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stock` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_skus
-- ----------------------------

-- ----------------------------
-- Table structure for `product_skus_items`
-- ----------------------------
DROP TABLE IF EXISTS `product_skus_items`;
CREATE TABLE `product_skus_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sku_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_skus_items
-- ----------------------------
