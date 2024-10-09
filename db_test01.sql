/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 100422 (10.4.22-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : db_test01

 Target Server Type    : MySQL
 Target Server Version : 100422 (10.4.22-MariaDB)
 File Encoding         : 65001

 Date: 09/10/2024 13:04:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for employees
-- ----------------------------
DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of employees
-- ----------------------------
INSERT INTO `employees` VALUES (1, 'นาย ก');
INSERT INTO `employees` VALUES (2, 'นาย ข');
INSERT INTO `employees` VALUES (3, 'นาย ค');

-- ----------------------------
-- Table structure for product_log
-- ----------------------------
DROP TABLE IF EXISTS `product_log`;
CREATE TABLE `product_log`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `old_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `new_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `edited_by` int NOT NULL,
  `edited_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_id`(`product_id` ASC) USING BTREE,
  INDEX `edited_by`(`edited_by` ASC) USING BTREE,
  CONSTRAINT `product_log_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `product_log_ibfk_2` FOREIGN KEY (`edited_by`) REFERENCES `employees` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_log
-- ----------------------------
INSERT INTO `product_log` VALUES (19, 1, 'Product 1 ', 'Product 1  แก้ไข', 1, '2024-10-09 12:59:00');
INSERT INTO `product_log` VALUES (20, 5, 'Product 5', 'Product 5', 2, '2024-10-09 13:00:06');
INSERT INTO `product_log` VALUES (21, 1, 'Product 1  แก้ไข', 'Product 1 ', 2, '2024-10-09 13:00:47');
INSERT INTO `product_log` VALUES (22, 1, 'Product 1 ', 'Product 1 ', 2, '2024-10-09 13:03:56');

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 'Product 1 ');
INSERT INTO `products` VALUES (2, 'Product 2');
INSERT INTO `products` VALUES (3, 'Product 3');
INSERT INTO `products` VALUES (4, 'Product 4');
INSERT INTO `products` VALUES (5, 'Product 5');

SET FOREIGN_KEY_CHECKS = 1;
