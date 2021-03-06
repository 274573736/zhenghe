<?php defined('IN_IA') or exit('Access Denied');?><?php  include itemplate('public/header', TEMPLATE_INCLUDEPATH);?>
<div class="page clearfix">
	<h2>微信模板消息</h2>
	<form class="form-horizontal form form-validate" id="form1" action="" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">订单状态变更模板</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="text" class="form-control" name="wechat[public_tpl]" value="<?php  echo $wechat['public_tpl'];?>" required>
				<div class="help-block">模板编号：TM00017。标题:订单状态更新. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
			</div>
		</div>
		<div class="form-group hide">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">任务处理通知模板</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="text" class="form-control" name="wechat[task_tpl]" value="<?php  echo $wechat['task_tpl'];?>" required>
				<div class="help-block">模板编号：OPENTM200605630。标题:任务处理通知. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">新用户入驻申请</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="text" class="form-control" name="wechat[settle_apply_tpl]" value="<?php  echo $wechat['settle_apply_tpl'];?>">
				<div class="help-block">模板编号：OPENTM401619203。标题:新用户入驻申请. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">入驻通知模板</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="text" class="form-control" name="wechat[settle_tpl]" value="<?php  echo $wechat['settle_tpl'];?>">
				<div class="help-block">模板编号：OPENTM207419103。标题:入驻通知. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现提交模板</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="text" class="form-control" name="wechat[getcash_apply_tpl]" value="<?php  echo $wechat['getcash_apply_tpl'];?>">
				<div class="help-block">模板编号：TM00979。标题:提现提交通知. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现成功通知</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="text" class="form-control" name="wechat[getcash_success_tpl]" value="<?php  echo $wechat['getcash_success_tpl'];?>">
				<div class="help-block">模板编号：TM00980。标题:提现成功通知. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">提现失败通知</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="text" class="form-control" name="wechat[getcash_fail_tpl]" value="<?php  echo $wechat['getcash_fail_tpl'];?>">
				<div class="help-block">模板编号：TM00981。标题:提现失败通知. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">退款通知</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="text" class="form-control" name="wechat[refund_tpl]" value="<?php  echo $wechat['refund_tpl'];?>">
				<div class="help-block">模板编号：TM00004。标题:退款通知. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">账户变动通知</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="text" class="form-control" name="wechat[account_change_tpl]" value="<?php  echo $wechat['account_change_tpl'];?>">
				<div class="help-block">模板编号：OPENTM207664902。标题:账户变动提醒. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">预警通知</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="text" class="form-control" name="wechat[warning_tpl]" value="<?php  echo $wechat['warning_tpl'];?>">
				<div class="help-block">模板编号：OPENTM206019251。标题:预警通知. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">会员加入提醒</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="text" class="form-control" name="wechat[join_tpl]" value="<?php  echo $wechat['join_tpl'];?>">
				<div class="help-block">模板编号：OPENTM207679900。标题:会员加入提醒. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
			</div>
		</div>
		<div class="form-group hide">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">任务处理通知</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="text" class="form-control" name="wechat[task_tpl]" value="<?php  echo $wechat['task_tpl'];?>">
				<div class="help-block">模板编号：OPENTM200605630。标题:任务处理通知. 行业:IT科技 - 互联网|电子商务. 您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">排队通知</label>
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="text" class="form-control" name="wechat[assign_tpl]" value="<?php  echo $wechat['assign_tpl'];?>">
				<div class="help-block">在模板库选择行业餐饮－餐饮，搜索“排号通知”编号为OPENTM383288748的模板.您可以在公众平台查找该模板编号，获取模板id。该功能需要您的公众号为认证服务号</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="hidden" name="wechat[token" value="<?php  echo $_W['token'];?>">
				<input type="submit" value="提交" class="btn btn-primary">
				<?php  if($_GPC['slog'] == 1) { ?>
					<a href="<?php  echo iurl('config/notice/wxtemplate_init')?>" class="btn btn-danger js-post" data-confirm="一键设置模板ID吗？">一键设置模板ID</a>
				<?php  } ?>
			</div>
		</div>
	</form>
</div>
<?php  include itemplate('public/footer', TEMPLATE_INCLUDEPATH);?>