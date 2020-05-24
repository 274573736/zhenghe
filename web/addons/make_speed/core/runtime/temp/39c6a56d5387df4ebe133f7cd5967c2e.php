<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:113:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/busines/setting/index.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:101:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/busines/setting/ele.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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

<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <?php echo build_heading(null, false); ?>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#base" data-toggle="tab">基本设置</a></li>
            <li><a href="#hezuo" data-toggle="tab">合作协议</a></li>
            <li><a href="#koukuan" data-toggle="tab">扣款协议</a></li>
            <li><a href="#eleme" data-toggle="tab">饿了么设置</a></li>
        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">

            <div class="tab-pane fade in active" id="base">

            <form id="program-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="setting/add">

                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-2">是否启用大客户快速下单:</label>
                    <div class="col-xs-12 col-sm-8">
                        <?php echo build_radios('business_switch', ['0'=>'关', '1'=>'开'], !empty($result['business_switch']) ? $result['business_switch'] : ''); ?>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2 control-label">充值最低金额：</label>
                    <div class="col-sm-3">
                        <input type="text" data-rule="" class="form-control" name="business_recharge" value="<?php echo isset($result['business_recharge'])?$result['business_recharge']: ''; ?>">
                    </div>
                    <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>大客户每次充值账户的最低金额</span>
                </div>

                <div class="form-group">
                    <label for="c-avatar" class="control-label col-xs-12 col-sm-2">一键下单宣传图:</label>
                    <div class="col-xs-12 col-sm-3">
                        <div class="input-group">
                            <input id="c-business_poster1" data-rule="" class="form-control" size="50" name="business_poster1" type="text" value="<?php echo isset($result['business_poster'][0])?$result['business_poster'][0]: ''; ?>">
                            <div class="input-group-addon no-border no-padding">
                                <span><button type="button" id="plupload-business_poster1" class="btn btn-success plupload" data-input-id="c-business_poster1" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-business_poster1"><i class="fa fa-upload"></i> 上传</button></span>
                            </div>
                            <span class="msg-box n-right" for="c-business_poster1"></span>
                        </div>
                        <ul class="row list-inline plupload-preview" id="p-business_poster1"></ul>
                    </div>
                    <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 670*400</span>
                </div>

                <div class="form-group">
                    <label for="c-avatar" class="control-label col-xs-12 col-sm-2">更多优惠宣传图:</label>
                    <div class="col-xs-12 col-sm-3">
                        <div class="input-group">
                            <input id="c-business_poster2" data-rule="" class="form-control" size="50" name="business_poster2" type="text" value="<?php echo isset($result['business_poster'][1])?$result['business_poster'][1]: ''; ?>">
                            <div class="input-group-addon no-border no-padding">
                                <span><button type="button" id="plupload-usershare" class="btn btn-success plupload" data-input-id="c-business_poster2" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-business_poster2"><i class="fa fa-upload"></i> 上传</button></span>
                            </div>
                            <span class="msg-box n-right" for="c-business_poster2"></span>
                        </div>
                        <ul class="row list-inline plupload-preview" id="p-business_poster2"></ul>
                    </div>
                    <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 670*400</span>
                </div>

                <div class="form-group layer-footer">
                    <label class="control-label col-xs-12 col-sm-2"></label>
                    <div class="col-xs-12 col-sm-8">
                        <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
                        <!--<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>-->
                    </div>
                </div>

            </form>
            </div>

            <div class="tab-pane fade in" id="hezuo">
                <form id="hezuo-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="setting/addtext">
                    <div class="form-group" style="padding: 20px">
                        <textarea class="form-control editor" name="business_hezuo"><?php echo isset($result['business_hezuo'])?$result['business_hezuo']: ''; ?></textarea>
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

            <div class="tab-pane fade in" id="koukuan">
                <form id="koukuan-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="setting/addtext">
                    <div class="form-group" style="padding: 20px">
                        <textarea class="form-control editor" name="business_kk"><?php echo isset($result['business_kk'])?$result['business_kk']: ''; ?></textarea>
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

            <div class="tab-pane fade in" id="eleme">
                <form id="price-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="setting/eleme">

    <div class="form-group"></div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">是否开启正式环境:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo build_radios('eleme_switch', ['0'=>'关闭', '1'=>'开启'], !empty($result['eleme_switch']) ? $result['eleme_switch'] : ''); ?>
        </div>
        <span class="help-block text-danger"><i class="fa fa-info-circle mr-xs"></i>关闭情况下,仅可使用沙箱环境测试（注：开启后测试的商家账号无法授权使用; 正式环境与沙箱环境Key和Secret不一样，切换环境请注意更改）</span>
    </div>
    <div class="form-group"></div>

    <div class="form-group">
        <label for="c-eleme_logo" class="control-label col-xs-12 col-sm-2">应用logo:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-eleme_logo" data-rule="required" class="form-control" size="50" name="eleme_logo" type="text" value="<?php echo isset($result['eleme_logo'])?$result['eleme_logo']: ''; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-eleme_logo" class="btn btn-success plupload" data-input-id="c-eleme_logo" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-eleme_logo"><i class="fa fa-upload"></i> 上传</button></span>
                </div>
                <span class="msg-box n-right" for="c-eleme_logo"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-eleme_logo"></ul>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 200*200,用于商家授权应用的回调页面展示</span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">应用名称：</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" data-rule="required" value="<?php echo isset($result['eleme_name'])?$result['eleme_name']: ''; ?>" name="eleme_name" placeholder="请输入应用名称">
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>饿了么开放平台创建的应用名称,用于商家授权应用的回调页面展示</span>
    </div>
    <div class="form-group"></div>


    <div class="form-group">
        <label class="col-sm-2 control-label">开放平台应用Key：</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" data-rule="required" value="<?php echo isset($result['eleme_key'])?$result['eleme_key']: ''; ?>" name="eleme_key" placeholder="请输入Key">
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>饿了么开放平台创建应用所获得的Key</span>
    </div>
    <div class="form-group"></div>

    <div class="form-group">
        <label class="col-sm-2 control-label">开放平台应用Secret：</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" data-rule="required" value="<?php echo isset($result['eleme_secret'])?$result['eleme_secret']: ''; ?>" name="eleme_secret" placeholder="请输入Secret">
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>饿了么开放平台创建应用所获得的Secret</span>
    </div>
    <div class="form-group"></div>

    <div class="form-group" style="margin-bottom:0;">
        <label class="col-sm-2 control-label">推送URL：</label>
        <div class="col-sm-6">
            <p class="form-control-static  text-info"><?php echo isset($result['callapi_url'])?$result['callapi_url']: ''; ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"> </label>
        <div class="col-sm-6">
            <p class="form-control-static">
                <i class="fa fa-info-circle mr-xs"></i>饿了么开放平台 创建应用时，需复制此链接到应用中设置的-推送URL
            </p>
        </div>
    </div>
    <div class="form-group"></div>

    <div class="form-group"  style="margin-bottom:0;">
        <label class="col-sm-2 control-label">回调地址URL：</label>
        <div class="col-sm-6">
            <p class="form-control-static text-info"><?php echo isset($result['callback_url'])?$result['callback_url']: ''; ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"> </label>
        <div class="col-sm-6">
            <p class="form-control-static">
                <i class="fa fa-info-circle mr-xs"></i>饿了么开放平台 创建应用时，需复制此链接到应用中设置的-回调地址URL
            </p>
        </div>
    </div>
    <div class="form-group"></div>

    <div class="form-group"  style="margin-bottom:0;">
        <label class="col-sm-2 control-label">商家授权本平台URL：</label>
        <div class="col-sm-10">
            <p class="form-control-static text-info"><?php echo isset($result['shop_auth_url'])?$result['shop_auth_url']: ''; ?></p>
        </div>
    </div>

    <div class="form-group" style="padding: 20px">
        <label class="col-sm-2 control-label">商家授权后的回调页面说明内容：</label>
        <div class="col-sm-6">
            <textarea class="form-control editor" name="eleme_desc"><?php echo isset($result['eleme_desc'])?$result['eleme_desc']: ''; ?></textarea>
        </div>
    </div>


    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/addons/make_speed/core/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/addons/make_speed/core/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>
