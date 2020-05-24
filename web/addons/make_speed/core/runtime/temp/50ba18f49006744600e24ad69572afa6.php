<?php if (!defined('THINK_PATH')) exit(); /*a:13:{s:112:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/general/config/index.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:108:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/general/config/miniprogram.html";i:1582941334;s:107:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/general/config/programtwo.html";i:1582941334;s:103:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/general/config/images.html";i:1582941334;s:102:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/general/config/other.html";i:1582941334;s:100:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/general/config/app.html";i:1582941334;s:103:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/general/config/system.html";i:1582941334;s:101:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/general/config/time.html";i:1582941334;s:102:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/general/config/order.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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
            <li class="active"><a href="#program" data-toggle="tab">小程序配置</a></li>
            <li><a href="#order" data-toggle="tab">订单配置</a></li>
            <li><a href="#other" data-toggle="tab">其他配置</a></li>
            <li><a href="#images" data-toggle="tab">小程序图片</a></li>
            <li><a href="#system" data-toggle="tab">系统设置</a></li>
            <li><a href="#time" data-toggle="tab">时效设置</a></li>
            <li><a href="#business" data-toggle="tab">业务类型</a></li>
            <li><a href="#sms" data-toggle="tab">短信配置</a></li>
            <li><a href="#app" data-toggle="tab">app推送配置</a></li>
            <li><a href="#programtwo" data-toggle="tab">小程序二维码</a></li>
            <li><a href="#rider" data-toggle="tab">骑手端小程序绑定</a></li>
            <li><a href="#ssl" data-toggle="tab">SSL证书</a></li>
        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">

            <div class="tab-pane fade in active" id="program">
                <style>
.tplclass{
    background-color: #eeeeee;
    opacity: 1;
    cursor: not-allowed;
}
</style>
<form id="program-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/miniprogram">
    <div class="form-group">
        <label class="col-sm-2 control-label">用户端背景颜色：</label>
        <div class="col-sm-2">
            <div class="input-group"  style="display:inline">
                <input type="text" id='mycp' data-rule="" autocomplete="off" class="form-control" name="row[program_background]" value="<?php echo isset($result['program_background'])?$result['program_background']: ''; ?>" >
            </div>
        </div>
        <label class="col-sm-1 control-label">字体颜色：</label>
        <div class="col-sm-2">
            <div class="input-group"  style="display:inline">
                <select  id="c-status" data-rule="required" class="form-control selectpicker" style="display: inline-block !important;" name="row[program_font]">
                    <option value="#000000" <?php if(!(empty($result['program_font']) || (($result['program_font'] instanceof \think\Collection || $result['program_font'] instanceof \think\Paginator ) && $result['program_font']->isEmpty()))): if($result['program_font'] == '#000000'): ?>selected<?php endif; endif; ?>>黑色</option>
                    <option value="#ffffff" <?php if(!(empty($result['program_font']) || (($result['program_font'] instanceof \think\Collection || $result['program_font'] instanceof \think\Paginator ) && $result['program_font']->isEmpty()))): if($result['program_font'] == '#ffffff'): ?>selected<?php endif; endif; ?>>白色</option>
                </select>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>用户端小程序顶部导航栏颜色</span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">骑手端背景颜色：</label>
        <div class="col-sm-2">
            <div class="input-group"  style="display:inline">
                <input type="text" id='rmycp' data-rule="" autocomplete="off" class="form-control" name="row[rider_program_background]" value="<?php echo isset($result['rider_program_background'])?$result['rider_program_background']: ''; ?>" placeholder="">
                <!--<div class="input-group-addon">公里</div>-->
            </div>
        </div>
        <label class="col-sm-1 control-label">字体颜色：</label>
        <div class="col-sm-2">

            <select  id="rc-status" data-rule="required" class="form-control selectpicker" style="display: inline-block !important;" name="row[rider_program_font]">
                <option value="#000000" <?php if(!(empty($result['rider_program_font']) || (($result['rider_program_font'] instanceof \think\Collection || $result['rider_program_font'] instanceof \think\Paginator ) && $result['rider_program_font']->isEmpty()))): if($result['rider_program_font'] == '#000000'): ?>selected<?php endif; endif; ?>>黑色</option>
                <option value="#ffffff" <?php if(!(empty($result['rider_program_font']) || (($result['rider_program_font'] instanceof \think\Collection || $result['rider_program_font'] instanceof \think\Paginator ) && $result['rider_program_font']->isEmpty()))): if($result['rider_program_font'] == '#ffffff'): ?>selected<?php endif; endif; ?>>白色</option>
            </select>

        </div>

        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>骑手端小程序顶部导航栏颜色</span>
    </div>

    <hr>

    <div class="form-group">
        <label class="col-sm-2 control-label">反馈客服电话：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[kefu_phone]" value="<?php echo isset($result['kefu_phone'])?$result['kefu_phone']: ''; ?>">
        </div>

        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>填写用户端联系客服电话</span>
    </div>

    <div class="form-group layer-footer">
        <label class="col-sm-2 control-label">下单通知模板消息通知ID：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control tplclass" name="row[template_id]" value="<?php echo isset($result['template_id'])?$result['template_id']: ''; ?>">
        </div>
        <div class="col-xs-12 col-sm-1" style='padding-left:0;'>
            <?php if(empty($result['template_id']) || (($result['template_id'] instanceof \think\Collection || $result['template_id'] instanceof \think\Paginator ) && $result['template_id']->isEmpty())): ?>
            <button  type="button" class="btn btn-info start_tpl" id="start_ridertpl" data-id="0">启用</button>
            <?php else: ?>
            <button class="btn btn-info start_tpl" id="start_ridertpl" data-id="0" style="opacity: 0.65;box-shadow: none;">已启用</button>
            <?php endif; ?>
        </div>
<!--        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>[用户端小程序申请]（标题：下单成功通知）订单名称、订单编号、取货地址、收货地址、支付金额、订单状态、下单时间、取单号、揽收码</span>-->
    </div>

    <div class="form-group layer-footer" >
        <label class="col-sm-2 control-label">取消订单模板消息通知ID：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control tplclass" name="row[cancel_template_id]" value="<?php echo isset($result['cancel_template_id'])?$result['cancel_template_id']: ''; ?>">
        </div>
        <div class="col-xs-12 col-sm-1" style='padding-left:0;'>
            <?php if(empty($result['cancel_template_id']) || (($result['cancel_template_id'] instanceof \think\Collection || $result['cancel_template_id'] instanceof \think\Paginator ) && $result['cancel_template_id']->isEmpty())): ?>
            <button type="submit" class="btn btn-info start_tpl " id="start_ridertpl" data-id="1">启用</button>
            <?php else: ?>
            <button class="btn btn-info start_tpl" id="start_ridertpl" data-id="1" style="opacity: 0.65;box-shadow: none;">已启用</button>
            <?php endif; ?>
        </div>
<!--        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>[用户端小程序申请]（标题：订单取消通知）订单编号、订单金额、下单时间、订单状态、取消时间、温馨提示</span>-->
    </div>

    <div class="form-group layer-footer">
        <label class="col-sm-2 control-label">通知骑手接单消息模板ID：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control tplclass" name="row[acceptorder_template_id]" value="<?php echo isset($result['acceptorder_template_id'])?$result['acceptorder_template_id']: ''; ?>">
        </div>
        <div class="col-xs-12 col-sm-1" style='padding-left:0;'>
            <?php if(empty($result['acceptorder_template_id']) || (($result['acceptorder_template_id'] instanceof \think\Collection || $result['acceptorder_template_id'] instanceof \think\Paginator ) && $result['acceptorder_template_id']->isEmpty())): ?>
            <button type="button" class="btn btn-info start_tpl" id="start_ridertpl  " data-id="2">启用</button>
            <?php else: ?>
            <button class="btn btn-info start_tpl" id="start_ridertpl" data-id="2" style="opacity: 0.65;box-shadow: none;">已启用</button>
            <?php endif; ?>
        </div>
<!--        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>[骑手端小程序申请](标题: 接单提醒）订单号、商品名称、订单类型、订单金额、接单描述、预约地址</span>-->
    </div>

    <div class="form-group layer-footer">
        <label class="col-sm-2 control-label">骑手接单后通知用户消息模板ID：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control tplclass" name="row[accepted_template_id]" value="<?php echo isset($result['accepted_template_id'])?$result['accepted_template_id']: ''; ?>">
        </div>
        <div class="col-xs-12 col-sm-1" style='padding-left:0;'>
            <?php if(empty($result['accepted_template_id']) || (($result['accepted_template_id'] instanceof \think\Collection || $result['accepted_template_id'] instanceof \think\Paginator ) && $result['accepted_template_id']->isEmpty())): ?>
            <button type="button" class="btn btn-info start_tpl " id="start_ridertpl  " data-id="3">启用</button>
            <?php else: ?>
            <button class="btn btn-info start_tpl" id="start_ridertpl" data-id="3" style="opacity: 0.65;box-shadow: none;">已启用</button>
            <?php endif; ?>
        </div>
<!--        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>[用户端小程序申请](标题: 接单提醒）订单号、订单类型、预约时间、预约地址、接单人、联系电话、接单时间、订单状态</span>-->
    </div>

    <div class="form-group layer-footer">
        <label class="col-sm-2 control-label">骑手送达后通知用户消息模板ID：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control tplclass " name="row[complete_template_id]" value="<?php echo isset($result['complete_template_id'])?$result['complete_template_id']: ''; ?>">
        </div>
        <div class="col-xs-12 col-sm-1" style='padding-left:0;'>
            <?php if(empty($result['complete_template_id']) || (($result['complete_template_id'] instanceof \think\Collection || $result['complete_template_id'] instanceof \think\Paginator ) && $result['complete_template_id']->isEmpty())): ?>
            <button type="button"  class="btn btn-info start_tpl " id="start_ridertpl " data-id="4">启用</button>
            <?php else: ?>
            <button class="btn btn-info start_tpl" id="start_ridertpl" data-id="4" style="opacity: 0.65;box-shadow: none;">已启用</button>
            <?php endif; ?>
        </div>
<!--        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>[用户端小程序申请](标题: 订单完成通知）订单号码、订单类型、送达时间、骑手姓名、客服电话、订单状态</span>-->
    </div>
    <div class="form-group layer-footer">
        <label class="col-sm-2 control-label">审核骑手通过/失败消息通知：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control tplclass" name="row[audit_rider_tpl]" value="<?php echo isset($result['audit_rider_tpl'])?$result['audit_rider_tpl']: ''; ?>">
        </div>
        <div class="col-xs-12 col-sm-1" style='padding-left:0;'>
            <?php if(empty($result['audit_rider_tpl']) || (($result['audit_rider_tpl'] instanceof \think\Collection || $result['audit_rider_tpl'] instanceof \think\Paginator ) && $result['audit_rider_tpl']->isEmpty())): ?>
            <button type="button" class="btn btn-info start_tpl  "   id="start_ridertpl" data-id="5">启用</button>
            <?php else: ?>
            <button class="btn btn-info start_tpl" id="start_ridertpl" data-id="5" style="opacity: 0.65;box-shadow: none;">已启用</button>
            <?php endif; ?>
        </div>
<!--        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>[骑手端小程序申请](标题: 审核结果通知）申请时间、审核结果、备注、审核时间</span>-->
    </div>


    <div class="form-group">
        <label class="col-sm-2 control-label">用户端腾讯地图KEY：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[tencent_key]" value="<?php echo isset($result['tencent_key'])?$result['tencent_key']: ''; ?>">
        </div>

        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>填入申请开通好的腾讯地图key值<a target="_blank" href="https://lbs.qq.com/dev/console/key/add">点击跳转</a></span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">用户端高德地图KEY：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[gaode_key]" value="<?php echo isset($result['gaode_key'])?$result['gaode_key']: ''; ?>">
        </div>

        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>填入申请开通好的高德地图key值 <a target="_blank" href="https://lbs.amap.com/dev/key/app">点击跳转</a></span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">骑手端腾讯地图KEY：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[rider_tencent_key]" value="<?php echo isset($result['rider_tencent_key'])?$result['rider_tencent_key']: ''; ?>">
        </div>

        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>填入申请开通好的腾讯地图key值 <a target="_blank" href="https://lbs.qq.com/dev/console/key/add">点击跳转</a></span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">骑手端高德地图KEY：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[rider_gaode_key]" value="<?php echo isset($result['rider_gaode_key'])?$result['rider_gaode_key']: ''; ?>">
        </div>

        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>填入申请开通好的高德地图key值 <a target="_blank" href="https://lbs.amap.com/dev/key/app">点击跳转</a></span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">用户端小程序标题：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[user_program_title]" value="<?php echo isset($result['user_program_title'])?$result['user_program_title']: ''; ?>">
        </div>

        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>小程序首页顶部标题</span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">骑手端小程序标题：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[rider_program_title]" value="<?php echo isset($result['rider_program_title'])?$result['rider_program_title']: ''; ?>">
        </div>

        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>小程序首页顶部标题</span>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">用户端版权信息：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[speed_copyright]" value="<?php echo isset($result['speed_copyright'])?$result['speed_copyright']: ''; ?>">
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>用户端底部版权信息</span>
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

            <div class="tab-pane fade " id="programtwo">
                <style>
    .tplclass{
        background-color: #eeeeee;
        opacity: 1;
        cursor: not-allowed;
    }
</style>
<form id="programtwo-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/programtwo">
    <!--<div class="form-group">-->
        <!--<label class="col-sm-2 control-label">生成.name}小程序码：</label>-->
        <!--<div class="col-sm-6" >-->
            <!--<div class="input-group ">-->
                <!--&lt;!&ndash;<input type="text" class="form-control">&ndash;&gt;-->
                <!--<span ><button type="button" class="btn btn-warning create_code" data-type="v.type}" data-url="make_speed/router/router" id="create_button">点击生成</button></span>-->
            <!--</div>-->
            <!--<ul class="row list-inline plupload-preview" id="code">-->
                <!--<li class="col-xs-3">-->
                    <!--<a href="/addons/make_speed/core/public" data-url="/uploads/20190604/d86095e40fc43150065ecff8467d8b8d.png" target="_blank" class="thumbnail">-->
                        <!--<img src="/addons/make_speed/core/public/uploads/20190604/d86095e40fc43150065ecff8467d8b8d.png" class="img-responsive">-->
                    <!--</a>-->
                <!--</li>-->
            <!--</ul>-->
        <!--</div>-->
    <!--</div>-->
    <div style="margin-top: 40px">
    </div>

    <?php foreach($smallProgramImg as $k=>$v): ?>
    <div class="form-group" >
        <label class="col-sm-2 control-label"><?php echo $v['name']; ?>小程序码：</label>
        <div class="col-sm-6" >
            <div class="input-group">
                <button type="button" class="btn btn-warning create_code" data-type="<?php echo $v['type']; ?>" data-url="make_speed/router/router" >点击生成</button>
            </div>
            <div class="col-xs-3 <?php if(!$v['url']): ?> hide <?php endif; ?>">
                <a style="bottom: 49px;position: relative;left: 78px;" href="/addons/make_speed/core/public<?php echo $v['url']; ?>" data-url="/addons/make_speed/core/public<?php echo $v['url']; ?>" target="_blank" class="thumbnail">
                    <img src="/addons/make_speed/core/public<?php echo $v['url']; ?>" class="img-responsive">
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</form>

            </div>
            <div class="tab-pane fade " id="images">
                <!--form-horizontal-->
<style>
    .hit-font{
        color: #737373;
        font-size: 12px;
        margin-left:50px;
    }

</style>
<form id="other-form" class="" role="form" data-toggle="validator" method="POST" action="general/config/saveConfig">

    <div class="row">
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title">骑手端</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label>授权页背景图:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 750*1334</span>
                            </div>
                        </div>
                        <?php echo Form::image('row[rider_auth_bg]',isset($result['rider_auth_bg']) ? $result['rider_auth_bg'] : ''); ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label>分享图片:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高):  210*168</span>
                            </div>
                        </div>
                        <?php echo Form::image('row[rider_share_img]',isset($result['rider_share_img']) ? $result['rider_share_img'] : ''); ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label>邀请分享海报背景图:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 750*1125</span>
                            </div>
                        </div>
                        <?php echo Form::image('row[rider_poster]',isset($result['rider_poster']) ? $result['rider_poster'] : ''); ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label class="left" >登陆注册背景图:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font right"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 750*440</span>
                            </div>

                        </div>
                        <?php echo Form::image('row[rider_logo]',isset($result['rider_logo']) ? $result['rider_logo'] : ''); ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label class="left" >接单首页背景图:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font right"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 750*420</span>
                            </div>

                        </div>
                        <?php echo Form::image('row[rider_index_bg]',isset($result['rider_index_bg']) ? $result['rider_index_bg'] : ''); ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label class="left" >待抢订单图标:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font right"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 80*80</span>
                            </div>

                        </div>
                        <?php echo Form::image('row[to_robbed_icon]',isset($result['to_robbed_icon']) ? $result['to_robbed_icon'] : ''); ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label class="left" >待抢地图图标:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font right"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 80*80</span>
                            </div>

                        </div>
                        <?php echo Form::image('row[robbed_map_icon]',isset($result['robbed_map_icon']) ? $result['robbed_map_icon'] : ''); ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label class="left" >接单设置图标:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font right"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 80*80</span>
                            </div>

                        </div>
                        <?php echo Form::image('row[receiving_order_icon]',isset($result['receiving_order_icon']) ? $result['receiving_order_icon'] : ''); ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label class="left" >抢单记录图标:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font right"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 80*80</span>
                            </div>

                        </div>
                        <?php echo Form::image('row[order_record_icon]',isset($result['order_record_icon']) ? $result['order_record_icon'] : ''); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">用户端</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label>授权页背景图:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 300*300</span>
                            </div>
                        </div>
                        <?php echo Form::image('row[user_auth_bg]',isset($result['user_auth_bg']) ? $result['user_auth_bg'] : ''); ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label>分享图片:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font">
                                    <i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高):  210*168
                                </span>
                            </div>
                        </div>
                        <?php echo Form::image('row[user_share_img]',isset($result['user_share_img']) ? $result['user_share_img'] : ''); ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label>邀请分享海报背景图:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font">
                                    <i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高):  750*1125
                                </span>
                            </div>
                        </div>
                        <?php echo Form::image('row[user_poster]',isset($result['user_poster']) ? $result['user_poster'] : ''); ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label>首页地图骑手小图标:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 25*25</span>
                            </div>
                        </div>
                        <?php echo Form::image('row[rider_map_icon]',isset($result['rider_map_icon']) ? $result['rider_map_icon'] : ''); ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label>首页地图司机小图标:</label>
                            </div>
                            <div class="col-xs-6">
                                <span class="hit-font"><i class="fa fa-info-circle mr-xs"></i>建议尺寸大小(宽*高): 25*25</span>
                            </div>
                        </div>
                        <?php echo Form::image('row[driver_map_icon]',isset($result['driver_map_icon']) ? $result['driver_map_icon'] : ''); ?>
                    </div>
                    <div class="form-group">
                        <label>小程序首页添加图标:</label>
                        <div class="input-group">
                            <div class="row">
                                <div class="col-sm-5">
                                    <input  data-rule="" placeholder="小程序页面路径输入service则跳转在线客服" class="form-control " size="60" name="row[pindex_icon][pindex_icon_url]" type="text" value="<?php echo isset($pindex_icon['pindex_icon_url'])?$pindex_icon['pindex_icon_url']: ''; ?>">
                                </div>
                                <div class="col-sm-2">
                                    <input id="c-pindex_icon" data-rule="" class="form-control"  name="row[pindex_icon][pindex_icon]" type="text" value="<?php echo isset($pindex_icon['pindex_icon'])?$pindex_icon['pindex_icon']: ''; ?>">
                                </div>
                                <div class="input-group-addon no-border no-padding">
                                    <span><button type="button" id="plupload-pindex_icon" class="btn btn-success plupload" data-input-id="c-pindex_icon" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-pindex_icon"><i class="fa fa-upload"></i> 上传</button></span>
                                    <span><button type="button" id="fachoose-pindex_icon" class="btn btn-info fachoose" data-input-id="c-pindex_icon" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                                </div>
                                <span class="msg-box n-right" for="c-pindex_icon"></span>
                            </div>
                            <ul class="row list-inline plupload-preview" id="p-pindex_icon"></ul>

                        </div>
                    </div>

                </div>
            </div>
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

            <div class="tab-pane fade" id="sms">
                <form id="sms-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/sms">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">AccessKeyId：</label>
                        <div class="col-sm-3">
                            <input type="text" data-rule="" class="form-control" name="row[ali_sms_appid]" value="<?php echo isset($result['ali_sms_appid'])?$result['ali_sms_appid']: ''; ?>">
                        </div>
                        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>阿里云用户AccessKey ID</span>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">AccessKeySecret：</label>
                        <div class="col-sm-3">
                            <input type="text" data-rule="" class="form-control" name="row[ali_sms_secret]" value="<?php echo isset($result['ali_sms_secret'])?$result['ali_sms_secret']: ''; ?>">
                        </div>

                        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>阿里云用户AccessKey Secret</span>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">短信签名名称：</label>
                        <div class="col-sm-3">
                            <input type="text" data-rule="" class="form-control" name="row[ali_sign_name]" value="<?php echo isset($result['ali_sign_name'])?$result['ali_sign_name']: ''; ?>">
                        </div>

                        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>阿里云短信服务-短信签名名称</span>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">发送收件码短信模板code：</label>
                        <div class="col-sm-3">
                            <input type="text" data-rule="" class="form-control" name="row[ali_goto_temp]" value="<?php echo isset($result['ali_goto_temp'])?$result['ali_goto_temp']: ''; ?>">
                        </div>

                        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>发送收件码短信到收件人手机号，需模板变量：${code}(验证码)</span>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">发送验证码短信模板code：</label>
                        <div class="col-sm-3">
                            <input type="text" data-rule="" class="form-control" name="row[ali_temp_code]" value="<?php echo isset($result['ali_temp_code'])?$result['ali_temp_code']: ''; ?>">
                        </div>

                        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>需模板变量：${code}(验证码)</span>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">配送任务通知给骑手短信模板code：</label>
                        <div class="col-sm-3">
                            <input type="text" data-rule="" class="form-control" name="row[ali_temp_task]" value="<?php echo isset($result['ali_temp_task'])?$result['ali_temp_task']: ''; ?>">
                        </div>

                        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>需模板变量：${name}(骑手姓名), ${code}(订单号)</span>
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

            <div class="tab-pane fade" id="other">
                <form id="other-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/other">




    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">是否启用发票申请:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo build_radios('row[invoice_switch]', ['0'=>'不启用', '1'=>'启用'], !empty($result['invoice_switch']) ? $result['invoice_switch'] : '0'); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>小程序用户端申请开发票功能, 关闭则不显示此功能</span>
    </div>


    <!--<div class="form-group">-->
        <!--<label class="col-sm-2 control-label">骑手提现到微信在线转账功能：</label>-->
        <!--<div class="col-sm-2">-->
            <!--<select  id="c-wechat_withdraw" data-rule="required" class="form-control selectpicker" style="display: inline-block !important;" name="row[wechat_withdraw]">-->
                <!--<option value="0" <?php if(!(empty($result['wechat_withdraw']) || (($result['wechat_withdraw'] instanceof \think\Collection || $result['wechat_withdraw'] instanceof \think\Paginator ) && $result['wechat_withdraw']->isEmpty()))): if($result['wechat_withdraw'] == '0'): ?>selected<?php endif; endif; ?>>关</option>-->
                <!--<option value="1" <?php if(!(empty($result['wechat_withdraw']) || (($result['wechat_withdraw'] instanceof \think\Collection || $result['wechat_withdraw'] instanceof \think\Paginator ) && $result['wechat_withdraw']->isEmpty()))): if($result['wechat_withdraw'] == '1'): ?>selected<?php endif; endif; ?>>开</option>-->
            <!--</select>-->
        <!--</div>-->

        <!--<span class="help-block"><i class="fa fa-info-circle mr-xs"></i>是否启用骑手提现到微信在线转账功能</span>-->
    <!--</div>-->
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">骑手端开通提现方式:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo Form::selectpickers("row[wechat_withdraw][]", [2=>'微信钱包',0=>'支付宝',1=>'银行卡'],isset($result['wechat_withdraw']) ? explode(',',$result['wechat_withdraw']) : [0,1,2],['data-rule'=>'require'] ); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>
            默认全开
        </span>
    </div>


    <div class="form-group">
        <label class="col-sm-2 control-label">设定骑手保证金：</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="row[rider_bondmoney]" value="<?php echo isset($result['rider_bondmoney'])?$result['rider_bondmoney']: ''; ?>">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>设置骑手保证金金额</span>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">是否启用保证金必须充值:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo build_radios('row[rider_bondmoney_switch]', ['0'=>'不启用', '1'=>'启用'], !empty($result['rider_bondmoney_switch']) ? $result['rider_bondmoney_switch'] : '0'); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>启用后，骑手必须充值够保证金后才能接单（注：开启时需确保骑手没有进行中的订单）</span>
    </div>



    <div class="form-group">
        <label class="col-sm-2 control-label">用户充值优惠：</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="row[user_recharge_coupon]" value="<?php echo isset($result['user_recharge_coupon'])?$result['user_recharge_coupon']: ''; ?>">
                <div class="input-group-addon">%</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>设置用户充值余额赠送百分比</span>
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

            <div class="tab-pane fade" id="rider">
                <form id="rider-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/riderprogram">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">小程序AppId：</label>
                        <div class="col-sm-4">
                            <input type="text" data-rule="" class="form-control" name="rider_program_key" value="<?php echo isset($result['rider_program_key'])?$result['rider_program_key']: ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">小程序AppSecret：</label>
                        <div class="col-sm-4">
                            <input type="text" data-rule="" class="form-control" name="rider_program_secret" <?php if(!(empty($result['rider_program_secret']) || (($result['rider_program_secret'] instanceof \think\Collection || $result['rider_program_secret'] instanceof \think\Paginator ) && $result['rider_program_secret']->isEmpty()))): ?>placeholder="已保存(不可随意修改)"<?php endif; ?> value="">
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


            <div class="tab-pane fade" id="ssl">
                <form id="ssl-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/savessl">

                    <div class="form-group">
                        <label class="col-sm-1 control-label">密钥(KEY)：</label>
                        <div class="col-sm-3">
                            <textarea class="form-control" name="ssl_key" style="height:380px;resize: none;" <?php if(!(empty($result['ssl_key']) || (($result['ssl_key'] instanceof \think\Collection || $result['ssl_key'] instanceof \think\Paginator ) && $result['ssl_key']->isEmpty()))): ?>placeholder="已保存(不可随意修改)"<?php endif; ?>><?php echo !empty($result['ssl_key'])?'' : ''; ?></textarea>
                        </div>

                        <label class="col-sm-1 control-label">证书(PEM格式)：</label>
                        <div class="col-sm-3">
                            <textarea class="form-control" name="ssl_cert" style="height:380px;resize: none;" <?php if(!(empty($result['ssl_cert']) || (($result['ssl_cert'] instanceof \think\Collection || $result['ssl_cert'] instanceof \think\Paginator ) && $result['ssl_cert']->isEmpty()))): ?>placeholder="已保存(不可随意修改)"<?php endif; ?>><?php echo !empty($result['ssl_cert'])?'' : ''; ?></textarea>
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

            <div class="tab-pane fade" id="business">
                <form id="business-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/business">

                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2">开放业务:</label>
                        <div class="col-sm-8 col-xs-12">
                            <dl class="fieldlist" data-name="row[business]">
                                <dd>
                                    <ins style="text-align: center;">开关</ins>
                                    <ins>业务</ins>
                                    <ins>排序</ins>
                                    <ins>自定义名称</ins>
                                </dd>
                                <?php if(is_array($result['open_business']) || $result['open_business'] instanceof \think\Collection || $result['open_business'] instanceof \think\Paginator): $key = 0; $__LIST__ = $result['open_business'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bu): $mod = ($key % 2 );++$key;?>
                                <dd class="form-inline">
                                    <input type="checkbox" id="inlineCheckbox<?php echo $key; ?>" name="business[<?php echo $key; ?>][status]" value="0" <?php if(!empty($bu['status'])): ?>checked<?php endif; ?>>
                                    <input type="hidden" name="business[<?php echo $key; ?>][type]" class="form-control" value="<?php echo isset($bu['type'])?$bu['type']: ''; ?>" size="5">
                                    <input type="text" style="border:none;padding-left:0;padding-right: 22px;" class="form-control" value="<?php echo isset($btype[$bu['type']])?$btype[$bu['type']]: '跑腿'; ?>" size="5">
                                    <input type="text" name="business[<?php echo $key; ?>][sort]" class="form-control" value="<?php echo isset($bu['sort'])?$bu['sort']: ''; ?>" size="5">
                                    <input type="text" name="business[<?php echo $key; ?>][title]" style="margin-left: 15px;" class="form-control" value="<?php echo isset($bu['title'])?$bu['title']: ''; ?>" size="20">
                                </dd>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                <br/>
                            </dl>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-2">服务端认证业务:</label>
                        <div class="col-sm-8 col-xs-12">
                            <dl class="fieldlist" data-name="row[register_business]">
                                <dd>
                                    <ins style="text-align: center;">开关</ins>
                                    <ins>业务</ins>
                                    <ins>排序</ins>
                                    <ins>自定义名称</ins>
                                </dd>
                                <?php if(is_array($result['register_business']) || $result['register_business'] instanceof \think\Collection || $result['register_business'] instanceof \think\Paginator): $key = 0; $__LIST__ = $result['register_business'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bu): $mod = ($key % 2 );++$key;?>
                                <dd class="form-inline">
                                    <input type="checkbox" id="inlineCheckbox<?php echo $key; ?>" name="register_business[<?php echo $key; ?>][status]" value="0" <?php if(!empty($bu['status'])): ?>checked<?php endif; ?>>
                                    <input type="hidden" name="register_business[<?php echo $key; ?>][type]" class="form-control" value="<?php echo isset($bu['type'])?$bu['type']: ''; ?>" size="5">
                                    <input type="text" style="border:none;padding-left:0;padding-right: 22px;" class="form-control" value="<?php echo isset($register_type[$bu['type']])?$register_type[$bu['type']]: '跑腿'; ?>" size="5">
                                    <input type="text" name="register_business[<?php echo $key; ?>][sort]" class="form-control" value="<?php echo isset($bu['sort'])?$bu['sort']: ''; ?>" size="5">
                                    <input type="text" name="register_business[<?php echo $key; ?>][title]" style="margin-left: 15px;" class="form-control" value="<?php echo isset($bu['title'])?$bu['title']: ''; ?>" size="20">
                                    <input type="hidden" name="register_business[<?php echo $key; ?>][cname]" style="margin-left: 15px;" class="form-control" value="<?php echo isset($bu['cname'])?$bu['cname']: ''; ?>" size="20">

                                </dd>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                <br/>
                                <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>开放的排序最大值的为首页</span>
                            </dl>
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

            <div class="tab-pane fade" id="app">
                <form id="app-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/sms">

    <div class="form-group">
        <label class="col-sm-2 control-label">AppID：</label>
        <div class="col-sm-3">
            <input type="text"  class="form-control" name="row[uni_appid]" value="<?php echo isset($result['uni_appid'])?$result['uni_appid']: ''; ?>">
        </div>
    </div>

<!--    <div class="form-group">-->
<!--        <label class="col-sm-2 control-label">AppSecret：</label>-->
<!--        <div class="col-sm-3">-->
<!--            <input type="text" data-rule="" class="form-control" name="row[uni_app_secret]" value="<?php echo isset($result['uni_app_secret'])?$result['uni_app_secret']: ''; ?>">-->
<!--        </div>-->

<!--    </div>-->

    <div class="form-group">
        <label class="col-sm-2 control-label">AppKey：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[uni_appkey]" value="<?php echo isset($result['uni_appkey'])?$result['uni_appkey']: ''; ?>">
        </div>

    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">MasterSecret：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[uni_master_secrect]" value="<?php echo isset($result['uni_master_secrect'])?$result['uni_master_secrect']: ''; ?>">
        </div>

    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">应用标识：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[uni_identify]" value="<?php echo isset($result['uni_identify'])?$result['uni_identify']: ''; ?>">
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

            <div class="tab-pane fade" id="system">
                <form id="other-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/savesystem">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">平台开关:</label>
        <div class="col-xs-12 col-sm-3">
            <?php echo build_radios('row[system_switch]', ['0'=>'开', '1'=>'关'], !empty($result['system_switch']) ? $result['system_switch'] : ''); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>用于紧急关闭平台下单功能, 默认开启, 选择关闭后平台系统将无法下单</span>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">系统关闭提示语：</label>
        <div class="col-sm-3">
            <input type="text" data-rule="" class="form-control" name="row[off_tip]" value="<?php echo isset($result['off_tip'])?$result['off_tip']: ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">自定义端口：</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" name="workerman_port" value="<?php echo isset($port)?$port: 9502; ?>">
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>监听端口,修改后服务器需放行该端口，小程序后台合法域名也需要更改，默认9502</span>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">自定义域名：</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" name="row[socket_domain]" value="<?php echo isset($result['socket_domain'])?$result['socket_domain']: \think\Request::instance()->server('http_host'); ?>">
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>连接socket域名,修改后需要在小程序后台合法域名添加,更改后重启脚本，默认<?php echo \think\Request::instance()->server('http_host'); ?></span>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">显示公益金比例：</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" name="row[public_price]" value="<?php echo isset($result['public_price'])?$result['public_price']: 0; ?>">
                <div class="input-group-addon">%</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>设置显示公益金比例的金额（3位小数以内），为0或空则不显示</span>
    </div>

    <div class="form-group">
        <label for="c-rider_tipbgm" class="control-label col-xs-12 col-sm-2">骑手端订单通知提示音:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-rider_tipbgm" data-rule="" class="form-control" size="50" name="row[rider_tipbgm]" type="text" value="<?php echo isset($result['rider_tipbgm'])?$result['rider_tipbgm']: ''; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-rider_tipbgm" class="btn btn-success plupload" data-input-id="c-rider_tipbgm" data-mimetype="m4a,aac,mp3,wav" data-multiple="false" data-preview-id="p-rider_tipbgm"><i class="fa fa-upload"></i> 上传</button></span>
                    <span><button type="button" id="fachoose-rider_tipbgm" class="btn btn-info fachoose" data-input-id="c-rider_tipbgm" data-mimetype="m4a,aac,mp3,wav" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>

                    <?php if(!(empty($result['rider_tipbgm']) || (($result['rider_tipbgm'] instanceof \think\Collection || $result['rider_tipbgm'] instanceof \think\Paginator ) && $result['rider_tipbgm']->isEmpty()))): ?><span><a href="/addons/make_speed/core/public/<?php echo $result['rider_tipbgm']; ?>" target="_blank" class="btn btn-info"><i class="fa fa-volume-down"></i>播放</a></span><?php endif; ?>
                </div>
                <span class="msg-box n-right" for="c-rider_tipbgm"></span>
            </div>

        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>建议音频时长30秒以内(mp3文件格式)</span>
    </div>

    <div class="form-group">
        <label for="c-backend_tipbgm" class="control-label col-xs-12 col-sm-2">后台弹窗通知提示音:</label>
        <div class="col-xs-12 col-sm-3">
            <div class="input-group">
                <input id="c-backend_tipbgm" data-rule="" class="form-control" size="50" name="row[backend_tipbgm]" type="text" value="<?php echo isset($result['backend_tipbgm'])?$result['backend_tipbgm']: ''; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-backend_tipbgm" class="btn btn-success plupload" data-input-id="c-backend_tipbgm" data-mimetype="m4a,aac,mp3,wav" data-multiple="false" data-preview-id="p-backend_tipbgm"><i class="fa fa-upload"></i> 上传</button></span>
                    <span><button type="button" id="fachoose-backend_tipbgm" class="btn btn-info fachoose" data-input-id="c-backend_tipbgm" data-mimetype="m4a,aac,mp3,wav" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>

                    <?php if(!(empty($result['backend_tipbgm']) || (($result['backend_tipbgm'] instanceof \think\Collection || $result['backend_tipbgm'] instanceof \think\Paginator ) && $result['backend_tipbgm']->isEmpty()))): ?><span><a href="/addons/make_speed/core/public/<?php echo $result['backend_tipbgm']; ?>" target="_blank" class="btn btn-info"><i class="fa fa-volume-down"></i>播放</a></span><?php endif; ?>
                </div>
                <span class="msg-box n-right" for="c-backend_tipbgm"></span>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>新订单支付完成后，后台提示音(mp3文件格式),注:后台提醒页面标签页不能关闭</span>
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

            <div class="tab-pane fade" id="time">
                <form id="price-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/settime">

    <div class="form-group">
        <label class="col-sm-2 control-label">帮送-预计取件额外时间：</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" class="form-control" value="<?php echo isset($result['expect_time0'])?$result['expect_time0']: ''; ?>" name="give_expect_time" placeholder="输入预计时间">
                <div class="input-group-addon">分钟</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>取件路程行驶时间，加上此处设置的额外时间</span>
    </div>

    <div  class="form-group">
        <label class="col-sm-2 control-label">帮送-预计送达额外时间：</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" class="form-control" value="<?php echo isset($result['expect_timed0'])?$result['expect_timed0']: ''; ?>" name="give_expect_timed" placeholder="输入预计时间">
                <div class="input-group-addon">分钟</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>送件路程行驶时间，加上此处设置的额外时间</span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">帮买(就近)-预计送达额外时间：</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" class="form-control" value="<?php echo isset($result['expect_timed1'])?$result['expect_timed1']: ''; ?>" name="buy_expect_timed" placeholder="输入预计时间">
                <div class="input-group-addon">分钟</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>买/送 路程行驶时间，加上此处设置的额外时间</span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">帮买(指定地点)-预计送达额外时间：</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" class="form-control" value="<?php echo isset($result['s_expect_timed1'])?$result['s_expect_timed1']: ''; ?>" name="buys_expect_timed" placeholder="输入预计时间">
                <div class="input-group-addon">分钟</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>买/送 路程行驶时间，加上此处设置的额外时间</span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">万能服务-预计到达服务地点额外时间：</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" class="form-control" value="<?php echo isset($result['expect_time2'])?$result['expect_time2']: ''; ?>" name="fuwu_expect_time" placeholder="输入预计时间">
                <div class="input-group-addon">分钟</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>骑手路程时间，加上此处设置的额外时间</span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">代驾-预计到达驾驶地点额外时间：</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" class="form-control" value="<?php echo isset($result['expect_time3'])?$result['expect_time3']: ''; ?>" name="drive_expect_time" placeholder="输入预计时间">
                <div class="input-group-addon">分钟</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>骑手路程时间，加上此处设置的额外时间</span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">
        </label>
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
            <div class="tab-pane fade" id="order">
<!--                <form id="order-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/order">-->
                    <form id="order-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="general/config/order">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">取件码开关:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo build_radios('row[getcode_switch]', ['0'=>'开', '1'=>'关'], !empty($result['getcode_switch']) ? $result['getcode_switch'] : 0); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>骑手取件/服务时,是否需要取件/服务码</span>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">收货码开关:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo build_radios('row[endcode_switch]', ['0'=>'开', '1'=>'关'], !empty($result['endcode_switch']) ? $result['endcode_switch'] : 0); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>骑手完成服务时,是否需要完成码确认</span>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">取件照片开关:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo build_radios('row[take_photo]', ['0'=>'开', '1'=>'关'], !empty($result['take_photo']) ? $result['take_photo'] : 0); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>骑手取件时,是否需要拍照上传照片</span>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">收件照片开关:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo build_radios('row[receive_photo]', ['0'=>'开', '1'=>'关'], !empty($result['receive_photo']) ? $result['receive_photo'] : 0); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>骑手收件时,是否需要拍照上传照片</span>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">万能服务上传图片开关:</label>
        <div class="col-xs-12 col-sm-2">
            <?php echo build_radios('row[unservice_img_switch]', ['1'=>'开', '0'=>'关'], !empty($result['unservice_img_switch']) ? $result['unservice_img_switch'] : 0); ?>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>万能服务用户端下单时,是否开启拍照上传功能</span>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">听单骑手范围限制：</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" name="row[rider_distance]" value="<?php echo isset($result['rider_distance'])?$result['rider_distance']: ''; ?>">
                <div class="input-group-addon">公里以内</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>设置多少公里范围内的骑手能够听单</span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">骑手接单数：</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="row[rider_order_number]" value="<?php echo isset($result['rider_order_number'])?$result['rider_order_number']: ''; ?>">
                <div class="input-group-addon">单</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>限制骑手能同时接多少单</span>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">每日骑手取消订单数：</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="row[rider_cancel_order]" value="<?php echo isset($result['rider_cancel_order'])?$result['rider_cancel_order']: ''; ?>">
                <div class="input-group-addon">单</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>设置骑手一天能够取消的订单数，超出则无法接单</span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">骑手订单佣金比例：</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="row[rider_wages]" value="<?php echo isset($result['rider_wages'])?$result['rider_wages']: ''; ?>">
                <div class="input-group-addon">%</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>设置骑手完成订单可获得相应比例的金额</span>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">用户获得积分比例：</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="row[user_gral]" value="<?php echo isset($result['user_gral'])?$result['user_gral']: ''; ?>">
                <div class="input-group-addon">%</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>用户完成订单后可获得订单总额的百分比数量积分</span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">用户获得成长值比例：</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="row[user_grow]" value="<?php echo isset($result['user_grow'])?$result['user_grow']: ''; ?>">
                <div class="input-group-addon">%</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>用户完成订单后可获得订单总额的百分比的成长值</span>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">订单过期时间：</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="row[order_expire]" value="<?php echo isset($result['order_expire'])?$result['order_expire']: 30; ?>">
                <div class="input-group-addon">分钟</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>下单后多久未付款或无人接单订单则自动取消并退款，系统默认30分钟</span>
    </div>

    <hr>


    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <!--<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>-->
        </div>
    </div>
</form>

<!--                </form>-->
            </div>

        </div>
    </div>
</div>

<script src="/addons/make_speed/core/public//assets/libs/jquery/dist/jquery.min.js" type="text/javascript"></script>

<script src="/addons/make_speed/core/public//assets/plugins/color-picker/bootstrap-colorpicker.min.js"></script>
<script>
    $(function(){

        $('#mycp').colorpicker({
            useAlpha: false
        });
        $('#rmycp').colorpicker({
            useAlpha: false
        });

    })
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
