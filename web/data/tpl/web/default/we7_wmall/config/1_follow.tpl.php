<?php defined('IN_IA') or exit('Access Denied');?><?php  include itemplate('public/header', TEMPLATE_INCLUDEPATH);?>
<div class="page clearfix">
	<form class="form-horizontal form form-validate" id="form1" action="" method="post" enctype="multipart/form-data">
		<h3>关注</h3>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">未关注提示</label>
			<div class="col-sm-9 col-xs-12">
				<div class="radio radio-inline radio-primary">
					<input type="radio" value="1" name="guide_status" id="guide-status-1" <?php  if($follow['guide_status'] == 1) { ?>checked<?php  } ?>>
					<label for="guide-status-1">提示</label>
				</div>
				<div class="radio radio-inline radio-primary">
					<input type="radio" value="0" name="guide_status" id="guide-status-2" <?php  if(!$follow['guide_status']) { ?>checked<?php  } ?>>
					<label for="guide-status-2">不提示</label>
				</div>
				<div class="help-block text-danger">粉丝未关注公众号时， 是否在页面顶部引导关注</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">关注引导页</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" name="followurl" value="<?php  echo $follow['link'];?>" class="form-control">
				<div class="help-block text-danger">用户未关注的引导页面，建议使用短链接: <a href="http://www.dwz.cn/" target="_blank">短网址</a> 如果设置关注二维码则优先弹出二维码</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">二维码</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_form_field_image('qrcode', $follow['qrcode']);?>
				<div class="help-block text-danger">关注时调用</div>
			</div>
		</div>
		<h3>分享</h3>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" name="title" value="<?php  echo $share['title'];?>" class="form-control" required>
				<div class="help-block text-danger"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">平台图标</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_form_field_image('imgUrl', $share['imgUrl']);?>
				<div class="help-block text-danger">分享时调用</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享描述</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" name="desc" value="<?php  echo $share['desc'];?>" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享链接</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_form_field_tiny_link('link', $share['link']);?>
				<div class="help-block text-danger">
					用户分享出去的链接，默认为首页。
					<span class="text-danger">注意:分享链接必须以http://或https://,如果选择的链接不是以http://或https://开头,请自行补全</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9 col-xs-9 col-md-9">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
				<input type="submit" value="提交" class="btn btn-primary">
			</div>
		</div>
	</form>
</div>
<?php  include itemplate('public/footer', TEMPLATE_INCLUDEPATH);?>