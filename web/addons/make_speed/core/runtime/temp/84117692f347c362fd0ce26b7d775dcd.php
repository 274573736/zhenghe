<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:117:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/distribution/config/index.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:106:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/distribution/config/base.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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
</style>


<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <?php echo build_heading(null, false); ?>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#base" data-toggle="tab">基本配置</a></li>
            <li><a href="#agreement" data-toggle="tab">分销协议</a></li>
        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="base">
                <form id="base-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="distribution/config/base">
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">分销开关:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo build_radios('row[d_switch]', ['0'=>'关', '1'=>'开'], isset($result['d_switch']) ? $result['d_switch'] : 0); ?>
        </div>
        <span class="help-block"></span>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">自定义名称:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo Form::input('text','row[distribution_name]', isset($result['distribution_name']) ? $result['distribution_name'] : '推广员' ); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>用户端个人中心自定义分销名称</span>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">佣金计算:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo build_radios('row[d_count_commission_type]', ['1'=>'支付金额', '2'=>'平台抽佣'], isset($result['d_count_commission_type']) ? $result['d_count_commission_type'] : 1); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>默认订单支付金额</span>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">分销层级:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo build_radios('row[d_tier]', ['1'=>'一级', '2'=>'二级','3'=>'三级'], isset($result['d_tier']) ? $result['d_tier'] : 2); ?>
        </div>
        <span class="help-block"></span>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">分销内购:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo build_radios('row[d_iap]', ['0'=>'关闭', '1'=>'开启'], isset($result['d_iap']) ? $result['d_iap'] : 0); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>
            开启分销内购，分销商自己享受一级佣金，上级享受二级佣金，上上级享受三级佣金，默认关闭
        </span>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">成为分销商是否审核:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo build_radios('row[d_audit]', [ '1'=>'需要','0'=>'不需要'], isset($result['d_audit']) ? $result['d_audit'] : 1); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>
            默认需要
        </span>
    </div>

    <hr>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">提现方式:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo Form::selectpickers("row[d_commission_type][]", [1=>'微信钱包',2=>'支付宝',3=>'银行卡'],explode(',',$result['d_commission_type']),['data-rule'=>'require'] ); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>
            默认全开
        </span>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">最低提现金额:</label>
        <div class="col-xs-12 col-sm-2">
            <div class="input-group">
                <input type="number" data-rule="require" class="form-control" name="row[d_mini_amount]" value="<?php echo isset($result['d_mini_amount'])?$result['d_mini_amount']: 1; ?>">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>
            默认最低一元
        </span>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">提现手续费:</label>
        <div class="col-xs-12 col-sm-2">
            <div class="input-group">
                <input type="number" data-rule="require" class="form-control" name="row[d_commission_charge]" value="<?php echo isset($result['d_commission_charge'])?$result['d_commission_charge']: 1; ?>">
                <div class="input-group-addon">%</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>
            默认1%
        </span>
    </div>
    <hr>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">分销等级升级依据:</label>
        <div class="col-xs-12 col-sm-10">
            <?php echo build_radios('row[d_grade]', ['0'=>'分销订单总额(完成的订单)', '1'=>'分销订单总数(完成的订单)','2'=>'分销商下线人数'], isset($result['d_grade']) ? $result['d_grade'] : 0); ?>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">申请页图片:</label>
        <div class="col-xs-12 col-sm-2">
            <div class="input-group">
                <input id="c-img" class="form-control form-control" data-rule="required" size="50" name="row[d_img]" type="text" value="<?php echo isset($result['d_img'])?$result['d_img']: ''; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-img" class="btn btn-danger plupload" data-input-id="c-img" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-img"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-img" class="btn btn-primary fachoose" data-input-id="c-img" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-img"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-img"></ul>
        </div>
        <!--        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小</span>-->
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
        </div>
    </div>
</form>
            </div>
            <div class="tab-pane fade" id="agreement">
                <form id="agreement-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="distribution/config/base">
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2">协议内容:</label>
                        <div class="col-xs-12 col-sm-10">
                            <?php echo Form::editor('row[d_agreement]',isset($result['d_agreement']) ? $result['d_agreement'] :'' ); ?>
                        </div>
                    </div>
                    <div class="form-group layer-footer">
                        <label class="control-label col-xs-12 col-sm-2"></label>
                        <div class="col-xs-12 col-sm-8">
                            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
                            <!--<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>-->
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

        <script src="/addons/make_speed/core/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/addons/make_speed/core/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>
