<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="we7-page-title">微官网</div>
<ul class="we7-page-tab">
	<?php  if(is_array($active_sub_permission)) { foreach($active_sub_permission as $active_menu) { ?>
	<?php  if(permission_check_account_user($active_menu['permission_name'], false) && (empty($active_menu['is_display']) || is_array($active_menu['is_display']) && in_array($_W['account']['type'], $active_menu['is_display']))) { ?>
	<li <?php  if($action == $active_menu['active']) { ?>class="active"<?php  } ?>><a href="<?php  echo $active_menu['url'];?>"><?php  echo $active_menu['title'];?></a></li>
	<?php  } ?>
	<?php  } } ?>
</ul>

<div class="we7-page-search we7-padding-bottom clearfix">
	<form action="./index.php" method="get" class="form-inline">
		<input type="hidden" name="c" value="site">
		<input type="hidden" name="a" value="style">
		<input type="hidden" name="do" value="template">
		<div class="input-group col-sm-4">
			<input type="text" name="keyword" value="<?php  echo $_GPC['keyword'];?>" class="form-control" placeholder="请输入模板名称">
			<span class="input-group-btn"><button class="btn btn-default"><i class="fa fa-search"></i></button></span>
		</div>
	</form>
</div>

<div class="site-template" id="js-wesite-tpl-display" ng-controller="WesiteTplDidplay" ng-cloak>
	<div class="btn-group we7-btn-group">
		<a ng-href="{{links.template}}&type=all" ng-class="{'btn': 1,'active': type == 'all'}">全部</a>
		<a ng-href="{{links.template}}&type={{temtype.name}}" ng-class="{'btn': 1, 'active': type == temtype.name}"  ng-repeat="temtype in temtypes" ng-bind="temtype.title"></a>
	</div>
	<div class="site-template-list">
		<div class="site-template-item" ng-class="{'active' : style.styleid == setting.styleid}" ng-repeat="style in stylesResult" ng-if="style.styleid">
			<h2 class="site-template-title">{{style.title}} ({{style.name}})</h2>
			<div class="site-template-img" ng-click="selectDefault(style.styleid)">
				<img ng-src="../app/themes/{{style.name}}/preview.jpg" alt="{{style.name}}"/>
				<div class="cover-dark">
					<div class="selected">
						<i class="fa fa-check"></i>
					</div>
				</div>
			</div>
			<div class="site-template-manage">
				<a ng-href="{{links.designer}}&styleid={{style.styleid}}" class="manage-item" data-toggle="tooltip" data-placement="bottom" title="设计风格"><i class="wi wi-text"></i></a>
				<a ng-href="{{links.copy}}&styleid={{style.styleid}}" class="manage-item" data-toggle="tooltip" data-placement="bottom" title="复制风格"><i class="wi wi-copy"></i></a>
				<a href="javascript:;" class="manage-item" ng-click="preview(style.styleid)" data-toggle="tooltip" data-placement="bottom" title="预览"><i class="wi wi-eye"></i></a>
				<a ng-href="{{links.del}}&styleid={{style.styleid}}" class="manage-item" onclick="if(!confirm('删除后将不可恢复,确定删除吗?')) return false;" data-toggle="tooltip" data-placement="bottom" title="删除"><i class="wi wi-delete2"></i></a>
			</div>
		</div>
		<div class="site-template-item" ng-repeat="style in stylesResult" ng-if="!style.styleid">
			<div class="cover-lock">
				<div class="lock">
					<a ng-href="{{links.build}}&styleid={{style.templateid}}" class="btn btn-warning item-build-btn" role="button" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="该模板尚未激活，激活后可正常使用！" data-original-title="" title="">点击激活</a>
				</div>
			</div>
			<h2 class="site-template-title">{{style.title}} ({{style.name}})</h2>
			<div class="site-template-img">
				<img src="../app/themes/{{style.name}}/preview.jpg"/>
				<div class="cover-dark">
					<div class="selected">
						<i class="fa fa-check"></i>
					</div>
				</div>
			</div>
			<div class="site-template-manage">
				<a href="javascript:;" class="manage-item" title="设计风格"><i class="wi wi-text"></i></a>
				<a href="javascript:;" class="manage-item" title="复制风格"><i class="wi wi-template"></i></a>
				<a href="javascript:;" class="manage-item" class="预览"><i class="wi wi-eye"></i></a>
				<a href="javascript:;" class="manage-item" title="删除"><i class="wi wi-delete2"></i></a>
			</div>
		</div>
	</div>
</div>
<script>
	$(function () { 
		$("[data-toggle='popover']").popover();
	});
	angular.module('wesiteApp').value('config', {
		stylesResult: <?php echo !empty($stylesResult) ? json_encode($stylesResult) : 'null'?>,
		temtypes: <?php echo !empty($temtypes) ? json_encode($temtypes) : 'null'?>,
		type: <?php echo !empty($_GPC['type']) ? json_encode($_GPC['type']) : 'null'?>,
		setting: <?php echo !empty($setting) ? json_encode($setting) : 'null'?>,
		links: {
			template: "<?php  echo url('site/style/template')?>",
			default: "<?php  echo url('site/style/default')?>",
			designer: "<?php  echo url('site/style/designer')?>",
			copy: "<?php  echo url('site/style/copy')?>",
			build: "<?php  echo url('site/style/build')?>",
			del: "<?php  echo url('site/style/del')?>",
			home: "<?php  echo murl('home', array(), true, true)?>",
		},
	});
	angular.bootstrap($('#js-wesite-tpl-display'), ['wesiteApp']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>