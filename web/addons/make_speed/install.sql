DROP TABLE IF EXISTS `ims_make_speed_cancel_order`;
CREATE TABLE `ims_make_speed_cancel_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL,
  `rider_id` int(10) NOT NULL,
  `cancel_time` int(10) NOT NULL,
  `accept_time` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ids` (`order_id`,`rider_id`,`cancel_time`,`uniacid`,`city_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `ims_make_speed_distribution_distributor`;
CREATE TABLE `ims_make_speed_distribution_distributor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  `gid` int(10) NOT NULL,
  `invite_code` char(8) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '姓名',
  `phone` char(11) NOT NULL COMMENT '手机号',
  `commission` decimal(10,2) NOT NULL COMMENT '佣金',
  `pay_commission` decimal(10,2) NOT NULL COMMENT '已提现佣金',
  `count_commission` decimal(10,2) NOT NULL COMMENT '累计佣金',
  `status` tinyint(1) NOT NULL COMMENT '状态:0=待审核,1=正常,2=失败',
  `create_time` int(10) NOT NULL COMMENT '添加时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `uniacid` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `is_distributor` tinyint(10) NOT NULL COMMENT '是否分销商:0=false,1=true',
  PRIMARY KEY (`id`),
  KEY `index` (`pid`,`status`,`uniacid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ims_make_speed_distribution_grade
-- ----------------------------
DROP TABLE IF EXISTS `ims_make_speed_distribution_grade`;
CREATE TABLE `ims_make_speed_distribution_grade` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '等级名称',
  `first_commission` int(10) NOT NULL COMMENT '一级佣金',
  `second_commission` int(10) NOT NULL COMMENT '二级佣金',
  `three_commission` int(10) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL COMMENT '分销订单总额',
  `total_order` int(10) NOT NULL COMMENT '分销订单总数',
  `number_people` int(10) NOT NULL COMMENT '分销人数',
  `rank` int(10) NOT NULL COMMENT '等级',
  `auto_level` tinyint(1) NOT NULL COMMENT '是否自动升级:0=否,1=是',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `grade` (`rank`) USING BTREE,
  KEY `s` (`first_commission`,`second_commission`,`rank`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for ims_make_speed_distribution_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_make_speed_distribution_order`;
CREATE TABLE `ims_make_speed_distribution_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号',
  `pay_user_id` int(10) NOT NULL COMMENT '下单用户',
  `price` decimal(10,2) NOT NULL COMMENT '支付价格',
  `platform_price` decimal(10,2) NOT NULL COMMENT '平台获取抽成',
  `commission` decimal(10,2) NOT NULL COMMENT '获得佣金',
  `level` tinyint(10) NOT NULL COMMENT '获佣级别',
  `order_id` int(10) NOT NULL COMMENT '订单id',
  `user_id` int(10) NOT NULL COMMENT '获佣分销商id',
  `status` tinyint(1) NOT NULL COMMENT '状态：0=待付款,1=待分佣,2=已分佣,3=已取消',
  `uniacid` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `create_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `dis` (`pay_user_id`,`order_id`,`user_id`,`status`,`uniacid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for ims_make_speed_distribution_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `ims_make_speed_distribution_withdraw`;
CREATE TABLE `ims_make_speed_distribution_withdraw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_num` varchar(50) NOT NULL,
  `user_id` int(10) NOT NULL COMMENT '分销商',
  `did` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL COMMENT '提现金额',
  `server_charge` decimal(10,2) NOT NULL COMMENT '手续费',
  `status` tinyint(1) NOT NULL COMMENT '状态:0=待审核,1=待打款,2=已打款',
  `type` tinyint(1) NOT NULL COMMENT '提现方式:1=微信,2=支付宝，3=银行卡',
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `bank`  varchar(50) NOT NULL,
  `account` varchar(30) NOT NULL COMMENT '账号',
  `create_time` int(10) NOT NULL COMMENT '申请时间',
  `update_time` int(10) NOT NULL COMMENT '打款时间',
  `uniacid` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `open_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_virtual_rider`;
CREATE TABLE `ims_make_speed_virtual_rider` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lat` double(10,6) NOT NULL COMMENT '经度',
  `lng` double(10,6) NOT NULL COMMENT '维度',
  `address` varchar(100) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `is_show` enum('0','1') NOT NULL DEFAULT '1' COMMENT '是否显示:0=隐藏,1=显示',
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='虚拟司机';


DROP TABLE IF EXISTS `ims_make_speed_admin`;
CREATE TABLE `ims_make_speed_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `realname` varchar(64) NOT NULL DEFAULT '',
  `mobile` varchar(15) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(30) NOT NULL DEFAULT '' COMMENT '密码盐',
  `avatar` varchar(100) NOT NULL DEFAULT '' COMMENT '头像',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `loginfailure` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '失败次数',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `token` varchar(59) NOT NULL DEFAULT '' COMMENT 'Session标识',
  `status` varchar(30) NOT NULL DEFAULT 'normal' COMMENT '状态',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'uniacid',
  `city_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  KEY `uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员表';

DROP TABLE IF EXISTS `ims_make_speed_admin_log`;
CREATE TABLE `ims_make_speed_admin_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员名字',
  `url` varchar(1500) NOT NULL DEFAULT '' COMMENT '操作页面',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '日志标题',
  `content` text NOT NULL COMMENT '内容',
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT 'IP',
  `useragent` varchar(255) NOT NULL DEFAULT '' COMMENT 'User-Agent',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作时间',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'uniacid',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `name` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=358 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员日志表';

DROP TABLE IF EXISTS `ims_make_speed_agreement`;
CREATE TABLE `ims_make_speed_agreement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '协议类别(0用户端,1骑手端)',
  `position` varchar(64) NOT NULL DEFAULT '' COMMENT '所在版块',
  `content` text COMMENT '协议内容',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_attachment`;
CREATE TABLE `ims_make_speed_attachment` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '物理路径',
  `imagewidth` varchar(30) NOT NULL DEFAULT '' COMMENT '宽度',
  `imageheight` varchar(30) NOT NULL DEFAULT '' COMMENT '高度',
  `imagetype` varchar(30) NOT NULL DEFAULT '' COMMENT '图片类型',
  `imageframes` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '图片帧数',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `mimetype` varchar(100) NOT NULL DEFAULT '' COMMENT 'mime类型',
  `extparam` varchar(255) NOT NULL DEFAULT '' COMMENT '透传数据',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建日期',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uploadtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `storage` varchar(100) NOT NULL DEFAULT 'local' COMMENT '存储位置',
  `sha1` varchar(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'uniacid',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='附件表';

DROP TABLE IF EXISTS `ims_make_speed_auth_group`;
CREATE TABLE `ims_make_speed_auth_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父组别',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名',
  `rules` text NOT NULL COMMENT '规则ID',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` varchar(30) NOT NULL DEFAULT '' COMMENT '状态',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'uniacid',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='分组表';

DROP TABLE IF EXISTS `ims_make_speed_auth_group_access`;
CREATE TABLE `ims_make_speed_auth_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '会员ID',
  `group_id` int(10) unsigned NOT NULL COMMENT '级别ID',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='权限分组表';

DROP TABLE IF EXISTS `ims_make_speed_auth_rule`;
CREATE TABLE `ims_make_speed_auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('menu','file') NOT NULL DEFAULT 'file' COMMENT 'menu为菜单,file为权限节点',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则名称',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '规则名称',
  `icon` varchar(50) NOT NULL DEFAULT '' COMMENT '图标',
  `condition` varchar(255) NOT NULL DEFAULT '' COMMENT '条件',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为菜单',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` varchar(30) NOT NULL DEFAULT '' COMMENT '状态',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'uniacid',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `pid` (`pid`),
  KEY `weigh` (`weigh`),
  KEY `uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='节点表';

DROP TABLE IF EXISTS `ims_make_speed_banner`;
CREATE TABLE `ims_make_speed_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(128) NOT NULL DEFAULT '',
  `path` varchar(64) NOT NULL DEFAULT '',
  `disabled` tinyint(3) NOT NULL DEFAULT '0',
  `add_time` int(10) NOT NULL DEFAULT '0',
  `uniacid` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_city`;
CREATE TABLE `ims_make_speed_city` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '城市名称',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `key` varchar(10) NOT NULL DEFAULT '' COMMENT '首字母',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否热门',
  `is_disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0启用,1禁用',
  `list_order` int(10) NOT NULL DEFAULT '0' COMMENT '列表顺序',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_command`;
CREATE TABLE `ims_make_speed_command` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型',
  `params` varchar(1500) NOT NULL DEFAULT '' COMMENT '参数',
  `command` varchar(1500) NOT NULL DEFAULT '' COMMENT '命令',
  `content` text COMMENT '返回结果',
  `executetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行时间',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` enum('successed','failured') NOT NULL DEFAULT 'failured' COMMENT '状态',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='在线命令表';

DROP TABLE IF EXISTS `ims_make_speed_config`;
CREATE TABLE `ims_make_speed_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '变量名',
  `group` varchar(30) NOT NULL DEFAULT '' COMMENT '分组',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '变量标题',
  `tip` varchar(100) NOT NULL DEFAULT '' COMMENT '变量描述',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型:string,text,int,bool,array,datetime,date,file',
  `value` text NOT NULL COMMENT '变量值',
  `content` text NOT NULL COMMENT '变量字典数据',
  `rule` varchar(100) NOT NULL DEFAULT '' COMMENT '验证规则',
  `extend` varchar(255) NOT NULL DEFAULT '' COMMENT '扩展属性',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'uniacid',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `uniacid` (`uniacid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='系统配置';

DROP TABLE IF EXISTS `ims_make_speed_coupon_activity`;
CREATE TABLE `ims_make_speed_coupon_activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '活动名',
  `coupon_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券',
  `type` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动类型(0新人首次进入,1支付下单,2邀请好友)',
  `total_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '满足数量',
  `begin_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `is_disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_coupons`;
CREATE TABLE `ims_make_speed_coupons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '标题',
  `code` varchar(30) NOT NULL DEFAULT '' COMMENT '兑换码',
  `code_num` int(10) NOT NULL DEFAULT '0',
  `money` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
  `satisfy_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '满多少可用',
  `day` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用期限天数(0为不限制)',
  `distance` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '距离内可使用(0不限制)',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `total` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '满足获得的数量',
  `gral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券积分价格',
  `img` varchar(128) NOT NULL DEFAULT '' COMMENT '优惠券图片',
  `description` varchar(225) NOT NULL DEFAULT '' COMMENT '使用规则',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券状态',
  `begin_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_equip`;
CREATE TABLE `ims_make_speed_equip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '装备标题',
  `img` varchar(128) NOT NULL DEFAULT '' COMMENT '装备图片',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '装备价格',
  `detail` text COMMENT '装备详情',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '装备上架状态',
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_equip_order`;
CREATE TABLE `ims_make_speed_equip_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_code` varchar(32) NOT NULL DEFAULT '' COMMENT '订单号',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `rider_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '骑手ID',
  `equip_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '装备ID',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0)',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_make_speed_goods_type`;
CREATE TABLE `ims_make_speed_goods_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '业务类型',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '类型名称',
  `icon` varchar(128) NOT NULL DEFAULT '' COMMENT '类型图标',
  `iconed` varchar(128) NOT NULL DEFAULT '',
  `weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_handbook`;
CREATE TABLE `ims_make_speed_handbook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '(0骑手端,1用户端)',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '手册标题',
  `icon` varchar(128) NOT NULL DEFAULT '' COMMENT '标题图标',
  `content` text COMMENT '内容',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_order`;
CREATE TABLE `ims_make_speed_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单类型0=跑腿,1=帮买,2=万能服务,3=代驾',
  `order_code` varchar(32) NOT NULL DEFAULT '' COMMENT '订单号',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下单用户',
  `business_id` int(11) unsigned NOT NULL DEFAULT '0',
  `clouds_id` int(11) unsigned NOT NULL DEFAULT '0',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '物品类型ID',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '订单联系电话',
  `goodsname` varchar(128) NOT NULL DEFAULT '' COMMENT '物品类型',
  `get_time` varchar(64) NOT NULL DEFAULT '' COMMENT '取件时间',
  `coupon_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券',
  `small_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '小费金额',
  `distance` float(6,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单距离',
  `weight` float(6,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '重量',
  `distance_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '里程费',
  `weight_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '续重费',
  `night_price` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '夜间费用',
  `change_price` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '溢价费用',
  `discount_price` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '会员折扣',
  `total_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单总额',
  `pay_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实际支付',
  `floor_price` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '楼层费用',
  `budget_price` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '预计价',
  `is_discuss` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否接受议价',
  `img` varchar(600) NOT NULL DEFAULT '' COMMENT '下单图片',
  `audio` varchar(128) NOT NULL DEFAULT '',
  `order_time` varchar(32) NOT NULL DEFAULT '' COMMENT '订单时时间',
  `distance_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '路程时间',
  `expect_time` varchar(32) NOT NULL DEFAULT '' COMMENT '预计取件/服务时间',
  `expect_timeed` varchar(32) NOT NULL DEFAULT '' COMMENT '预计送达/完成时间',
  `description` varchar(255) DEFAULT '' COMMENT '备注/描述',
  `payment` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '支付类型(1余额,2微信支付)',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态(0待支付,1已取消,2已支付待接单,3已接单待取件,4送货中，5待评价 6待评价)',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `role` varchar(20) NOT NULL DEFAULT '',
  `city_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '城市',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `car_id` int(10) NOT NULL,
  `car_name` varchar(20) NOT NULL COMMENT '车辆名称',
  `start_price` decimal(10,2) NOT NULL COMMENT '起步价格',
  `start_km` double(6,2) NOT NULL,
  `charg_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '代驾收费类型1=距离,2-实时',
  `expire_time` int(10) NOT NULL,
  `load_switch` tinyint(1) NOT NULL COMMENT '是否需要装卸',
  `car_type` tinyint(1) NOT NULL COMMENT '半车整车',
  `load_price` decimal(10,2) NOT NULL COMMENT '装修',
  `total_car` decimal(10,2) NOT NULL COMMENT '整车费',
  `category_id` int(10) NOT NULL,
  `cube`   float(10,2) NOT NULL,
  `cube_price`  decimal(10,2) NOT NULL,
  `snap_item` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_code` (`order_code`),
  KEY `uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=1111 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_order_address`;
CREATE TABLE `ims_make_speed_order_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属订单ID',
  `begin_address` varchar(128) NOT NULL DEFAULT '' COMMENT '寄件地址',
  `begin_detail` varchar(128) NOT NULL DEFAULT '' COMMENT '详情地址: 街道/门牌',
  `begin_lat` double(11,9) NOT NULL DEFAULT '0.000000000' COMMENT '寄件纬度',
  `begin_lng` double(13,10) NOT NULL DEFAULT '0.0000000000' COMMENT '寄件经度',
  `begin_username` varchar(64) NOT NULL DEFAULT '' COMMENT '寄件人姓名',
  `begin_phone` varchar(12) NOT NULL DEFAULT '' COMMENT '寄件人电话',
  `end_address` varchar(128) NOT NULL DEFAULT '' COMMENT '收件地址',
  `end_detail` varchar(128) NOT NULL DEFAULT '' COMMENT '详情地址: 街道/门牌',
  `end_lat` double(12,10) NOT NULL DEFAULT '0.0000000000' COMMENT '寄件纬度',
  `end_lng` double(13,10) NOT NULL DEFAULT '0.0000000000' COMMENT '收件经度',
  `end_username` varchar(64) NOT NULL DEFAULT '' COMMENT '收件人姓名',
  `end_phone` varchar(64) NOT NULL DEFAULT '' COMMENT '收件电话',
  `end_floor` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '所在楼层',
  `extension_number`  varchar(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_order_pickcode`;
CREATE TABLE `ims_make_speed_order_pickcode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `pick_code` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '取件码',
  `end_code` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收件码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_make_speed_order_rider`;
CREATE TABLE `ims_make_speed_order_rider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `rider_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '骑手ID',
  `rider_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '骑手佣金',
  `score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评分',
  `tag` varchar(64) NOT NULL DEFAULT '' COMMENT '标签',
  `rider_distance` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '骑手路程',
  `pick_img` varchar(1000) NOT NULL DEFAULT '' COMMENT '取件照片',
  `end_img`  varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `total_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单花费时间(单位:秒)',
  `accept_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '接单时间',
  `get_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '揽件时间',
  `goto_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '送达时间',
  `complete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '完成时间(评价时间)',
  `goto_msec_time`  char(13) NOT NULL ,
  `get_msec_time`    char(13) NOT NULL ,
  `trid`  varchar(20) NOT NULL COMMENT '轨迹ID' ,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_rider`;
CREATE TABLE `ims_make_speed_rider` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `invite_code` varchar(20) NOT NULL DEFAULT '' COMMENT '邀请码',
  `nick_name` varchar(100) NOT NULL DEFAULT '' COMMENT '昵称,显示时用',
  `real_name` varchar(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `sex` tinyint(3) NOT NULL DEFAULT '0' COMMENT '性别: 0女,1男',
  `age` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `height` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '身高',
  `weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '体重',
  `education` varchar(32) NOT NULL DEFAULT '' COMMENT '学历',
  `occup` varchar(32) DEFAULT '' COMMENT '职业',
  `address` varchar(128) NOT NULL DEFAULT '' COMMENT '住址',
  `nervous_person` varchar(32) NOT NULL DEFAULT '' COMMENT '紧急联系人',
  `nervous_phone` varchar(20) NOT NULL DEFAULT '' COMMENT '紧急联系电话',
  `open_id` varchar(128) NOT NULL DEFAULT '' COMMENT '用户openid',
  `user_grade` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户成长值',
  `invalid_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '不可用余额',
  `valid_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '可用余额',
  `bond_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '保证金',
  `madou` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '码豆',
  `recommend_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人ID',
  `recommend_code` varchar(16) NOT NULL DEFAULT '' COMMENT '个人推荐码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册或添加时间',
  `logged_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最近一次登录时间',
  `logged_ip` varchar(128) NOT NULL DEFAULT '' COMMENT '最近一次登录IP',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `city_id` int(10) unsigned NOT NULL DEFAULT '0',
  `accept_order_num` int(10) unsigned NOT NULL DEFAULT '0',
  `app_client_id` varchar(128) NOT NULL DEFAULT '' COMMENT '客户端id',

  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_rider_bind`;
CREATE TABLE `ims_make_speed_rider_bind` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rider_id` int(10) unsigned NOT NULL DEFAULT '0',
  `real_name` varchar(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `card_code` varchar(20) NOT NULL DEFAULT '' COMMENT '身份证号',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `address` varchar(128) NOT NULL DEFAULT '' COMMENT '户籍所在地',
  `card1_img` varchar(100) NOT NULL DEFAULT '' COMMENT '身份证图片',
  `card2_img` varchar(100) NOT NULL DEFAULT '' COMMENT '身份证背面照',
  `card3_img` varchar(100) NOT NULL DEFAULT '' COMMENT '手持身份证照',
  `card4_img` varchar(100) NOT NULL DEFAULT '' COMMENT '个人自拍照',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态(0待审核,1未通过,2已通过)',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `remark` varchar(20)  NOT NULL,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_rider_brokerage`;
CREATE TABLE `ims_make_speed_rider_brokerage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `account` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '(0骑手,1用户)',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `object_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `recommend_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人ID',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '获得佣金',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '奖励推荐类型',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0:待分成,1已取消,2以分成)',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_rider_cashlog`;
CREATE TABLE `ims_make_speed_rider_cashlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '说明',
  `rider_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户',
  `object_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '项目ID',
  `order_code` varchar(32) NOT NULL DEFAULT '' COMMENT '业务订单号',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '财务类型(0消费记录,1充值记录,2退款)',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0异常,1以划款,2已到账)',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_rider_formid`;
CREATE TABLE `ims_make_speed_rider_formid` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rider_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '骑手id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `open_id` varchar(32) NOT NULL DEFAULT '' COMMENT '骑手openid',
  `form_id` varchar(32) NOT NULL DEFAULT '' COMMENT '服务通知formid',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `open_id` (`open_id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_rider_info`;
CREATE TABLE `ims_make_speed_rider_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rider_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '骑手ID',
  `score` float(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '评分',
  `service_total` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '服务总次数',
  `distance_total` float(12,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '累计行程',
  `income_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '累计收入',
  `lat` double(8,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '骑手坐标纬度',
  `lng` double(9,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '骑手坐标经度',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '接单地址',
  `is_accept` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否接单(0接单,1不接单)',
  `cancel_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已接单数量',
  `accept_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '接单类型(0全接,1实时单,2预约单)',
  `order_type`  varchar(10) NOT NULL DEFAULT '0' COMMENT '接单类型:0=跑腿,1=帮买,2=万能服务,3=代驾,5=货运,6=家政',
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rider_id` (`rider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_make_speed_rider_message`;
CREATE TABLE `ims_make_speed_rider_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '通知类型(0系统通知,1处罚公告,2订单通知)',
  `rider_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '通知骑手',
  `title` varchar(225) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text COMMENT '消息详情',
  `object_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属项目',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已读：0否；1是',
  `all` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '下发所有骑手',
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `role_uid` (`rider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站内信数据表';

DROP TABLE IF EXISTS `ims_make_speed_rider_sanction`;
CREATE TABLE `ims_make_speed_rider_sanction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rider_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '奖惩骑手',
  `type` enum('0','1') NOT NULL DEFAULT '0' COMMENT '类型(0惩罚,1奖励)',
  `class` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '奖惩内容(0余额,1通知警告,2禁止接单,3冻结账户余额)',
  `metric` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '奖惩度量(元|小时)',
  `reason` varchar(225) NOT NULL DEFAULT '' COMMENT '奖惩原因说明',
  `appeal` varchar(225) NOT NULL DEFAULT '' COMMENT '申诉内容',
  `begin_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0进行中1申诉2申诉成功)',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `notify` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否通知骑手',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rider_id` (`rider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_rider_withdraw`;
CREATE TABLE `ims_make_speed_rider_withdraw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '转账类型',
  `rider_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '骑手ID',
  `trade_code` varchar(32) NOT NULL DEFAULT '' COMMENT '流水订单号',
  `money` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `open_id` varchar(64) NOT NULL DEFAULT '' COMMENT '到账账户open_id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0待通过,1不通过,2已通过并打款)',
  `description` varchar(128) NOT NULL DEFAULT '' COMMENT '企业付款备注',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `received_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现到账时间',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_setting`;
CREATE TABLE `ims_make_speed_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL DEFAULT '' COMMENT '配置键名',
  `value` text COMMENT '配置值',
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `city_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '城市ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_train_point`;
CREATE TABLE `ims_make_speed_train_point` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '城市ID',
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '培训点名称',
  `business_date` varchar(64) NOT NULL DEFAULT '' COMMENT '营业日期',
  `morn` varchar(64) NOT NULL DEFAULT '' COMMENT '上午',
  `after` varchar(64) NOT NULL DEFAULT '' COMMENT '下午',
  `total` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预约人数',
  `phone` varchar(15) NOT NULL DEFAULT '' COMMENT '培训点电话',
  `address` varchar(128) NOT NULL DEFAULT '' COMMENT '培训地点',
  `lat` double(12,10) unsigned NOT NULL DEFAULT '0.0000000000' COMMENT '坐标纬度',
  `lng` double(13,10) unsigned NOT NULL DEFAULT '0.0000000000' COMMENT '坐标经度',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='培训点列表';

DROP TABLE IF EXISTS `ims_make_speed_train_rider`;
CREATE TABLE `ims_make_speed_train_rider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rider_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '骑手',
  `train_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '培训点',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预约培训时间',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0上午,1下午',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_user`;
CREATE TABLE `ims_make_speed_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nick_name` varchar(100) NOT NULL DEFAULT '' COMMENT '昵称,显示时用',
  `real_name` varchar(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `mobile` char(20) NOT NULL DEFAULT '0' COMMENT '手机',
  `sex` tinyint(3) NOT NULL DEFAULT '0' COMMENT '性别: 0女,1男',
  `qq` varchar(20) NOT NULL DEFAULT '' COMMENT 'QQ',
  `email` varchar(32) NOT NULL DEFAULT '' COMMENT '邮箱',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `open_id` varchar(128) NOT NULL DEFAULT '' COMMENT '用户openid',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0正常',
  `blacklist` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '黑名单',
  `user_grade` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户等级(0:用户,1:会员,2:项目合伙人)',
  `recommend_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '推荐用户id',
  `recommend_rider` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '推荐骑手ID',
  `invalid` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '不可用余额',
  `valid` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '可用余额',
  `grow` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户成长值',
  `gral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册或添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `logged_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最近一次登录时间',
  `logged_ip` varchar(128) NOT NULL DEFAULT '' COMMENT '最近一次登录IP',
  `is_disabled` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否禁用',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_user_cashlog`;
CREATE TABLE `ims_make_speed_user_cashlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '说明',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户',
  `business_id` int(11) unsigned NOT NULL DEFAULT '0',
  `object_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '项目ID',
  `order_code` varchar(32) NOT NULL DEFAULT '' COMMENT '业务订单号',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '财务类型(0消费记录,1充值记录,2退款)',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0异常,1正常)',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_user_coupons`;
CREATE TABLE `ims_make_speed_user_coupons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可用业务订单类型',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT '来源',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `tips` varchar(64) NOT NULL DEFAULT '' COMMENT '标题',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
  `full_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '多少满减',
  `limit_distance` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '使用距离',
  `coupon_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '使用状态',
  `begin_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '到期时间',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_user_grade`;
CREATE TABLE `ims_make_speed_user_grade` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grade` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员等级',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '等级名称',
  `grow` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '满足成长值',
  `discount` decimal(6,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '折扣额度',
  `icon` varchar(128) NOT NULL DEFAULT '' COMMENT '会员图标',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_user_message`;
CREATE TABLE `ims_make_speed_user_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '消息类型(0系统通知,1用户操作通知)',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '通知用户',
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '标题',
  `summary` varchar(254) NOT NULL DEFAULT '' COMMENT '摘要',
  `img` varchar(128) NOT NULL DEFAULT '' COMMENT '缩略图',
  `content` text COMMENT '通知内容',
  `is_read` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否已读',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '通知时间',
  `top` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否制定',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_version`;
CREATE TABLE `ims_make_speed_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `oldversion` varchar(30) NOT NULL DEFAULT '' COMMENT '旧版本号',
  `newversion` varchar(30) NOT NULL DEFAULT '' COMMENT '新版本号',
  `packagesize` varchar(30) NOT NULL DEFAULT '' COMMENT '包大小',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '升级内容',
  `downloadurl` varchar(255) NOT NULL DEFAULT '' COMMENT '下载地址',
  `enforce` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '强制更新',
  `createtime` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` varchar(30) NOT NULL DEFAULT '' COMMENT '状态',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'uniacid',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uniacid` (`uniacid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='版本表';

DROP TABLE IF EXISTS `ims_make_speed_rider_driver`;
CREATE TABLE `ims_make_speed_rider_driver` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rider_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '认证骑手',
  `card_img1` varchar(128) NOT NULL DEFAULT '' COMMENT '驾驶证正本',
  `card_img2` varchar(128) NOT NULL DEFAULT '' COMMENT '驾驶证副本',
  `card_num` varchar(128) NOT NULL DEFAULT '' COMMENT '档案编号',
  `card_type` varchar(64) NOT NULL DEFAULT '' COMMENT '准驾车型',
  `card_time` varchar(64) NOT NULL DEFAULT '' COMMENT '初领驾驶证日期',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `remark`  varchar(50) NOT NULL DEFAULT '' COMMENT '备注',
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  `tid`  varchar(20) NOT NULL DEFAULT '' COMMENT '终端ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `rider_id` (`rider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_make_speed_clouds`;
CREATE TABLE `ims_make_speed_clouds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '对接名称',
  `modules_name` varchar(64) NOT NULL DEFAULT '' COMMENT '对接模块',
  `salt` varchar(32) NOT NULL DEFAULT '',
  `domain` varchar(64) NOT NULL DEFAULT '',
  `ip` varchar(20) DEFAULT '',
  `appid` varchar(64) NOT NULL DEFAULT '' COMMENT '对接小程序appid',
  `token` varchar(64) NOT NULL DEFAULT '' COMMENT 'Token',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `m_uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `charging`  varchar(255) NOT NULL COMMENT '计费',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_make_speed_user_invoice`;
CREATE TABLE `ims_make_speed_user_invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '申请用户',
  `mobile` varchar(15) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `content` varchar(164) NOT NULL DEFAULT '' COMMENT '发票内容',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '发票金额',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0个人1公司',
  `type_name` varchar(64) NOT NULL DEFAULT '',
  `tax_number` varchar(64) NOT NULL DEFAULT '',
  `code` varchar(32) NOT NULL DEFAULT '' COMMENT '发票代码',
  `number` varchar(32) NOT NULL DEFAULT '' COMMENT '发票号码',
  `date` varchar(32) NOT NULL DEFAULT '' COMMENT '开票日期',
  `check_code` varchar(32) NOT NULL DEFAULT '' COMMENT '校验码',
  `img` varchar(164) NOT NULL DEFAULT '' COMMENT '发票图片',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态0待审核',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '申请时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `uniacid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

insert  into `ims_make_speed_admin`(`id`,`username`,`nickname`,`password`,`salt`,`avatar`,`email`,`loginfailure`,`logintime`,`createtime`,`updatetime`,`token`,`status`,`uniacid`) values (1,'admin','Admin','65eaf51c156902f2e36847c83b98a2fd','s4f3','/uploads/20181204/a3380c52fe2927a756191e5abd517d40.jpg','',0,1552118204,1492186163,1552118204,'367351c6-c2f6-4b1c-9335-d363bbffc54d','normal',0);
insert  into `ims_make_speed_auth_group`(`id`,`pid`,`name`,`rules`,`createtime`,`updatetime`,`status`,`uniacid`) values (1,0,'Admin group','*',1490883540,149088354,'normal',0);
insert  into `ims_make_speed_auth_group`(`id`,`pid`,`name`,`rules`,`createtime`,`updatetime`,`status`,`uniacid`) values (2,1,'城市代理组','1,7,8,13,23,24,25,26,27,28,29,30,31,32,33,34,100,101,102,103,104,105,106,152,153,154,155,156,157,158,159,160,161,162,163,173,190,191,192,193,198,199,200,201,202,210,211,212,213,214,215,216,217,218,219,220,221,251,252,253,254,255,194,165,2,172,164',1490883540,149088354,'normal',0);
insert  into `ims_make_speed_auth_group_access`(`uid`,`group_id`) values (1,1);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (1,'file',0,'dashboard','Dashboard','fa fa-dashboard','','Dashboard tips',1,1497429920,1554193243,143,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (2,'file',0,'general','General','fa fa-cogs','','',1,1497429920,1497430169,99,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (6,'file',164,'general/config','系统配置','fa fa-cog','','Config tips',1,1497429920,1557564029,999,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (7,'file',194,'general/attachment','附件管理','fa fa-file-image-o','','Attachment tips',1,1497429920,1557565776,113,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (8,'file',194,'general/profile','个人配置','fa fa-user','','',1,1497429920,1557561234,118,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (9,'file',194,'auth/admin','管理员管理','fa fa-user','','Admin tips',1,1497429920,1557565793,109,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (10,'file',194,'auth/adminlog','管理员日志','fa fa-list-alt','','Admin log tips',1,1497429920,1557565802,104,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (11,'file',194,'auth/group','角色组','fa fa-group','','Group tips',1,1497429920,1557565814,53,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (13,'file',1,'dashboard/index','View','fa fa-circle-o','','',0,1497429920,1497429920,136,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (18,'file',6,'general/config/index','View','fa fa-circle-o','','',0,1497429920,1497429920,52,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (19,'file',6,'general/config/miniprogram','小程序配置','fa fa-circle-o','','',0,1497429920,1557730923,51,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (20,'file',6,'general/config/sms','短信配置','fa fa-circle-o','','',0,1497429920,1557731034,50,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (21,'file',6,'general/config/other','其他配置','fa fa-circle-o','','',0,1497429920,1557730978,49,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (22,'file',6,'general/config/riderprogram','骑手端小程序绑定','fa fa-circle-o','','',0,1497429920,1557731029,48,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (23,'file',7,'general/attachment/index','View','fa fa-circle-o','','Attachment tips',0,1497429920,1497429920,59,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (24,'file',7,'general/attachment/select','Select attachment','fa fa-circle-o','','',0,1497429920,1497429920,58,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (25,'file',7,'general/attachment/add','Add','fa fa-circle-o','','',0,1497429920,1497429920,57,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (26,'file',7,'general/attachment/edit','Edit','fa fa-circle-o','','',0,1497429920,1497429920,56,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (27,'file',7,'general/attachment/del','Delete','fa fa-circle-o','','',0,1497429920,1497429920,55,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (28,'file',7,'general/attachment/multi','Multi','fa fa-circle-o','','',0,1497429920,1497429920,54,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (29,'file',8,'general/profile/index','View','fa fa-circle-o','','',0,1497429920,1497429920,33,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (30,'file',8,'general/profile/update','Update profile','fa fa-circle-o','','',0,1497429920,1497429920,32,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (31,'file',8,'general/profile/add','Add','fa fa-circle-o','','',0,1497429920,1497429920,31,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (32,'file',8,'general/profile/edit','Edit','fa fa-circle-o','','',0,1497429920,1497429920,30,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (33,'file',8,'general/profile/del','Delete','fa fa-circle-o','','',0,1497429920,1497429920,29,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (34,'file',8,'general/profile/multi','Multi','fa fa-circle-o','','',0,1497429920,1497429920,28,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (40,'file',9,'auth/admin/index','View','fa fa-circle-o','','Admin tips',0,1497429920,1497429920,117,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (41,'file',9,'auth/admin/add','Add','fa fa-circle-o','','',0,1497429920,1497429920,116,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (42,'file',9,'auth/admin/edit','Edit','fa fa-circle-o','','',0,1497429920,1497429920,115,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (43,'file',9,'auth/admin/del','Delete','fa fa-circle-o','','',0,1497429920,1497429920,114,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (44,'file',10,'auth/adminlog/index','View','fa fa-circle-o','','Admin log tips',0,1497429920,1497429920,112,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (45,'file',10,'auth/adminlog/detail','Detail','fa fa-circle-o','','',0,1497429920,1497429920,111,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (46,'file',10,'auth/adminlog/del','Delete','fa fa-circle-o','','',0,1497429920,1497429920,110,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (47,'file',11,'auth/group/index','View','fa fa-circle-o','','Group tips',0,1497429920,1497429920,108,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (48,'file',11,'auth/group/add','Add','fa fa-circle-o','','',0,1497429920,1497429920,107,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (49,'file',11,'auth/group/edit','Edit','fa fa-circle-o','','',0,1497429920,1497429920,106,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (50,'file',11,'auth/group/del','Delete','fa fa-circle-o','','',0,1497429920,1497429920,105,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (100,'file',0,'order','订单管理','fa fa-book','','',1,1543909514,1557567392,98,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (101,'file',100,'order/order','跑腿订单','fa fa-space-shuttle','','',1,1543909514,1557568232,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (102,'file',101,'order/order/index','查看','fa fa-circle-o','','',0,1543909514,1543909514,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (103,'file',101,'order/order/add','添加','fa fa-circle-o','','',0,1543909514,1543909514,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (104,'file',101,'order/order/edit','编辑','fa fa-circle-o','','',0,1543909514,1543909514,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (105,'file',101,'order/order/del','删除','fa fa-circle-o','','',0,1543909514,1543909514,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (106,'file',101,'order/order/multi','批量更新','fa fa-circle-o','','',0,1543909514,1543909514,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (107,'file',0,'person','用户管理','fa fa-address-book','','',1,1545202336,1557568301,97,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (108,'file',107,'person/user','用户列表','fa fa-user','','',1,1545202336,1557568347,10,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (109,'file',108,'person/user/index','查看','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (110,'file',108,'person/user/add','Add','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (111,'file',108,'person/user/edit','编辑','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (112,'file',108,'person/user/del','删除','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (113,'file',108,'person/user/multi','批量更新','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (114,'file',2,'city','城市管理','fa fa-trello','','',1,1545210449,1557564553,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (115,'file',114,'city/index','列表','fa fa-circle-o','','',0,1545210449,1545210449,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (116,'file',114,'city/add','添加','fa fa-circle-o','','',0,1545210449,1545210449,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (117,'file',114,'city/edit','编辑','fa fa-circle-o','','',0,1545210449,1545210449,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (118,'file',114,'city/del','删除','fa fa-circle-o','','',0,1545210449,1545210449,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (119,'file',114,'city/multi','批量更新','fa fa-circle-o','','',0,1545210449,1545210449,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (120,'file',2,'goodstype','物品类型','fa fa-th-large','','',1,1545210719,1557564566,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (121,'file',120,'goodstype/index','列表','fa fa-circle-o','','',0,1545210719,1545210719,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (122,'file',120,'goodstype/add','添加','fa fa-circle-o','','',0,1545210719,1545210719,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (123,'file',120,'goodstype/edit','编辑','fa fa-circle-o','','',0,1545210719,1545210719,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (124,'file',120,'goodstype/del','删除','fa fa-circle-o','','',0,1545210719,1545210719,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (125,'file',120,'goodstype/multi','批量更新','fa fa-circle-o','','',0,1545210719,1545210719,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (126,'file',2,'coupons','优惠券管理','fa fa-cc-discover','','',1,1545309955,1557564670,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (127,'file',126,'coupons/index','查看','fa fa-circle-o','','',0,1545309955,1545309955,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (128,'file',126,'coupons/add','添加','fa fa-circle-o','','',0,1545309955,1545309955,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (129,'file',126,'coupons/edit','编辑','fa fa-circle-o','','',0,1545309955,1545309955,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (130,'file',126,'coupons/del','删除','fa fa-circle-o','','',0,1545309955,1545309955,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (131,'file',126,'coupons/multi','批量更新','fa fa-circle-o','','',0,1545309955,1545309955,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (132,'file',107,'person/cashlog','支付日志','fa fa-file-text-o','','',1,1547014699,1557568488,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (133,'file',132,'person/cashlog/index','查看','fa fa-circle-o','','',0,1547014699,1547014699,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (134,'file',132,'person/cashlog/add','添加','fa fa-circle-o','','',0,1547014699,1547014699,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (135,'file',132,'person/cashlog/edit','编辑','fa fa-circle-o','','',0,1547014699,1547014699,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (136,'file',132,'person/cashlog/del','删除','fa fa-circle-o','','',0,1547014699,1547014699,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (137,'file',132,'person/cashlog/multi','批量更新','fa fa-circle-o','','',0,1547014699,1547014699,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (138,'file',165,'person/rider','骑手列表','fa fa-user-circle-o','','',1,1547014805,1557568561,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (139,'file',138,'person/rider/index','查看','fa fa-circle-o','','',0,1547014805,1547014805,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (140,'file',138,'person/rider/detail','详情','fa fa-circle-o','','',0,1547014805,1547014805,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (141,'file',138,'person/rider/add','添加','fa fa-circle-o','','',0,1547014805,1547014805,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (142,'file',138,'person/rider/edit','编辑','fa fa-circle-o','','',0,1547014805,1547014805,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (143,'file',138,'person/rider/del','删除','fa fa-circle-o','','',0,1547014805,1547014805,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (144,'file',138,'person/rider/multi','批量更新','fa fa-circle-o','','',0,1547014805,1547014805,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (145,'file',165,'person/riderbind','认证审核','fa fa-address-card','','',1,1547552373,1557568608,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (146,'file',145,'person/riderbind/index','查看','fa fa-circle-o','','',0,1547552373,1547552373,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (147,'file',145,'person/riderbind/add','添加','fa fa-circle-o','','',0,1547552373,1547552373,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (148,'file',145,'person/riderbind/edit','编辑','fa fa-circle-o','','',0,1547552373,1547552373,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (149,'file',145,'person/riderbind/del','删除','fa fa-circle-o','','',0,1547552373,1547552373,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (150,'file',145,'person/riderbind/multi','批量更新','fa fa-circle-o','','',0,1547552373,1547552373,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (152,'file',165,'setting/trainrider','预约列表','fa fa-check-square-o','','',1,1547795066,1557568782,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (153,'file',152,'setting/trainrider/index','查看','fa fa-circle-o','','',0,1547795066,1547795066,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (154,'file',152,'setting/trainrider/add','添加','fa fa-circle-o','','',0,1547795066,1547795066,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (155,'file',152,'setting/trainrider/edit','编辑','fa fa-circle-o','','',0,1547795066,1547795066,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (156,'file',152,'setting/trainrider/del','删除','fa fa-circle-o','','',0,1547795066,1547795066,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (157,'file',152,'setting/trainrider/multi','批量更新','fa fa-circle-o','','',0,1547795066,1547795066,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (158,'file',2,'setting/trainlist','培训点列管理','fa fa-flag','','',1,1547795269,1557567304,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (159,'file',158,'setting/trainlist/index','查看','fa fa-circle-o','','',0,1547795269,1547795269,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (160,'file',158,'setting/trainlist/add','添加','fa fa-circle-o','','',0,1547795269,1547795269,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (161,'file',158,'setting/trainlist/edit','编辑','fa fa-circle-o','','',0,1547795269,1547795269,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (162,'file',158,'setting/trainlist/del','删除','fa fa-circle-o','','',0,1547795269,1547795269,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (163,'file',158,'setting/trainlist/multi','批量更新','fa fa-circle-o','','',0,1547795269,1547795269,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (164,'file',0,'base','基本设置','fa fa-cog','','',1,1547862418,1557566328,137,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (165,'file',0,'riderman','骑手管理','fa fa-user-md','','',1,1547862531,1557568525,96,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (166,'file',164,'setting/couponactivity','活动设置','fa fa-gift','','',1,1550056601,1558768511,5,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (167,'file',196,'agreement','用户端协议','fa fa-file-text-o','','',1,1550219372,1557569156,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (168,'file',196,'rideragreement','骑手端协议','fa fa-file-text','','骑手端协议设置',1,1551057050,1557569168,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (169,'file',164,'riderinvite','骑手推荐设置','fa fa-user-secret','','',1,1551670386,1557566950,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (170,'file',164,'userinvite','用户推荐设置','fa fa-users','','',1,1552096113,1557566917,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (171,'file',172,'equip','装备列表','fa fa-bookmark-o','','',1,1553929069,1557575033,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (172,'file',0,'equipman','装备商城','fa fa-bug','','',1,1554084933,1557574957,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (173,'file',172,'equiporder','装备订单','fa fa-credit-card','','',1,1554084980,1557575056,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (174,'file',196,'handbook','骑手手册','fa fa-clone','','',1,1554173103,1557574990,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (175,'file',165,'person/riderwithdraw','提现列表','fa fa-money','','',1,1553238366,1557568729,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (184,'file',165,'person/ridersanction','奖惩管理','fa fa-pencil-square-o','','',1,1553238366,1557568757,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (185,'file',195,'person/ridermessage','骑手端消息通知','fa fa-commenting','','发送骑手端站内消息通知',1,1553238366,1557569092,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (188,'file',195,'person/usermessage','用户端消息通知','fa fa-commenting-o','','',1,1555580311,1557569121,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (189,'file',107,'person/usergrade','用户等级管理','fa fa-address-card-o','','',1,1555580338,1557568395,1,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (190,'file',100,'order/buyorder','帮买订单','fa fa-shopping-bag','','代购、帮买订单管理列表',1,1557107712,1557567862,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (191,'file',100,'order/lineorder','万能服务订单','fa fa-child','','排队订单排队订单排队订单',1,1557109762,1557567668,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (192,'file',100,'order/driveorder','代驾订单','fa fa-car','','代驾订单代驾订单代驾订单',1,1557109797,1557567750,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (193,'file',164,'setting/price','价格配置','fa fa-jpy','','价格配置价格配置价格配置',1,1557123397,1557566574,60,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (194,'file',0,'settings','系统管理','fa fa-sun-o','','',1,1557560297,1557575153,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (195,'file',0,'messages','站内消息','fa fa-twitch','','',1,1557564879,1557568846,95,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (196,'file',0,'agreements','协议手册','fa fa-list-alt','','',1,1557565487,1557568918,94,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (197,'file',6,'general/config/savessl','SSL证书','fa fa-circle-o','','',0,1557731226,1557731226,0,'hidden',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (198,'file',193,'setting/price/index','查看','fa fa-circle-o','','',0,1557731381,1557732401,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (199,'file',193,'setting/price/add','跑腿价格配置','fa fa-circle-o','','',0,1557731409,1557732398,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (200,'file',193,'setting/price/buy','帮买价格配置','fa fa-circle-o','','',0,1557731447,1557732396,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (201,'file',193,'setting/price/line','万能跑腿配置','fa fa-circle-o','','',0,1557731507,1557732394,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (202,'file',193,'setting/price/drive','代驾价格配置','fa fa-circle-o','','',0,1557731527,1557732392,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (203,'file',166,'setting/couponactivity/index','查看','fa fa-circle-o','','',0,1557731620,1557732390,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (204,'file',166,'setting/couponactivity/newperson','新人活动优惠券设置','fa fa-circle-o','','',0,1557731659,1557732385,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (205,'file',169,'riderinvite/index','查看','fa fa-circle-o','','',0,1557731769,1557732382,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (206,'file',169,'riderinvite/inviterider','推荐骑手设置','fa fa-circle-o','','',0,1557731797,1557732380,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (207,'file',169,'riderinvite/userinvite','推荐用户设置','fa fa-circle-o','','',0,1557731827,1557732378,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (208,'file',170,'userinvite/index','查看','fa fa-circle-o','','',0,1557731848,1557732376,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (209,'file',170,'userinvite/saveinvite','推荐用户设置','fa fa-circle-o','','',0,1557731885,1557732374,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (210,'file',190,'order/buyorder/index','查看','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (211,'file',190,'order/buyorder/edit','编辑','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (212,'file',190,'order/buyorder/del','删除','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (213,'file',190,'order/buyorder/multi','批量更新','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (214,'file',191,'order/lineorder/index','查看','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (215,'file',191,'order/lineorder/edit','编辑','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (216,'file',191,'order/lineorder/del','删除','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (217,'file',191,'order/lineorder/multi','批量更新','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (218,'file',192,'order/driveorder/index','查看','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (219,'file',192,'order/driveorder/edit','编辑','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (220,'file',192,'order/driveorder/del','删除','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (221,'file',192,'order/driveorder/multi','批量更新','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (222,'file',189,'person/usergrade/index','查看','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (223,'file',189,'person/usergrade/add','添加','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (224,'file',189,'person/usergrade/edit','编辑','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (225,'file',189,'person/usergrade/del','删除','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (226,'file',189,'person/usergrade/multi','批量更新','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (227,'file',175,'person/riderwithdraw/index','查看','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (228,'file',175,'person/riderwithdraw/edit','编辑','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (229,'file',175,'person/riderwithdraw/del','删除','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (230,'file',175,'person/riderwithdraw/multi','批量更新','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (231,'file',184,'person/ridersanction/index','查看','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (232,'file',184,'person/ridersanction/add','添加','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (233,'file',184,'person/ridersanction/edit','编辑','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (234,'file',184,'person/ridersanction/del','删除','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (235,'file',184,'person/ridersanction/multi','批量更新','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (236,'file',185,'person/ridermessage/index','查看','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (237,'file',185,'person/ridermessage/add','添加','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (238,'file',185,'person/ridermessage/edit','编辑','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (239,'file',185,'person/ridermessage/del','删除','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (240,'file',185,'person/ridermessage/multi','批量更新','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (241,'file',188,'person/usermessage/index','查看','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (242,'file',188,'person/usermessage/add','添加','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (243,'file',188,'person/usermessage/edit','编辑','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (244,'file',188,'person/usermessage/del','删除','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (245,'file',188,'person/usermessage/multi','批量更新','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (246,'file',171,'equip/index','查看','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (247,'file',171,'equip/add','添加','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (248,'file',171,'equip/edit','编辑','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (249,'file',171,'equip/del','删除','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (250,'file',171,'equip/multi','批量更新','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (251,'file',173,'equiporder/index','查看','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (252,'file',173,'equiporder/add','添加','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (253,'file',173,'equiporder/edit','编辑','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (254,'file',173,'equiporder/del','删除','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (255,'file',173,'equiporder/multi','批量更新','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (256,'file',164,'setting/banner','轮播图设置','fa fa-picture-o','','',1,1558075143,1558075143,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (257,'file',256,'setting/banner/index','查看','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (258,'file',256,'setting/banner/add','添加','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (259,'file',256,'setting/banner/edit','编辑','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (260,'file',256,'setting/banner/del','删除','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (261,'file',256,'setting/banner/multi','批量更新','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (262,'file',167,'agreement/index','查看','fa fa-circle-o','','',0,1559618861,1559618861,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (263,'file',167,'agreement/helper','帮助','fa fa-circle-o','','',0,1559618908,1559619250,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (264,'file',167,'agreement/price','价格说明','fa fa-circle-o','','',0,1559619067,1559619322,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (265,'file',167,'agreement/redbao','红包规则说明','fa fa-circle-o','','',0,1559619133,1559619435,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (266,'file',167,'agreement/user','用户协议','fa fa-circle-o','','',0,1559619162,1559619162,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (267,'file',167,'agreement/recharge','充值协议','fa fa-circle-o','','',0,1559619190,1559619190,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (268,'file',167,'agreement/cancel','取消订单说明','fa fa-circle-o','','',0,1559619357,1559619372,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (269,'file',168,'rideragreement/index','查看','fa fa-circle-o','','',0,1559619574,1559619574,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (270,'file',168,'rideragreement/service','客服帮助','fa fa-circle-o','','',0,1559619595,1559619595,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (271,'file',168,'rideragreement/account','账户说明','fa fa-circle-o','','',0,1559619625,1559619625,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (272,'file',168,'rideragreement/bean','码豆说明','fa fa-circle-o','','',0,1559619658,1559619658,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (273,'file',168,'rideragreement/cooperate','活动协议','fa fa-circle-o','','',0,1559619687,1559619687,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (274,'file',168,'rideragreement/activity','分享活动说明','fa fa-circle-o','','',0,1559619709,1559619709,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (275,'file',174,'handbook/index','查看','fa fa-circle-o','','',0,1559619841,1559619841,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (276,'file',174,'handbook/add','添加','fa fa-circle-o','','',0,1559619865,1559619865,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (277,'file',174,'handbook/edit','编辑','fa fa-circle-o','','',0,1559619884,1559619884,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (278,'file',174,'handbook/del','删除','fa fa-circle-o','','',0,1559619896,1559619896,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (279,'file',174,'handbook/multi','批量更新','fa fa-circle-o','','',0,1545202336,1545202336,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (280,'file',108,'person/user/coupon','发放优惠券','fa fa-circle-o','','',0,1559629689,1559629689,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (281,'file',101,'order/order/detail','详情','fa fa-circle-o','','',0,1559635260,1559635260,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (282,'file',101,'order/order/tasking','分配骑手','fa fa-circle-o','','',0,1559635288,1559635288,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (283,'file',190,'order/buyorder/detail','详情','fa fa-circle-o','','',0,1559635400,1559635400,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (284,'file',190,'order/buyorder/tasking','分配骑手','fa fa-circle-o','','',0,1559635428,1559635428,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (285,'file',191,'order/lineorder/tasking','分配骑手','fa fa-circle-o','','',0,1559635487,1559635487,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (286,'file',191,'order/lineorder/detail','详情','fa fa-circle-o','','',0,1559635511,1559635511,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (287,'file',192,'order/driveorder/detail','详情','fa fa-circle-o','','',0,1559635571,1559635571,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (288,'file',192,'order/driveorder/tasking','分配骑手','fa fa-circle-o','','',0,1559635590,1559635590,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (289,'file',6,'general/config/business','业务类型开放','fa fa-circle-o','','',0,1559635638,1559635638,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (290,'file',108,'person/user/detail','详情','fa fa-circle-o','','',0,1559649924,1559649924,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (291,'file',6,'general/config/startrider','启用模板消息','fa fa-circle-o','','',0,1559716420,1559716420,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (292,'file',165,'person/riderdriver','代驾身份审核','fa fa-circle-o','','',1,1560245066,1560251732,1,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (293,'file',292,'person/riderdriver/index','查看','fa fa-circle-o','','',0,1560324449,1560324449,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (294,'file',292,'person/riderdriver/edit','编辑','fa fa-circle-o','','',0,1560324467,1560324467,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (295,'file',292,'person/riderdriver/del','删除','fa fa-circle-o','','',0,1560324492,1560324492,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (296,'file',107,'person/invoice','发票申请','fa fa-chain-broken','','',1,1562053384,1562055503,7,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (297,'file',296,'person/invoice/index','查看','fa fa-circle-o','','',0,1562053414,1562053414,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (298,'file',296,'person/invoice/edit','编辑','fa fa-circle-o','','',0,1562053463,1562053463,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (299,'file',296,'person/invoice/del','删除','fa fa-circle-o','','',0,1562053485,1562053485,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (340,'file',164,'setting/theme','前端主题','fa fa-stumbleupon-circle','','',1,1564367487,1564367506,4,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (341,'file',340,'setting/theme/index','查看','fa fa-circle-o','','',0,1564367557,1564367557,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (342,'file',340,'setting/theme/save','保存','fa fa-circle-o','','',0,1564367582,1564367582,0,'normal',0);


insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (330,'file',0,'cloudman','模块对接管理','fa fa-mixcloud','','',1,1565600739,1565667593,97,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (331,'file',330,'cloud/clouds','模块列表','fa fa-cloud','','',1,1565600787,1565664843,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (332,'file',330,'cloud/orderlist','对接订单','fa fa-list-ul','','',1,1565600820,1565664865,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (361,'file',331,'cloud/clouds/add','添加','fa fa-circle-o','','',0,1570521631,1570522154,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (362,'file',331,'cloud/clouds/edit','编辑','fa fa-circle-o','','',0,1570521682,1570521682,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (363,'file',331,'cloud/clouds/del','删除','fa fa-circle-o','','',0,1570521707,1570521707,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (364,'file',332,'cloud/orderlist/edit','编辑','fa fa-circle-o','','',0,1570521849,1570521849,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (365,'file',332,'cloud/orderlist/detail','详情','fa fa-circle-o','','',0,1570521872,1570521872,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (366,'file',332,'cloud/orderlist/del','删除','fa fa-circle-o','','',0,1570521963,1570521963,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (367,'file',332,'cloud/orderlist/index','查看','fa fa-circle-o','','',0,1570522021,1570522021,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (368,'file',332,'cloud/orderlist/tasking','分配骑手','fa fa-circle-o','','',0,1570522098,1570522098,0,'normal',0);
insert  into `ims_make_speed_auth_rule`(`id`,`type`,`pid`,`name`,`title`,`icon`,`condition`,`remark`,`ismenu`,`createtime`,`updatetime`,`weigh`,`status`,`uniacid`) values (369,'file',331,'cloud/clouds/index','查看','fa fa-circle-o','','',0,1570522127,1570522127,0,'normal',0);

INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('415', 'file', '164', 'general/config/programmenu', '小程序页面路径', 'fa fa-circle-o', '', '', '1', '1571814505', '1571814505', '0', 'normal', '0');


INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('419', 'file', '165', 'person/virtual_rider', '虚拟骑手', 'fa fa-circle-o', '', '', '1', '1572079383', '1572312091', '0', 'normal', '0');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('420', 'file', '419', 'person/virtual_rider/add', '添加', 'fa fa-circle-o', '', '', '0', '1572419365', '1572419365', '0', 'normal', '0');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('421', 'file', '419', 'person/virtual_rider/edit', '编辑', 'fa fa-circle-o', '', '', '0', '1572419387', '1572419387', '0', 'normal', '0');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('425', 'file', '100', 'order/cancel_order', '骑手取消单', 'fa fa-close', '', '', '1', '1574929996', '1574930136', '0', 'normal', '0');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('426', 'file', '425', 'order/cancel_order/del', '删除', 'fa fa-circle-o', '', '', '0', '1574930094', '1574930094', '0', 'normal', '0');

INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('427', 'file', '0', 'distribution', '分销管理', 'fa fa-circle-o', '', '', '1', '1575615395', '1575615395', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('429', 'file', '427', 'distribution/distributor', '分销商管理', 'fa fa-circle-o', '', '', '1', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('430', 'file', '429', 'distribution/distributor/index', '查看', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('431', 'file', '429', 'distribution/distributor/edit', '编辑', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('432', 'file', '429', 'distribution/distributor/del', '删除', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('433', 'file', '427', 'distribution/order', '分销订单', 'fa fa-circle-o', '', '', '1', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('434', 'file', '433', 'distribution/order/index', '查看', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('435', 'file', '433', 'distribution/order/edit', '编辑', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('436', 'file', '433', 'distribution/order/del', '删除', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('437', 'file', '427', 'distribution/grade', '分销等级', 'fa fa-circle-o', '', '', '1', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('438', 'file', '437', 'distribution/grade/index', '查看', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('439', 'file', '437', 'distribution/grade/add', '添加', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('440', 'file', '437', 'distribution/grade/edit', '编辑', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('441', 'file', '437', 'distribution/grade/del', '删除', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('442', 'file', '427', 'distribution/withdraw', '提现列表', 'fa fa-circle-o', '', '', '1', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('443', 'file', '442', 'distribution/withdraw/index', '查看', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('444', 'file', '442', 'distribution/withdraw/edit', '编辑', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('445', 'file', '442', 'distribution/withdraw/del', '删除', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('446', 'file', '427', 'distribution/config', '基础设置', 'fa fa-circle-o', '', '', '1', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('447', 'file', '446', 'distribution/config/index', '查看', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('448', 'file', '446', 'distribution/config/base', '编辑', 'fa fa-circle-o', '', '', '0', '1575615764', '1575615764', '0', 'normal', '36');
INSERT INTO `ims_make_speed_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `condition`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`, `uniacid`) VALUES ('449', 'file', '429', 'distribution/distributor/userinfo', '用户信息', 'fa fa-circle-o', '', '', '0', '1576230523', '1576230523', '0', 'normal', '0');