/*
 Navicat Premium Data Transfer

 Source Server         : root2212165
 Source Server Type    : MySQL
 Source Server Version : 100432
 Source Host           : 127.0.0.1:3306
 Source Schema         : milktea

 Target Server Type    : MySQL
 Target Server Version : 100432
 File Encoding         : 65001

 Date: 09/06/2024 04:33:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `ctel` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cname` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `cpoints` int(10) UNSIGNED NOT NULL,
  `cpw` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`cid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES (13, '11111111111', '小一', 3, '$2y$10$cHbpCVaOsxCWo1FSudCb9OtSnsVF9qCVUVgsk3GuJ0cDdm/7fkRS.');
INSERT INTO `customer` VALUES (14, '13719275697', '小哈', 0, '$2y$10$b8SaO7X4kMKtdDuKafw8U.XqjeFYL1IVOinmc2zGewlDLdgQbqz7y');
INSERT INTO `customer` VALUES (15, '13719275697', '小五', 0, '$2y$10$9mZRWiBqoV3Rdblufl36CeiGJ5iZS979/LOxy3Pwv0DPNt6LmH9Uy');
INSERT INTO `customer` VALUES (16, '22222222222', '好好好', 0, '$2y$10$FtD8sDAJwhv30hHuA9.i2.MeNPaNt7OPSZ1us0VvALQj4YMnAYaRK');
INSERT INTO `customer` VALUES (17, '11223344556', '嘿嘿', 0, '$2y$10$4C9FBO4bItg8/Gm1nHTHBukI0WBtbt2qIXBoD.0sGR3g1wtdVS1rm');
INSERT INTO `customer` VALUES (18, '44444444444', '444', 0, '$2y$10$V7duAZcxnX5MeOw455jL5OvuEiD5oLVnn6llKebYrSH8NKrlPXAC6');
INSERT INTO `customer` VALUES (19, '99999999999', '小九', 0, '$2y$10$qFCkIQLP3a/bQM0SB8MLLeke6uCIN8ba/WPGVII0s7DY0NE2Egp4i');

-- ----------------------------
-- Table structure for good
-- ----------------------------
DROP TABLE IF EXISTS `good`;
CREATE TABLE `good`  (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `gprice` int(11) NOT NULL,
  `gname` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gintro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gbeizhu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`gid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of good
-- ----------------------------
INSERT INTO `good` VALUES (1, 15, '百香果双响炮', '百香果遇上绝世好茶', '制作时多加百香果');
INSERT INTO `good` VALUES (2, 10, '芒果绿茶', '芒果遇上绝世好茶', NULL);
INSERT INTO `good` VALUES (3, 14, '莓莓果茶', '草莓遇上绝世好茶', '多加草莓');
INSERT INTO `good` VALUES (4, 5, '柠檬茶', '遇上绝世好柠檬', NULL);
INSERT INTO `good` VALUES (5, 18, '杨枝甘露', NULL, '多加芒果');
INSERT INTO `good` VALUES (6, 13, '四季奶青', '超级美味', NULL);
INSERT INTO `good` VALUES (7, 9, '经典拿铁', '超经典', NULL);

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order`  (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `oaddr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ogood` int(11) NOT NULL,
  `otel` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `obeizhu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ostatus` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'making',
  `owid` int(11) NULL DEFAULT NULL,
  `oname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `osid` int(11) NOT NULL,
  `ocid` int(11) NOT NULL,
  PRIMARY KEY (`oid`) USING BTREE,
  INDEX `ogood`(`ogood`) USING BTREE,
  INDEX `osid`(`osid`) USING BTREE,
  INDEX `owid`(`owid`) USING BTREE,
  CONSTRAINT `ogood` FOREIGN KEY (`ogood`) REFERENCES `good` (`gid`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `osid` FOREIGN KEY (`osid`) REFERENCES `shop` (`sid`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `owid` FOREIGN KEY (`owid`) REFERENCES `worker` (`wid`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES (3, '南开大学', 1, '11111111111', '多放小料', 'finished', 1, '小绿', 1, 13);
INSERT INTO `order` VALUES (4, '南开大学', 3, '22222222222', NULL, 'making', NULL, '小蓝', 1, 13);
INSERT INTO `order` VALUES (5, '南开大学', 3, '11111111111', NULL, 'making', NULL, '小紫', 1, 17);
INSERT INTO `order` VALUES (6, '八里台', 2, '22222234564', NULL, 'error', NULL, '小红', 1, 17);
INSERT INTO `order` VALUES (7, '天津大学', 1, '23443675632', NULL, 'distributing', 1, '小黄', 1, 17);
INSERT INTO `order` VALUES (9, '河北工业大学', 7, '11111111111', '多加冰', 'making', NULL, '小粉', 3, 15);
INSERT INTO `order` VALUES (10, '天津师范大学', 6, '22222222222', '好好干', 'distributing', 6, '小黑', 4, 14);
INSERT INTO `order` VALUES (11, '天津大学', 2, '33333333333', NULL, 'error', NULL, '小花', 2, 13);
INSERT INTO `order` VALUES (12, '1111', 1, '11111111111', '', 'making', NULL, '111', 2, 13);
INSERT INTO `order` VALUES (13, '2', 1, '11111111111', '', 'making', NULL, '1234', 2, 13);
INSERT INTO `order` VALUES (14, '2', 1, '11111111111', '', 'making', NULL, '1234', 2, 13);
INSERT INTO `order` VALUES (15, '1111', 1, '11111111111', '', 'making', NULL, '1234', 2, 13);

-- ----------------------------
-- Table structure for shop
-- ----------------------------
DROP TABLE IF EXISTS `shop`;
CREATE TABLE `shop`  (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `sname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`sid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of shop
-- ----------------------------
INSERT INTO `shop` VALUES (1, '南开大学店');
INSERT INTO `shop` VALUES (2, '天津大学店');
INSERT INTO `shop` VALUES (3, '天津师范大学店');
INSERT INTO `shop` VALUES (4, '河北工业大学店');

-- ----------------------------
-- Table structure for ssellg
-- ----------------------------
DROP TABLE IF EXISTS `ssellg`;
CREATE TABLE `ssellg`  (
  `sid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  PRIMARY KEY (`sid`, `gid`) USING BTREE,
  INDEX `gid_sg`(`gid`) USING BTREE,
  CONSTRAINT `gid_sg` FOREIGN KEY (`gid`) REFERENCES `good` (`gid`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sid_sg` FOREIGN KEY (`sid`) REFERENCES `shop` (`sid`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ssellg
-- ----------------------------
INSERT INTO `ssellg` VALUES (1, 4);
INSERT INTO `ssellg` VALUES (2, 1);
INSERT INTO `ssellg` VALUES (2, 2);
INSERT INTO `ssellg` VALUES (3, 1);
INSERT INTO `ssellg` VALUES (3, 3);
INSERT INTO `ssellg` VALUES (3, 7);
INSERT INTO `ssellg` VALUES (4, 1);
INSERT INTO `ssellg` VALUES (4, 2);
INSERT INTO `ssellg` VALUES (4, 4);
INSERT INTO `ssellg` VALUES (4, 7);

-- ----------------------------
-- Table structure for worker
-- ----------------------------
DROP TABLE IF EXISTS `worker`;
CREATE TABLE `worker`  (
  `wid` int(11) NOT NULL AUTO_INCREMENT,
  `wpos` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '普通员工',
  `ctel` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `wname` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cpw` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '$2y$10$FtD8sDAJwhv30hHuA9.i2.MeNPaNt7OPSZ1us0VvALQj4YMnAYaRK',
  `wsid` int(11) NOT NULL,
  `wage` int(11) NOT NULL DEFAULT 3000,
  `waddr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`wid`) USING BTREE,
  INDEX `wsid`(`wsid`) USING BTREE,
  CONSTRAINT `wsid` FOREIGN KEY (`wsid`) REFERENCES `shop` (`sid`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of worker
-- ----------------------------
INSERT INTO `worker` VALUES (1, '普通员工', '11111111111', '王五', '$2y$10$FtD8sDAJwhv30hHuA9.i2.MeNPaNt7OPSZ1us0VvALQj4YMnAYaRK', 1, 3000, NULL);
INSERT INTO `worker` VALUES (2, '店长', '22222222222', '李二一', '$2y$10$FtD8sDAJwhv30hHuA9.i2.MeNPaNt7OPSZ1us0VvALQj4YMnAYaRK', 1, 4000, NULL);
INSERT INTO `worker` VALUES (3, '普通员工', '44444444444', '李二', '$2y$10$FtD8sDAJwhv30hHuA9.i2.MeNPaNt7OPSZ1us0VvALQj4YMnAYaRK', 2, 3000, NULL);
INSERT INTO `worker` VALUES (4, '店长', '55555555555', '张四', '$2y$10$FtD8sDAJwhv30hHuA9.i2.MeNPaNt7OPSZ1us0VvALQj4YMnAYaRK', 2, 3000, NULL);
INSERT INTO `worker` VALUES (5, '普通员工', '33333333333', '赵三', '$2y$10$FtD8sDAJwhv30hHuA9.i2.MeNPaNt7OPSZ1us0VvALQj4YMnAYaRK', 1, 4000, NULL);
INSERT INTO `worker` VALUES (6, '店长', '66666666666', '王六', '$2y$10$FtD8sDAJwhv30hHuA9.i2.MeNPaNt7OPSZ1us0VvALQj4YMnAYaRK', 4, 5800, NULL);
INSERT INTO `worker` VALUES (7, '店长', '77777777777', '周六', '$2y$10$lPulxtdXERGQzFSccso0DuJ6N4ee64Y7OOPW/cRhoEbkFu1HzcoUW', 3, 3000, NULL);
INSERT INTO `worker` VALUES (9, '普通员工', '99999999999', '周八', '$2y$10$FtD8sDAJwhv30hHuA9.i2.MeNPaNt7OPSZ1us0VvALQj4YMnAYaRK', 4, 3000, NULL);

-- ----------------------------
-- View structure for order_view
-- ----------------------------
DROP VIEW IF EXISTS `order_view`;
CREATE ALGORITHM = UNDEFINED DEFINER = `root`@`localhost` SQL SECURITY DEFINER VIEW `order_view` AS SELECT 
    o.oid AS '订单ID',
    g.gname AS '商品名',
    o.oaddr AS '收货地址',
    o.otel AS '手机号码',
    o.oname AS '收货人',
    o.obeizhu AS '备注',
    o.ostatus AS '订单状态',
    w.wname AS '处理人姓名',
    o.osid AS 'shopid'
FROM 
    `order` o
JOIN 
    good g ON o.ogood = g.gid
LEFT JOIN 
    `worker` w ON o.owid = w.wid ;

-- ----------------------------
-- Procedure structure for check_salary
-- ----------------------------
DROP PROCEDURE IF EXISTS `check_salary`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `check_salary`(IN empid int(11), IN newsala int)
BEGIN
    DECLARE completedOrders INT DEFAULT 0;
    DECLARE storeSales INT DEFAULT 0;
    DECLARE oldsala INT DEFAULT 0;
    
    SELECT wage INTO oldsala
    FROM `worker`
    WHERE wid = empid;

    SELECT COUNT(*) INTO completedOrders
    FROM `order`
    WHERE owid = empid;
    
    -- 先把order中各worker完成的订单数形成一个表，再与worker用join连接，计算与目标worker同店的订单数的总和给storeSales
    SELECT SUM(subquery.sales_count) INTO storeSales
    FROM (
        SELECT COUNT(*) AS sales_count,owid
        FROM `order`
        GROUP BY owid
    ) AS subquery
    JOIN `worker` ON subquery.owid = worker.wid
    WHERE worker.wsid = (SELECT wsid FROM worker WHERE wid=empid) ;

    IF (completedOrders < 5 OR storeSales < 10 OR storeSales is null) AND newsala > 5000 THEN
      SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = '该员工没有涨工资的资格';
    ELSEIF newsala < oldsala THEN
      SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = '请检查输入';
    ELSE
        UPDATE `worker`
        SET wage = newsala
        WHERE wid = empid;
    END IF;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table customer
-- ----------------------------
DROP TRIGGER IF EXISTS `sign`;
delimiter ;;
CREATE TRIGGER `sign` BEFORE INSERT ON `customer` FOR EACH ROW BEGIN
   IF (CHAR_LENGTH(NEW.ctel) != 11 OR NOT NEW.ctel REGEXP '^[0-9]{11}$') THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '请检查输入合法性';
   END IF;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table order
-- ----------------------------
DROP TRIGGER IF EXISTS `submitorder`;
delimiter ;;
CREATE TRIGGER `submitorder` BEFORE INSERT ON `order` FOR EACH ROW BEGIN
	DECLARE sid_exists INT;
	SELECT COUNT(*) INTO sid_exists
	FROM ssellg
	WHERE sid = NEW.osid AND gid = NEW.ogood;
			
	IF sid_exists = 0 THEN
			SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = '该店暂不售卖该产品';
	END IF;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
