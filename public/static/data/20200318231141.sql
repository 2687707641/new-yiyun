/*
MySQL Database Backup Tools
Server:localhost:3306
Database:new_yiyun
Data:2020-03-18 23:11:41
*/
SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for tb_auth_competency
-- ----------------------------
DROP TABLE IF EXISTS `tb_auth_competency`;
CREATE TABLE `tb_auth_competency` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限规则ID',
  `name` varchar(255) DEFAULT NULL COMMENT '规则名称',
  `url` varchar(255) DEFAULT NULL COMMENT '方法路由',
  `remark` varchar(255) DEFAULT NULL COMMENT '规则描述',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `deleted` tinyint(1) DEFAULT '0' COMMENT '是否被删除(0:否,1:是)',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='权限规则表(操作方法)';
-- ----------------------------
-- Records of tb_auth_competency
-- ----------------------------
INSERT INTO `tb_auth_competency` (`id`,`name`,`url`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('1','添加权限规则','Competency/add','拥有新增权限规则的能力','1','0','2019-12-23 12:27:55','2019-12-23 12:27:55');
INSERT INTO `tb_auth_competency` (`id`,`name`,`url`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('2','编辑权限规则','Competency/edit','拥有修改权限规则的能力','1','0','2019-12-23 12:29:20','2019-12-23 12:29:20');
INSERT INTO `tb_auth_competency` (`id`,`name`,`url`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('3','启用/禁用权限规则','Competency/change_status','拥有更改权限规则状态的能力','1','0','2019-12-23 14:01:45','2019-12-23 14:01:45');
INSERT INTO `tb_auth_competency` (`id`,`name`,`url`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('4','删除权限规则','Competency/del','拥有删除权限规则的能力','1','0','2019-12-23 14:04:05','2019-12-23 14:04:05');
INSERT INTO `tb_auth_competency` (`id`,`name`,`url`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('5','添加角色','Role/add','拥有添加角色的能力','1','0','2019-12-23 14:04:54','2019-12-23 14:05:13');
INSERT INTO `tb_auth_competency` (`id`,`name`,`url`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('6','编辑角色','Role/edit','拥有编辑角色的能力','1','0','2019-12-23 14:06:07','2019-12-23 14:06:07');
INSERT INTO `tb_auth_competency` (`id`,`name`,`url`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('7','启用/禁用角色','Role/change_status','拥有启用/禁用角色的能力','1','0','2019-12-23 14:07:16','2019-12-23 14:07:16');
INSERT INTO `tb_auth_competency` (`id`,`name`,`url`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('8','角色分配权限','Role/assign_authority','拥有给角色分配权限的能力','1','0','2019-12-23 14:08:46','2019-12-23 14:19:30');
INSERT INTO `tb_auth_competency` (`id`,`name`,`url`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('9','删除角色','Role/del','拥有删除角色的能力','1','0','2019-12-23 14:09:33','2019-12-23 14:19:30');
INSERT INTO `tb_auth_competency` (`id`,`name`,`url`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('10','添加管理员','Manager/add','拥有添加管理员的能力','1','0','2019-12-23 14:41:26','2019-12-23 14:41:26');
INSERT INTO `tb_auth_competency` (`id`,`name`,`url`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('11','编辑管理员','Manager/edit','拥有编辑管理员的能力','1','0','2019-12-23 14:42:02','2019-12-23 14:42:02');
INSERT INTO `tb_auth_competency` (`id`,`name`,`url`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('12','启用/停用管理员','Manager/change_status','拥有启用/停用管理员的能力','1','0','2019-12-23 14:42:44','2019-12-23 14:42:44');
INSERT INTO `tb_auth_competency` (`id`,`name`,`url`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('13','删除管理员','Manager/del','拥有删除管理员的能力','1','0','2019-12-23 14:43:11','2019-12-23 14:43:11');

-- ----------------------------
-- Table structure for tb_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `tb_auth_group`;
CREATE TABLE `tb_auth_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `role_name` varchar(255) DEFAULT NULL COMMENT '角色名称',
  `rules` varchar(255) DEFAULT NULL COMMENT '权限节点ID',
  `competency` varchar(255) DEFAULT NULL COMMENT '权限规则ID',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注(描述)',
  `status` int(1) DEFAULT '1' COMMENT '启用状态(0:禁用,1:启用)',
  `deleted` int(1) DEFAULT '0' COMMENT '是否删除(0:否,1:是)',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='角色权限表';
-- ----------------------------
-- Records of tb_auth_group
-- ----------------------------
INSERT INTO `tb_auth_group` (`id`,`role_name`,`rules`,`competency`,`remark`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('1','后台管理员',',1,2,3,4,5,6,7,8,9,10,11,12,',',5,10,','','1','0','2020-03-10 19:40:33','2020-03-10 19:42:10');

-- ----------------------------
-- Table structure for tb_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `tb_auth_rule`;
CREATE TABLE `tb_auth_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '侧边栏菜单ID',
  `name` varchar(255) DEFAULT NULL COMMENT '菜单名称',
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `pid` int(11) DEFAULT '0' COMMENT '上级栏目ID(0为顶级栏目)',
  `url` varchar(255) DEFAULT '#' COMMENT '菜单对应路由',
  `remark` varchar(255) DEFAULT NULL COMMENT '描述',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `deleted` tinyint(1) DEFAULT '0' COMMENT '是否被删除(0:否,1:是)',
  `sort` varchar(255) DEFAULT '1' COMMENT '排序',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='权限节点表(侧边菜单栏)';
-- ----------------------------
-- Records of tb_auth_rule
-- ----------------------------
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('1','用户管理','&#xe6b8;','0','','123','1','0','1','2019-11-29 11:06:39','2019-12-25 16:23:39');
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('2','用户列表','','1','user/lists','','1','0','','2019-11-29 11:07:13','2019-12-25 16:45:42');
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('3','商品管理','&#xe83b;','0','','','1','0','1','2019-11-29 11:09:33','2019-12-24 15:31:55');
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('4','商品列表','','3','Book/lists','','1','0','','2019-11-29 11:10:01','2020-03-10 19:54:47');
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('5','订单管理','','0','','','1','0','1','2019-11-29 11:10:27','2019-12-24 15:17:49');
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('6','订单列表','','5','','','1','0','','2019-11-29 11:10:48','2019-11-29 11:10:51');
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('7','系统管理','&#xe6ae;','0','','','1','0','80','2019-11-29 11:11:11','2019-12-24 15:31:09');
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('8','管理员列表','&#xe726;','7','manager/lists','','1','0','','2019-11-29 11:11:47','2019-11-29 11:11:50');
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('9','角色管理','&#xe6f5;','7','role/lists','','1','0','','2019-11-29 11:12:22','2019-12-24 15:30:50');
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('10','权限规则','&#xe6f1;','7','competency/lists','','1','0','','2019-11-29 11:12:43','2019-11-29 11:12:45');
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('11','菜单管理','&#xe6b4;','7','menu/lists','','1','0','','2019-11-29 11:13:08','2019-11-29 11:13:10');
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('12','操作日志','&#xe6fc;','7','logs/lists','','1','0','','2019-11-29 11:13:23','2019-12-24 15:22:37');
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('13','商品分类','','3','Cate/lists','','1','0','1','2020-03-10 20:11:04','2020-03-10 23:13:30');
INSERT INTO `tb_auth_rule` (`id`,`name`,`icon`,`pid`,`url`,`remark`,`status`,`deleted`,`sort`,`create_time`,`update_time`) VALUES ('14','数据管理','','7','Backup/lists','对数据进行备份,与还原','1','0','1','2020-03-18 22:06:23','2020-03-18 22:06:23');

-- ----------------------------
-- Table structure for tb_book
-- ----------------------------
DROP TABLE IF EXISTS `tb_book`;
CREATE TABLE `tb_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID主键',
  `name` varchar(255) DEFAULT NULL COMMENT '书籍名称',
  `remark` varchar(255) DEFAULT NULL COMMENT '描述',
  `pid` int(11) DEFAULT NULL COMMENT '所属栏目ID',
  `prince` decimal(11,2) DEFAULT NULL COMMENT '价格',
  `number` int(8) DEFAULT NULL COMMENT '数量',
  `author` varchar(255) DEFAULT NULL COMMENT '作者',
  `picture` varchar(255) DEFAULT NULL COMMENT '展示图',
  `sales` int(11) unsigned DEFAULT '0' COMMENT '销量',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态(0:禁用 1:启用)',
  `deleted` tinyint(1) DEFAULT '0' COMMENT '是否被删除(0:否 1:是)',
  `create_time` datetime DEFAULT NULL COMMENT '添加时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='商品表';
-- ----------------------------
-- Records of tb_book
-- ----------------------------
INSERT INTO `tb_book` (`id`,`name`,`remark`,`pid`,`prince`,`number`,`author`,`picture`,`sales`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('1','book1','','3','12.00','3','匿名','/image/book/20200316/dd67f880a8037c80c02579441c673c01.jpg','0','1','0','2020-03-16 18:14:04','2020-03-16 18:14:04');
INSERT INTO `tb_book` (`id`,`name`,`remark`,`pid`,`prince`,`number`,`author`,`picture`,`sales`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('2','book2','3','3','11.00','11','匿名','/image/book/20200316/30c80f6d39d1247455f3c4870a6e072e.jpg','0','1','0','2020-03-16 18:14:20','2020-03-16 18:14:20');
INSERT INTO `tb_book` (`id`,`name`,`remark`,`pid`,`prince`,`number`,`author`,`picture`,`sales`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('3','book3','3','8','12.00','33','匿名','/image/book/20200316/60cf0aae084a4da09836f83d41e23c64.jpg','0','1','0','2020-03-16 18:14:40','2020-03-16 18:16:13');

-- ----------------------------
-- Table structure for tb_cate
-- ----------------------------
DROP TABLE IF EXISTS `tb_cate`;
CREATE TABLE `tb_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(255) DEFAULT NULL COMMENT '分类名',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) DEFAULT '1' COMMENT '状(0:禁用 1:启用)',
  `pid` int(11) DEFAULT '0' COMMENT 'parent_id(父级ID)',
  `picture` varchar(255) DEFAULT NULL COMMENT '展示图片地址',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  `deleted` tinyint(1) DEFAULT '0' COMMENT '是否被删除(0:否,1:是)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='商品分类表';
-- ----------------------------
-- Records of tb_cate
-- ----------------------------
INSERT INTO `tb_cate` (`id`,`name`,`remark`,`status`,`pid`,`picture`,`create_time`,`update_time`,`deleted`) VALUES ('3','Mystery Suspense','分类1','1','0','/image/book/ia_200000013.jpg','2020-03-13 16:43:30','2020-03-13 19:15:08','0');
INSERT INTO `tb_cate` (`id`,`name`,`remark`,`status`,`pid`,`picture`,`create_time`,`update_time`,`deleted`) VALUES ('6','测试','测试','1','','/image/book/20200313/d674a03ebab005072c51b833a7a42b15.jpg','2020-03-13 20:56:54','2020-03-16 18:14:48','1');
INSERT INTO `tb_cate` (`id`,`name`,`remark`,`status`,`pid`,`picture`,`create_time`,`update_time`,`deleted`) VALUES ('7','weqwe','qweqwe','1','','/image/book/20200313/dadb4150aa8b1b1fc672d96efc8fa827.jpg','2020-03-13 21:42:59','2020-03-16 18:14:52','1');
INSERT INTO `tb_cate` (`id`,`name`,`remark`,`status`,`pid`,`picture`,`create_time`,`update_time`,`deleted`) VALUES ('8','qazwsx','123','1','0','/image/book/20200316/3c5370bcc57187d7746aaff9d75480c0.jpg','2020-03-16 18:15:04','2020-03-16 18:15:04','0');

-- ----------------------------
-- Table structure for tb_logs
-- ----------------------------
DROP TABLE IF EXISTS `tb_logs`;
CREATE TABLE `tb_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `username` varchar(255) DEFAULT NULL COMMENT '操作者',
  `action` varchar(255) DEFAULT NULL COMMENT '执行行为',
  `ip_addr` varchar(255) DEFAULT NULL COMMENT '操作者IP地址',
  `details` text COMMENT '详情(sql语句)',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COMMENT='操作日志表';
-- ----------------------------
-- Records of tb_logs
-- ----------------------------
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('1','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=92,`login_ip`='192.168.182.1',`last_login_time`='2020-03-03,15-47-35',`update_time`='2020-03-03 15:47:35'  WHERE  `id` = 1','2020-03-03 15:47:35');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('2','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=93,`login_ip`='192.168.182.1',`last_login_time`='2020-03-04,18-22-55',`update_time`='2020-03-04 18:22:55'  WHERE  `id` = 1','2020-03-04 18:22:55');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('3','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=94,`login_ip`='192.168.182.1',`last_login_time`='2020-03-10,19-34-43',`update_time`='2020-03-10 19:34:43'  WHERE  `id` = 1','2020-03-10 19:34:43');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('4','admin','禁用管理员:外比巴卜','192.168.182.1','UPDATE `tb_user`  SET `status`=0,`update_time`='2020-03-10 19:34:54'  WHERE  `id` = 2','2020-03-10 19:34:54');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('5','admin','启用管理员:外比巴卜','192.168.182.1','UPDATE `tb_user`  SET `status`=1,`update_time`='2020-03-10 19:34:57'  WHERE  `id` = 2','2020-03-10 19:34:57');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('6','admin','删除用户:外比巴卜','192.168.182.1','UPDATE `tb_user`  SET `deleted`=1,`update_time`='2020-03-10 19:36:17'  WHERE  `id` IN (2)','2020-03-10 19:36:17');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('7','admin','新增角色: 后台管理员','192.168.182.1','INSERT INTO `tb_auth_group` (`role_name` , `rules` , `remark` , `create_time` , `update_time`) VALUES ('后台管理员' , ',1,2,3,4,5,6,7,8,9,10,11,12,' , '' , '2020-03-10 19:40:33' , '2020-03-10 19:40:33')','2020-03-10 19:40:33');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('8','admin','更改角色权限:后台管理员','192.168.182.1','UPDATE `tb_auth_group`  SET `role_name`='后台管理员',`competency`=',5,10,',`remark`='',`update_time`='2020-03-10 19:42:10'  WHERE  `id` = 1','2020-03-10 19:42:10');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('9','admin','编辑菜单: 商品列表','192.168.182.1','UPDATE `tb_auth_rule`  SET `name`='商品列表',`url`='Book/lists',`pid`=0,`icon`='',`remark`='',`update_time`='2020-03-10 19:54:20'  WHERE  `id` = 4','2020-03-10 19:54:20');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('10','admin','编辑菜单: 商品列表','192.168.182.1','UPDATE `tb_auth_rule`  SET `name`='商品列表',`url`='Book/lists',`pid`=3,`icon`='',`remark`='',`update_time`='2020-03-10 19:54:47'  WHERE  `id` = 4','2020-03-10 19:54:47');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('11','admin','新增菜单: 商品分类','192.168.182.1','INSERT INTO `tb_auth_rule` (`name` , `url` , `pid` , `icon` , `remark` , `create_time` , `update_time`) VALUES ('商品分类' , '' , 3 , '' , '' , '2020-03-10 20:11:04' , '2020-03-10 20:11:04')','2020-03-10 20:11:04');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('12','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=95,`login_ip`='192.168.182.1',`last_login_time`='2020-03-10,22-58-12',`update_time`='2020-03-10 22:58:12'  WHERE  `id` = 1','2020-03-10 22:58:12');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('13','admin','编辑菜单: 商品分类','192.168.182.1','UPDATE `tb_auth_rule`  SET `name`='商品分类',`url`='Cate/list',`pid`=3,`icon`='',`remark`='',`update_time`='2020-03-10 23:12:57'  WHERE  `id` = 13','2020-03-10 23:12:57');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('14','admin','编辑菜单: 商品分类','192.168.182.1','UPDATE `tb_auth_rule`  SET `name`='商品分类',`url`='Cate/lists',`pid`=3,`icon`='',`remark`='',`update_time`='2020-03-10 23:13:30'  WHERE  `id` = 13','2020-03-10 23:13:30');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('15','admin','禁用商品分类:装逼爽文','192.168.182.1','UPDATE `tb_cate`  SET `status`=0,`update_time`='2020-03-10 23:21:11'  WHERE  `id` = 3','2020-03-10 23:21:11');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('16','admin','启用商品分类:装逼爽文','192.168.182.1','UPDATE `tb_cate`  SET `status`=1,`update_time`='2020-03-10 23:21:49'  WHERE  `id` = 3','2020-03-10 23:21:49');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('17','admin','新增菜单: crsqwe','192.168.182.1','INSERT INTO `tb_cate` (`name` , `remark` , `pid` , `create_time` , `update_time`) VALUES ('crsqwe' , '123' , 0 , '2020-03-10 23:31:18' , '2020-03-10 23:31:18')','2020-03-10 23:31:18');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('18','admin','删除用户:外比巴卜','192.168.182.1','UPDATE `tb_user`  SET `deleted`=1,`update_time`='2020-03-10 23:46:38'  WHERE  `id` IN (2)','2020-03-10 23:46:38');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('19','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=96,`login_ip`='192.168.182.1',`last_login_time`='2020-03-12,12-25-45',`update_time`='2020-03-12 12:25:45'  WHERE  `id` = 1','2020-03-12 12:25:46');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('20','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=97,`login_ip`='192.168.182.1',`last_login_time`='2020-03-13,16-19-58',`update_time`='2020-03-13 16:19:58'  WHERE  `id` = 1','2020-03-13 16:19:58');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('21','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=98,`login_ip`='192.168.182.1',`last_login_time`='2020-03-13,17-22-37',`update_time`='2020-03-13 17:22:37'  WHERE  `id` = 1','2020-03-13 17:22:37');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('22','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=99,`login_ip`='192.168.182.1',`last_login_time`='2020-03-13,18-02-17',`update_time`='2020-03-13 18:02:17'  WHERE  `id` = 1','2020-03-13 18:02:17');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('23','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=100,`login_ip`='192.168.182.1',`last_login_time`='2020-03-13,18-38-27',`update_time`='2020-03-13 18:38:27'  WHERE  `id` = 1','2020-03-13 18:38:27');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('24','admin','删除分类:Mystery Suspense','192.168.182.1','UPDATE `tb_cate`  SET `deleted`=1,`update_time`='2020-03-13 19:13:08'  WHERE  `id` IN (5)','2020-03-13 19:13:08');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('25','admin','禁用商品分类:Mystery Suspense','192.168.182.1','UPDATE `tb_cate`  SET `status`=0,`update_time`='2020-03-13 19:15:05'  WHERE  `id` = 5','2020-03-13 19:15:05');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('26','admin','启用商品分类:Mystery Suspense','192.168.182.1','UPDATE `tb_cate`  SET `status`=1,`update_time`='2020-03-13 19:15:08'  WHERE  `id` = 5','2020-03-13 19:15:08');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('27','admin','新增商品分类: 测试','192.168.182.1','INSERT INTO `tb_cate` (`name` , `remark` , `picture` , `create_time` , `update_time`) VALUES ('测试' , '测试' , '/image/book/20200313/d674a03ebab005072c51b833a7a42b15.jpg' , '2020-03-13 20:56:54' , '2020-03-13 20:56:54')','2020-03-13 20:56:54');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('28','admin','新增商品分类: weqwe','192.168.182.1','INSERT INTO `tb_cate` (`name` , `remark` , `picture` , `create_time` , `update_time`) VALUES ('weqwe' , 'qweqwe' , '/image/book/20200313/31f46f891789dbf92e9cce172ab70d72.jpg' , '2020-03-13 21:42:59' , '2020-03-13 21:42:59')','2020-03-13 21:42:59');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('29','admin','禁用商品分类:weqwe','192.168.182.1','UPDATE `tb_cate`  SET `status`=0,`update_time`='2020-03-13 21:43:27'  WHERE  `id` = 7','2020-03-13 21:43:27');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('30','admin','启用商品分类:weqwe','192.168.182.1','UPDATE `tb_cate`  SET `status`=1,`update_time`='2020-03-13 21:43:30'  WHERE  `id` = 7','2020-03-13 21:43:30');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('31','admin','编辑商品分类: weqwe','192.168.182.1','UPDATE `tb_cate`  SET `name`='weqwe',`remark`='qweqwe',`picture`='',`update_time`='2020-03-13 21:43:53'  WHERE  `id` = 7','2020-03-13 21:43:53');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('32','admin','编辑商品分类: weqwe','192.168.182.1','UPDATE `tb_cate`  SET `name`='weqwe',`remark`='qweqwe',`picture`='/image/book/20200313/343d45cf4605411afeaac4007492036e.jpg',`update_time`='2020-03-13 21:46:39'  WHERE  `id` = 7','2020-03-13 21:46:39');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('33','admin','编辑商品分类: weqwe','192.168.182.1','UPDATE `tb_cate`  SET `name`='weqwe',`remark`='qweqwe',`picture`='',`update_time`='2020-03-13 21:46:44'  WHERE  `id` = 7','2020-03-13 21:46:44');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('34','admin','编辑商品分类: weqwe','192.168.182.1','UPDATE `tb_cate`  SET `name`='weqwe',`remark`='qweqwe',`picture`='/image/book/20200313/dadb4150aa8b1b1fc672d96efc8fa827.jpg',`update_time`='2020-03-13 21:47:02'  WHERE  `id` = 7','2020-03-13 21:47:02');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('35','admin','编辑商品分类: weqwe','192.168.182.1','UPDATE `tb_cate`  SET `name`='weqwe',`remark`='qweqwe',`picture`='/image/book/20200313/dadb4150aa8b1b1fc672d96efc8fa827.jpg',`update_time`='2020-03-13 21:47:06'  WHERE  `id` = 7','2020-03-13 21:47:06');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('36','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=101,`login_ip`='192.168.182.1',`last_login_time`='2020-03-14,16-04-34',`update_time`='2020-03-14 16:04:34'  WHERE  `id` = 1','2020-03-14 16:04:34');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('37','admin','删除商品:朱一旦的枯燥生活','192.168.182.1','UPDATE `tb_book`  SET `deleted`=1,`update_time`='2020-03-14 16:30:41'  WHERE  `id` IN (2)','2020-03-14 16:30:41');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('38','admin','禁用商品:乔布斯财富经','192.168.182.1','UPDATE `tb_book`  SET `update_time`='2020-03-14 16:30:46'  WHERE  `id` = 1','2020-03-14 16:30:46');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('39','admin','禁用商品:乔布斯财富经','192.168.182.1','UPDATE `tb_book`  SET `update_time`='2020-03-14 16:30:50'  WHERE  `id` = 1','2020-03-14 16:30:50');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('40','admin','禁用商品:乔布斯财富经','192.168.182.1','UPDATE `tb_book`  SET `update_time`='2020-03-14 16:31:22'  WHERE  `id` = 1','2020-03-14 16:31:22');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('41','admin','禁用商品:乔布斯财富经','192.168.182.1','UPDATE `tb_book`  SET `update_time`='2020-03-14 16:31:26'  WHERE  `id` = 1','2020-03-14 16:31:26');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('42','admin','禁用商品:乔布斯财富经','192.168.182.1','UPDATE `tb_book`  SET `update_time`='2020-03-14 16:32:05'  WHERE  `id` = 1','2020-03-14 16:32:05');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('43','admin','禁用商品:乔布斯财富经','192.168.182.1','UPDATE `tb_book`  SET `status`=0,`update_time`='2020-03-14 16:33:28'  WHERE  `id` = 1','2020-03-14 16:33:28');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('44','admin','启用商品:乔布斯财富经','192.168.182.1','UPDATE `tb_book`  SET `status`=1,`update_time`='2020-03-14 16:33:30'  WHERE  `id` = 1','2020-03-14 16:33:30');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('45','admin','删除商品:乔布斯财富经','192.168.182.1','UPDATE `tb_book`  SET `deleted`=1,`update_time`='2020-03-14 16:34:35'  WHERE  `id` IN (1)','2020-03-14 16:34:35');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('46','admin','新增商品信息: 测试','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `picture` , `create_time` , `update_time`) VALUES ('测试' , '匿名' , '33' , 3 , '/image/book/20200314/2ec212639085f3893daa03c17affcb3e.jpg' , '2020-03-14 16:57:07' , '2020-03-14 16:57:07')','2020-03-14 16:57:07');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('47','admin','新增商品信息: 123','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `picture` , `create_time` , `update_time`) VALUES ('123' , '匿名' , '123' , 3 , '/image/book/20200314/f7ae9e071afc1901e44774a4ace913cb.jpg' , '2020-03-14 16:58:28' , '2020-03-14 16:58:28')','2020-03-14 16:58:28');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('48','admin','新增商品信息: 123','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `picture` , `create_time` , `update_time`) VALUES ('123' , '匿名' , '123' , 3 , '/image/book/20200314/ae5c0b1d41e0f61e6ee87a5474fc11cd.jpg' , '2020-03-14 16:59:14' , '2020-03-14 16:59:14')','2020-03-14 16:59:14');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('49','admin','新增商品信息: 1321','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `picture` , `create_time` , `update_time`) VALUES ('1321' , '匿名12312' , '3232' , 3 , '' , '2020-03-14 17:00:57' , '2020-03-14 17:00:57')','2020-03-14 17:00:57');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('50','admin','新增商品信息: 33','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `prince` , `number` , `picture` , `create_time` , `update_time`) VALUES ('33' , '匿名' , '32' , 3 , '213' , 123 , '' , '2020-03-14 17:02:37' , '2020-03-14 17:02:37')','2020-03-14 17:02:37');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('51','admin','删除商品:33,123,123,123,123,123,1321,123,123,测试','192.168.182.1','UPDATE `tb_book`  SET `deleted`=1,`update_time`='2020-03-14 17:03:49'  WHERE  `id` IN (12,11,10,9,8,7,6,5,4,3)','2020-03-14 17:03:49');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('52','admin','新增商品信息: test','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `prince` , `number` , `picture` , `create_time` , `update_time`) VALUES ('test' , '匿名' , '' , 3 , '1' , 222 , '' , '2020-03-14 17:10:08' , '2020-03-14 17:10:08')','2020-03-14 17:10:08');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('53','admin','新增商品信息: 123','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `prince` , `number` , `picture` , `create_time` , `update_time`) VALUES ('123' , '匿名' , '123' , 3 , '-1000' , 123 , '' , '2020-03-14 17:13:13' , '2020-03-14 17:13:13')','2020-03-14 17:13:13');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('54','admin','新增商品信息: 123','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `prince` , `number` , `picture` , `create_time` , `update_time`) VALUES ('123' , '匿名' , '' , 3 , '0' , 123 , '' , '2020-03-14 17:14:46' , '2020-03-14 17:14:46')','2020-03-14 17:14:46');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('55','admin','新增商品信息: 123','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `prince` , `number` , `picture` , `create_time` , `update_time`) VALUES ('123' , '匿名' , '' , 3 , '0.99999' , 123 , '' , '2020-03-14 17:14:55' , '2020-03-14 17:14:55')','2020-03-14 17:14:55');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('56','admin','新增商品信息: 11111','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `prince` , `number` , `picture` , `create_time` , `update_time`) VALUES ('11111' , '匿名' , '' , 3 , 1.9999999999 , 123 , '' , '2020-03-14 17:20:34' , '2020-03-14 17:20:34')','2020-03-14 17:20:34');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('57','admin','新增商品信息: 333','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `prince` , `number` , `picture` , `create_time` , `update_time`) VALUES ('333' , '匿名' , '' , 3 , 12.99 , 123 , '' , '2020-03-14 17:20:56' , '2020-03-14 17:20:56')','2020-03-14 17:20:56');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('58','admin','删除商品:333,11111,123,123,123,test,朱一旦的枯燥生活,乔布斯财富经','192.168.182.1','UPDATE `tb_book`  SET `deleted`=1,`update_time`='2020-03-14 17:21:09'  WHERE  `id` IN (18,17,16,15,14,13,2,1)','2020-03-14 17:21:09');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('59','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=102,`login_ip`='192.168.182.1',`last_login_time`='2020-03-14,17-56-11',`update_time`='2020-03-14 17:56:11'  WHERE  `id` = 1','2020-03-14 17:56:11');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('60','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=103,`login_ip`='192.168.182.1',`last_login_time`='2020-03-16,18-13-28',`update_time`='2020-03-16 18:13:28'  WHERE  `id` = 1','2020-03-16 18:13:28');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('61','admin','新增商品信息: book1','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `prince` , `number` , `picture` , `create_time` , `update_time`) VALUES ('book1' , '匿名' , '' , 3 , 12 , 3 , '/image/book/20200316/dd67f880a8037c80c02579441c673c01.jpg' , '2020-03-16 18:14:04' , '2020-03-16 18:14:04')','2020-03-16 18:14:04');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('62','admin','新增商品信息: book2','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `prince` , `number` , `picture` , `create_time` , `update_time`) VALUES ('book2' , '匿名' , '3' , 3 , 11 , 11 , '/image/book/20200316/30c80f6d39d1247455f3c4870a6e072e.jpg' , '2020-03-16 18:14:20' , '2020-03-16 18:14:20')','2020-03-16 18:14:20');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('63','admin','新增商品信息: book3','192.168.182.1','INSERT INTO `tb_book` (`name` , `author` , `remark` , `pid` , `prince` , `number` , `picture` , `create_time` , `update_time`) VALUES ('book3' , '匿名' , '3' , 3 , 12 , 33 , '/image/book/20200316/60cf0aae084a4da09836f83d41e23c64.jpg' , '2020-03-16 18:14:40' , '2020-03-16 18:14:40')','2020-03-16 18:14:40');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('64','admin','删除分类:测试','192.168.182.1','UPDATE `tb_cate`  SET `deleted`=1,`update_time`='2020-03-16 18:14:48'  WHERE  `id` IN (6)','2020-03-16 18:14:48');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('65','admin','删除分类:weqwe','192.168.182.1','UPDATE `tb_cate`  SET `deleted`=1,`update_time`='2020-03-16 18:14:52'  WHERE  `id` IN (7)','2020-03-16 18:14:52');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('66','admin','新增商品分类: qazwsx','192.168.182.1','INSERT INTO `tb_cate` (`name` , `remark` , `picture` , `create_time` , `update_time`) VALUES ('qazwsx' , '123' , '/image/book/20200316/3c5370bcc57187d7746aaff9d75480c0.jpg' , '2020-03-16 18:15:04' , '2020-03-16 18:15:04')','2020-03-16 18:15:04');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('67','admin','编辑商品信息: book3','192.168.182.1','UPDATE `tb_book`  SET `name`='book3',`author`='匿名',`remark`='3',`pid`=8,`prince`=12,`number`=33,`picture`='/image/book/20200316/60cf0aae084a4da09836f83d41e23c64.jpg',`update_time`='2020-03-16 18:16:13'  WHERE  `id` = 3','2020-03-16 18:16:13');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('68','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=104,`login_ip`='192.168.182.1',`last_login_time`='2020-03-16,20-50-26',`update_time`='2020-03-16 20:50:26'  WHERE  `id` = 1','2020-03-16 20:50:26');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('69','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=105,`login_ip`='192.168.182.1',`last_login_time`='2020-03-18,22-04-00',`update_time`='2020-03-18 22:04:00'  WHERE  `id` = 1','2020-03-18 22:04:00');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('70','admin','登录后台管理系统','192.168.182.1','UPDATE `tb_manager`  SET `login_times`=106,`login_ip`='192.168.182.1',`last_login_time`='2020-03-18,22-05-21',`update_time`='2020-03-18 22:05:21'  WHERE  `id` = 1','2020-03-18 22:05:21');
INSERT INTO `tb_logs` (`id`,`username`,`action`,`ip_addr`,`details`,`create_time`) VALUES ('71','admin','新增菜单: 数据管理','192.168.182.1','INSERT INTO `tb_auth_rule` (`name` , `url` , `pid` , `icon` , `remark` , `create_time` , `update_time`) VALUES ('数据管理' , 'Backup/lists' , 7 , '' , '对数据进行备份,与还原' , '2020-03-18 22:06:23' , '2020-03-18 22:06:23')','2020-03-18 22:06:23');

-- ----------------------------
-- Table structure for tb_manager
-- ----------------------------
DROP TABLE IF EXISTS `tb_manager`;
CREATE TABLE `tb_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `nickname` varchar(255) DEFAULT NULL COMMENT '管理员昵称',
  `username` varchar(255) DEFAULT NULL COMMENT '登录账号',
  `password` varchar(255) DEFAULT NULL COMMENT '登录密码',
  `role_id` int(3) DEFAULT NULL COMMENT '所属角色ID',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态(0:禁用,1:启用)',
  `remark` varchar(255) DEFAULT NULL COMMENT '描述',
  `deleted` tinyint(1) DEFAULT '0' COMMENT '是否删除(0:否,1是)',
  `login_ip` varchar(255) DEFAULT '0.0.0.0' COMMENT '登录IP',
  `last_login_time` datetime DEFAULT NULL COMMENT '上次登录时间',
  `login_times` int(11) DEFAULT '0' COMMENT '登录次数',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';
-- ----------------------------
-- Records of tb_manager
-- ----------------------------
INSERT INTO `tb_manager` (`id`,`nickname`,`username`,`password`,`role_id`,`status`,`remark`,`deleted`,`login_ip`,`last_login_time`,`login_times`,`create_time`,`update_time`) VALUES ('1','HAIYUN','admin','e10adc3949ba59abbe56e057f20f883e','0','1','拥有所有权限','0','192.168.182.1','2020-03-18 22:05:21','106','2019-11-28 11:05:52','2020-03-18 22:05:21');

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `nickname` varchar(255) DEFAULT NULL COMMENT '用户名',
  `phone` varchar(255) DEFAULT NULL COMMENT '绑定手机号',
  `password` varchar(255) DEFAULT NULL COMMENT '密码',
  `status` tinyint(1) DEFAULT '1' COMMENT '用户状态: 0:禁用 1:启用',
  `deleted` tinyint(1) DEFAULT '0' COMMENT '是否被删除: 0:否 1:是',
  `create_time` datetime DEFAULT NULL COMMENT '注册时间',
  `update_time` datetime DEFAULT NULL COMMENT '最后修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户表';
-- ----------------------------
-- Records of tb_user
-- ----------------------------
INSERT INTO `tb_user` (`id`,`nickname`,`phone`,`password`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('1','测试用户','18383821931','e10adc3949ba59abbe56e057f20f883e','1','0','2020-03-06 15:06:12','2020-03-06 15:06:12');
INSERT INTO `tb_user` (`id`,`nickname`,`phone`,`password`,`status`,`deleted`,`create_time`,`update_time`) VALUES ('2','外比巴卜','18383821930','654321','1','0','2020-03-10 18:27:02','2020-03-10 23:46:38');

