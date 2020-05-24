<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:120:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/setting/couponactivity/index.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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

<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <?php echo build_heading(null, false); ?>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#user" data-toggle="tab">优惠券活动设置</a></li>
        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="user">
                <div class="box box-success">
                    <form id="reg-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="couponactivity/newperson">
                        <div class="panel-heading"><span class="heading-span">新人优惠券活动</span></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-1 control-label" style>可获得优惠券：</label>
                                <div class="col-sm-3">
                                    <select  id="c-coupons" data-rule="required" class="form-control" name="coupons">
                                        <option value="0" <?php if(in_array(($newcoupon['coupon_id']), explode(',',"0"))): ?>selected<?php endif; ?>>关闭活动</option>
                                        <?php if(is_array($coupons) || $coupons instanceof \think\Collection || $coupons instanceof \think\Paginator): if( count($coupons)==0 ) : echo "" ;else: foreach($coupons as $key=>$vo): ?>
                                        <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($newcoupon['coupon_id'])?$newcoupon['coupon_id']:explode(',',$newcoupon['coupon_id']))): ?>selected<?php endif; ?>><?php echo $vo['title']; ?>/<?php echo $vo['money']; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-1">活动背景图:</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input id="c-newpersonbg" data-rule="" class="form-control" size="50" name="newpersonbg" type="text" value="<?php echo isset($newcoupon['coupon_bg'])?$newcoupon['coupon_bg']: ''; ?>">
                                        <div class="input-group-addon no-border no-padding">
                                            <span><button type="button" id="plupload-newpersonbg" class="btn btn-danger plupload" data-input-id="c-newpersonbg" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-newpersonbg"><i class="fa fa-upload"></i> 上传</button></span>
                                            <span><button type="button" id="fachoose-newpersonbg" class="btn btn-primary fachoose" data-input-id="c-newpersonbg" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> 选择</button></span>
                                        </div>
                                        <span class="msg-box n-right" for="c-newpersonbg"></span>
                                    </div>
                                    <ul class="row list-inline plupload-preview" id="p-newpersonbg"></ul>
                                </div>
                                <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 379*625</span>

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
