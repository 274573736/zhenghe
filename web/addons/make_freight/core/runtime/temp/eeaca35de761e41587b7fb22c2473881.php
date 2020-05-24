<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:109:"/www/wwwroot/linux.henan863.cn/addons/make_freight/core/public/../application/admin/view/base/banner/add.html";i:1562722760;s:98:"/www/wwwroot/linux.henan863.cn/addons/make_freight/core/application/admin/view/layout/default.html";i:1562722712;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_freight/core/application/admin/view/common/meta.html";i:1562722738;s:97:"/www/wwwroot/linux.henan863.cn/addons/make_freight/core/application/admin/view/common/script.html";i:1562722738;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/addons/make_freight/core/public/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/addons/make_freight/core/public/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/addons/make_freight/core/public/assets/js/html5shiv.js"></script>
  <script src="/addons/make_freight/core/public/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
        input[type="number"]{
            -moz-appearance: textfield;
        }
    </style>
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
                                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">跳转:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="radio">
                <label id="page">
                    <input  name="row[type]" type="radio" value="1" checked /> 小程序页面
                </label>
                <label id="select_app">
                    <input  name="row[type]" type="radio" value="2"  /> 小程序
                </label>
            </div>
        </div>
    </div>
    <div class="form-group" id="select_page">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Url'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select class="form-control" name="row[url]" id="select_name">
                <option value="no">不跳转</option>
                <?php foreach($paths as $k=>$v): ?>
                <option value="<?php echo $v; ?>"><?php echo $k; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group hide" id="appid">
        <label class="control-label col-xs-12 col-sm-2">跳转小程序APPID:</label>
        <div class="col-xs-12 col-sm-8">
            <input  data-rule="required" class="form-control" name="row[appid]" type="text" data-tip="设置后需要重新上传小程序审核并在微擎上添加APPID">
        </div>
    </div>
    <div class="form-group hide"  id="pages">
        <label class="control-label col-xs-12 col-sm-2">跳转的小程序页面:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="jump_page" class="form-control" name="row[app_url]" type="text" data-tip="小程序页面路径，不填则默认跳到首页">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Image'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-image" data-rule="required" class="form-control" size="50" name="row[image]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-image" class="btn btn-danger plupload" data-input-id="c-image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-image" class="btn btn-primary fachoose" data-input-id="c-image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-image"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-image"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Sort'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-sort" data-rule="required" class="form-control" name="row[sort]" type="number" data-tip="数值越大越靠前">
        </div>
    </div>


    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Show_switch'); ?>:</label>
        <div class="col-xs-12 col-sm-8">

            <div class="radio">

                <label >
                    <input  name="row[show_switch]" type="radio" value="0" checked /> 隐藏
                </label>
                <label >
                    <input  name="row[show_switch]" type="radio" value="1" checked /> 显示
                </label>
            </div>

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
        <script src="/addons/make_freight/core/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/addons/make_freight/core/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>