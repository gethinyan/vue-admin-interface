SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for va_user
-- ----------------------------
DROP TABLE IF EXISTS `va_user`;
CREATE TABLE `va_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '地址',
  `gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别（1男性2女性）',
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `avatar_url` varchar(200) NOT NULL DEFAULT '' COMMENT '头像地址',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '用户状态（1有效2无效）',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

INSERT INTO `va_user` VALUES ('1', 'user_name', 'address', '1', '13888888888', 'admin@admin.com', '', '$2y$13$r44JWKcWt27ZwdfU.Bc0menUd0hq6.qrYTIPsY.tqBR2FXXm0nCUG', '1', UNIX_TIMESTAMP(NOW()), UNIX_TIMESTAMP(NOW()));

SET FOREIGN_KEY_CHECKS = 1;
