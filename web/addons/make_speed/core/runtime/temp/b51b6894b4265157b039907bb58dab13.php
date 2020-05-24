<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:112:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/rideragreement/index.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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
    .wauto{width:auto}
    /*.n-default .n-left, .n-default .n-right{margin-left:8px;}*/
</style>
<link href="/addons/make_speed/core/public//assets/plugins/color-picker/bootstrap-colorpicker.min.css" rel="stylesheet">


<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <?php echo build_heading(null, false); ?>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#service" data-toggle="tab">客服帮助</a></li>
            <li><a href="#account" data-toggle="tab">账户说明</a></li>
            <li><a href="#bean" data-toggle="tab">服务分说明</a></li>
            <li><a href="#cooperate" data-toggle="tab">合作协议</a></li>
            <li><a href="#activity" data-toggle="tab">分享活动说明</a></li>

        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">

            <div class="tab-pane fade in active" id="service">
                <form id="service-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="rideragreement/service">

                    <div class="form-group">
                        <label class="col-sm-1 control-label">咨询电话：</label>
                        <div class="col-sm-2">
                            <input type="text" data-rule="" class="form-control" name="phone" value="<?php echo isset($results['rider_service']['phone'])?$results['rider_service']['phone']: ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label">咨询时间：</label>
                        <div class="col-sm-2">
                            <input type="text" data-rule="" class="form-control" name="time" value="<?php echo isset($results['rider_service']['time'])?$results['rider_service']['time']: ''; ?>">
                        </div>
                    </div>

                    <?php if(!(empty($results['rider_service']['question']) || (($results['rider_service']['question'] instanceof \think\Collection || $results['rider_service']['question'] instanceof \think\Paginator ) && $results['rider_service']['question']->isEmpty()))): if(is_array($results['rider_service']['question']) || $results['rider_service']['question'] instanceof \think\Collection || $results['rider_service']['question'] instanceof \think\Paginator): if( count($results['rider_service']['question'])==0 ) : echo "" ;else: foreach($results['rider_service']['question'] as $key=>$vo): ?>
                    <div class="form-group question">
                        <label class="col-sm-1 control-label">常用问题：</label>
                        <div class="col-sm-3">
                            <input type="text" data-rule="" class="form-control" name="question_title[]" value="<?php echo isset($vo['title'])?$vo['title']: ''; ?>">
                        </div>
                        <label class="col-sm-1 control-label wauto">问题解答</label>
                        <div class="col-sm-5">
                            <textarea class="form-control" name="question[]" style="resize: none;"><?php echo isset($vo['content'])?$vo['content']: ''; ?></textarea>
                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; else: ?>
                    <div class="form-group question">
                        <label class="col-sm-1 control-label">常用问题：</label>
                        <div class="col-sm-3">
                            <input type="text" data-rule="" class="form-control" name="question_title[]" value="">
                        </div>
                        <label class="col-sm-1 control-label wauto">问题解答</label>
                        <div class="col-sm-5">
                            <textarea class="form-control" name="question[]" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label class="col-sm-1 control-label"></label>
                        <div class="col-sm-3">
                        </div>
                        <label class="col-sm-1 control-label wauto" style='color:#fff'>添加按钮</label>
                        <div class="col-sm-4">
                            <a href="javascript:add_question();" class="btn btn-success btn-add add_question" title="添加"><i class="fa fa-plus"></i>添加问答</a>
                        </div>
                    </div>

                    <div class="form-group layer-footer">
                        <label class="control-label col-xs-12"></label>
                        <div class="col-xs-12 col-sm-8">
                            <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
                            <!-- <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>-->
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="account">
                <form id="account-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="rideragreement/account">
                    <div class="form-group" style="padding: 20px">
                        <textarea class="form-control editor" name="rider_account"><?php echo isset($results['rider_account'])?$results['rider_account']: ''; ?></textarea>
                    </div>

                    <div class="form-group layer-footer">
                        <label class="control-label col-xs-12"></label>
                        <div class="col-xs-12 col-sm-8">
                            <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
                            <!--<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>-->
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="bean">
                <form id="bean-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="rideragreement/bean">
                    <div class="form-group" style="padding: 20px">
                        <textarea class="form-control editor" name="rider_bean"><?php echo isset($results['rider_bean'])?$results['rider_bean']: ''; ?></textarea>
                    </div>

                    <div class="form-group layer-footer">
                        <label class="control-label col-xs-12"></label>
                        <div class="col-xs-12 col-sm-8">
                        <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
                        <!--<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>-->
                    </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="cooperate">
                <form id="cooperate-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="rideragreement/cooperate">
                    <div class="form-group" style="padding: 20px">
                        <textarea class="form-control editor" name="rider_cooperate"><?php echo isset($results['rider_cooperate'])?$results['rider_cooperate']: ''; ?></textarea>
                    </div>

                    <div class="form-group layer-footer">
                        <label class="control-label col-xs-12"></label>
                        <div class="col-xs-12 col-sm-8">
                            <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
                            <!--<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>-->
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="activity">
                <form id="activity-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="rideragreement/activity">
                    <div class="form-group" style="padding: 20px">
                        <textarea class="form-control editor" name="rider_activity"><?php echo isset($results['rider_activity'])?$results['rider_activity']: ''; ?></textarea>
                    </div>

                    <div class="form-group layer-footer">
                        <label class="control-label col-xs-12"></label>
                        <div class="col-xs-12 col-sm-8">
                            <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
                            <!--<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>-->
                        </div>
                    </div>
                </form>
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
