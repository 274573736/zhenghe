<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:108:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/userinvite/index.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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

                                <style>
    /*.n-right .msg-wrap{right:10px;}*/
    .wauto{width:100%}
    .wat{width:auto}
    .box-success{box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);}
    /*.n-default .n-left, .n-default .n-right{margin-left:8px;}*/
    .heading-span{font-size:14px;font-weight: bold;}
</style>
<link href="/addons/make_speed/core/public//assets/plugins/color-picker/bootstrap-colorpicker.min.css" rel="stylesheet">


<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <?php echo build_heading(null, false); ?>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#user" data-toggle="tab">推荐邀请奖励</a></li>
        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="user">
                <div class="box box-success">
                    <form id="reg-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="userinvite/saveinvite">
                        <div class="panel-heading"><span class="heading-span">分享即得</span></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">分享好友可获得：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="share" value="<?php echo isset($results['users_invite']['share'])?$results['users_invite']['share']: ''; ?>">
                                        <div class="input-group-addon">元优惠券</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">满减：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="share_full" value="<?php echo isset($results['users_invite']['share_full'])?$results['users_invite']['share_full']: ''; ?>">
                                        <div class="input-group-addon">可使用</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label">优惠券期限天数：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="share_day" value="<?php echo isset($results['users_invite']['share_day'])?$results['users_invite']['share_day']: ''; ?>">
                                        <div class="input-group-addon">天</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">奖励次数上限：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="share_limit" value="<?php echo isset($results['users_invite']['share_limit'])?$results['users_invite']['share_limit']: ''; ?>">
                                        <div class="input-group-addon">次</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-heading"><span class="heading-span">邀请奖励</span></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">每邀请：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="person_num" value="<?php echo isset($results['users_invite']['person_num'])?$results['users_invite']['person_num']: ''; ?>">
                                        <div class="input-group-addon">人进入</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label">可获得奖励：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="person_price" value="<?php echo isset($results['users_invite']['person_price'])?$results['users_invite']['person_price']: ''; ?>">
                                        <div class="input-group-addon">元优惠券</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">满减：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="person_full" value="<?php echo isset($results['users_invite']['person_full'])?$results['users_invite']['person_full']: ''; ?>">
                                        <div class="input-group-addon">可使用</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label">优惠券期限天数：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="person_day" value="<?php echo isset($results['users_invite']['person_day'])?$results['users_invite']['person_day']: ''; ?>">
                                        <div class="input-group-addon">天</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">奖励次数上限：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="person_limit" value="<?php echo isset($results['users_invite']['person_limit'])?$results['users_invite']['person_limit']: ''; ?>">
                                        <div class="input-group-addon">次</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-heading"><span class="heading-span">推荐好友完成首单</span></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">每完成首单获得：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="first" value="<?php echo isset($results['users_invite']['first'])?$results['users_invite']['first']: ''; ?>">
                                        <div class="input-group-addon">元优惠券</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">满减：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="first_full" value="<?php echo isset($results['users_invite']['first_full'])?$results['users_invite']['first_full']: ''; ?>">
                                        <div class="input-group-addon">可使用</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label">优惠券期限天数：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="first_day" value="<?php echo isset($results['users_invite']['first_day'])?$results['users_invite']['first_day']: ''; ?>">
                                        <div class="input-group-addon">天</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">获得奖励上限：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="first_limit" value="<?php echo isset($results['users_invite']['first_limit'])?$results['users_invite']['first_limit']: ''; ?>">
                                        <div class="input-group-addon">次</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body">
                        <div class="form-group layer-footer">
                            <label class="control-label col-sm-1"></label>
                            <div class="col-sm-1">
                                <button type="submit" class="btn btn-success btn-embossed wauto"><?php echo __('OK'); ?></button>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/addons/make_speed/core/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/addons/make_speed/core/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>
