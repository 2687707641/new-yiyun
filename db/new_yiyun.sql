/*
Navicat MySQL Data Transfer

Source Server         : 192.168.78.128
Source Server Version : 50644
Source Host           : 192.168.78.128:3306
Source Database       : new_yiyun

Target Server Type    : MYSQL
Target Server Version : 50644
File Encoding         : 65001

Date: 2019-12-25 17:25:43
*/

SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE IF NOT EXISTS `new_yiyun` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `new_yiyun`;
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
INSERT INTO `tb_auth_competency` VALUES ('1', '添加权限规则', 'Competency/add', '拥有新增权限规则的能力', '1', '0', '2019-12-23 12:27:55', '2019-12-23 12:27:55');
INSERT INTO `tb_auth_competency` VALUES ('2', '编辑权限规则', 'Competency/edit', '拥有修改权限规则的能力', '1', '0', '2019-12-23 12:29:20', '2019-12-23 12:29:20');
INSERT INTO `tb_auth_competency` VALUES ('3', '启用/禁用权限规则', 'Competency/change_status', '拥有更改权限规则状态的能力', '1', '0', '2019-12-23 14:01:45', '2019-12-23 14:01:45');
INSERT INTO `tb_auth_competency` VALUES ('4', '删除权限规则', 'Competency/del', '拥有删除权限规则的能力', '1', '0', '2019-12-23 14:04:05', '2019-12-23 14:04:05');
INSERT INTO `tb_auth_competency` VALUES ('5', '添加角色', 'Role/add', '拥有添加角色的能力', '1', '0', '2019-12-23 14:04:54', '2019-12-23 14:05:13');
INSERT INTO `tb_auth_competency` VALUES ('6', '编辑角色', 'Role/edit', '拥有编辑角色的能力', '1', '0', '2019-12-23 14:06:07', '2019-12-23 14:06:07');
INSERT INTO `tb_auth_competency` VALUES ('7', '启用/禁用角色', 'Role/change_status', '拥有启用/禁用角色的能力', '1', '0', '2019-12-23 14:07:16', '2019-12-23 14:07:16');
INSERT INTO `tb_auth_competency` VALUES ('8', '角色分配权限', 'Role/assign_authority', '拥有给角色分配权限的能力', '1', '0', '2019-12-23 14:08:46', '2019-12-23 14:19:30');
INSERT INTO `tb_auth_competency` VALUES ('9', '删除角色', 'Role/del', '拥有删除角色的能力', '1', '0', '2019-12-23 14:09:33', '2019-12-23 14:19:30');
INSERT INTO `tb_auth_competency` VALUES ('10', '添加管理员', 'Manager/add', '拥有添加管理员的能力', '1', '0', '2019-12-23 14:41:26', '2019-12-23 14:41:26');
INSERT INTO `tb_auth_competency` VALUES ('11', '编辑管理员', 'Manager/edit', '拥有编辑管理员的能力', '1', '0', '2019-12-23 14:42:02', '2019-12-23 14:42:02');
INSERT INTO `tb_auth_competency` VALUES ('12', '启用/停用管理员', 'Manager/change_status', '拥有启用/停用管理员的能力', '1', '0', '2019-12-23 14:42:44', '2019-12-23 14:42:44');
INSERT INTO `tb_auth_competency` VALUES ('13', '删除管理员', 'Manager/del', '拥有删除管理员的能力', '1', '0', '2019-12-23 14:43:11', '2019-12-23 14:43:11');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限表';

-- ----------------------------
-- Records of tb_auth_group
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='权限节点表(侧边菜单栏)';

-- ----------------------------
-- Records of tb_auth_rule
-- ----------------------------
INSERT INTO `tb_auth_rule` VALUES ('1', '用户管理', '&#xe6b8;', '0', '', '123', '1', '0', '1', '2019-11-29 11:06:39', '2019-12-25 16:23:39');
INSERT INTO `tb_auth_rule` VALUES ('2', '用户列表', null, '1', 'user/lists', null, '1', '0', null, '2019-11-29 11:07:13', '2019-12-25 16:45:42');
INSERT INTO `tb_auth_rule` VALUES ('3', '商品管理', '&#xe83b;', '0', null, null, '1', '0', '1', '2019-11-29 11:09:33', '2019-12-24 15:31:55');
INSERT INTO `tb_auth_rule` VALUES ('4', '商品列表', null, '3', null, null, '1', '0', null, '2019-11-29 11:10:01', '2019-11-29 11:10:04');
INSERT INTO `tb_auth_rule` VALUES ('5', '订单管理', null, '0', null, null, '1', '0', '1', '2019-11-29 11:10:27', '2019-12-24 15:17:49');
INSERT INTO `tb_auth_rule` VALUES ('6', '订单列表', null, '5', null, null, '1', '0', null, '2019-11-29 11:10:48', '2019-11-29 11:10:51');
INSERT INTO `tb_auth_rule` VALUES ('7', '系统管理', '&#xe6ae;', '0', null, null, '1', '0', '80', '2019-11-29 11:11:11', '2019-12-24 15:31:09');
INSERT INTO `tb_auth_rule` VALUES ('8', '管理员列表', '&#xe726;', '7', 'manager/lists', null, '1', '0', null, '2019-11-29 11:11:47', '2019-11-29 11:11:50');
INSERT INTO `tb_auth_rule` VALUES ('9', '角色管理', '&#xe6f5;', '7', 'role/lists', null, '1', '0', null, '2019-11-29 11:12:22', '2019-12-24 15:30:50');
INSERT INTO `tb_auth_rule` VALUES ('10', '权限规则', '&#xe6f1;', '7', 'competency/lists', null, '1', '0', null, '2019-11-29 11:12:43', '2019-11-29 11:12:45');
INSERT INTO `tb_auth_rule` VALUES ('11', '菜单管理', '&#xe6b4;', '7', 'menu/lists', null, '1', '0', null, '2019-11-29 11:13:08', '2019-11-29 11:13:10');
INSERT INTO `tb_auth_rule` VALUES ('12', '操作日志', '&#xe6fc;', '7', 'logs/lists', null, '1', '0', null, '2019-11-29 11:13:23', '2019-12-24 15:22:37');

-- ----------------------------
-- Table structure for tb_logs
-- ----------------------------
DROP TABLE IF EXISTS `tb_logs`;
CREATE TABLE `tb_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `username` varchar(255) DEFAULT NULL COMMENT '操作者',
  `action` varchar(255) DEFAULT NULL COMMENT '执行行为',
  `ip_addr` varchar(255) DEFAULT NULL COMMENT '操作者IP地址',
  `details` varchar(255) DEFAULT NULL COMMENT '详情(sql语句)',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作日志表';

-- ----------------------------
-- Records of tb_logs
-- ----------------------------

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
INSERT INTO `tb_manager` VALUES ('1', 'HAIYUN', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '0', '1', '拥有所有权限', '0', '192.168.78.1', '2019-12-25 17:01:51', '91', '2019-11-28 11:05:52', '2019-12-25 17:01:51');
