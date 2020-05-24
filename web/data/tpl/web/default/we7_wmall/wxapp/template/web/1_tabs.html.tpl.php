<?php defined('IN_IA') or exit('Access Denied');?><div class="second-sidebar-title"><?php  echo $_W['_plugin']['title'];?></div>
<div class="nav slimscroll">
	<div class="menu-header">设置</div>
	<ul class="menu-item">
		<?php  if(check_perm('wxapp.config')) { ?>
			<li <?php  if($_GPC['op'] == 'basic') { ?>class="active"<?php  } ?>>
				<a href="<?php  echo iurl('wxapp/config/basic');?>">基础设置</a>
			</li>
			<li <?php  if($_GPC['op'] == 'wxtemplate') { ?>class="active"<?php  } ?>>
				<a href="<?php  echo iurl('wxapp/config/wxtemplate');?>">模板消息</a>
			</li>
			<li <?php  if($_GPC['op'] == 'payment') { ?>class="active"<?php  } ?>>
				<a href="<?php  echo iurl('wxapp/config/payment');?>">支付方式</a>
			</li>
		<?php  } ?>
	</ul>
	<div class="menu-header">小程序装修</div>
	<ul class="menu-item">
		<li <?php  if($_GPC['ac'] == 'extpage') { ?>class="active"<?php  } ?>>
			<a href="<?php  echo iurl('wxapp/extpage')?>">页面配置</a>
		</li>
		<li <?php  if($_GPC['ac'] == 'menu') { ?>class="active"<?php  } ?>>
			<a href="<?php  echo iurl('wxapp/menu')?>">底部导航</a>
		</li>
		<li <?php  if($_W['_action'] == 'diyPage') { ?>class="active"<?php  } ?>>
			<a href="<?php  echo iurl('wxapp/diyPage/list')?>">自定义DIY</a>
		</li>
		<li <?php  if($_W['_action'] == 'guide') { ?>class="active"<?php  } ?>>
		<a href="<?php  echo iurl('wxapp/guide/index')?>">启动图</a>
		</li>
		<li <?php  if($_W['_action'] == 'diyShop') { ?>class="active"<?php  } ?>>
			<a href="<?php  echo iurl('wxapp/diyShop/index')?>">页面设置</a>
		</li>
	</ul>
	<div class="menu-header">入口</div>
	<ul class="menu-item">
		<li <?php  if($_GPC['ac'] == 'urls') { ?>class="active"<?php  } ?>>
			<a href="<?php  echo iurl('wxapp/urls');?>">入口链接</a>
		</li>
	</ul>
	<div class="menu-header">小程序</div>
	<ul class="menu-item">
		<li <?php  if($_GPC['ac'] == 'release') { ?>class="active"<?php  } ?>>
			<a href="<?php  echo iurl('wxapp/release');?>">发布与审核</a>
		</li>
		<li <?php  if($_GPC['ac'] == 'commitlog') { ?>class="active"<?php  } ?>>
			<a href="<?php  echo iurl('wxapp/commitlog');?>">代码上传记录</a>
		</li>
		<li <?php  if($_GPC['ac'] == 'memberauth') { ?>class="active"<?php  } ?>>
			<a href="<?php  echo iurl('wxapp/memberauth');?>">体验者</a>
		</li>
	</ul>
</div>
