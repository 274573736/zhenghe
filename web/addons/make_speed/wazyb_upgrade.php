<?php 
/**
 * 本破解程序由易码资源提供
 * 易码资源www.ymzy100.com
 *   承接网站建设、公众号搭建、小程序建设、企业网站
 */
pdo_query("CREATE TABLE IF NOT EXISTS `ims_make_speed_admin` (
`id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'ID',
`username` varchar(20) NOT NULL   COMMENT '用户名',
`nickname` varchar(50) NOT NULL   COMMENT '昵称',
`realname` varchar(64) NOT NULL,
`mobile` varchar(15) NOT NULL,
`password` varchar(32) NOT NULL   COMMENT '密码',
`salt` varchar(30) NOT NULL   COMMENT '密码盐',
`avatar` varchar(100) NOT NULL   COMMENT '头像',
`email` varchar(100) NOT NULL   COMMENT '电子邮箱',
`loginfailure` tinyint(1) NOT NULL   COMMENT '失败次数',
`logintime` int(10) NOT NULL   COMMENT '登录时间',
`createtime` int(10) NOT NULL   COMMENT '创建时间',
`updatetime` int(10) NOT NULL   COMMENT '更新时间',
`token` varchar(59) NOT NULL   COMMENT 'Session标识',
`status` varchar(30) NOT NULL DEFAULT NULL DEFAULT 'normal'  COMMENT '状态',
`uniacid` int(10) NOT NULL   COMMENT 'uniacid',
`city_id` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_admin_log` (
`id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'ID',
`admin_id` int(10) NOT NULL   COMMENT '管理员ID',
`username` varchar(30) NOT NULL   COMMENT '管理员名字',
`url` varchar(1500) NOT NULL   COMMENT '操作页面',
`title` varchar(100) NOT NULL   COMMENT '日志标题',
`content` text() NOT NULL   COMMENT '内容',
`ip` varchar(50) NOT NULL   COMMENT 'IP',
`useragent` varchar(255) NOT NULL   COMMENT 'User-Agent',
`createtime` int(10) NOT NULL   COMMENT '操作时间',
`uniacid` int(10) NOT NULL   COMMENT 'uniacid',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_agreement` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`type` tinyint(3) NOT NULL   COMMENT '协议类别(0用户端,1骑手端)',
`position` varchar(64) NOT NULL   COMMENT '所在版块',
`content` text()    COMMENT '协议内容',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_attachment` (
`id` int(20) NOT NULL  AUTO_INCREMENT COMMENT 'ID',
`admin_id` int(10) NOT NULL   COMMENT '管理员ID',
`user_id` int(10) NOT NULL   COMMENT '会员ID',
`url` varchar(255) NOT NULL   COMMENT '物理路径',
`imagewidth` varchar(30) NOT NULL   COMMENT '宽度',
`imageheight` varchar(30) NOT NULL   COMMENT '高度',
`imagetype` varchar(30) NOT NULL   COMMENT '图片类型',
`imageframes` int(10) NOT NULL   COMMENT '图片帧数',
`filesize` int(10) NOT NULL   COMMENT '文件大小',
`mimetype` varchar(100) NOT NULL   COMMENT 'mime类型',
`extparam` varchar(255) NOT NULL   COMMENT '透传数据',
`createtime` int(10) NOT NULL   COMMENT '创建日期',
`updatetime` int(10) NOT NULL   COMMENT '更新时间',
`uploadtime` int(10) NOT NULL   COMMENT '上传时间',
`storage` varchar(100) NOT NULL DEFAULT NULL DEFAULT 'local'  COMMENT '存储位置',
`sha1` varchar(40) NOT NULL   COMMENT '文件 sha1编码',
`uniacid` int(10) NOT NULL   COMMENT 'uniacid',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_auth_group` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`pid` int(10) NOT NULL   COMMENT '父组别',
`name` varchar(100) NOT NULL   COMMENT '组名',
`rules` text() NOT NULL   COMMENT '规则ID',
`createtime` int(10) NOT NULL   COMMENT '创建时间',
`updatetime` int(10) NOT NULL   COMMENT '更新时间',
`status` varchar(30) NOT NULL   COMMENT '状态',
`uniacid` int(10) NOT NULL   COMMENT 'uniacid',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_auth_group_access` (
`uid` int(10) NOT NULL   COMMENT '会员ID',
`group_id` int(10) NOT NULL   COMMENT '级别ID',
PRIMARY KEY (``)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_auth_rule` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`type` enum('menu','file') NOT NULL DEFAULT NULL DEFAULT 'file'  COMMENT 'menu为菜单,file为权限节点',
`pid` int(10) NOT NULL   COMMENT '父ID',
`name` varchar(100) NOT NULL   COMMENT '规则名称',
`title` varchar(50) NOT NULL   COMMENT '规则名称',
`icon` varchar(50) NOT NULL   COMMENT '图标',
`condition` varchar(255) NOT NULL   COMMENT '条件',
`remark` varchar(255) NOT NULL   COMMENT '备注',
`ismenu` tinyint(1) NOT NULL   COMMENT '是否为菜单',
`createtime` int(10) NOT NULL   COMMENT '创建时间',
`updatetime` int(10) NOT NULL   COMMENT '更新时间',
`weigh` int(10) NOT NULL   COMMENT '权重',
`status` varchar(30) NOT NULL   COMMENT '状态',
`uniacid` int(10) NOT NULL   COMMENT 'uniacid',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_banner` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`img` varchar(128) NOT NULL,
`path` varchar(64) NOT NULL,
`disabled` tinyint(3) NOT NULL,
`add_time` int(10) NOT NULL,
`uniacid` int(10),
`app_url` varchar(40) NOT NULL,
`appid` varchar(40) NOT NULL,
`type` tinyint(1) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_business` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`user_id` int(11) NOT NULL   COMMENT '主用户',
`name` varchar(128) NOT NULL   COMMENT '大客户名称',
`phone` varchar(16) NOT NULL   COMMENT '联系电话',
`address` varchar(256) NOT NULL   COMMENT '联系地址',
`license_img1` varchar(128) NOT NULL   COMMENT '营业执照',
`license_img2` varchar(128) NOT NULL   COMMENT '经营许可证',
`imgs` varchar(900) NOT NULL   COMMENT '店内实景照片',
`valid` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '可用余额',
`status` tinyint(3) NOT NULL   COMMENT '状态',
`role` varchar(20) NOT NULL DEFAULT NULL DEFAULT 'system',
`shop_id` varchar(32) NOT NULL   COMMENT '饿了么店铺ID',
`token` varchar(64) NOT NULL,
`refresh_token` varchar(64) NOT NULL,
`token_expire` int(10) NOT NULL   COMMENT 'token过期时间',
`add_time` int(10) NOT NULL   COMMENT '申请时间',
`update_time` int(10) NOT NULL   COMMENT '最后更新时间',
`city_id` int(10) NOT NULL,
`uniacid` int(11) NOT NULL,
`remark` varchar(255) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_business_info` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`business_id` int(11) NOT NULL,
`rider_id` varchar(225) NOT NULL,
`init_price` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00',
`init_distance` double(6,1) NOT NULL DEFAULT NULL DEFAULT '0.0',
`price` varchar(225) NOT NULL,
`lat` double(12,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000',
`lng` double(13,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000',
`address` varchar(128) NOT NULL,
`charge_mode` tinyint(1) NOT NULL   COMMENT '计费模式：0=距离收费，1=协议价',
`agreement_price` decimal(10,2) NOT NULL   COMMENT '协议价',
`night_price` varchar(255) NOT NULL,
`change_price` decimal(10,2) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_business_user` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`business_id` int(10) NOT NULL,
`user_id` int(10) NOT NULL,
`username` varchar(64) NOT NULL,
`mobile` varchar(15) NOT NULL,
`sex` varchar(16) NOT NULL,
`home_address` varchar(128) NOT NULL,
`add_time` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_cancel_order` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`order_id` int(10) NOT NULL,
`rider_id` int(10) NOT NULL,
`cancel_time` int(10) NOT NULL,
`accept_time` int(10) NOT NULL,
`city_id` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_city` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`name` varchar(50) NOT NULL   COMMENT '城市名称',
`parent_id` int(11) NOT NULL   COMMENT '父级ID',
`key` varchar(10) NOT NULL   COMMENT '首字母',
`is_hot` tinyint(1) NOT NULL   COMMENT '是否热门',
`is_disabled` tinyint(1) NOT NULL   COMMENT '0启用,1禁用',
`list_order` int(10) NOT NULL   COMMENT '列表顺序',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`update_time` int(10) NOT NULL   COMMENT '更新时间',
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_clouds` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`name` varchar(64) NOT NULL   COMMENT '对接名称',
`modules_name` varchar(64) NOT NULL   COMMENT '对接模块',
`salt` varchar(32) NOT NULL,
`domain` varchar(64) NOT NULL,
`ip` varchar(20),
`appid` varchar(64) NOT NULL   COMMENT '对接小程序appid',
`token` varchar(64) NOT NULL   COMMENT 'Token',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`m_uniacid` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`charging` varchar(255) NOT NULL   COMMENT '计费',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_command` (
`id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'ID',
`type` varchar(30) NOT NULL   COMMENT '类型',
`params` varchar(1500) NOT NULL   COMMENT '参数',
`command` varchar(1500) NOT NULL   COMMENT '命令',
`content` text()    COMMENT '返回结果',
`executetime` int(10) NOT NULL   COMMENT '执行时间',
`createtime` int(10) NOT NULL   COMMENT '创建时间',
`updatetime` int(10) NOT NULL   COMMENT '更新时间',
`status` enum('successed','failured') NOT NULL DEFAULT NULL DEFAULT 'failured'  COMMENT '状态',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_config` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`name` varchar(30) NOT NULL   COMMENT '变量名',
`group` varchar(30) NOT NULL   COMMENT '分组',
`title` varchar(100) NOT NULL   COMMENT '变量标题',
`tip` varchar(100) NOT NULL   COMMENT '变量描述',
`type` varchar(30) NOT NULL   COMMENT '类型:string,text,int,bool,array,datetime,date,file',
`value` text() NOT NULL   COMMENT '变量值',
`content` text() NOT NULL   COMMENT '变量字典数据',
`rule` varchar(100) NOT NULL   COMMENT '验证规则',
`extend` varchar(255) NOT NULL   COMMENT '扩展属性',
`uniacid` int(10) NOT NULL   COMMENT 'uniacid',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_coupon_activity` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`title` varchar(128) NOT NULL   COMMENT '活动名',
`coupon_id` int(10) NOT NULL   COMMENT '优惠券',
`type` int(10) NOT NULL   COMMENT '活动类型(0新人首次进入,1支付下单,2邀请好友)',
`total_num` int(10) NOT NULL   COMMENT '满足数量',
`begin_time` int(10) NOT NULL   COMMENT '开始时间',
`end_time` int(10) NOT NULL   COMMENT '结束时间',
`is_disabled` tinyint(1) NOT NULL   COMMENT '是否启用',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_coupons` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`title` varchar(64) NOT NULL   COMMENT '标题',
`code` varchar(30) NOT NULL   COMMENT '兑换码',
`code_num` int(10) NOT NULL,
`money` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '优惠金额',
`satisfy_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '满多少可用',
`day` int(10) NOT NULL   COMMENT '使用期限天数(0为不限制)',
`distance` float(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '距离内可使用(0不限制)',
`type` tinyint(3) NOT NULL,
`total` int(10) NOT NULL   COMMENT '满足获得的数量',
`gral` int(10) NOT NULL   COMMENT '优惠券积分价格',
`img` varchar(128) NOT NULL   COMMENT '优惠券图片',
`description` varchar(225) NOT NULL   COMMENT '使用规则',
`status` tinyint(1) NOT NULL   COMMENT '优惠券状态',
`begin_time` int(10) NOT NULL   COMMENT '开始时间',
`end_time` int(10) NOT NULL   COMMENT '结束时间',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`update_time` int(10) NOT NULL   COMMENT '更新时间',
`is_delete` tinyint(1) NOT NULL   COMMENT '是否删除',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_distribution_distributor` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`user_id` int(10) NOT NULL,
`pid` int(10) NOT NULL,
`gid` int(10) NOT NULL,
`invite_code` char(8) NOT NULL,
`name` varchar(255) NOT NULL   COMMENT '姓名',
`phone` char(11) NOT NULL   COMMENT '手机号',
`commission` decimal(10,2) NOT NULL   COMMENT '佣金',
`pay_commission` decimal(10,2) NOT NULL   COMMENT '已提现佣金',
`count_commission` decimal(10,2) NOT NULL   COMMENT '累计佣金',
`status` tinyint(1) NOT NULL   COMMENT '状态:0=待审核,1=正常,2=失败',
`create_time` int(10) NOT NULL   COMMENT '添加时间',
`update_time` int(10) NOT NULL   COMMENT '更新时间',
`uniacid` int(10) NOT NULL,
`city_id` int(10) NOT NULL,
`is_distributor` tinyint(10) NOT NULL   COMMENT '是否分销商:0=false,1=true',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_distribution_grade` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`name` varchar(20) NOT NULL   COMMENT '等级名称',
`first_commission` int(10) NOT NULL   COMMENT '一级佣金',
`second_commission` int(10) NOT NULL   COMMENT '二级佣金',
`three_commission` int(10) NOT NULL,
`total_amount` decimal(10,2) NOT NULL   COMMENT '分销订单总额',
`total_order` int(10) NOT NULL   COMMENT '分销订单总数',
`number_people` int(10) NOT NULL   COMMENT '分销人数',
`rank` int(10) NOT NULL   COMMENT '等级',
`auto_level` tinyint(1) NOT NULL   COMMENT '是否自动升级:0=否,1=是',
`create_time` int(10) NOT NULL,
`update_time` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
`city_id` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_distribution_order` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`order_number` varchar(50) NOT NULL   COMMENT '订单号',
`pay_user_id` int(10) NOT NULL   COMMENT '下单用户',
`price` decimal(10,2) NOT NULL   COMMENT '支付价格',
`platform_price` decimal(10,2) NOT NULL   COMMENT '平台获取抽成',
`commission` decimal(10,2) NOT NULL   COMMENT '获得佣金',
`level` tinyint(10) NOT NULL   COMMENT '获佣级别',
`order_id` int(10) NOT NULL   COMMENT '订单id',
`user_id` int(10) NOT NULL   COMMENT '获佣分销商id',
`status` tinyint(1) NOT NULL   COMMENT '状态：0=待付款,1=待分佣,2=已分佣,3=已取消',
`uniacid` int(10) NOT NULL,
`city_id` int(10) NOT NULL,
`create_time` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_distribution_withdraw` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`order_num` varchar(50) NOT NULL,
`user_id` int(10) NOT NULL   COMMENT '分销商',
`did` int(10) NOT NULL,
`amount` decimal(10,2) NOT NULL   COMMENT '提现金额',
`server_charge` decimal(10,2) NOT NULL,
`status` tinyint(1) NOT NULL   COMMENT '状态:0=待审核,1=待打款,2=已打款',
`type` tinyint(1) NOT NULL   COMMENT '提现方式:1=微信,2=支付宝，3=银行卡',
`name` varchar(20) NOT NULL   COMMENT '姓名',
`account` varchar(30) NOT NULL   COMMENT '账号',
`create_time` int(10) NOT NULL   COMMENT '申请时间',
`update_time` int(10) NOT NULL   COMMENT '打款时间',
`uniacid` int(10) NOT NULL,
`city_id` int(10) NOT NULL,
`open_id` varchar(50) NOT NULL,
`bank` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_equip` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`title` varchar(64) NOT NULL   COMMENT '装备标题',
`img` varchar(128) NOT NULL   COMMENT '装备图片',
`price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '装备价格',
`detail` text()    COMMENT '装备详情',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`status` tinyint(3) NOT NULL   COMMENT '装备上架状态',
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_equip_order` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`order_code` varchar(32) NOT NULL   COMMENT '订单号',
`price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '支付金额',
`rider_id` int(10) NOT NULL   COMMENT '骑手ID',
`equip_id` int(10) NOT NULL   COMMENT '装备ID',
`status` tinyint(3) NOT NULL   COMMENT '状态(0)',
`add_time` int(10) NOT NULL   COMMENT '购买时间',
`update_time` int(10) NOT NULL   COMMENT '更新时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_goods_type` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`order_type` tinyint(3) NOT NULL   COMMENT '业务类型',
`name` varchar(64) NOT NULL   COMMENT '类型名称',
`icon` varchar(128) NOT NULL   COMMENT '类型图标',
`iconed` varchar(128) NOT NULL,
`weight` int(10) NOT NULL   COMMENT '排序',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`update_time` int(10) NOT NULL   COMMENT '更新时间',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_handbook` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`type` tinyint(3) NOT NULL   COMMENT '(0骑手端,1用户端)',
`title` varchar(64) NOT NULL   COMMENT '手册标题',
`icon` varchar(128) NOT NULL   COMMENT '标题图标',
`content` text()    COMMENT '内容',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_order` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`type` tinyint(3) NOT NULL   COMMENT '订单类型',
`order_code` varchar(32) NOT NULL   COMMENT '订单号',
`user_id` int(11) NOT NULL   COMMENT '下单用户',
`clouds_id` int(10) NOT NULL,
`business_id` int(11) NOT NULL,
`goods_id` int(11) NOT NULL   COMMENT '物品类型ID',
`goodsname` varchar(128) NOT NULL   COMMENT '物品类型',
`phone` varchar(32) NOT NULL,
`get_time` varchar(64) NOT NULL   COMMENT '取件时间',
`coupon_id` int(10) NOT NULL   COMMENT '优惠券',
`small_price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '小费金额',
`distance` float(6,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '订单距离',
`weight` float(6,1) NOT NULL DEFAULT NULL DEFAULT '0.0'  COMMENT '重量',
`distance_price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '里程费',
`weight_price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '续重费',
`night_price` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '夜间费用',
`change_price` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '溢价费用',
`discount_price` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '会员折扣',
`total_price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '订单总额',
`pay_price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '实际支付',
`floor_price` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '楼层费用',
`budget_price` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '预计价',
`is_discuss` tinyint(3) NOT NULL   COMMENT '是否接受议价',
`img` varchar(600) NOT NULL   COMMENT '下单图片',
`audio` varchar(128) NOT NULL,
`order_time` varchar(32) NOT NULL   COMMENT '订单时时间',
`distance_time` int(10) NOT NULL   COMMENT '路程时间',
`expect_time` varchar(32) NOT NULL   COMMENT '预计取件/服务时间',
`expect_timeed` varchar(32) NOT NULL   COMMENT '预计送达/完成时间',
`description` varchar(255)    COMMENT '备注/描述',
`payment` tinyint(1) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '支付类型(1余额,2微信支付)',
`status` tinyint(1) NOT NULL   COMMENT '订单状态(0待支付,1已取消,2已支付待取件,3已取件送货中,4完成送达待评价,5完成)',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`update_time` int(10) NOT NULL   COMMENT '更新时间',
`city_id` int(10) NOT NULL   COMMENT '城市',
`uniacid` int(10) NOT NULL,
`role` varchar(32) NOT NULL,
`car_id` int(10) NOT NULL,
`car_name` varchar(20) NOT NULL   COMMENT '车辆名称',
`start_price` decimal(10,2) NOT NULL   COMMENT '起步价格',
`start_km` double(6,2) NOT NULL,
`accept_order_num` int(10) NOT NULL,
`charg_type` tinyint(1) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '代驾收费类型1=距离,2-实时',
`expire_time` int(10) NOT NULL,
`car_type` tinyint(1) NOT NULL,
`total_car` decimal(10,2) NOT NULL,
`load_price` decimal(10,2) NOT NULL,
`load_switch` tinyint(1) NOT NULL,
`category_id` int(10) NOT NULL,
`cube` float(10,2) NOT NULL,
`cube_price` decimal(10,2) NOT NULL,
`snap_item` varchar(500) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_order_address` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`order_id` int(10) NOT NULL   COMMENT '所属订单ID',
`begin_address` varchar(128) NOT NULL   COMMENT '寄件地址',
`begin_detail` varchar(128) NOT NULL   COMMENT '详情地址: 街道/门牌',
`begin_lat` double(11,9) NOT NULL DEFAULT NULL DEFAULT '0.000000000'  COMMENT '寄件纬度',
`begin_lng` double(13,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000'  COMMENT '寄件经度',
`begin_username` varchar(64) NOT NULL   COMMENT '寄件人姓名',
`begin_phone` varchar(12) NOT NULL   COMMENT '寄件人电话',
`end_address` varchar(128) NOT NULL   COMMENT '收件地址',
`end_detail` varchar(128) NOT NULL   COMMENT '详情地址: 街道/门牌',
`end_lat` double(12,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000'  COMMENT '寄件纬度',
`end_lng` double(13,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000'  COMMENT '收件经度',
`end_username` varchar(64) NOT NULL   COMMENT '收件人姓名',
`end_phone` varchar(64) NOT NULL   COMMENT '收件电话',
`end_floor` tinyint(3) NOT NULL   COMMENT '所在楼层',
`extension_number` varchar(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_order_pickcode` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`order_id` int(10) NOT NULL   COMMENT '订单ID',
`pick_code` int(10) NOT NULL   COMMENT '取件码',
`end_code` int(10) NOT NULL   COMMENT '收件码',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_order_rider` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`order_id` int(10) NOT NULL   COMMENT '订单ID',
`rider_id` int(10) NOT NULL   COMMENT '骑手ID',
`rider_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '骑手佣金',
`score` int(10) NOT NULL   COMMENT '评分',
`tag` varchar(64) NOT NULL   COMMENT '标签',
`rider_distance` float(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '骑手路程',
`pick_img` varchar(128) NOT NULL   COMMENT '取件照片',
`end_img` varchar(129) NOT NULL,
`total_time` int(10) NOT NULL   COMMENT '订单花费时间(单位:秒)',
`accept_time` int(10) NOT NULL   COMMENT '接单时间',
`get_time` int(10) NOT NULL   COMMENT '揽件时间',
`goto_time` int(10) NOT NULL   COMMENT '送达时间',
`complete_time` int(10) NOT NULL   COMMENT '完成时间(评价时间)',
`expect_time` varchar(32) NOT NULL,
`expect_timed` varchar(32) NOT NULL,
`goto_msec_time` char(13) NOT NULL,
`get_msec_time` char(13) NOT NULL,
`trid` varchar(20) NOT NULL   COMMENT '轨迹ID',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_rider` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`invite_code` varchar(20) NOT NULL   COMMENT '邀请码',
`nick_name` varchar(100) NOT NULL   COMMENT '昵称,显示时用',
`real_name` varchar(100) NOT NULL   COMMENT '真实姓名',
`mobile` varchar(20) NOT NULL   COMMENT '手机',
`avatar` varchar(255) NOT NULL   COMMENT '头像',
`sex` tinyint(3) NOT NULL   COMMENT '性别: 0女,1男',
`age` int(10) NOT NULL   COMMENT '年龄',
`height` int(10) NOT NULL   COMMENT '身高',
`weight` int(10) NOT NULL   COMMENT '体重',
`education` varchar(32) NOT NULL   COMMENT '学历',
`occup` varchar(32)    COMMENT '职业',
`address` varchar(128) NOT NULL   COMMENT '住址',
`nervous_person` varchar(32) NOT NULL   COMMENT '紧急联系人',
`nervous_phone` varchar(20) NOT NULL   COMMENT '紧急联系电话',
`open_id` varchar(128) NOT NULL   COMMENT '用户openid',
`user_grade` int(10) NOT NULL   COMMENT '用户成长值',
`invalid_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '不可用余额',
`valid_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '可用余额',
`bond_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '保证金',
`madou` int(10) NOT NULL   COMMENT '码豆',
`recommend_id` int(11) NOT NULL   COMMENT '推荐人ID',
`recommend_code` varchar(16) NOT NULL   COMMENT '个人推荐码',
`status` tinyint(1) NOT NULL   COMMENT '状态',
`add_time` int(10) NOT NULL   COMMENT '注册或添加时间',
`logged_time` int(10) NOT NULL   COMMENT '最近一次登录时间',
`logged_ip` varchar(128) NOT NULL   COMMENT '最近一次登录IP',
`uniacid` int(10) NOT NULL,
`city_id` int(10) NOT NULL,
`accept_order_num` int(10) NOT NULL,
`app_client_id` varchar(100) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_rider_bind` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`rider_id` int(10) NOT NULL,
`real_name` varchar(32) NOT NULL   COMMENT '真实姓名',
`card_code` varchar(20) NOT NULL   COMMENT '身份证号',
`sex` tinyint(1) NOT NULL   COMMENT '性别',
`address` varchar(128) NOT NULL   COMMENT '户籍所在地',
`card1_img` varchar(100) NOT NULL   COMMENT '身份证图片',
`card2_img` varchar(100) NOT NULL   COMMENT '身份证背面照',
`card3_img` varchar(100) NOT NULL   COMMENT '手持身份证照',
`card4_img` varchar(100) NOT NULL   COMMENT '个人自拍照',
`status` tinyint(1) NOT NULL   COMMENT '审核状态(0待审核,1未通过,2已通过)',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`update_time` int(10) NOT NULL   COMMENT '更新时间',
`uniacid` int(10) NOT NULL,
`remark` varchar(20) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_rider_brokerage` (
`id` int(11) NOT NULL  AUTO_INCREMENT COMMENT '自增ID',
`account` tinyint(3) NOT NULL   COMMENT '(0骑手,1用户)',
`user_id` int(11) NOT NULL   COMMENT '用户ID',
`object_id` int(11) NOT NULL   COMMENT '订单ID',
`recommend_id` int(11) NOT NULL   COMMENT '推荐人ID',
`amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '获得佣金',
`type` varchar(20) NOT NULL   COMMENT '奖励推荐类型',
`status` tinyint(3) NOT NULL   COMMENT '状态(0:待分成,1已取消,2以分成)',
`add_time` int(11) NOT NULL   COMMENT '添加时间',
`update_time` int(11) NOT NULL   COMMENT '更新时间',
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_rider_cashlog` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`title` varchar(128) NOT NULL   COMMENT '说明',
`rider_id` int(10) NOT NULL   COMMENT '用户',
`object_id` int(10) NOT NULL   COMMENT '项目ID',
`order_code` varchar(32) NOT NULL   COMMENT '业务订单号',
`amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '金额',
`type` tinyint(3) NOT NULL   COMMENT '财务类型(0消费记录,1充值记录,2退款)',
`status` tinyint(1) NOT NULL   COMMENT '状态(0异常,1以划款,2已到账)',
`add_time` int(10) NOT NULL   COMMENT '创建时间',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_rider_driver` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`rider_id` int(11) NOT NULL   COMMENT '认证骑手',
`card_img1` varchar(128) NOT NULL   COMMENT '驾驶证正本',
`card_img2` varchar(128) NOT NULL   COMMENT '驾驶证副本',
`card_num` varchar(128) NOT NULL   COMMENT '档案编号',
`card_type` varchar(64) NOT NULL   COMMENT '准驾车型',
`card_time` varchar(64) NOT NULL   COMMENT '初领驾驶证日期',
`status` tinyint(3) NOT NULL   COMMENT '审核状态',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`update_time` int(10) NOT NULL   COMMENT '更新时间',
`uniacid` int(11) NOT NULL,
`remark` varchar(20) NOT NULL,
`tid` varchar(20) NOT NULL   COMMENT '终端ID',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_rider_formid` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`rider_id` int(10) NOT NULL   COMMENT '骑手id',
`user_id` int(10) NOT NULL   COMMENT '用户ID',
`open_id` varchar(32) NOT NULL   COMMENT '骑手openid',
`form_id` varchar(32) NOT NULL   COMMENT '服务通知formid',
`expire_time` int(10) NOT NULL   COMMENT '过期时间',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_rider_info` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`rider_id` int(10) NOT NULL   COMMENT '骑手ID',
`score` float(5,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '评分',
`service_total` int(10) NOT NULL   COMMENT '服务总次数',
`distance_total` float(12,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '累计行程',
`income_total` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '累计收入',
`time_total` int(10) NOT NULL,
`lat` double(8,6) NOT NULL DEFAULT NULL DEFAULT '0.000000'  COMMENT '骑手坐标纬度',
`lng` double(9,6) NOT NULL DEFAULT NULL DEFAULT '0.000000'  COMMENT '骑手坐标经度',
`address` varchar(100) NOT NULL   COMMENT '接单地址',
`is_accept` tinyint(1) NOT NULL   COMMENT '是否接单(0接单,1不接单)',
`cancel_count` int(10) NOT NULL   COMMENT '已接单数量',
`accept_type` tinyint(1) NOT NULL   COMMENT '接单类型(0全接,1实时单,2预约单)',
`uniacid` int(11) NOT NULL,
`order_type` varchar(10) NOT NULL DEFAULT NULL DEFAULT '0,3,5,6',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_rider_message` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`type` int(10) NOT NULL   COMMENT '通知类型(0系统通知,1处罚公告,2订单通知)',
`rider_id` int(11) NOT NULL   COMMENT '通知骑手',
`title` varchar(225) NOT NULL   COMMENT '标题',
`content` text()    COMMENT '消息详情',
`object_id` int(11) NOT NULL   COMMENT '所属项目',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`is_read` tinyint(1) NOT NULL   COMMENT '是否已读：0否；1是',
`all` tinyint(1) NOT NULL   COMMENT '下发所有骑手',
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_rider_sanction` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`rider_id` int(10) NOT NULL   COMMENT '奖惩骑手',
`type` enum('0','1') NOT NULL   COMMENT '类型(0惩罚,1奖励)',
`class` int(10) NOT NULL   COMMENT '奖惩内容(0余额,1通知警告,2禁止接单,3冻结账户余额)',
`metric` int(10) NOT NULL   COMMENT '奖惩度量(元|小时)',
`reason` varchar(225) NOT NULL   COMMENT '奖惩原因说明',
`appeal` varchar(225) NOT NULL   COMMENT '申诉内容',
`begin_time` int(10) NOT NULL   COMMENT '开始时间',
`end_time` int(10) NOT NULL   COMMENT '结束时间',
`status` tinyint(3) NOT NULL   COMMENT '状态(0进行中1申诉2申诉成功)',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`notify` tinyint(3) NOT NULL   COMMENT '是否通知骑手',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_rider_withdraw` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`type` tinyint(3) NOT NULL DEFAULT NULL DEFAULT '2'  COMMENT '转账类型',
`tx_type` tinyint(3) NOT NULL,
`rider_id` int(11) NOT NULL   COMMENT '骑手ID',
`trade_code` varchar(32) NOT NULL   COMMENT '流水订单号',
`money` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '提现金额',
`open_id` varchar(64) NOT NULL   COMMENT '到账账户open_id',
`status` tinyint(1) NOT NULL   COMMENT '状态(0待通过,1不通过,2已通过并打款)',
`description` varchar(128) NOT NULL   COMMENT '企业付款备注',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`update_time` int(10) NOT NULL   COMMENT '更新时间',
`received_time` int(10) NOT NULL   COMMENT '提现到账时间',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_setting` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`key` varchar(64) NOT NULL   COMMENT '配置键名',
`value` text()    COMMENT '配置值',
`uniacid` int(11) NOT NULL,
`city_id` int(10) NOT NULL   COMMENT '城市ID',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_train_point` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`city_id` int(10) NOT NULL   COMMENT '城市ID',
`name` varchar(128) NOT NULL   COMMENT '培训点名称',
`business_date` varchar(64) NOT NULL   COMMENT '营业日期',
`morn` varchar(64) NOT NULL   COMMENT '上午',
`after` varchar(64) NOT NULL   COMMENT '下午',
`total` int(10) NOT NULL   COMMENT '预约人数',
`phone` varchar(15) NOT NULL   COMMENT '培训点电话',
`address` varchar(128) NOT NULL   COMMENT '培训地点',
`lat` double(12,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000'  COMMENT '坐标纬度',
`lng` double(13,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000'  COMMENT '坐标经度',
`add_time` int(10) NOT NULL,
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_train_rider` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`rider_id` int(10) NOT NULL   COMMENT '骑手',
`train_id` int(10) NOT NULL   COMMENT '培训点',
`time` int(10) NOT NULL   COMMENT '预约培训时间',
`type` tinyint(1) NOT NULL   COMMENT '0上午,1下午',
`status` tinyint(1) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_user` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`nick_name` varchar(100) NOT NULL   COMMENT '昵称,显示时用',
`real_name` varchar(100) NOT NULL   COMMENT '真实姓名',
`mobile` char(20) NOT NULL   COMMENT '手机',
`sex` tinyint(3) NOT NULL   COMMENT '性别: 0女,1男',
`qq` varchar(20) NOT NULL   COMMENT 'QQ',
`email` varchar(32) NOT NULL   COMMENT '邮箱',
`avatar` varchar(255) NOT NULL   COMMENT '头像',
`open_id` varchar(128) NOT NULL   COMMENT '用户openid',
`status` tinyint(1) NOT NULL   COMMENT '状态：0正常',
`user_grade` tinyint(3) NOT NULL   COMMENT '用户等级(0:用户,1:会员,2:项目合伙人)',
`recommend_id` int(11) NOT NULL   COMMENT '推荐用户id',
`recommend_rider` int(11) NOT NULL   COMMENT '推荐骑手ID',
`invalid` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '不可用余额',
`valid` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '可用余额',
`grow` int(10) NOT NULL   COMMENT '用户成长值',
`gral` int(10) NOT NULL   COMMENT '积分',
`add_time` int(10) NOT NULL   COMMENT '注册或添加时间',
`update_time` int(10) NOT NULL   COMMENT '更新时间',
`logged_time` int(10) NOT NULL   COMMENT '最近一次登录时间',
`logged_ip` varchar(128) NOT NULL   COMMENT '最近一次登录IP',
`is_disabled` tinyint(3) NOT NULL   COMMENT '是否禁用',
`uniacid` int(10) NOT NULL,
`blacklist` tinyint(1) NOT NULL   COMMENT '黑名单',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_user_cashlog` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`title` varchar(128) NOT NULL   COMMENT '说明',
`user_id` int(10) NOT NULL   COMMENT '用户',
`business_id` int(11) NOT NULL,
`object_id` int(10) NOT NULL   COMMENT '项目ID',
`order_code` varchar(32) NOT NULL   COMMENT '业务订单号',
`amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '金额',
`type` tinyint(3) NOT NULL   COMMENT '财务类型(0消费记录,1充值记录,2退款)',
`status` tinyint(1) NOT NULL   COMMENT '状态(0异常,1正常)',
`add_time` int(10) NOT NULL   COMMENT '创建时间',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_user_coupons` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`order_type` tinyint(3) NOT NULL   COMMENT '可用业务订单类型',
`type` varchar(32) NOT NULL   COMMENT '来源',
`user_id` int(10) NOT NULL   COMMENT '用户ID',
`tips` varchar(64) NOT NULL   COMMENT '标题',
`amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '优惠金额',
`full_amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '多少满减',
`limit_distance` float(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '使用距离',
`coupon_id` int(10) NOT NULL   COMMENT '优惠券ID',
`status` tinyint(1) NOT NULL   COMMENT '使用状态',
`begin_time` int(10) NOT NULL   COMMENT '开始时间',
`expire_time` int(10) NOT NULL   COMMENT '到期时间',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_user_grade` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`grade` int(10) NOT NULL   COMMENT '会员等级',
`name` varchar(64) NOT NULL   COMMENT '等级名称',
`grow` int(10) NOT NULL   COMMENT '满足成长值',
`discount` decimal(6,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '折扣额度',
`icon` varchar(128) NOT NULL   COMMENT '会员图标',
`add_time` int(10) NOT NULL   COMMENT '添加时间',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_user_invoice` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`user_id` int(11) NOT NULL   COMMENT '申请用户',
`mobile` varchar(15) NOT NULL,
`email` varchar(64) NOT NULL,
`content` varchar(164) NOT NULL   COMMENT '发票内容',
`amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '发票金额',
`type` tinyint(3) NOT NULL   COMMENT '0个人1公司',
`type_name` varchar(64) NOT NULL,
`tax_number` varchar(64) NOT NULL,
`code` varchar(32) NOT NULL   COMMENT '发票代码',
`number` varchar(32) NOT NULL   COMMENT '发票号码',
`date` varchar(32) NOT NULL   COMMENT '开票日期',
`check_code` varchar(32) NOT NULL   COMMENT '校验码',
`img` varchar(164) NOT NULL   COMMENT '发票图片',
`status` tinyint(3) NOT NULL   COMMENT '状态0待审核',
`add_time` int(10) NOT NULL   COMMENT '申请时间',
`update_time` int(10) NOT NULL   COMMENT '更新时间',
`uniacid` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_user_message` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`type` tinyint(1) NOT NULL   COMMENT '消息类型(0系统通知,1用户操作通知)',
`user_id` int(10) NOT NULL   COMMENT '通知用户',
`title` varchar(128) NOT NULL   COMMENT '标题',
`summary` varchar(254) NOT NULL   COMMENT '摘要',
`img` varchar(128) NOT NULL   COMMENT '缩略图',
`content` text()    COMMENT '通知内容',
`is_read` enum('0','1') NOT NULL   COMMENT '是否已读',
`add_time` int(10) NOT NULL   COMMENT '通知时间',
`top` tinyint(3) NOT NULL   COMMENT '是否制定',
`uniacid` int(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_version` (
`id` int(11) NOT NULL  AUTO_INCREMENT COMMENT 'ID',
`oldversion` varchar(30) NOT NULL   COMMENT '旧版本号',
`newversion` varchar(30) NOT NULL   COMMENT '新版本号',
`packagesize` varchar(30) NOT NULL   COMMENT '包大小',
`content` varchar(500) NOT NULL   COMMENT '升级内容',
`downloadurl` varchar(255) NOT NULL   COMMENT '下载地址',
`enforce` tinyint(1) NOT NULL   COMMENT '强制更新',
`createtime` int(10) NOT NULL   COMMENT '创建时间',
`updatetime` int(10) NOT NULL   COMMENT '更新时间',
`weigh` int(10) NOT NULL   COMMENT '权重',
`status` varchar(30) NOT NULL   COMMENT '状态',
`uniacid` int(10) NOT NULL   COMMENT 'uniacid',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_make_speed_virtual_rider` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`lat` double(10,6) NOT NULL   COMMENT '经度',
`lng` double(10,6) NOT NULL   COMMENT '维度',
`address` varchar(100) NOT NULL,
`uniacid` int(11) NOT NULL,
`is_show` enum('0','1') NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '是否显示:0=隐藏,1=显示',
`create_time` int(11) NOT NULL   COMMENT '添加时间',
`update_time` int(11) NOT NULL   COMMENT '更新时间',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'ID';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'username')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `username` varchar(20) NOT NULL   COMMENT '用户名';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'nickname')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `nickname` varchar(50) NOT NULL   COMMENT '昵称';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'realname')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `realname` varchar(64) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'mobile')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `mobile` varchar(15) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'password')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `password` varchar(32) NOT NULL   COMMENT '密码';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'salt')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `salt` varchar(30) NOT NULL   COMMENT '密码盐';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'avatar')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `avatar` varchar(100) NOT NULL   COMMENT '头像';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'email')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `email` varchar(100) NOT NULL   COMMENT '电子邮箱';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'loginfailure')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `loginfailure` tinyint(1) NOT NULL   COMMENT '失败次数';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'logintime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `logintime` int(10) NOT NULL   COMMENT '登录时间';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `createtime` int(10) NOT NULL   COMMENT '创建时间';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `updatetime` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'token')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `token` varchar(59) NOT NULL   COMMENT 'Session标识';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `status` varchar(30) NOT NULL DEFAULT NULL DEFAULT 'normal'  COMMENT '状态';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `uniacid` int(10) NOT NULL   COMMENT 'uniacid';");
 }
}
if(pdo_tableexists('make_speed_admin')) {
 if(!pdo_fieldexists('make_speed_admin',  'city_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin')." ADD `city_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_admin_log')) {
 if(!pdo_fieldexists('make_speed_admin_log',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin_log')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'ID';");
 }
}
if(pdo_tableexists('make_speed_admin_log')) {
 if(!pdo_fieldexists('make_speed_admin_log',  'admin_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin_log')." ADD `admin_id` int(10) NOT NULL   COMMENT '管理员ID';");
 }
}
if(pdo_tableexists('make_speed_admin_log')) {
 if(!pdo_fieldexists('make_speed_admin_log',  'username')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin_log')." ADD `username` varchar(30) NOT NULL   COMMENT '管理员名字';");
 }
}
if(pdo_tableexists('make_speed_admin_log')) {
 if(!pdo_fieldexists('make_speed_admin_log',  'url')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin_log')." ADD `url` varchar(1500) NOT NULL   COMMENT '操作页面';");
 }
}
if(pdo_tableexists('make_speed_admin_log')) {
 if(!pdo_fieldexists('make_speed_admin_log',  'title')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin_log')." ADD `title` varchar(100) NOT NULL   COMMENT '日志标题';");
 }
}
if(pdo_tableexists('make_speed_admin_log')) {
 if(!pdo_fieldexists('make_speed_admin_log',  'content')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin_log')." ADD `content` text() NOT NULL   COMMENT '内容';");
 }
}
if(pdo_tableexists('make_speed_admin_log')) {
 if(!pdo_fieldexists('make_speed_admin_log',  'ip')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin_log')." ADD `ip` varchar(50) NOT NULL   COMMENT 'IP';");
 }
}
if(pdo_tableexists('make_speed_admin_log')) {
 if(!pdo_fieldexists('make_speed_admin_log',  'useragent')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin_log')." ADD `useragent` varchar(255) NOT NULL   COMMENT 'User-Agent';");
 }
}
if(pdo_tableexists('make_speed_admin_log')) {
 if(!pdo_fieldexists('make_speed_admin_log',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin_log')." ADD `createtime` int(10) NOT NULL   COMMENT '操作时间';");
 }
}
if(pdo_tableexists('make_speed_admin_log')) {
 if(!pdo_fieldexists('make_speed_admin_log',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_admin_log')." ADD `uniacid` int(10) NOT NULL   COMMENT 'uniacid';");
 }
}
if(pdo_tableexists('make_speed_agreement')) {
 if(!pdo_fieldexists('make_speed_agreement',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_agreement')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_agreement')) {
 if(!pdo_fieldexists('make_speed_agreement',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_agreement')." ADD `type` tinyint(3) NOT NULL   COMMENT '协议类别(0用户端,1骑手端)';");
 }
}
if(pdo_tableexists('make_speed_agreement')) {
 if(!pdo_fieldexists('make_speed_agreement',  'position')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_agreement')." ADD `position` varchar(64) NOT NULL   COMMENT '所在版块';");
 }
}
if(pdo_tableexists('make_speed_agreement')) {
 if(!pdo_fieldexists('make_speed_agreement',  'content')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_agreement')." ADD `content` text()    COMMENT '协议内容';");
 }
}
if(pdo_tableexists('make_speed_agreement')) {
 if(!pdo_fieldexists('make_speed_agreement',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_agreement')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_agreement')) {
 if(!pdo_fieldexists('make_speed_agreement',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_agreement')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `id` int(20) NOT NULL  AUTO_INCREMENT COMMENT 'ID';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'admin_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `admin_id` int(10) NOT NULL   COMMENT '管理员ID';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `user_id` int(10) NOT NULL   COMMENT '会员ID';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'url')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `url` varchar(255) NOT NULL   COMMENT '物理路径';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'imagewidth')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `imagewidth` varchar(30) NOT NULL   COMMENT '宽度';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'imageheight')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `imageheight` varchar(30) NOT NULL   COMMENT '高度';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'imagetype')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `imagetype` varchar(30) NOT NULL   COMMENT '图片类型';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'imageframes')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `imageframes` int(10) NOT NULL   COMMENT '图片帧数';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'filesize')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `filesize` int(10) NOT NULL   COMMENT '文件大小';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'mimetype')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `mimetype` varchar(100) NOT NULL   COMMENT 'mime类型';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'extparam')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `extparam` varchar(255) NOT NULL   COMMENT '透传数据';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `createtime` int(10) NOT NULL   COMMENT '创建日期';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `updatetime` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'uploadtime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `uploadtime` int(10) NOT NULL   COMMENT '上传时间';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'storage')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `storage` varchar(100) NOT NULL DEFAULT NULL DEFAULT 'local'  COMMENT '存储位置';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'sha1')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `sha1` varchar(40) NOT NULL   COMMENT '文件 sha1编码';");
 }
}
if(pdo_tableexists('make_speed_attachment')) {
 if(!pdo_fieldexists('make_speed_attachment',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_attachment')." ADD `uniacid` int(10) NOT NULL   COMMENT 'uniacid';");
 }
}
if(pdo_tableexists('make_speed_auth_group')) {
 if(!pdo_fieldexists('make_speed_auth_group',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_group')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_auth_group')) {
 if(!pdo_fieldexists('make_speed_auth_group',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_group')." ADD `pid` int(10) NOT NULL   COMMENT '父组别';");
 }
}
if(pdo_tableexists('make_speed_auth_group')) {
 if(!pdo_fieldexists('make_speed_auth_group',  'name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_group')." ADD `name` varchar(100) NOT NULL   COMMENT '组名';");
 }
}
if(pdo_tableexists('make_speed_auth_group')) {
 if(!pdo_fieldexists('make_speed_auth_group',  'rules')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_group')." ADD `rules` text() NOT NULL   COMMENT '规则ID';");
 }
}
if(pdo_tableexists('make_speed_auth_group')) {
 if(!pdo_fieldexists('make_speed_auth_group',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_group')." ADD `createtime` int(10) NOT NULL   COMMENT '创建时间';");
 }
}
if(pdo_tableexists('make_speed_auth_group')) {
 if(!pdo_fieldexists('make_speed_auth_group',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_group')." ADD `updatetime` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_auth_group')) {
 if(!pdo_fieldexists('make_speed_auth_group',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_group')." ADD `status` varchar(30) NOT NULL   COMMENT '状态';");
 }
}
if(pdo_tableexists('make_speed_auth_group')) {
 if(!pdo_fieldexists('make_speed_auth_group',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_group')." ADD `uniacid` int(10) NOT NULL   COMMENT 'uniacid';");
 }
}
if(pdo_tableexists('make_speed_auth_group_access')) {
 if(!pdo_fieldexists('make_speed_auth_group_access',  'uid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_group_access')." ADD `uid` int(10) NOT NULL   COMMENT '会员ID';");
 }
}
if(pdo_tableexists('make_speed_auth_group_access')) {
 if(!pdo_fieldexists('make_speed_auth_group_access',  'group_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_group_access')." ADD `group_id` int(10) NOT NULL   COMMENT '级别ID';");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `type` enum('menu','file') NOT NULL DEFAULT NULL DEFAULT 'file'  COMMENT 'menu为菜单,file为权限节点';");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `pid` int(10) NOT NULL   COMMENT '父ID';");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `name` varchar(100) NOT NULL   COMMENT '规则名称';");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'title')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `title` varchar(50) NOT NULL   COMMENT '规则名称';");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'icon')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `icon` varchar(50) NOT NULL   COMMENT '图标';");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'condition')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `condition` varchar(255) NOT NULL   COMMENT '条件';");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'remark')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `remark` varchar(255) NOT NULL   COMMENT '备注';");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'ismenu')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `ismenu` tinyint(1) NOT NULL   COMMENT '是否为菜单';");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `createtime` int(10) NOT NULL   COMMENT '创建时间';");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `updatetime` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'weigh')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `weigh` int(10) NOT NULL   COMMENT '权重';");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `status` varchar(30) NOT NULL   COMMENT '状态';");
 }
}
if(pdo_tableexists('make_speed_auth_rule')) {
 if(!pdo_fieldexists('make_speed_auth_rule',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_auth_rule')." ADD `uniacid` int(10) NOT NULL   COMMENT 'uniacid';");
 }
}
if(pdo_tableexists('make_speed_banner')) {
 if(!pdo_fieldexists('make_speed_banner',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_banner')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_banner')) {
 if(!pdo_fieldexists('make_speed_banner',  'img')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_banner')." ADD `img` varchar(128) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_banner')) {
 if(!pdo_fieldexists('make_speed_banner',  'path')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_banner')." ADD `path` varchar(64) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_banner')) {
 if(!pdo_fieldexists('make_speed_banner',  'disabled')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_banner')." ADD `disabled` tinyint(3) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_banner')) {
 if(!pdo_fieldexists('make_speed_banner',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_banner')." ADD `add_time` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_banner')) {
 if(!pdo_fieldexists('make_speed_banner',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_banner')." ADD `uniacid` int(10);");
 }
}
if(pdo_tableexists('make_speed_banner')) {
 if(!pdo_fieldexists('make_speed_banner',  'app_url')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_banner')." ADD `app_url` varchar(40) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_banner')) {
 if(!pdo_fieldexists('make_speed_banner',  'appid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_banner')." ADD `appid` varchar(40) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_banner')) {
 if(!pdo_fieldexists('make_speed_banner',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_banner')." ADD `type` tinyint(1) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `user_id` int(11) NOT NULL   COMMENT '主用户';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `name` varchar(128) NOT NULL   COMMENT '大客户名称';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `phone` varchar(16) NOT NULL   COMMENT '联系电话';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'address')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `address` varchar(256) NOT NULL   COMMENT '联系地址';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'license_img1')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `license_img1` varchar(128) NOT NULL   COMMENT '营业执照';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'license_img2')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `license_img2` varchar(128) NOT NULL   COMMENT '经营许可证';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'imgs')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `imgs` varchar(900) NOT NULL   COMMENT '店内实景照片';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'valid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `valid` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '可用余额';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `status` tinyint(3) NOT NULL   COMMENT '状态';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'role')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `role` varchar(20) NOT NULL DEFAULT NULL DEFAULT 'system';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'shop_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `shop_id` varchar(32) NOT NULL   COMMENT '饿了么店铺ID';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'token')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `token` varchar(64) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'refresh_token')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `refresh_token` varchar(64) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'token_expire')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `token_expire` int(10) NOT NULL   COMMENT 'token过期时间';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `add_time` int(10) NOT NULL   COMMENT '申请时间';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `update_time` int(10) NOT NULL   COMMENT '最后更新时间';");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'city_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `city_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business')) {
 if(!pdo_fieldexists('make_speed_business',  'remark')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business')." ADD `remark` varchar(255) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business_info')) {
 if(!pdo_fieldexists('make_speed_business_info',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_info')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_business_info')) {
 if(!pdo_fieldexists('make_speed_business_info',  'business_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_info')." ADD `business_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business_info')) {
 if(!pdo_fieldexists('make_speed_business_info',  'rider_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_info')." ADD `rider_id` varchar(225) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business_info')) {
 if(!pdo_fieldexists('make_speed_business_info',  'init_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_info')." ADD `init_price` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00';");
 }
}
if(pdo_tableexists('make_speed_business_info')) {
 if(!pdo_fieldexists('make_speed_business_info',  'init_distance')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_info')." ADD `init_distance` double(6,1) NOT NULL DEFAULT NULL DEFAULT '0.0';");
 }
}
if(pdo_tableexists('make_speed_business_info')) {
 if(!pdo_fieldexists('make_speed_business_info',  'price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_info')." ADD `price` varchar(225) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business_info')) {
 if(!pdo_fieldexists('make_speed_business_info',  'lat')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_info')." ADD `lat` double(12,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000';");
 }
}
if(pdo_tableexists('make_speed_business_info')) {
 if(!pdo_fieldexists('make_speed_business_info',  'lng')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_info')." ADD `lng` double(13,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000';");
 }
}
if(pdo_tableexists('make_speed_business_info')) {
 if(!pdo_fieldexists('make_speed_business_info',  'address')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_info')." ADD `address` varchar(128) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business_info')) {
 if(!pdo_fieldexists('make_speed_business_info',  'charge_mode')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_info')." ADD `charge_mode` tinyint(1) NOT NULL   COMMENT '计费模式：0=距离收费，1=协议价';");
 }
}
if(pdo_tableexists('make_speed_business_info')) {
 if(!pdo_fieldexists('make_speed_business_info',  'agreement_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_info')." ADD `agreement_price` decimal(10,2) NOT NULL   COMMENT '协议价';");
 }
}
if(pdo_tableexists('make_speed_business_info')) {
 if(!pdo_fieldexists('make_speed_business_info',  'night_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_info')." ADD `night_price` varchar(255) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business_info')) {
 if(!pdo_fieldexists('make_speed_business_info',  'change_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_info')." ADD `change_price` decimal(10,2) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business_user')) {
 if(!pdo_fieldexists('make_speed_business_user',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_user')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_business_user')) {
 if(!pdo_fieldexists('make_speed_business_user',  'business_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_user')." ADD `business_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business_user')) {
 if(!pdo_fieldexists('make_speed_business_user',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_user')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business_user')) {
 if(!pdo_fieldexists('make_speed_business_user',  'username')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_user')." ADD `username` varchar(64) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business_user')) {
 if(!pdo_fieldexists('make_speed_business_user',  'mobile')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_user')." ADD `mobile` varchar(15) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business_user')) {
 if(!pdo_fieldexists('make_speed_business_user',  'sex')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_user')." ADD `sex` varchar(16) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business_user')) {
 if(!pdo_fieldexists('make_speed_business_user',  'home_address')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_user')." ADD `home_address` varchar(128) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_business_user')) {
 if(!pdo_fieldexists('make_speed_business_user',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_business_user')." ADD `add_time` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_cancel_order')) {
 if(!pdo_fieldexists('make_speed_cancel_order',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_cancel_order')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_cancel_order')) {
 if(!pdo_fieldexists('make_speed_cancel_order',  'order_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_cancel_order')." ADD `order_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_cancel_order')) {
 if(!pdo_fieldexists('make_speed_cancel_order',  'rider_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_cancel_order')." ADD `rider_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_cancel_order')) {
 if(!pdo_fieldexists('make_speed_cancel_order',  'cancel_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_cancel_order')." ADD `cancel_time` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_cancel_order')) {
 if(!pdo_fieldexists('make_speed_cancel_order',  'accept_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_cancel_order')." ADD `accept_time` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_cancel_order')) {
 if(!pdo_fieldexists('make_speed_cancel_order',  'city_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_cancel_order')." ADD `city_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_cancel_order')) {
 if(!pdo_fieldexists('make_speed_cancel_order',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_cancel_order')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_city')) {
 if(!pdo_fieldexists('make_speed_city',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_city')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_city')) {
 if(!pdo_fieldexists('make_speed_city',  'name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_city')." ADD `name` varchar(50) NOT NULL   COMMENT '城市名称';");
 }
}
if(pdo_tableexists('make_speed_city')) {
 if(!pdo_fieldexists('make_speed_city',  'parent_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_city')." ADD `parent_id` int(11) NOT NULL   COMMENT '父级ID';");
 }
}
if(pdo_tableexists('make_speed_city')) {
 if(!pdo_fieldexists('make_speed_city',  'key')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_city')." ADD `key` varchar(10) NOT NULL   COMMENT '首字母';");
 }
}
if(pdo_tableexists('make_speed_city')) {
 if(!pdo_fieldexists('make_speed_city',  'is_hot')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_city')." ADD `is_hot` tinyint(1) NOT NULL   COMMENT '是否热门';");
 }
}
if(pdo_tableexists('make_speed_city')) {
 if(!pdo_fieldexists('make_speed_city',  'is_disabled')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_city')." ADD `is_disabled` tinyint(1) NOT NULL   COMMENT '0启用,1禁用';");
 }
}
if(pdo_tableexists('make_speed_city')) {
 if(!pdo_fieldexists('make_speed_city',  'list_order')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_city')." ADD `list_order` int(10) NOT NULL   COMMENT '列表顺序';");
 }
}
if(pdo_tableexists('make_speed_city')) {
 if(!pdo_fieldexists('make_speed_city',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_city')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_city')) {
 if(!pdo_fieldexists('make_speed_city',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_city')." ADD `update_time` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_city')) {
 if(!pdo_fieldexists('make_speed_city',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_city')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_clouds')) {
 if(!pdo_fieldexists('make_speed_clouds',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_clouds')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_clouds')) {
 if(!pdo_fieldexists('make_speed_clouds',  'name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_clouds')." ADD `name` varchar(64) NOT NULL   COMMENT '对接名称';");
 }
}
if(pdo_tableexists('make_speed_clouds')) {
 if(!pdo_fieldexists('make_speed_clouds',  'modules_name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_clouds')." ADD `modules_name` varchar(64) NOT NULL   COMMENT '对接模块';");
 }
}
if(pdo_tableexists('make_speed_clouds')) {
 if(!pdo_fieldexists('make_speed_clouds',  'salt')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_clouds')." ADD `salt` varchar(32) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_clouds')) {
 if(!pdo_fieldexists('make_speed_clouds',  'domain')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_clouds')." ADD `domain` varchar(64) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_clouds')) {
 if(!pdo_fieldexists('make_speed_clouds',  'ip')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_clouds')." ADD `ip` varchar(20);");
 }
}
if(pdo_tableexists('make_speed_clouds')) {
 if(!pdo_fieldexists('make_speed_clouds',  'appid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_clouds')." ADD `appid` varchar(64) NOT NULL   COMMENT '对接小程序appid';");
 }
}
if(pdo_tableexists('make_speed_clouds')) {
 if(!pdo_fieldexists('make_speed_clouds',  'token')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_clouds')." ADD `token` varchar(64) NOT NULL   COMMENT 'Token';");
 }
}
if(pdo_tableexists('make_speed_clouds')) {
 if(!pdo_fieldexists('make_speed_clouds',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_clouds')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_clouds')) {
 if(!pdo_fieldexists('make_speed_clouds',  'm_uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_clouds')." ADD `m_uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_clouds')) {
 if(!pdo_fieldexists('make_speed_clouds',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_clouds')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_clouds')) {
 if(!pdo_fieldexists('make_speed_clouds',  'charging')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_clouds')." ADD `charging` varchar(255) NOT NULL   COMMENT '计费';");
 }
}
if(pdo_tableexists('make_speed_command')) {
 if(!pdo_fieldexists('make_speed_command',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_command')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT COMMENT 'ID';");
 }
}
if(pdo_tableexists('make_speed_command')) {
 if(!pdo_fieldexists('make_speed_command',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_command')." ADD `type` varchar(30) NOT NULL   COMMENT '类型';");
 }
}
if(pdo_tableexists('make_speed_command')) {
 if(!pdo_fieldexists('make_speed_command',  'params')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_command')." ADD `params` varchar(1500) NOT NULL   COMMENT '参数';");
 }
}
if(pdo_tableexists('make_speed_command')) {
 if(!pdo_fieldexists('make_speed_command',  'command')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_command')." ADD `command` varchar(1500) NOT NULL   COMMENT '命令';");
 }
}
if(pdo_tableexists('make_speed_command')) {
 if(!pdo_fieldexists('make_speed_command',  'content')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_command')." ADD `content` text()    COMMENT '返回结果';");
 }
}
if(pdo_tableexists('make_speed_command')) {
 if(!pdo_fieldexists('make_speed_command',  'executetime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_command')." ADD `executetime` int(10) NOT NULL   COMMENT '执行时间';");
 }
}
if(pdo_tableexists('make_speed_command')) {
 if(!pdo_fieldexists('make_speed_command',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_command')." ADD `createtime` int(10) NOT NULL   COMMENT '创建时间';");
 }
}
if(pdo_tableexists('make_speed_command')) {
 if(!pdo_fieldexists('make_speed_command',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_command')." ADD `updatetime` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_command')) {
 if(!pdo_fieldexists('make_speed_command',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_command')." ADD `status` enum('successed','failured') NOT NULL DEFAULT NULL DEFAULT 'failured'  COMMENT '状态';");
 }
}
if(pdo_tableexists('make_speed_command')) {
 if(!pdo_fieldexists('make_speed_command',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_command')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_config')) {
 if(!pdo_fieldexists('make_speed_config',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_config')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_config')) {
 if(!pdo_fieldexists('make_speed_config',  'name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_config')." ADD `name` varchar(30) NOT NULL   COMMENT '变量名';");
 }
}
if(pdo_tableexists('make_speed_config')) {
 if(!pdo_fieldexists('make_speed_config',  'group')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_config')." ADD `group` varchar(30) NOT NULL   COMMENT '分组';");
 }
}
if(pdo_tableexists('make_speed_config')) {
 if(!pdo_fieldexists('make_speed_config',  'title')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_config')." ADD `title` varchar(100) NOT NULL   COMMENT '变量标题';");
 }
}
if(pdo_tableexists('make_speed_config')) {
 if(!pdo_fieldexists('make_speed_config',  'tip')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_config')." ADD `tip` varchar(100) NOT NULL   COMMENT '变量描述';");
 }
}
if(pdo_tableexists('make_speed_config')) {
 if(!pdo_fieldexists('make_speed_config',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_config')." ADD `type` varchar(30) NOT NULL   COMMENT '类型:string,text,int,bool,array,datetime,date,file';");
 }
}
if(pdo_tableexists('make_speed_config')) {
 if(!pdo_fieldexists('make_speed_config',  'value')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_config')." ADD `value` text() NOT NULL   COMMENT '变量值';");
 }
}
if(pdo_tableexists('make_speed_config')) {
 if(!pdo_fieldexists('make_speed_config',  'content')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_config')." ADD `content` text() NOT NULL   COMMENT '变量字典数据';");
 }
}
if(pdo_tableexists('make_speed_config')) {
 if(!pdo_fieldexists('make_speed_config',  'rule')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_config')." ADD `rule` varchar(100) NOT NULL   COMMENT '验证规则';");
 }
}
if(pdo_tableexists('make_speed_config')) {
 if(!pdo_fieldexists('make_speed_config',  'extend')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_config')." ADD `extend` varchar(255) NOT NULL   COMMENT '扩展属性';");
 }
}
if(pdo_tableexists('make_speed_config')) {
 if(!pdo_fieldexists('make_speed_config',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_config')." ADD `uniacid` int(10) NOT NULL   COMMENT 'uniacid';");
 }
}
if(pdo_tableexists('make_speed_coupon_activity')) {
 if(!pdo_fieldexists('make_speed_coupon_activity',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupon_activity')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_coupon_activity')) {
 if(!pdo_fieldexists('make_speed_coupon_activity',  'title')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupon_activity')." ADD `title` varchar(128) NOT NULL   COMMENT '活动名';");
 }
}
if(pdo_tableexists('make_speed_coupon_activity')) {
 if(!pdo_fieldexists('make_speed_coupon_activity',  'coupon_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupon_activity')." ADD `coupon_id` int(10) NOT NULL   COMMENT '优惠券';");
 }
}
if(pdo_tableexists('make_speed_coupon_activity')) {
 if(!pdo_fieldexists('make_speed_coupon_activity',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupon_activity')." ADD `type` int(10) NOT NULL   COMMENT '活动类型(0新人首次进入,1支付下单,2邀请好友)';");
 }
}
if(pdo_tableexists('make_speed_coupon_activity')) {
 if(!pdo_fieldexists('make_speed_coupon_activity',  'total_num')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupon_activity')." ADD `total_num` int(10) NOT NULL   COMMENT '满足数量';");
 }
}
if(pdo_tableexists('make_speed_coupon_activity')) {
 if(!pdo_fieldexists('make_speed_coupon_activity',  'begin_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupon_activity')." ADD `begin_time` int(10) NOT NULL   COMMENT '开始时间';");
 }
}
if(pdo_tableexists('make_speed_coupon_activity')) {
 if(!pdo_fieldexists('make_speed_coupon_activity',  'end_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupon_activity')." ADD `end_time` int(10) NOT NULL   COMMENT '结束时间';");
 }
}
if(pdo_tableexists('make_speed_coupon_activity')) {
 if(!pdo_fieldexists('make_speed_coupon_activity',  'is_disabled')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupon_activity')." ADD `is_disabled` tinyint(1) NOT NULL   COMMENT '是否启用';");
 }
}
if(pdo_tableexists('make_speed_coupon_activity')) {
 if(!pdo_fieldexists('make_speed_coupon_activity',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupon_activity')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_coupon_activity')) {
 if(!pdo_fieldexists('make_speed_coupon_activity',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupon_activity')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'title')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `title` varchar(64) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `code` varchar(30) NOT NULL   COMMENT '兑换码';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'code_num')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `code_num` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'money')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `money` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '优惠金额';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'satisfy_money')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `satisfy_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '满多少可用';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'day')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `day` int(10) NOT NULL   COMMENT '使用期限天数(0为不限制)';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'distance')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `distance` float(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '距离内可使用(0不限制)';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `type` tinyint(3) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'total')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `total` int(10) NOT NULL   COMMENT '满足获得的数量';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'gral')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `gral` int(10) NOT NULL   COMMENT '优惠券积分价格';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'img')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `img` varchar(128) NOT NULL   COMMENT '优惠券图片';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'description')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `description` varchar(225) NOT NULL   COMMENT '使用规则';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `status` tinyint(1) NOT NULL   COMMENT '优惠券状态';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'begin_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `begin_time` int(10) NOT NULL   COMMENT '开始时间';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'end_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `end_time` int(10) NOT NULL   COMMENT '结束时间';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `update_time` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'is_delete')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `is_delete` tinyint(1) NOT NULL   COMMENT '是否删除';");
 }
}
if(pdo_tableexists('make_speed_coupons')) {
 if(!pdo_fieldexists('make_speed_coupons',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_coupons')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `user_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'pid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `pid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'gid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `gid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'invite_code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `invite_code` char(8) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `name` varchar(255) NOT NULL   COMMENT '姓名';");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `phone` char(11) NOT NULL   COMMENT '手机号';");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'commission')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `commission` decimal(10,2) NOT NULL   COMMENT '佣金';");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'pay_commission')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `pay_commission` decimal(10,2) NOT NULL   COMMENT '已提现佣金';");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'count_commission')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `count_commission` decimal(10,2) NOT NULL   COMMENT '累计佣金';");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `status` tinyint(1) NOT NULL   COMMENT '状态:0=待审核,1=正常,2=失败';");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `create_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `update_time` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'city_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `city_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_distributor')) {
 if(!pdo_fieldexists('make_speed_distribution_distributor',  'is_distributor')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_distributor')." ADD `is_distributor` tinyint(10) NOT NULL   COMMENT '是否分销商:0=false,1=true';");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `name` varchar(20) NOT NULL   COMMENT '等级名称';");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'first_commission')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `first_commission` int(10) NOT NULL   COMMENT '一级佣金';");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'second_commission')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `second_commission` int(10) NOT NULL   COMMENT '二级佣金';");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'three_commission')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `three_commission` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'total_amount')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `total_amount` decimal(10,2) NOT NULL   COMMENT '分销订单总额';");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'total_order')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `total_order` int(10) NOT NULL   COMMENT '分销订单总数';");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'number_people')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `number_people` int(10) NOT NULL   COMMENT '分销人数';");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'rank')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `rank` int(10) NOT NULL   COMMENT '等级';");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'auto_level')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `auto_level` tinyint(1) NOT NULL   COMMENT '是否自动升级:0=否,1=是';");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `create_time` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `update_time` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_grade')) {
 if(!pdo_fieldexists('make_speed_distribution_grade',  'city_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_grade')." ADD `city_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_order')) {
 if(!pdo_fieldexists('make_speed_distribution_order',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_order')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_distribution_order')) {
 if(!pdo_fieldexists('make_speed_distribution_order',  'order_number')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_order')." ADD `order_number` varchar(50) NOT NULL   COMMENT '订单号';");
 }
}
if(pdo_tableexists('make_speed_distribution_order')) {
 if(!pdo_fieldexists('make_speed_distribution_order',  'pay_user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_order')." ADD `pay_user_id` int(10) NOT NULL   COMMENT '下单用户';");
 }
}
if(pdo_tableexists('make_speed_distribution_order')) {
 if(!pdo_fieldexists('make_speed_distribution_order',  'price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_order')." ADD `price` decimal(10,2) NOT NULL   COMMENT '支付价格';");
 }
}
if(pdo_tableexists('make_speed_distribution_order')) {
 if(!pdo_fieldexists('make_speed_distribution_order',  'platform_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_order')." ADD `platform_price` decimal(10,2) NOT NULL   COMMENT '平台获取抽成';");
 }
}
if(pdo_tableexists('make_speed_distribution_order')) {
 if(!pdo_fieldexists('make_speed_distribution_order',  'commission')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_order')." ADD `commission` decimal(10,2) NOT NULL   COMMENT '获得佣金';");
 }
}
if(pdo_tableexists('make_speed_distribution_order')) {
 if(!pdo_fieldexists('make_speed_distribution_order',  'level')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_order')." ADD `level` tinyint(10) NOT NULL   COMMENT '获佣级别';");
 }
}
if(pdo_tableexists('make_speed_distribution_order')) {
 if(!pdo_fieldexists('make_speed_distribution_order',  'order_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_order')." ADD `order_id` int(10) NOT NULL   COMMENT '订单id';");
 }
}
if(pdo_tableexists('make_speed_distribution_order')) {
 if(!pdo_fieldexists('make_speed_distribution_order',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_order')." ADD `user_id` int(10) NOT NULL   COMMENT '获佣分销商id';");
 }
}
if(pdo_tableexists('make_speed_distribution_order')) {
 if(!pdo_fieldexists('make_speed_distribution_order',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_order')." ADD `status` tinyint(1) NOT NULL   COMMENT '状态：0=待付款,1=待分佣,2=已分佣,3=已取消';");
 }
}
if(pdo_tableexists('make_speed_distribution_order')) {
 if(!pdo_fieldexists('make_speed_distribution_order',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_order')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_order')) {
 if(!pdo_fieldexists('make_speed_distribution_order',  'city_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_order')." ADD `city_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_order')) {
 if(!pdo_fieldexists('make_speed_distribution_order',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_order')." ADD `create_time` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'order_num')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `order_num` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `user_id` int(10) NOT NULL   COMMENT '分销商';");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'did')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `did` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'amount')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `amount` decimal(10,2) NOT NULL   COMMENT '提现金额';");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'server_charge')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `server_charge` decimal(10,2) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `status` tinyint(1) NOT NULL   COMMENT '状态:0=待审核,1=待打款,2=已打款';");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `type` tinyint(1) NOT NULL   COMMENT '提现方式:1=微信,2=支付宝，3=银行卡';");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `name` varchar(20) NOT NULL   COMMENT '姓名';");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'account')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `account` varchar(30) NOT NULL   COMMENT '账号';");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `create_time` int(10) NOT NULL   COMMENT '申请时间';");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `update_time` int(10) NOT NULL   COMMENT '打款时间';");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'city_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `city_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'open_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `open_id` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_distribution_withdraw')) {
 if(!pdo_fieldexists('make_speed_distribution_withdraw',  'bank')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_distribution_withdraw')." ADD `bank` varchar(50) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_equip')) {
 if(!pdo_fieldexists('make_speed_equip',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_equip')) {
 if(!pdo_fieldexists('make_speed_equip',  'title')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip')." ADD `title` varchar(64) NOT NULL   COMMENT '装备标题';");
 }
}
if(pdo_tableexists('make_speed_equip')) {
 if(!pdo_fieldexists('make_speed_equip',  'img')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip')." ADD `img` varchar(128) NOT NULL   COMMENT '装备图片';");
 }
}
if(pdo_tableexists('make_speed_equip')) {
 if(!pdo_fieldexists('make_speed_equip',  'price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip')." ADD `price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '装备价格';");
 }
}
if(pdo_tableexists('make_speed_equip')) {
 if(!pdo_fieldexists('make_speed_equip',  'detail')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip')." ADD `detail` text()    COMMENT '装备详情';");
 }
}
if(pdo_tableexists('make_speed_equip')) {
 if(!pdo_fieldexists('make_speed_equip',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_equip')) {
 if(!pdo_fieldexists('make_speed_equip',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip')." ADD `status` tinyint(3) NOT NULL   COMMENT '装备上架状态';");
 }
}
if(pdo_tableexists('make_speed_equip')) {
 if(!pdo_fieldexists('make_speed_equip',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_equip_order')) {
 if(!pdo_fieldexists('make_speed_equip_order',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip_order')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_equip_order')) {
 if(!pdo_fieldexists('make_speed_equip_order',  'order_code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip_order')." ADD `order_code` varchar(32) NOT NULL   COMMENT '订单号';");
 }
}
if(pdo_tableexists('make_speed_equip_order')) {
 if(!pdo_fieldexists('make_speed_equip_order',  'price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip_order')." ADD `price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '支付金额';");
 }
}
if(pdo_tableexists('make_speed_equip_order')) {
 if(!pdo_fieldexists('make_speed_equip_order',  'rider_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip_order')." ADD `rider_id` int(10) NOT NULL   COMMENT '骑手ID';");
 }
}
if(pdo_tableexists('make_speed_equip_order')) {
 if(!pdo_fieldexists('make_speed_equip_order',  'equip_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip_order')." ADD `equip_id` int(10) NOT NULL   COMMENT '装备ID';");
 }
}
if(pdo_tableexists('make_speed_equip_order')) {
 if(!pdo_fieldexists('make_speed_equip_order',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip_order')." ADD `status` tinyint(3) NOT NULL   COMMENT '状态(0)';");
 }
}
if(pdo_tableexists('make_speed_equip_order')) {
 if(!pdo_fieldexists('make_speed_equip_order',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip_order')." ADD `add_time` int(10) NOT NULL   COMMENT '购买时间';");
 }
}
if(pdo_tableexists('make_speed_equip_order')) {
 if(!pdo_fieldexists('make_speed_equip_order',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_equip_order')." ADD `update_time` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_goods_type')) {
 if(!pdo_fieldexists('make_speed_goods_type',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_goods_type')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_goods_type')) {
 if(!pdo_fieldexists('make_speed_goods_type',  'order_type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_goods_type')." ADD `order_type` tinyint(3) NOT NULL   COMMENT '业务类型';");
 }
}
if(pdo_tableexists('make_speed_goods_type')) {
 if(!pdo_fieldexists('make_speed_goods_type',  'name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_goods_type')." ADD `name` varchar(64) NOT NULL   COMMENT '类型名称';");
 }
}
if(pdo_tableexists('make_speed_goods_type')) {
 if(!pdo_fieldexists('make_speed_goods_type',  'icon')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_goods_type')." ADD `icon` varchar(128) NOT NULL   COMMENT '类型图标';");
 }
}
if(pdo_tableexists('make_speed_goods_type')) {
 if(!pdo_fieldexists('make_speed_goods_type',  'iconed')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_goods_type')." ADD `iconed` varchar(128) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_goods_type')) {
 if(!pdo_fieldexists('make_speed_goods_type',  'weight')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_goods_type')." ADD `weight` int(10) NOT NULL   COMMENT '排序';");
 }
}
if(pdo_tableexists('make_speed_goods_type')) {
 if(!pdo_fieldexists('make_speed_goods_type',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_goods_type')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_goods_type')) {
 if(!pdo_fieldexists('make_speed_goods_type',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_goods_type')." ADD `update_time` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_goods_type')) {
 if(!pdo_fieldexists('make_speed_goods_type',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_goods_type')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_handbook')) {
 if(!pdo_fieldexists('make_speed_handbook',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_handbook')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_handbook')) {
 if(!pdo_fieldexists('make_speed_handbook',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_handbook')." ADD `type` tinyint(3) NOT NULL   COMMENT '(0骑手端,1用户端)';");
 }
}
if(pdo_tableexists('make_speed_handbook')) {
 if(!pdo_fieldexists('make_speed_handbook',  'title')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_handbook')." ADD `title` varchar(64) NOT NULL   COMMENT '手册标题';");
 }
}
if(pdo_tableexists('make_speed_handbook')) {
 if(!pdo_fieldexists('make_speed_handbook',  'icon')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_handbook')." ADD `icon` varchar(128) NOT NULL   COMMENT '标题图标';");
 }
}
if(pdo_tableexists('make_speed_handbook')) {
 if(!pdo_fieldexists('make_speed_handbook',  'content')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_handbook')." ADD `content` text()    COMMENT '内容';");
 }
}
if(pdo_tableexists('make_speed_handbook')) {
 if(!pdo_fieldexists('make_speed_handbook',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_handbook')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_handbook')) {
 if(!pdo_fieldexists('make_speed_handbook',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_handbook')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `type` tinyint(3) NOT NULL   COMMENT '订单类型';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'order_code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `order_code` varchar(32) NOT NULL   COMMENT '订单号';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `user_id` int(11) NOT NULL   COMMENT '下单用户';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'clouds_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `clouds_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'business_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `business_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'goods_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `goods_id` int(11) NOT NULL   COMMENT '物品类型ID';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'goodsname')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `goodsname` varchar(128) NOT NULL   COMMENT '物品类型';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `phone` varchar(32) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'get_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `get_time` varchar(64) NOT NULL   COMMENT '取件时间';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'coupon_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `coupon_id` int(10) NOT NULL   COMMENT '优惠券';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'small_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `small_price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '小费金额';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'distance')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `distance` float(6,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '订单距离';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'weight')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `weight` float(6,1) NOT NULL DEFAULT NULL DEFAULT '0.0'  COMMENT '重量';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'distance_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `distance_price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '里程费';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'weight_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `weight_price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '续重费';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'night_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `night_price` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '夜间费用';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'change_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `change_price` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '溢价费用';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'discount_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `discount_price` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '会员折扣';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'total_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `total_price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '订单总额';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'pay_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `pay_price` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '实际支付';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'floor_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `floor_price` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '楼层费用';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'budget_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `budget_price` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '预计价';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'is_discuss')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `is_discuss` tinyint(3) NOT NULL   COMMENT '是否接受议价';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'img')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `img` varchar(600) NOT NULL   COMMENT '下单图片';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'audio')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `audio` varchar(128) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'order_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `order_time` varchar(32) NOT NULL   COMMENT '订单时时间';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'distance_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `distance_time` int(10) NOT NULL   COMMENT '路程时间';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'expect_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `expect_time` varchar(32) NOT NULL   COMMENT '预计取件/服务时间';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'expect_timeed')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `expect_timeed` varchar(32) NOT NULL   COMMENT '预计送达/完成时间';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'description')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `description` varchar(255)    COMMENT '备注/描述';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'payment')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `payment` tinyint(1) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '支付类型(1余额,2微信支付)';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `status` tinyint(1) NOT NULL   COMMENT '订单状态(0待支付,1已取消,2已支付待取件,3已取件送货中,4完成送达待评价,5完成)';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `update_time` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'city_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `city_id` int(10) NOT NULL   COMMENT '城市';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'role')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `role` varchar(32) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'car_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `car_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'car_name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `car_name` varchar(20) NOT NULL   COMMENT '车辆名称';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'start_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `start_price` decimal(10,2) NOT NULL   COMMENT '起步价格';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'start_km')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `start_km` double(6,2) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'accept_order_num')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `accept_order_num` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'charg_type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `charg_type` tinyint(1) NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '代驾收费类型1=距离,2-实时';");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'expire_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `expire_time` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'car_type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `car_type` tinyint(1) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'total_car')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `total_car` decimal(10,2) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'load_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `load_price` decimal(10,2) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'load_switch')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `load_switch` tinyint(1) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'category_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `category_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'cube')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `cube` float(10,2) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'cube_price')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `cube_price` decimal(10,2) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order')) {
 if(!pdo_fieldexists('make_speed_order',  'snap_item')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order')." ADD `snap_item` varchar(500) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'order_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `order_id` int(10) NOT NULL   COMMENT '所属订单ID';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'begin_address')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `begin_address` varchar(128) NOT NULL   COMMENT '寄件地址';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'begin_detail')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `begin_detail` varchar(128) NOT NULL   COMMENT '详情地址: 街道/门牌';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'begin_lat')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `begin_lat` double(11,9) NOT NULL DEFAULT NULL DEFAULT '0.000000000'  COMMENT '寄件纬度';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'begin_lng')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `begin_lng` double(13,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000'  COMMENT '寄件经度';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'begin_username')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `begin_username` varchar(64) NOT NULL   COMMENT '寄件人姓名';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'begin_phone')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `begin_phone` varchar(12) NOT NULL   COMMENT '寄件人电话';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'end_address')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `end_address` varchar(128) NOT NULL   COMMENT '收件地址';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'end_detail')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `end_detail` varchar(128) NOT NULL   COMMENT '详情地址: 街道/门牌';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'end_lat')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `end_lat` double(12,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000'  COMMENT '寄件纬度';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'end_lng')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `end_lng` double(13,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000'  COMMENT '收件经度';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'end_username')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `end_username` varchar(64) NOT NULL   COMMENT '收件人姓名';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'end_phone')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `end_phone` varchar(64) NOT NULL   COMMENT '收件电话';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'end_floor')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `end_floor` tinyint(3) NOT NULL   COMMENT '所在楼层';");
 }
}
if(pdo_tableexists('make_speed_order_address')) {
 if(!pdo_fieldexists('make_speed_order_address',  'extension_number')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_address')." ADD `extension_number` varchar(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order_pickcode')) {
 if(!pdo_fieldexists('make_speed_order_pickcode',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_pickcode')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_order_pickcode')) {
 if(!pdo_fieldexists('make_speed_order_pickcode',  'order_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_pickcode')." ADD `order_id` int(10) NOT NULL   COMMENT '订单ID';");
 }
}
if(pdo_tableexists('make_speed_order_pickcode')) {
 if(!pdo_fieldexists('make_speed_order_pickcode',  'pick_code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_pickcode')." ADD `pick_code` int(10) NOT NULL   COMMENT '取件码';");
 }
}
if(pdo_tableexists('make_speed_order_pickcode')) {
 if(!pdo_fieldexists('make_speed_order_pickcode',  'end_code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_pickcode')." ADD `end_code` int(10) NOT NULL   COMMENT '收件码';");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'order_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `order_id` int(10) NOT NULL   COMMENT '订单ID';");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'rider_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `rider_id` int(10) NOT NULL   COMMENT '骑手ID';");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'rider_money')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `rider_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '骑手佣金';");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'score')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `score` int(10) NOT NULL   COMMENT '评分';");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'tag')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `tag` varchar(64) NOT NULL   COMMENT '标签';");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'rider_distance')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `rider_distance` float(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '骑手路程';");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'pick_img')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `pick_img` varchar(128) NOT NULL   COMMENT '取件照片';");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'end_img')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `end_img` varchar(129) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'total_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `total_time` int(10) NOT NULL   COMMENT '订单花费时间(单位:秒)';");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'accept_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `accept_time` int(10) NOT NULL   COMMENT '接单时间';");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'get_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `get_time` int(10) NOT NULL   COMMENT '揽件时间';");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'goto_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `goto_time` int(10) NOT NULL   COMMENT '送达时间';");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'complete_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `complete_time` int(10) NOT NULL   COMMENT '完成时间(评价时间)';");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'expect_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `expect_time` varchar(32) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'expect_timed')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `expect_timed` varchar(32) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'goto_msec_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `goto_msec_time` char(13) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'get_msec_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `get_msec_time` char(13) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_order_rider')) {
 if(!pdo_fieldexists('make_speed_order_rider',  'trid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_order_rider')." ADD `trid` varchar(20) NOT NULL   COMMENT '轨迹ID';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'invite_code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `invite_code` varchar(20) NOT NULL   COMMENT '邀请码';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'nick_name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `nick_name` varchar(100) NOT NULL   COMMENT '昵称,显示时用';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'real_name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `real_name` varchar(100) NOT NULL   COMMENT '真实姓名';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'mobile')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `mobile` varchar(20) NOT NULL   COMMENT '手机';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'avatar')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `avatar` varchar(255) NOT NULL   COMMENT '头像';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'sex')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `sex` tinyint(3) NOT NULL   COMMENT '性别: 0女,1男';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'age')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `age` int(10) NOT NULL   COMMENT '年龄';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'height')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `height` int(10) NOT NULL   COMMENT '身高';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'weight')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `weight` int(10) NOT NULL   COMMENT '体重';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'education')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `education` varchar(32) NOT NULL   COMMENT '学历';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'occup')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `occup` varchar(32)    COMMENT '职业';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'address')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `address` varchar(128) NOT NULL   COMMENT '住址';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'nervous_person')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `nervous_person` varchar(32) NOT NULL   COMMENT '紧急联系人';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'nervous_phone')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `nervous_phone` varchar(20) NOT NULL   COMMENT '紧急联系电话';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'open_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `open_id` varchar(128) NOT NULL   COMMENT '用户openid';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'user_grade')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `user_grade` int(10) NOT NULL   COMMENT '用户成长值';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'invalid_money')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `invalid_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '不可用余额';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'valid_money')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `valid_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '可用余额';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'bond_money')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `bond_money` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '保证金';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'madou')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `madou` int(10) NOT NULL   COMMENT '码豆';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'recommend_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `recommend_id` int(11) NOT NULL   COMMENT '推荐人ID';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'recommend_code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `recommend_code` varchar(16) NOT NULL   COMMENT '个人推荐码';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `status` tinyint(1) NOT NULL   COMMENT '状态';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `add_time` int(10) NOT NULL   COMMENT '注册或添加时间';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'logged_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `logged_time` int(10) NOT NULL   COMMENT '最近一次登录时间';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'logged_ip')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `logged_ip` varchar(128) NOT NULL   COMMENT '最近一次登录IP';");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'city_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `city_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'accept_order_num')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `accept_order_num` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider')) {
 if(!pdo_fieldexists('make_speed_rider',  'app_client_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider')." ADD `app_client_id` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'rider_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `rider_id` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'real_name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `real_name` varchar(32) NOT NULL   COMMENT '真实姓名';");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'card_code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `card_code` varchar(20) NOT NULL   COMMENT '身份证号';");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'sex')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `sex` tinyint(1) NOT NULL   COMMENT '性别';");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'address')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `address` varchar(128) NOT NULL   COMMENT '户籍所在地';");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'card1_img')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `card1_img` varchar(100) NOT NULL   COMMENT '身份证图片';");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'card2_img')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `card2_img` varchar(100) NOT NULL   COMMENT '身份证背面照';");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'card3_img')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `card3_img` varchar(100) NOT NULL   COMMENT '手持身份证照';");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'card4_img')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `card4_img` varchar(100) NOT NULL   COMMENT '个人自拍照';");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `status` tinyint(1) NOT NULL   COMMENT '审核状态(0待审核,1未通过,2已通过)';");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `update_time` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_bind')) {
 if(!pdo_fieldexists('make_speed_rider_bind',  'remark')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_bind')." ADD `remark` varchar(20) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_brokerage')) {
 if(!pdo_fieldexists('make_speed_rider_brokerage',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_brokerage')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT COMMENT '自增ID';");
 }
}
if(pdo_tableexists('make_speed_rider_brokerage')) {
 if(!pdo_fieldexists('make_speed_rider_brokerage',  'account')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_brokerage')." ADD `account` tinyint(3) NOT NULL   COMMENT '(0骑手,1用户)';");
 }
}
if(pdo_tableexists('make_speed_rider_brokerage')) {
 if(!pdo_fieldexists('make_speed_rider_brokerage',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_brokerage')." ADD `user_id` int(11) NOT NULL   COMMENT '用户ID';");
 }
}
if(pdo_tableexists('make_speed_rider_brokerage')) {
 if(!pdo_fieldexists('make_speed_rider_brokerage',  'object_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_brokerage')." ADD `object_id` int(11) NOT NULL   COMMENT '订单ID';");
 }
}
if(pdo_tableexists('make_speed_rider_brokerage')) {
 if(!pdo_fieldexists('make_speed_rider_brokerage',  'recommend_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_brokerage')." ADD `recommend_id` int(11) NOT NULL   COMMENT '推荐人ID';");
 }
}
if(pdo_tableexists('make_speed_rider_brokerage')) {
 if(!pdo_fieldexists('make_speed_rider_brokerage',  'amount')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_brokerage')." ADD `amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '获得佣金';");
 }
}
if(pdo_tableexists('make_speed_rider_brokerage')) {
 if(!pdo_fieldexists('make_speed_rider_brokerage',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_brokerage')." ADD `type` varchar(20) NOT NULL   COMMENT '奖励推荐类型';");
 }
}
if(pdo_tableexists('make_speed_rider_brokerage')) {
 if(!pdo_fieldexists('make_speed_rider_brokerage',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_brokerage')." ADD `status` tinyint(3) NOT NULL   COMMENT '状态(0:待分成,1已取消,2以分成)';");
 }
}
if(pdo_tableexists('make_speed_rider_brokerage')) {
 if(!pdo_fieldexists('make_speed_rider_brokerage',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_brokerage')." ADD `add_time` int(11) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_rider_brokerage')) {
 if(!pdo_fieldexists('make_speed_rider_brokerage',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_brokerage')." ADD `update_time` int(11) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_rider_brokerage')) {
 if(!pdo_fieldexists('make_speed_rider_brokerage',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_brokerage')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_cashlog')) {
 if(!pdo_fieldexists('make_speed_rider_cashlog',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_cashlog')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_rider_cashlog')) {
 if(!pdo_fieldexists('make_speed_rider_cashlog',  'title')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_cashlog')." ADD `title` varchar(128) NOT NULL   COMMENT '说明';");
 }
}
if(pdo_tableexists('make_speed_rider_cashlog')) {
 if(!pdo_fieldexists('make_speed_rider_cashlog',  'rider_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_cashlog')." ADD `rider_id` int(10) NOT NULL   COMMENT '用户';");
 }
}
if(pdo_tableexists('make_speed_rider_cashlog')) {
 if(!pdo_fieldexists('make_speed_rider_cashlog',  'object_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_cashlog')." ADD `object_id` int(10) NOT NULL   COMMENT '项目ID';");
 }
}
if(pdo_tableexists('make_speed_rider_cashlog')) {
 if(!pdo_fieldexists('make_speed_rider_cashlog',  'order_code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_cashlog')." ADD `order_code` varchar(32) NOT NULL   COMMENT '业务订单号';");
 }
}
if(pdo_tableexists('make_speed_rider_cashlog')) {
 if(!pdo_fieldexists('make_speed_rider_cashlog',  'amount')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_cashlog')." ADD `amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '金额';");
 }
}
if(pdo_tableexists('make_speed_rider_cashlog')) {
 if(!pdo_fieldexists('make_speed_rider_cashlog',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_cashlog')." ADD `type` tinyint(3) NOT NULL   COMMENT '财务类型(0消费记录,1充值记录,2退款)';");
 }
}
if(pdo_tableexists('make_speed_rider_cashlog')) {
 if(!pdo_fieldexists('make_speed_rider_cashlog',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_cashlog')." ADD `status` tinyint(1) NOT NULL   COMMENT '状态(0异常,1以划款,2已到账)';");
 }
}
if(pdo_tableexists('make_speed_rider_cashlog')) {
 if(!pdo_fieldexists('make_speed_rider_cashlog',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_cashlog')." ADD `add_time` int(10) NOT NULL   COMMENT '创建时间';");
 }
}
if(pdo_tableexists('make_speed_rider_cashlog')) {
 if(!pdo_fieldexists('make_speed_rider_cashlog',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_cashlog')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_driver')) {
 if(!pdo_fieldexists('make_speed_rider_driver',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_driver')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_rider_driver')) {
 if(!pdo_fieldexists('make_speed_rider_driver',  'rider_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_driver')." ADD `rider_id` int(11) NOT NULL   COMMENT '认证骑手';");
 }
}
if(pdo_tableexists('make_speed_rider_driver')) {
 if(!pdo_fieldexists('make_speed_rider_driver',  'card_img1')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_driver')." ADD `card_img1` varchar(128) NOT NULL   COMMENT '驾驶证正本';");
 }
}
if(pdo_tableexists('make_speed_rider_driver')) {
 if(!pdo_fieldexists('make_speed_rider_driver',  'card_img2')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_driver')." ADD `card_img2` varchar(128) NOT NULL   COMMENT '驾驶证副本';");
 }
}
if(pdo_tableexists('make_speed_rider_driver')) {
 if(!pdo_fieldexists('make_speed_rider_driver',  'card_num')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_driver')." ADD `card_num` varchar(128) NOT NULL   COMMENT '档案编号';");
 }
}
if(pdo_tableexists('make_speed_rider_driver')) {
 if(!pdo_fieldexists('make_speed_rider_driver',  'card_type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_driver')." ADD `card_type` varchar(64) NOT NULL   COMMENT '准驾车型';");
 }
}
if(pdo_tableexists('make_speed_rider_driver')) {
 if(!pdo_fieldexists('make_speed_rider_driver',  'card_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_driver')." ADD `card_time` varchar(64) NOT NULL   COMMENT '初领驾驶证日期';");
 }
}
if(pdo_tableexists('make_speed_rider_driver')) {
 if(!pdo_fieldexists('make_speed_rider_driver',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_driver')." ADD `status` tinyint(3) NOT NULL   COMMENT '审核状态';");
 }
}
if(pdo_tableexists('make_speed_rider_driver')) {
 if(!pdo_fieldexists('make_speed_rider_driver',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_driver')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_rider_driver')) {
 if(!pdo_fieldexists('make_speed_rider_driver',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_driver')." ADD `update_time` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_rider_driver')) {
 if(!pdo_fieldexists('make_speed_rider_driver',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_driver')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_driver')) {
 if(!pdo_fieldexists('make_speed_rider_driver',  'remark')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_driver')." ADD `remark` varchar(20) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_driver')) {
 if(!pdo_fieldexists('make_speed_rider_driver',  'tid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_driver')." ADD `tid` varchar(20) NOT NULL   COMMENT '终端ID';");
 }
}
if(pdo_tableexists('make_speed_rider_formid')) {
 if(!pdo_fieldexists('make_speed_rider_formid',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_formid')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_rider_formid')) {
 if(!pdo_fieldexists('make_speed_rider_formid',  'rider_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_formid')." ADD `rider_id` int(10) NOT NULL   COMMENT '骑手id';");
 }
}
if(pdo_tableexists('make_speed_rider_formid')) {
 if(!pdo_fieldexists('make_speed_rider_formid',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_formid')." ADD `user_id` int(10) NOT NULL   COMMENT '用户ID';");
 }
}
if(pdo_tableexists('make_speed_rider_formid')) {
 if(!pdo_fieldexists('make_speed_rider_formid',  'open_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_formid')." ADD `open_id` varchar(32) NOT NULL   COMMENT '骑手openid';");
 }
}
if(pdo_tableexists('make_speed_rider_formid')) {
 if(!pdo_fieldexists('make_speed_rider_formid',  'form_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_formid')." ADD `form_id` varchar(32) NOT NULL   COMMENT '服务通知formid';");
 }
}
if(pdo_tableexists('make_speed_rider_formid')) {
 if(!pdo_fieldexists('make_speed_rider_formid',  'expire_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_formid')." ADD `expire_time` int(10) NOT NULL   COMMENT '过期时间';");
 }
}
if(pdo_tableexists('make_speed_rider_formid')) {
 if(!pdo_fieldexists('make_speed_rider_formid',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_formid')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'rider_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `rider_id` int(10) NOT NULL   COMMENT '骑手ID';");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'score')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `score` float(5,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '评分';");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'service_total')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `service_total` int(10) NOT NULL   COMMENT '服务总次数';");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'distance_total')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `distance_total` float(12,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '累计行程';");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'income_total')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `income_total` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '累计收入';");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'time_total')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `time_total` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'lat')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `lat` double(8,6) NOT NULL DEFAULT NULL DEFAULT '0.000000'  COMMENT '骑手坐标纬度';");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'lng')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `lng` double(9,6) NOT NULL DEFAULT NULL DEFAULT '0.000000'  COMMENT '骑手坐标经度';");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'address')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `address` varchar(100) NOT NULL   COMMENT '接单地址';");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'is_accept')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `is_accept` tinyint(1) NOT NULL   COMMENT '是否接单(0接单,1不接单)';");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'cancel_count')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `cancel_count` int(10) NOT NULL   COMMENT '已接单数量';");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'accept_type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `accept_type` tinyint(1) NOT NULL   COMMENT '接单类型(0全接,1实时单,2预约单)';");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_info')) {
 if(!pdo_fieldexists('make_speed_rider_info',  'order_type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_info')." ADD `order_type` varchar(10) NOT NULL DEFAULT NULL DEFAULT '0,3,5,6';");
 }
}
if(pdo_tableexists('make_speed_rider_message')) {
 if(!pdo_fieldexists('make_speed_rider_message',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_message')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_rider_message')) {
 if(!pdo_fieldexists('make_speed_rider_message',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_message')." ADD `type` int(10) NOT NULL   COMMENT '通知类型(0系统通知,1处罚公告,2订单通知)';");
 }
}
if(pdo_tableexists('make_speed_rider_message')) {
 if(!pdo_fieldexists('make_speed_rider_message',  'rider_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_message')." ADD `rider_id` int(11) NOT NULL   COMMENT '通知骑手';");
 }
}
if(pdo_tableexists('make_speed_rider_message')) {
 if(!pdo_fieldexists('make_speed_rider_message',  'title')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_message')." ADD `title` varchar(225) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('make_speed_rider_message')) {
 if(!pdo_fieldexists('make_speed_rider_message',  'content')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_message')." ADD `content` text()    COMMENT '消息详情';");
 }
}
if(pdo_tableexists('make_speed_rider_message')) {
 if(!pdo_fieldexists('make_speed_rider_message',  'object_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_message')." ADD `object_id` int(11) NOT NULL   COMMENT '所属项目';");
 }
}
if(pdo_tableexists('make_speed_rider_message')) {
 if(!pdo_fieldexists('make_speed_rider_message',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_message')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_rider_message')) {
 if(!pdo_fieldexists('make_speed_rider_message',  'is_read')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_message')." ADD `is_read` tinyint(1) NOT NULL   COMMENT '是否已读：0否；1是';");
 }
}
if(pdo_tableexists('make_speed_rider_message')) {
 if(!pdo_fieldexists('make_speed_rider_message',  'all')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_message')." ADD `all` tinyint(1) NOT NULL   COMMENT '下发所有骑手';");
 }
}
if(pdo_tableexists('make_speed_rider_message')) {
 if(!pdo_fieldexists('make_speed_rider_message',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_message')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_sanction')) {
 if(!pdo_fieldexists('make_speed_rider_sanction',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_sanction')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_rider_sanction')) {
 if(!pdo_fieldexists('make_speed_rider_sanction',  'rider_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_sanction')." ADD `rider_id` int(10) NOT NULL   COMMENT '奖惩骑手';");
 }
}
if(pdo_tableexists('make_speed_rider_sanction')) {
 if(!pdo_fieldexists('make_speed_rider_sanction',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_sanction')." ADD `type` enum('0','1') NOT NULL   COMMENT '类型(0惩罚,1奖励)';");
 }
}
if(pdo_tableexists('make_speed_rider_sanction')) {
 if(!pdo_fieldexists('make_speed_rider_sanction',  'class')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_sanction')." ADD `class` int(10) NOT NULL   COMMENT '奖惩内容(0余额,1通知警告,2禁止接单,3冻结账户余额)';");
 }
}
if(pdo_tableexists('make_speed_rider_sanction')) {
 if(!pdo_fieldexists('make_speed_rider_sanction',  'metric')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_sanction')." ADD `metric` int(10) NOT NULL   COMMENT '奖惩度量(元|小时)';");
 }
}
if(pdo_tableexists('make_speed_rider_sanction')) {
 if(!pdo_fieldexists('make_speed_rider_sanction',  'reason')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_sanction')." ADD `reason` varchar(225) NOT NULL   COMMENT '奖惩原因说明';");
 }
}
if(pdo_tableexists('make_speed_rider_sanction')) {
 if(!pdo_fieldexists('make_speed_rider_sanction',  'appeal')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_sanction')." ADD `appeal` varchar(225) NOT NULL   COMMENT '申诉内容';");
 }
}
if(pdo_tableexists('make_speed_rider_sanction')) {
 if(!pdo_fieldexists('make_speed_rider_sanction',  'begin_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_sanction')." ADD `begin_time` int(10) NOT NULL   COMMENT '开始时间';");
 }
}
if(pdo_tableexists('make_speed_rider_sanction')) {
 if(!pdo_fieldexists('make_speed_rider_sanction',  'end_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_sanction')." ADD `end_time` int(10) NOT NULL   COMMENT '结束时间';");
 }
}
if(pdo_tableexists('make_speed_rider_sanction')) {
 if(!pdo_fieldexists('make_speed_rider_sanction',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_sanction')." ADD `status` tinyint(3) NOT NULL   COMMENT '状态(0进行中1申诉2申诉成功)';");
 }
}
if(pdo_tableexists('make_speed_rider_sanction')) {
 if(!pdo_fieldexists('make_speed_rider_sanction',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_sanction')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_rider_sanction')) {
 if(!pdo_fieldexists('make_speed_rider_sanction',  'notify')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_sanction')." ADD `notify` tinyint(3) NOT NULL   COMMENT '是否通知骑手';");
 }
}
if(pdo_tableexists('make_speed_rider_sanction')) {
 if(!pdo_fieldexists('make_speed_rider_sanction',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_sanction')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_withdraw')) {
 if(!pdo_fieldexists('make_speed_rider_withdraw',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_withdraw')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_rider_withdraw')) {
 if(!pdo_fieldexists('make_speed_rider_withdraw',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_withdraw')." ADD `type` tinyint(3) NOT NULL DEFAULT NULL DEFAULT '2'  COMMENT '转账类型';");
 }
}
if(pdo_tableexists('make_speed_rider_withdraw')) {
 if(!pdo_fieldexists('make_speed_rider_withdraw',  'tx_type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_withdraw')." ADD `tx_type` tinyint(3) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_rider_withdraw')) {
 if(!pdo_fieldexists('make_speed_rider_withdraw',  'rider_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_withdraw')." ADD `rider_id` int(11) NOT NULL   COMMENT '骑手ID';");
 }
}
if(pdo_tableexists('make_speed_rider_withdraw')) {
 if(!pdo_fieldexists('make_speed_rider_withdraw',  'trade_code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_withdraw')." ADD `trade_code` varchar(32) NOT NULL   COMMENT '流水订单号';");
 }
}
if(pdo_tableexists('make_speed_rider_withdraw')) {
 if(!pdo_fieldexists('make_speed_rider_withdraw',  'money')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_withdraw')." ADD `money` decimal(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '提现金额';");
 }
}
if(pdo_tableexists('make_speed_rider_withdraw')) {
 if(!pdo_fieldexists('make_speed_rider_withdraw',  'open_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_withdraw')." ADD `open_id` varchar(64) NOT NULL   COMMENT '到账账户open_id';");
 }
}
if(pdo_tableexists('make_speed_rider_withdraw')) {
 if(!pdo_fieldexists('make_speed_rider_withdraw',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_withdraw')." ADD `status` tinyint(1) NOT NULL   COMMENT '状态(0待通过,1不通过,2已通过并打款)';");
 }
}
if(pdo_tableexists('make_speed_rider_withdraw')) {
 if(!pdo_fieldexists('make_speed_rider_withdraw',  'description')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_withdraw')." ADD `description` varchar(128) NOT NULL   COMMENT '企业付款备注';");
 }
}
if(pdo_tableexists('make_speed_rider_withdraw')) {
 if(!pdo_fieldexists('make_speed_rider_withdraw',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_withdraw')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_rider_withdraw')) {
 if(!pdo_fieldexists('make_speed_rider_withdraw',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_withdraw')." ADD `update_time` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_rider_withdraw')) {
 if(!pdo_fieldexists('make_speed_rider_withdraw',  'received_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_withdraw')." ADD `received_time` int(10) NOT NULL   COMMENT '提现到账时间';");
 }
}
if(pdo_tableexists('make_speed_rider_withdraw')) {
 if(!pdo_fieldexists('make_speed_rider_withdraw',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_rider_withdraw')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_setting')) {
 if(!pdo_fieldexists('make_speed_setting',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_setting')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_setting')) {
 if(!pdo_fieldexists('make_speed_setting',  'key')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_setting')." ADD `key` varchar(64) NOT NULL   COMMENT '配置键名';");
 }
}
if(pdo_tableexists('make_speed_setting')) {
 if(!pdo_fieldexists('make_speed_setting',  'value')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_setting')." ADD `value` text()    COMMENT '配置值';");
 }
}
if(pdo_tableexists('make_speed_setting')) {
 if(!pdo_fieldexists('make_speed_setting',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_setting')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_setting')) {
 if(!pdo_fieldexists('make_speed_setting',  'city_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_setting')." ADD `city_id` int(10) NOT NULL   COMMENT '城市ID';");
 }
}
if(pdo_tableexists('make_speed_train_point')) {
 if(!pdo_fieldexists('make_speed_train_point',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_point')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_train_point')) {
 if(!pdo_fieldexists('make_speed_train_point',  'city_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_point')." ADD `city_id` int(10) NOT NULL   COMMENT '城市ID';");
 }
}
if(pdo_tableexists('make_speed_train_point')) {
 if(!pdo_fieldexists('make_speed_train_point',  'name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_point')." ADD `name` varchar(128) NOT NULL   COMMENT '培训点名称';");
 }
}
if(pdo_tableexists('make_speed_train_point')) {
 if(!pdo_fieldexists('make_speed_train_point',  'business_date')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_point')." ADD `business_date` varchar(64) NOT NULL   COMMENT '营业日期';");
 }
}
if(pdo_tableexists('make_speed_train_point')) {
 if(!pdo_fieldexists('make_speed_train_point',  'morn')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_point')." ADD `morn` varchar(64) NOT NULL   COMMENT '上午';");
 }
}
if(pdo_tableexists('make_speed_train_point')) {
 if(!pdo_fieldexists('make_speed_train_point',  'after')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_point')." ADD `after` varchar(64) NOT NULL   COMMENT '下午';");
 }
}
if(pdo_tableexists('make_speed_train_point')) {
 if(!pdo_fieldexists('make_speed_train_point',  'total')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_point')." ADD `total` int(10) NOT NULL   COMMENT '预约人数';");
 }
}
if(pdo_tableexists('make_speed_train_point')) {
 if(!pdo_fieldexists('make_speed_train_point',  'phone')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_point')." ADD `phone` varchar(15) NOT NULL   COMMENT '培训点电话';");
 }
}
if(pdo_tableexists('make_speed_train_point')) {
 if(!pdo_fieldexists('make_speed_train_point',  'address')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_point')." ADD `address` varchar(128) NOT NULL   COMMENT '培训地点';");
 }
}
if(pdo_tableexists('make_speed_train_point')) {
 if(!pdo_fieldexists('make_speed_train_point',  'lat')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_point')." ADD `lat` double(12,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000'  COMMENT '坐标纬度';");
 }
}
if(pdo_tableexists('make_speed_train_point')) {
 if(!pdo_fieldexists('make_speed_train_point',  'lng')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_point')." ADD `lng` double(13,10) NOT NULL DEFAULT NULL DEFAULT '0.0000000000'  COMMENT '坐标经度';");
 }
}
if(pdo_tableexists('make_speed_train_point')) {
 if(!pdo_fieldexists('make_speed_train_point',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_point')." ADD `add_time` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_train_point')) {
 if(!pdo_fieldexists('make_speed_train_point',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_point')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_train_rider')) {
 if(!pdo_fieldexists('make_speed_train_rider',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_rider')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_train_rider')) {
 if(!pdo_fieldexists('make_speed_train_rider',  'rider_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_rider')." ADD `rider_id` int(10) NOT NULL   COMMENT '骑手';");
 }
}
if(pdo_tableexists('make_speed_train_rider')) {
 if(!pdo_fieldexists('make_speed_train_rider',  'train_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_rider')." ADD `train_id` int(10) NOT NULL   COMMENT '培训点';");
 }
}
if(pdo_tableexists('make_speed_train_rider')) {
 if(!pdo_fieldexists('make_speed_train_rider',  'time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_rider')." ADD `time` int(10) NOT NULL   COMMENT '预约培训时间';");
 }
}
if(pdo_tableexists('make_speed_train_rider')) {
 if(!pdo_fieldexists('make_speed_train_rider',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_rider')." ADD `type` tinyint(1) NOT NULL   COMMENT '0上午,1下午';");
 }
}
if(pdo_tableexists('make_speed_train_rider')) {
 if(!pdo_fieldexists('make_speed_train_rider',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_train_rider')." ADD `status` tinyint(1) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'nick_name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `nick_name` varchar(100) NOT NULL   COMMENT '昵称,显示时用';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'real_name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `real_name` varchar(100) NOT NULL   COMMENT '真实姓名';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'mobile')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `mobile` char(20) NOT NULL   COMMENT '手机';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'sex')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `sex` tinyint(3) NOT NULL   COMMENT '性别: 0女,1男';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'qq')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `qq` varchar(20) NOT NULL   COMMENT 'QQ';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'email')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `email` varchar(32) NOT NULL   COMMENT '邮箱';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'avatar')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `avatar` varchar(255) NOT NULL   COMMENT '头像';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'open_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `open_id` varchar(128) NOT NULL   COMMENT '用户openid';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `status` tinyint(1) NOT NULL   COMMENT '状态：0正常';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'user_grade')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `user_grade` tinyint(3) NOT NULL   COMMENT '用户等级(0:用户,1:会员,2:项目合伙人)';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'recommend_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `recommend_id` int(11) NOT NULL   COMMENT '推荐用户id';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'recommend_rider')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `recommend_rider` int(11) NOT NULL   COMMENT '推荐骑手ID';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'invalid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `invalid` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '不可用余额';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'valid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `valid` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '可用余额';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'grow')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `grow` int(10) NOT NULL   COMMENT '用户成长值';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'gral')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `gral` int(10) NOT NULL   COMMENT '积分';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `add_time` int(10) NOT NULL   COMMENT '注册或添加时间';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `update_time` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'logged_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `logged_time` int(10) NOT NULL   COMMENT '最近一次登录时间';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'logged_ip')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `logged_ip` varchar(128) NOT NULL   COMMENT '最近一次登录IP';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'is_disabled')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `is_disabled` tinyint(3) NOT NULL   COMMENT '是否禁用';");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_user')) {
 if(!pdo_fieldexists('make_speed_user',  'blacklist')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user')." ADD `blacklist` tinyint(1) NOT NULL   COMMENT '黑名单';");
 }
}
if(pdo_tableexists('make_speed_user_cashlog')) {
 if(!pdo_fieldexists('make_speed_user_cashlog',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_cashlog')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_user_cashlog')) {
 if(!pdo_fieldexists('make_speed_user_cashlog',  'title')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_cashlog')." ADD `title` varchar(128) NOT NULL   COMMENT '说明';");
 }
}
if(pdo_tableexists('make_speed_user_cashlog')) {
 if(!pdo_fieldexists('make_speed_user_cashlog',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_cashlog')." ADD `user_id` int(10) NOT NULL   COMMENT '用户';");
 }
}
if(pdo_tableexists('make_speed_user_cashlog')) {
 if(!pdo_fieldexists('make_speed_user_cashlog',  'business_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_cashlog')." ADD `business_id` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_user_cashlog')) {
 if(!pdo_fieldexists('make_speed_user_cashlog',  'object_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_cashlog')." ADD `object_id` int(10) NOT NULL   COMMENT '项目ID';");
 }
}
if(pdo_tableexists('make_speed_user_cashlog')) {
 if(!pdo_fieldexists('make_speed_user_cashlog',  'order_code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_cashlog')." ADD `order_code` varchar(32) NOT NULL   COMMENT '业务订单号';");
 }
}
if(pdo_tableexists('make_speed_user_cashlog')) {
 if(!pdo_fieldexists('make_speed_user_cashlog',  'amount')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_cashlog')." ADD `amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '金额';");
 }
}
if(pdo_tableexists('make_speed_user_cashlog')) {
 if(!pdo_fieldexists('make_speed_user_cashlog',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_cashlog')." ADD `type` tinyint(3) NOT NULL   COMMENT '财务类型(0消费记录,1充值记录,2退款)';");
 }
}
if(pdo_tableexists('make_speed_user_cashlog')) {
 if(!pdo_fieldexists('make_speed_user_cashlog',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_cashlog')." ADD `status` tinyint(1) NOT NULL   COMMENT '状态(0异常,1正常)';");
 }
}
if(pdo_tableexists('make_speed_user_cashlog')) {
 if(!pdo_fieldexists('make_speed_user_cashlog',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_cashlog')." ADD `add_time` int(10) NOT NULL   COMMENT '创建时间';");
 }
}
if(pdo_tableexists('make_speed_user_cashlog')) {
 if(!pdo_fieldexists('make_speed_user_cashlog',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_cashlog')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'order_type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `order_type` tinyint(3) NOT NULL   COMMENT '可用业务订单类型';");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `type` varchar(32) NOT NULL   COMMENT '来源';");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `user_id` int(10) NOT NULL   COMMENT '用户ID';");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'tips')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `tips` varchar(64) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'amount')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '优惠金额';");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'full_amount')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `full_amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '多少满减';");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'limit_distance')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `limit_distance` float(8,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '使用距离';");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'coupon_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `coupon_id` int(10) NOT NULL   COMMENT '优惠券ID';");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `status` tinyint(1) NOT NULL   COMMENT '使用状态';");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'begin_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `begin_time` int(10) NOT NULL   COMMENT '开始时间';");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'expire_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `expire_time` int(10) NOT NULL   COMMENT '到期时间';");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_user_coupons')) {
 if(!pdo_fieldexists('make_speed_user_coupons',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_coupons')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_user_grade')) {
 if(!pdo_fieldexists('make_speed_user_grade',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_grade')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_user_grade')) {
 if(!pdo_fieldexists('make_speed_user_grade',  'grade')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_grade')." ADD `grade` int(10) NOT NULL   COMMENT '会员等级';");
 }
}
if(pdo_tableexists('make_speed_user_grade')) {
 if(!pdo_fieldexists('make_speed_user_grade',  'name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_grade')." ADD `name` varchar(64) NOT NULL   COMMENT '等级名称';");
 }
}
if(pdo_tableexists('make_speed_user_grade')) {
 if(!pdo_fieldexists('make_speed_user_grade',  'grow')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_grade')." ADD `grow` int(10) NOT NULL   COMMENT '满足成长值';");
 }
}
if(pdo_tableexists('make_speed_user_grade')) {
 if(!pdo_fieldexists('make_speed_user_grade',  'discount')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_grade')." ADD `discount` decimal(6,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '折扣额度';");
 }
}
if(pdo_tableexists('make_speed_user_grade')) {
 if(!pdo_fieldexists('make_speed_user_grade',  'icon')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_grade')." ADD `icon` varchar(128) NOT NULL   COMMENT '会员图标';");
 }
}
if(pdo_tableexists('make_speed_user_grade')) {
 if(!pdo_fieldexists('make_speed_user_grade',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_grade')." ADD `add_time` int(10) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_user_grade')) {
 if(!pdo_fieldexists('make_speed_user_grade',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_grade')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `user_id` int(11) NOT NULL   COMMENT '申请用户';");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'mobile')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `mobile` varchar(15) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'email')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `email` varchar(64) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'content')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `content` varchar(164) NOT NULL   COMMENT '发票内容';");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'amount')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `amount` decimal(10,2) NOT NULL DEFAULT NULL DEFAULT '0.00'  COMMENT '发票金额';");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `type` tinyint(3) NOT NULL   COMMENT '0个人1公司';");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'type_name')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `type_name` varchar(64) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'tax_number')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `tax_number` varchar(64) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `code` varchar(32) NOT NULL   COMMENT '发票代码';");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'number')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `number` varchar(32) NOT NULL   COMMENT '发票号码';");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'date')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `date` varchar(32) NOT NULL   COMMENT '开票日期';");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'check_code')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `check_code` varchar(32) NOT NULL   COMMENT '校验码';");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'img')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `img` varchar(164) NOT NULL   COMMENT '发票图片';");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `status` tinyint(3) NOT NULL   COMMENT '状态0待审核';");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `add_time` int(10) NOT NULL   COMMENT '申请时间';");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `update_time` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_user_invoice')) {
 if(!pdo_fieldexists('make_speed_user_invoice',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_invoice')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_user_message')) {
 if(!pdo_fieldexists('make_speed_user_message',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_message')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_user_message')) {
 if(!pdo_fieldexists('make_speed_user_message',  'type')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_message')." ADD `type` tinyint(1) NOT NULL   COMMENT '消息类型(0系统通知,1用户操作通知)';");
 }
}
if(pdo_tableexists('make_speed_user_message')) {
 if(!pdo_fieldexists('make_speed_user_message',  'user_id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_message')." ADD `user_id` int(10) NOT NULL   COMMENT '通知用户';");
 }
}
if(pdo_tableexists('make_speed_user_message')) {
 if(!pdo_fieldexists('make_speed_user_message',  'title')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_message')." ADD `title` varchar(128) NOT NULL   COMMENT '标题';");
 }
}
if(pdo_tableexists('make_speed_user_message')) {
 if(!pdo_fieldexists('make_speed_user_message',  'summary')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_message')." ADD `summary` varchar(254) NOT NULL   COMMENT '摘要';");
 }
}
if(pdo_tableexists('make_speed_user_message')) {
 if(!pdo_fieldexists('make_speed_user_message',  'img')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_message')." ADD `img` varchar(128) NOT NULL   COMMENT '缩略图';");
 }
}
if(pdo_tableexists('make_speed_user_message')) {
 if(!pdo_fieldexists('make_speed_user_message',  'content')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_message')." ADD `content` text()    COMMENT '通知内容';");
 }
}
if(pdo_tableexists('make_speed_user_message')) {
 if(!pdo_fieldexists('make_speed_user_message',  'is_read')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_message')." ADD `is_read` enum('0','1') NOT NULL   COMMENT '是否已读';");
 }
}
if(pdo_tableexists('make_speed_user_message')) {
 if(!pdo_fieldexists('make_speed_user_message',  'add_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_message')." ADD `add_time` int(10) NOT NULL   COMMENT '通知时间';");
 }
}
if(pdo_tableexists('make_speed_user_message')) {
 if(!pdo_fieldexists('make_speed_user_message',  'top')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_message')." ADD `top` tinyint(3) NOT NULL   COMMENT '是否制定';");
 }
}
if(pdo_tableexists('make_speed_user_message')) {
 if(!pdo_fieldexists('make_speed_user_message',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_user_message')." ADD `uniacid` int(10) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_version')) {
 if(!pdo_fieldexists('make_speed_version',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_version')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT COMMENT 'ID';");
 }
}
if(pdo_tableexists('make_speed_version')) {
 if(!pdo_fieldexists('make_speed_version',  'oldversion')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_version')." ADD `oldversion` varchar(30) NOT NULL   COMMENT '旧版本号';");
 }
}
if(pdo_tableexists('make_speed_version')) {
 if(!pdo_fieldexists('make_speed_version',  'newversion')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_version')." ADD `newversion` varchar(30) NOT NULL   COMMENT '新版本号';");
 }
}
if(pdo_tableexists('make_speed_version')) {
 if(!pdo_fieldexists('make_speed_version',  'packagesize')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_version')." ADD `packagesize` varchar(30) NOT NULL   COMMENT '包大小';");
 }
}
if(pdo_tableexists('make_speed_version')) {
 if(!pdo_fieldexists('make_speed_version',  'content')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_version')." ADD `content` varchar(500) NOT NULL   COMMENT '升级内容';");
 }
}
if(pdo_tableexists('make_speed_version')) {
 if(!pdo_fieldexists('make_speed_version',  'downloadurl')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_version')." ADD `downloadurl` varchar(255) NOT NULL   COMMENT '下载地址';");
 }
}
if(pdo_tableexists('make_speed_version')) {
 if(!pdo_fieldexists('make_speed_version',  'enforce')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_version')." ADD `enforce` tinyint(1) NOT NULL   COMMENT '强制更新';");
 }
}
if(pdo_tableexists('make_speed_version')) {
 if(!pdo_fieldexists('make_speed_version',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_version')." ADD `createtime` int(10) NOT NULL   COMMENT '创建时间';");
 }
}
if(pdo_tableexists('make_speed_version')) {
 if(!pdo_fieldexists('make_speed_version',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_version')." ADD `updatetime` int(10) NOT NULL   COMMENT '更新时间';");
 }
}
if(pdo_tableexists('make_speed_version')) {
 if(!pdo_fieldexists('make_speed_version',  'weigh')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_version')." ADD `weigh` int(10) NOT NULL   COMMENT '权重';");
 }
}
if(pdo_tableexists('make_speed_version')) {
 if(!pdo_fieldexists('make_speed_version',  'status')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_version')." ADD `status` varchar(30) NOT NULL   COMMENT '状态';");
 }
}
if(pdo_tableexists('make_speed_version')) {
 if(!pdo_fieldexists('make_speed_version',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_version')." ADD `uniacid` int(10) NOT NULL   COMMENT 'uniacid';");
 }
}
if(pdo_tableexists('make_speed_virtual_rider')) {
 if(!pdo_fieldexists('make_speed_virtual_rider',  'id')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_virtual_rider')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('make_speed_virtual_rider')) {
 if(!pdo_fieldexists('make_speed_virtual_rider',  'lat')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_virtual_rider')." ADD `lat` double(10,6) NOT NULL   COMMENT '经度';");
 }
}
if(pdo_tableexists('make_speed_virtual_rider')) {
 if(!pdo_fieldexists('make_speed_virtual_rider',  'lng')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_virtual_rider')." ADD `lng` double(10,6) NOT NULL   COMMENT '维度';");
 }
}
if(pdo_tableexists('make_speed_virtual_rider')) {
 if(!pdo_fieldexists('make_speed_virtual_rider',  'address')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_virtual_rider')." ADD `address` varchar(100) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_virtual_rider')) {
 if(!pdo_fieldexists('make_speed_virtual_rider',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_virtual_rider')." ADD `uniacid` int(11) NOT NULL;");
 }
}
if(pdo_tableexists('make_speed_virtual_rider')) {
 if(!pdo_fieldexists('make_speed_virtual_rider',  'is_show')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_virtual_rider')." ADD `is_show` enum('0','1') NOT NULL DEFAULT NULL DEFAULT '1'  COMMENT '是否显示:0=隐藏,1=显示';");
 }
}
if(pdo_tableexists('make_speed_virtual_rider')) {
 if(!pdo_fieldexists('make_speed_virtual_rider',  'create_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_virtual_rider')." ADD `create_time` int(11) NOT NULL   COMMENT '添加时间';");
 }
}
if(pdo_tableexists('make_speed_virtual_rider')) {
 if(!pdo_fieldexists('make_speed_virtual_rider',  'update_time')) {
  pdo_query("ALTER TABLE ".tablename('make_speed_virtual_rider')." ADD `update_time` int(11) NOT NULL   COMMENT '更新时间';");
 }
}
