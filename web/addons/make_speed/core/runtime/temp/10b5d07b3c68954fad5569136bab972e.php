<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:107:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/agreement/index.html";i:1586139900;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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

    /*.n-default .n-left, .n-default .n-right{margin-left:8px;}*/
</style>
<link href="/addons/make_speed/core/public//assets/plugins/color-picker/bootstrap-colorpicker.min.css" rel="stylesheet">


<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <?php echo build_heading(null, false); ?>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#user" data-toggle="tab">用户协议</a></li>
            <li><a href="#recharge" data-toggle="tab">充值协议</a></li>
            <li><a href="#newperson" data-toggle="tab">新人红包活动规则</a></li>
            <li><a href="#price" data-toggle="tab">价格说明</a></li>
            <li><a href="#cancel" data-toggle="tab">取消订单说明</a></li>
            <li><a href="#helper" data-toggle="tab">疑问帮助</a></li>
            <li><a href="#invite" data-toggle="tab">邀请好友奖励发放规则</a></li>
        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">

            <div class="tab-pane fade in active" id="user">
                <form id="user-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="agreement/user">
                    <div class="form-group" style="padding: 20px">
                        <textarea class="form-control editor" name="user_content"><?php echo isset($results['user_agreement'])?$results['user_agreement']: ''; ?></textarea>
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
<div style="color: red !important;"></div>
            <div class="tab-pane fade" id="newperson">
                <form id="new-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="agreement/redbao">
                    <div class="form-group" style="padding: 20px">
                        <textarea class="form-control editor" name="redbao_content"><?php echo isset($results['user_redbao'])?$results['user_redbao']: ''; ?></textarea>

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

            <div class="tab-pane fade" id="recharge">
                <form id="re-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="agreement/recharge">
                    <div class="form-group" style="padding: 20px">
                        <textarea class="form-control editor" name="user_recharge"><?php echo isset($results['user_recharge'])?$results['user_recharge']: ''; ?></textarea>

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

            <div class="tab-pane fade" id="price">
                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="agreement/price">
                    <div class="form-group" style="padding: 20px">
                            <textarea class="form-control editor" name="price_content"><?php echo isset($results['user_price'])?$results['user_price']: ''; ?></textarea>
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

            <div class="tab-pane fade" id="cancel">
                <form id="cancel-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="agreement/cancel">
                    <div class="form-group" style="padding: 20px">
                        <textarea class="form-control editor" name="cancel_content"><?php echo isset($results['user_cancel'])?$results['user_cancel']: ''; ?></textarea>
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

            <div class="tab-pane fade" id="helper">
                <form id="helper-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="agreement/helper">

                        <div class="form-group">
                        <label class="col-sm-1 control-label">咨询电话：</label>
                    <div class="col-sm-2">
                        <input type="text" data-rule="" class="form-control" name="phone" value="<?php echo isset($results['user_helper']['phone'])?$results['user_helper']['phone']: ''; ?>">
                        </div>
                        </div>

                        <div class="form-group">
                        <label class="col-sm-1 control-label">咨询时间：</label>
                    <div class="col-sm-2">
                        <input type="text" data-rule="" class="form-control" name="time" value="<?php echo isset($results['user_helper']['time'])?$results['user_helper']['time']: ''; ?>">
                        </div>
                        </div>
                    <?php if(!(empty($results['user_helper']['question']) || (($results['user_helper']['question'] instanceof \think\Collection || $results['user_helper']['question'] instanceof \think\Paginator ) && $results['user_helper']['question']->isEmpty()))): if(is_array($results['user_helper']['question']) || $results['user_helper']['question'] instanceof \think\Collection || $results['user_helper']['question'] instanceof \think\Paginator): if( count($results['user_helper']['question'])==0 ) : echo "" ;else: foreach($results['user_helper']['question'] as $key=>$vo): ?>
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
                            <!--<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>-->
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="invite">
                <form id="invite-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="agreement/invitetxt">
                    <div class="form-group" style="padding: 20px">
                        <textarea class="form-control editor" name="user_invite_txt"><?php echo isset($results['user_invite_txt'])?$results['user_invite_txt']: ''; ?></textarea>
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
        console.log('添加');
        $('#helper-form .question:eq(0)').before(html);
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
