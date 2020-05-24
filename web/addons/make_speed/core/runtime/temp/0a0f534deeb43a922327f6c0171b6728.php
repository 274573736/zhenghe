<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:109:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/riderinvite/index.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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
    .box-success{box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);}
    /*.n-default .n-left, .n-default .n-right{margin-left:8px;}*/
</style>
<link href="/addons/make_speed/core/public//assets/plugins/color-picker/bootstrap-colorpicker.min.css" rel="stylesheet">


<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <?php echo build_heading(null, false); ?>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#rider" data-toggle="tab">推荐骑手</a></li>
            <li><a href="#user" data-toggle="tab">推荐用户</a></li>
        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">

            <div class="tab-pane fade in active" id="rider">
                <div class="box box-success">
                    <form id="reg-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="riderinvite/inviterider">
                        <!--<div class="panel-heading">推荐完成注册奖励</div>-->
                        <!--<div class="panel-body">-->
                            <!--<div class="form-group">-->
                                <!--<label class="col-sm-1 control-label">注册成功可获得：</label>-->
                                <!--<div class="col-sm-3">-->
                                    <!--<div class="input-group">-->
                                        <!--<input type="text" data-rule="" class="form-control" name="reg" value="<?php echo isset($results['rider_invite']['reg'])?$results['rider_invite']['reg']: ''; ?>">-->
                                        <!--<div class="input-group-addon">元/人</div>-->
                                    <!--</div>-->
                                <!--</div>-->
                            <!--</div>-->

                            <!--<div class="form-group">-->
                                <!--<label class="col-sm-1 control-label">获得奖励上限：</label>-->
                                <!--<div class="col-sm-3">-->
                                    <!--<div class="input-group">-->
                                        <!--<input type="text" data-rule="" class="form-control" name="reg_limit" value="<?php echo isset($results['rider_invite']['reg_limit'])?$results['rider_invite']['reg_limit']: ''; ?>">-->
                                        <!--<div class="input-group-addon">次</div>-->
                                    <!--</div>-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->

                        <!--<div class="panel-heading">推荐通过培训奖励</div>-->
                        <!--<div class="panel-body">-->
                            <!--<div class="form-group">-->
                                <!--<label class="col-sm-1 control-label">培训通过可获得：</label>-->
                                <!--<div class="col-sm-3">-->
                                    <!--<div class="input-group">-->
                                        <!--<input type="text" data-rule="" class="form-control" name="train" value="<?php echo isset($results['rider_invite']['train'])?$results['rider_invite']['train']: ''; ?>">-->
                                        <!--<div class="input-group-addon">元/人</div>-->
                                    <!--</div>-->
                                <!--</div>-->
                            <!--</div>-->

                            <!--<div class="form-group">-->
                                <!--<label class="col-sm-1 control-label">获得奖励上限：</label>-->
                                <!--<div class="col-sm-3">-->
                                    <!--<div class="input-group">-->
                                        <!--<input type="text" data-rule="" class="form-control" name="train_limit" value="<?php echo isset($results['rider_invite']['train_limit'])?$results['rider_invite']['train_limit']: ''; ?>">-->
                                        <!--<div class="input-group-addon">次</div>-->
                                    <!--</div>-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->

                        <div class="panel-heading">推荐骑手完成接单次数奖励</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">完成单数：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_total[0]" value="<?php echo isset($results['rider_invite']['buy_total'][0])?$results['rider_invite']['buy_total'][0]: ''; ?>">
                                        <div class="input-group-addon">单</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">获得奖励：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_reward[0]" value="<?php echo isset($results['rider_invite']['buy_reward'][0])?$results['rider_invite']['buy_reward'][0]: ''; ?>">
                                        <div class="input-group-addon">元</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label">完成单数：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_total[1]" value="<?php echo isset($results['rider_invite']['buy_total'][1])?$results['rider_invite']['buy_total'][1]: ''; ?>">
                                        <div class="input-group-addon">单</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">获得奖励：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_reward[1]" value="<?php echo isset($results['rider_invite']['buy_reward'][1])?$results['rider_invite']['buy_reward'][1]: ''; ?>">
                                        <div class="input-group-addon">元</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label">完成单数：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_total[2]" value="<?php echo isset($results['rider_invite']['buy_total'][2])?$results['rider_invite']['buy_total'][2]: ''; ?>">
                                        <div class="input-group-addon">单</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">获得奖励：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_reward[2]" value="<?php echo isset($results['rider_invite']['buy_reward'][2])?$results['rider_invite']['buy_reward'][2]: ''; ?>">
                                        <div class="input-group-addon">元</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label">完成单数：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_total[3]" value="<?php echo isset($results['rider_invite']['buy_total'][3])?$results['rider_invite']['buy_total'][3]: ''; ?>">
                                        <div class="input-group-addon">单</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">获得奖励：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_reward[3]" value="<?php echo isset($results['rider_invite']['buy_reward'][3])?$results['rider_invite']['buy_reward'][3]: ''; ?>">
                                        <div class="input-group-addon">元</div>
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

            <div class="tab-pane fade" id="user">
                <div class="box box-success">
                    <form id="user-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="riderinvite/userinvite">
                        <div class="panel-heading">
                            邀请用户首次进入
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">授权进入可获得：</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="user" value="<?php echo isset($results['user_invite']['reg'])?$results['user_invite']['reg']: ''; ?>">
                                        <div class="input-group-addon">元/人</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label">获得奖励上限：</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="user_limit" value="<?php echo isset($results['user_invite']['reg_limit'])?$results['user_invite']['reg_limit']: ''; ?>">
                                        <div class="input-group-addon">次</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-heading">
                            邀请用户完成首单
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">首次下单可获得：</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="userone" value="<?php echo isset($results['user_invite']['userone'])?$results['user_invite']['userone']: ''; ?>">
                                        <div class="input-group-addon">元/人</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label">获得奖励上限：</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="userone_limit" value="<?php echo isset($results['user_invite']['userone_limit'])?$results['user_invite']['userone_limit']: ''; ?>">
                                        <div class="input-group-addon">次</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-heading">推荐用户下单次数奖励</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">完成下单数：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_total[0]" value="<?php echo isset($results['user_invite']['buy_total'][0])?$results['user_invite']['buy_total'][0]: ''; ?>">
                                        <div class="input-group-addon">单</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">获得奖励：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_reward[0]" value="<?php echo isset($results['user_invite']['buy_reward'][0])?$results['user_invite']['buy_reward'][0]: ''; ?>">
                                        <div class="input-group-addon">元</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label">完成下单数：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_total[1]" value="<?php echo isset($results['user_invite']['buy_total'][1])?$results['user_invite']['buy_total'][1]: ''; ?>">
                                        <div class="input-group-addon">单</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">获得奖励：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_reward[1]" value="<?php echo isset($results['user_invite']['buy_reward'][1])?$results['user_invite']['buy_reward'][1]: ''; ?>">
                                        <div class="input-group-addon">元</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label">完成下单数：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_total[2]" value="<?php echo isset($results['user_invite']['buy_total'][2])?$results['user_invite']['buy_total'][2]: ''; ?>">
                                        <div class="input-group-addon">单</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">获得奖励：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_reward[2]" value="<?php echo isset($results['user_invite']['buy_reward'][2])?$results['user_invite']['buy_reward'][2]: ''; ?>">
                                        <div class="input-group-addon">元</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label">完成下单数：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_total[3]" value="<?php echo isset($results['user_invite']['buy_total'][3])?$results['user_invite']['buy_total'][3]: ''; ?>">
                                        <div class="input-group-addon">单</div>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">获得奖励：</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" data-rule="" class="form-control" name="buy_reward[3]" value="<?php echo isset($results['user_invite']['buy_reward'][3])?$results['user_invite']['buy_reward'][3]: ''; ?>">
                                        <div class="input-group-addon">元</div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="form-group layer-footer">
                                    <label class="control-label col-sm-1"></label>
                                    <div class="col-xs-12 col-sm-1">
                                        <button type="submit" class="btn btn-success btn-embossed wauto"><?php echo __('OK'); ?></button>
                                        <!--<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>-->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<!--<script src="/addons/make_speed/core/public//assets/plugins/ueditor/ueditor.config.js"></script>-->
<!--<script src="/addons/make_speed/core/public//assets/plugins/ueditor/ueditor.all.min.js"></script>-->
<script src="/addons/make_speed/core/public//assets/libs/jquery/dist/jquery.min.js" type="text/javascript"></script>

<!-- 实例化编辑器 -->
<script type="text/javascript">

    function add_question() {
        var html = '<div class="form-group question">\n' +
            '                        <label class="col-sm-1 control-label">常用问题：</label>\n' +
            '                        <div class="col-sm-3">\n' +
            '                            <input type="text" data-rule="" class="form-control" name="question_title[]" value="<?php echo isset($result['question_title'])?$result['question_title']: ''; ?>">\n' +
            '                        </div>\n' +
            '                        <label class="col-sm-1 control-label wauto">问题解答</label>\n' +
            '                        <div class="col-sm-5">\n' +
            '                            <textarea class="form-control" name="question[]" style="resize: none;"></textarea>\n' +
            '                        </div>\n' +
            '                    </div>';

        $('#service-form .question:eq(0)').before(html);
    }
</script>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/addons/make_speed/core/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/addons/make_speed/core/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>
