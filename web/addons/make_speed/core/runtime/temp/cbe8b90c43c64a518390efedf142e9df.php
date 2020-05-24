<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:112:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/busines/business/add.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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
.address-search-text{
    width:56%;height:7%;margin: 1%;float:left;
}
.address-search-btn{
    width:15%;height:7%;margin: 1%;
}

</style>
<form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('User_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-user_id" data-rule="required" data-source="person/user/index" data-field="id|nick_name" data-and-or='or'  data-order-by="id DESC" class="form-control selectpage form-control" name="row[user_id]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name" data-rule="required" class="form-control form-control" name="row[name]" type="text" value="">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Phone'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-phone" data-rule="required" class="form-control form-control" name="row[phone]" type="text" value="">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">对接店铺ID:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-shop_id" class="form-control form-control" name="row[shop_id]" type="text" value="" placeholder="无对接则留空">
        </div>
    </div>

    <?php if(empty($GLOBALS['city_id']) || (($GLOBALS['city_id'] instanceof \think\Collection || $GLOBALS['city_id'] instanceof \think\Paginator ) && $GLOBALS['city_id']->isEmpty())): ?>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">所属城市:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-city_id" data-rule="required" data-source="city/index" class="form-control selectpage form-control" name="row[city_id]" type="text" value="">
        </div>
    </div>
    <?php endif; ?>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Address'); ?>:</label>
        <div class="col-xs-12 col-sm-6">
            <input id="c-address" data-rule="required" class="form-control form-control" name="row[address]" type="text" value="">
            <input id="c-lng" data-rule="" class="form-control" name="row[lat]" type="hidden" value="">
            <input id="c-lat" data-rule="" class="form-control" name="row[lng]" type="hidden" value="">
        </div>
        <div class="col-xs-12 col-sm-2">
            <button class="btn btn-success" id="get-address" style="width:100%">选择地址</button>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('License_img1'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-license_img1" data-rule="required" class="form-control form-control" size="50" name="row[license_img1]" type="text" value="">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-license_img1" class="btn btn-danger plupload" data-input-id="c-license_img1" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-license_img1"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-license_img1" class="btn btn-primary fachoose" data-input-id="c-license_img1" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-license_img1"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-license_img1"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('License_img2'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-license_img2" data-rule="required" class="form-control form-control" size="50" name="row[license_img2]" type="text" value="">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-license_img2" class="btn btn-danger plupload" data-input-id="c-license_img2" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-license_img2"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-license_img2" class="btn btn-primary fachoose" data-input-id="c-license_img2" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-license_img2"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-license_img2"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Imgs'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-imgs" data-rule="required" class="form-control form-control" size="50" name="row[imgs]" type="text" value="">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-imgs" class="btn btn-danger plupload" data-input-id="c-imgs" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="true" data-preview-id="p-imgs"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-imgs" class="btn btn-primary fachoose" data-input-id="c-imgs" data-mimetype="image/*" data-multiple="true"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-imgs"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-imgs"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Valid'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-valid" data-rule="required" class="form-control form-control" step="0.01" name="row[valid]" type="number" value="0.00">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <select  id="c-status" data-rule="required" class="form-control selectpicker" name="row[status]">
                <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
                <option value="<?php echo $key; ?>" ><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
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

<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=<?php echo $mapkey; ?>"></script>
<script>var upload_img_url = "/addons/make_speed/core/public//uploads/program_icon/";</script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/addons/make_speed/core/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/addons/make_speed/core/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>
