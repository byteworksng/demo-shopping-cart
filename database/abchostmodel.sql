/*
 Navicat Premium Data Transfer

 Source Server         : MariaDB
 Source Server Type    : MariaDB
 Source Server Version : 100213
 Source Host           : localhost:3306
 Source Schema         : abchost

 Target Server Type    : MariaDB
 Target Server Version : 100213
 File Encoding         : 65001

 Date: 18/07/2018 14:38:14
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product
-- ----------------------------
BEGIN;
INSERT INTO `product` VALUES (1, 'Apple', 'Delicious in and healthy in every bite', 0.30, 'https://c2.staticflickr.com/4/3332/3600866644_35794645b0_m.jpg');
INSERT INTO `product` VALUES (2, 'Beer', 'Satisfying everytime', 2.00, 'https://c2.staticflickr.com/4/3192/2775570016_3480b4440d_n.jpg');
INSERT INTO `product` VALUES (3, 'Water', 'quench your thirst', 1.00, 'https://c1.staticflickr.com/8/7367/12977131413_dab67bb3b9_m.jpg');
INSERT INTO `product` VALUES (4, 'Cheese', 'Eat as much', 3.74, 'https://c2.staticflickr.com/4/3234/3093833340_40d7c8888d.jpg');
COMMIT;

-- ----------------------------
-- Table structure for rate
-- ----------------------------
DROP TABLE IF EXISTS `rate`;
CREATE TABLE `rate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(11) NOT NULL,
  `rate` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of rate
-- ----------------------------
BEGIN;
INSERT INTO `rate` VALUES (1, 1, 4);
INSERT INTO `rate` VALUES (2, 1, 2);
INSERT INTO `rate` VALUES (3, 2, 1);
INSERT INTO `rate` VALUES (4, 2, 2);
INSERT INTO `rate` VALUES (5, 4, 3);
INSERT INTO `rate` VALUES (6, 3, 3);
INSERT INTO `rate` VALUES (7, 3, 3);
INSERT INTO `rate` VALUES (8, 5, 5);
INSERT INTO `rate` VALUES (9, 4, 4);
INSERT INTO `rate` VALUES (10, 2, 3);
INSERT INTO `rate` VALUES (11, 1, 5);
INSERT INTO `rate` VALUES (12, 5, 2);
INSERT INTO `rate` VALUES (13, 4, 1);
INSERT INTO `rate` VALUES (14, 1, 3);
INSERT INTO `rate` VALUES (15, 1, 3);
INSERT INTO `rate` VALUES (16, 2, 3);
INSERT INTO `rate` VALUES (17, 2, 4);
INSERT INTO `rate` VALUES (18, 5, 4);
INSERT INTO `rate` VALUES (19, 5, 4);
INSERT INTO `rate` VALUES (20, 3, 4);
INSERT INTO `rate` VALUES (21, 2, 5);
INSERT INTO `rate` VALUES (22, 3, 5);
INSERT INTO `rate` VALUES (23, 3, 5);
INSERT INTO `rate` VALUES (24, 3, 5);
INSERT INTO `rate` VALUES (25, 3, 3);
INSERT INTO `rate` VALUES (26, 2, 4);
INSERT INTO `rate` VALUES (27, 2, 5);
INSERT INTO `rate` VALUES (28, 2, 5);
INSERT INTO `rate` VALUES (29, 2, 5);
INSERT INTO `rate` VALUES (30, 2, 2);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
