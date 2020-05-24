<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:108:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/person/user/edit.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/addons/make_speed/core/public/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/addons/make_speed/core/public/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/addons/make_speed/core/public/assets/js/html5shiv.js"></script>
  <script src="/addons/make_speed/core/public/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <style>
.bella-checkbox{
    position: relative;
}
/** 将初始的checkbox的样式改变 */
.bella-checkbox input[type="checkbox"] {
    opacity: 0; /*将初始的checkbox隐藏起来*/
}

/** 设计新的checkbox，位置 */
.bella-checkbox label:before {
    content: '';
    width: 19px;
    height: 19px;
    display: inline-block;
    border-radius: 2px;
    border: 1px solid #bbb;
    background: #fff;
}

/** 点击初始的checkbox，将新的checkbox关联起来 */
.bella-checkbox input[type="checkbox"]:checked + label:after {
    display: inline-block;
    font-family: 'Glyphicons Halflings';
    content: "\e013";
    top: 15%;
    left: 10%;
    position: absolute;
    font-size: 11px;
    line-height: 1;
    width: 16px;
    height: 16px;
    color: #333;
}

.bella-checkbox label {
    cursor: pointer;
    text-align: center;
    position: absolute;
    left: 10px;
}
</style>

                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Nick_name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-nick_name" data-rule="" class="form-control form-control" name="row[nick_name]" type="text" value="<?php echo $row['nick_name']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Real_name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-real_name" data-rule="" class="form-control form-control" name="row[real_name]" type="text" value="<?php echo $row['real_name']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Mobile'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-mobile" data-rule="" class="form-control form-control" name="row[mobile]" type="text" value="<?php echo $row['mobile']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Sex'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select  id="c-sex" data-rule="required" class="form-control selectpicker" name="row[sex]">
                <?php if(is_array($sexList) || $sexList instanceof \think\Collection || $sexList instanceof \think\Paginator): if( count($sexList)==0 ) : echo "" ;else: foreach($sexList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['sex'])?$row['sex']:explode(',',$row['sex']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">是否拉入黑名单:</label>
        <div class="col-xs-12 col-sm-8">
            <select  id="c-blacklist" data-rule="required" class="form-control selectpicker" name="row[blacklist]">
                <option value="0" <?php if(in_array(($row['blacklist']), explode(',',"0"))): ?>selected<?php endif; ?>>否</option>
                <option value="1" <?php if(in_array(($row['blacklist']), explode(',',"1"))): ?>selected<?php endif; ?>>是</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Qq'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-qq" data-rule="" class="form-control form-control" name="row[qq]" type="text" value="<?php echo $row['qq']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Email'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-email" data-rule="" class="form-control form-control" name="row[email]" type="text" value="<?php echo $row['email']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Avatar'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-avatar" data-rule="" class="form-control form-control" size="50" name="row[avatar]" type="text" value="<?php echo $row['avatar']; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-avatar" class="btn btn-danger plupload" data-input-id="c-avatar" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-avatar"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-avatar" class="btn btn-primary fachoose" data-input-id="c-avatar" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-avatar"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-avatar"></ul>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('User_grade'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select  id="c-user_grade" data-rule="required" class="form-control selectpicker" name="row[user_grade]">
                <?php if(is_array($gradeList) || $gradeList instanceof \think\Collection || $gradeList instanceof \think\Paginator): if( count($gradeList)==0 ) : echo "" ;else: foreach($gradeList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['user_grade'])?$row['user_grade']:explode(',',$row['user_grade']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Invalid'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-invalid" data-rule="required" class="form-control form-control" step="0.01" name="row[invalid]" type="number" value="<?php echo $row['invalid']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Valid'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-valid" data-rule="required" class="form-control form-control" step="0.01" name="row[valid]" type="number" value="<?php echo $row['valid']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Gral'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-gral" data-rule="required" class="form-control form-control" step="0.01" name="row[gral]" type="number" value="<?php echo $row['gral']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Add_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <!--<input id="c-add_time" data-rule="required" class="form-control datetimepicker form-control" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[add_time]" type="text" value="<?php echo datetime($row['add_time']); ?>">-->
            <span id="c-add_time" class="form-control  form-control" ><?php echo datetime($row['add_time']); ?></span>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Logged_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <!--<input id="c-logged_time" data-rule="required" class="form-control datetimepicker form-control" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[logged_time]" type="text" value="<?php echo datetime($row['logged_time']); ?>">-->
            <span id="c-logged_time" class="form-control  form-control" ><?php echo !empty($row['logged_time'])?datetime($row['logged_time']) : ''; ?></span>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Logged_ip'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <!--<input id="c-logged_ip" data-rule="" class="form-control form-control" name="row[logged_ip]" type="text" value="<?php echo $row['logged_ip']; ?>">-->
            <span id="c-logged_ip" class="form-control  form-control" ><?php echo $row['logged_ip']; ?></span>
        </div>
    </div>

    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/addons/make_speed/core/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/addons/make_speed/core/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>
