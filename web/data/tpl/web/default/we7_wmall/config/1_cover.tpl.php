<?php defined('IN_IA') or exit('Access Denied');?><?php  include itemplate('public/header', TEMPLATE_INCLUDEPATH);?>
<div class="page clearfix">
	<h2><?php  echo $_W['page']['title'];?></h2>
	<form class="form-horizontal form form-validate" id="form1" action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="op" value="<?php  echo $op;?>"/>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">直接连接</label>
			<div class="col-sm-9 col-xs-12">
				<p class="form-control-static">
					<a href="javascript:;" class="js-clip" data-href="<?php  echo $cover['url'];?>"><?php  echo $cover['url'];?></a>
				</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">关键词</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" name="keyword" value="<?php  echo $cover['keyword'];?>" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">封面标题</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" name="title" value="<?php  echo $cover['title'];?>" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">封面图片</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_form_field_image('thumb', $cover['thumb']);?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">封面描述</label>
			<div class="col-sm-9 col-xs-12">
				<textarea name="description" class="form-control" rows="3"><?php  echo $cover['description'];?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
			<div class="col-sm-9 col-xs-12">
				<div class="radio radio-inline">
					<input type="radio" value="1" name="status" id="status-1" <?php  if($cover['status'] == 1) { ?>checked<?php  } ?>>
					<label for="status-1">启用</label>
				</div>
				<div class="radio radio-inline">
					<input type="radio" value="0" name="status" id="status-0" <?php  if(!$cover['status']) { ?>checked<?php  } ?>>
					<label for="status-0">禁用</label>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-12">
			<input type="submit" value="提交" class="btn btn-primary">
		</div>
	</form>
</div>
<?php  include itemplate('public/footer', TEMPLATE_INCLUDEPATH);?>