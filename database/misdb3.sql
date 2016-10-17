/*
Navicat MySQL Data Transfer

Source Server         : ScarZ
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : misdb

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-10-17 13:57:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for billdisp
-- ----------------------------
DROP TABLE IF EXISTS `billdisp`;
CREATE TABLE `billdisp` (
  `billdisp_id` int(10) NOT NULL AUTO_INCREMENT,
  `providerID` int(5) NOT NULL,
  `dispenseID` varchar(15) DEFAULT NULL,
  `invoice_no` varchar(12) DEFAULT NULL,
  `hn` varchar(10) NOT NULL,
  `PID` varchar(13) NOT NULL,
  `prescription_date` datetime DEFAULT NULL,
  `dispensed_date` datetime DEFAULT NULL,
  `prescriber` varchar(6) DEFAULT NULL,
  `item_count` int(2) NOT NULL,
  `charg_amount` decimal(9,2) DEFAULT NULL,
  `claim_amount` decimal(9,2) DEFAULT NULL,
  `paid_amount` decimal(9,2) DEFAULT NULL,
  `other_amount` decimal(9,2) DEFAULT NULL,
  `reimbuser` varchar(6) DEFAULT NULL,
  `benefit_plan` varchar(6) DEFAULT NULL,
  `dispense_status` int(2) DEFAULT NULL,
  `chk` int(3) DEFAULT '0',
  PRIMARY KEY (`billdisp_id`),
  UNIQUE KEY `hn` (`hn`,`prescription_date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of billdisp
-- ----------------------------

-- ----------------------------
-- Table structure for billdisp_item
-- ----------------------------
DROP TABLE IF EXISTS `billdisp_item`;
CREATE TABLE `billdisp_item` (
  `billdispitem_id` int(10) NOT NULL AUTO_INCREMENT,
  `hos_guid` varchar(38) NOT NULL,
  `dispenseID` varchar(15) DEFAULT NULL,
  `productCategory` int(2) DEFAULT NULL,
  `HospitalDrugID` int(7) DEFAULT NULL,
  `drugID` int(6) DEFAULT NULL,
  `dfsCode` varchar(255) DEFAULT NULL,
  `dfstext` varchar(255) DEFAULT NULL,
  `PackSize` varchar(50) DEFAULT NULL,
  `singcode` int(6) DEFAULT NULL,
  `sigText` varchar(255) DEFAULT NULL,
  `quantity` int(4) DEFAULT NULL,
  `UnitPrice` decimal(6,2) DEFAULT NULL,
  `Chargeamount` decimal(6,2) DEFAULT NULL,
  `ReimbPrice` decimal(6,2) DEFAULT NULL,
  `ReimbAmount` decimal(6,2) DEFAULT NULL,
  `ProDuctselectionCode` varchar(5) DEFAULT NULL,
  `refill` varchar(5) DEFAULT NULL,
  `claimControl` varchar(5) DEFAULT NULL,
  `ClaimCategory` varchar(5) DEFAULT NULL,
  `prescription_date` datetime DEFAULT NULL,
  `chk` int(3) DEFAULT '0',
  PRIMARY KEY (`billdispitem_id`),
  UNIQUE KEY `dispenseID` (`dispenseID`,`hos_guid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of billdisp_item
-- ----------------------------

-- ----------------------------
-- Table structure for billtran
-- ----------------------------
DROP TABLE IF EXISTS `billtran`;
CREATE TABLE `billtran` (
  `billtran_id` int(10) NOT NULL AUTO_INCREMENT,
  `Station` int(5) NOT NULL,
  `AuthCode` int(10) DEFAULT NULL,
  `DTTran` datetime DEFAULT NULL,
  `HCode` int(5) DEFAULT NULL,
  `InvNo` varchar(12) DEFAULT NULL,
  `BillNo` varchar(10) DEFAULT NULL,
  `HN` varchar(10) DEFAULT NULL,
  `MemberNo` varchar(10) DEFAULT NULL,
  `Amount` decimal(9,2) DEFAULT NULL,
  `Paid` decimal(5,2) DEFAULT NULL,
  `VerCode` varchar(10) DEFAULT NULL,
  `Tflag` varchar(10) DEFAULT NULL,
  `chk` int(3) DEFAULT NULL,
  PRIMARY KEY (`billtran_id`),
  UNIQUE KEY `DTTran` (`DTTran`,`HN`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of billtran
-- ----------------------------

-- ----------------------------
-- Table structure for billtran_item
-- ----------------------------
DROP TABLE IF EXISTS `billtran_item`;
CREATE TABLE `billtran_item` (
  `billtranitem_id` int(10) NOT NULL AUTO_INCREMENT,
  `hos_guid` varchar(38) NOT NULL,
  `InvNo` varchar(12) DEFAULT NULL,
  `BillMuad` varchar(2) DEFAULT NULL,
  `Amount` decimal(9,2) DEFAULT NULL,
  `Paid` decimal(5,2) DEFAULT NULL,
  `DTTran` datetime DEFAULT NULL,
  `chk` int(3) DEFAULT NULL,
  PRIMARY KEY (`billtranitem_id`),
  UNIQUE KEY `InvNo` (`hos_guid`,`InvNo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of billtran_item
-- ----------------------------

-- ----------------------------
-- Table structure for hospital
-- ----------------------------
DROP TABLE IF EXISTS `hospital`;
CREATE TABLE `hospital` (
  `hospital` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `manager` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`hospital`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hospital
-- ----------------------------
INSERT INTO `hospital` VALUES ('1', 'โรงพยาบาลจิตเวชเลยราชนครินทร์', '0133', '09-07-20151logo.png', 'http://localhost:89/', 'โรงพยาบาลจิตเวชเลยฯ');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_fname` varchar(200) NOT NULL,
  `user_lname` varchar(200) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_account` varchar(200) NOT NULL,
  `user_pwd` varchar(200) NOT NULL,
  `user_status` int(1) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `date_login` datetime DEFAULT NULL,
  `time_login` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'ฐานปนพงศ์', 'ดีอุดมจันทร์', 'scarz', 'a182e991eb5396de1e18f430dbc49a37', 'e82a0d322fa2653ba0ce48474cbe03a6', '0', '14-10-20161103514707665928000459681740219600770174620n.jpg', '2016-10-17 12:10:47', '1476683867');
INSERT INTO `user` VALUES ('2', 'ขัตติยา', 'วัฒนา', 'ae', 'b6bb43df4525b928a105fb5741bddbea', '81dc9bdb52d04dc20036dbd8313ed055', '1', null, '2016-10-13 13:10:44', '1476340304');
INSERT INTO `user` VALUES ('3', 'สมิง', 'ศรีบุตรตา', 'toy', '10016b6ed5a5b09be08133fa2d282636', '81dc9bdb52d04dc20036dbd8313ed055', '0', null, null, null);
