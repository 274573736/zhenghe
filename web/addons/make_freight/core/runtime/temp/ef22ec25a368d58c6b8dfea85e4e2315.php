<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:116:"/www/wwwroot/linux.henan863.cn/addons/make_freight/core/public/../application/admin/view/driver/driver_list/add.html";i:1563413614;s:98:"/www/wwwroot/linux.henan863.cn/addons/make_freight/core/application/admin/view/layout/default.html";i:1562722712;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_freight/core/application/admin/view/common/meta.html";i:1562722738;s:97:"/www/wwwroot/linux.henan863.cn/addons/make_freight/core/application/admin/view/common/script.html";i:1562722738;}*/ ?>
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
        <label class="control-label col-xs-12 col-sm-2">绑定用户:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-user_id" data-rule="required" data-field="nick_name"	data-source="user/users/index" class="form-control selectpage" name="row[user_id]" type="text" value="" placeholder="可输入微信昵称搜索">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">绑定车型:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-car_id" data-rule="required" data-field="title"	data-source="vehicle/index" class="form-control selectpage" name="row[car_id]" type="text" value="" placeholder="请选择车型">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Driver_name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-driver_name" data-rule="required" class="form-control" name="row[driver_name]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Driver_phone'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-driver_phone" data-rule="required" class="form-control" name="row[driver_phone]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Plate_number'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-plate_number" data-rule="required" class="form-control" name="row[plate_number]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Driver_idcard'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-driver_IDcard" data-rule="required" class="form-control" name="row[driver_IDcard]" type="text">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Front_idcard_image'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-front_IDcard_image" data-rule="required" class="form-control" size="50" name="row[front_IDcard_image]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-front_IDcard_image" class="btn btn-danger plupload" data-input-id="c-front_IDcard_image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-front_IDcard_image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-front_IDcard_image" class="btn btn-primary fachoose" data-input-id="c-front_IDcard_image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-front_IDcard_image"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-front_IDcard_image"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Contrary_idcard__image'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-contrary_IDcard_image" data-rule="required" class="form-control" size="50" name="row[contrary_IDcard_image]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-contrary_IDcard_image" class="btn btn-danger plupload" data-input-id="c-contrary_IDcard_image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-contrary_IDcard_image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-contrary_IDcard_image" class="btn btn-primary fachoose" data-input-id="c-contrary_IDcard_image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-contrary_IDcard_image"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-contrary_IDcard_image"></ul>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Car_image'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-car_image" data-rule="required" class="form-control" size="50" name="row[car_image]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-car_image" class="btn btn-danger plupload" data-input-id="c-car_image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-car_image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-car_image" class="btn btn-primary fachoose" data-input-id="c-car_image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-car_image"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-car_image"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Photo'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-photo" data-rule="required" class="form-control" size="50" name="row[photo]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-photo" class="btn btn-danger plupload" data-input-id="c-photo" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-photo"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-photo" class="btn btn-primary fachoose" data-input-id="c-photo" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-photo"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-photo"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Drivers_license'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <!--<input id="c-drivers_license" data-rule="required" class="form-control" name="row[drivers_license]" type="text">-->
            <div class="input-group">
                <input id="c-drivers_license" data-rule="required" class="form-control" size="50" name="row[drivers_license]" type="text">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-drivers_license" class="btn btn-danger plupload" data-input-id="c-drivers_license" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-drivers_license"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-drivers_license" class="btn btn-primary fachoose" data-input-id="c-drivers_license" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-photo"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-drivers_license"></ul>
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