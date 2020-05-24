<?php if (!defined('THINK_PATH')) exit(); /*a:9:{s:111:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/public/../application/admin/view/setting/price/index.html";i:1582941334;s:96:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/layout/default.html";i:1582941334;s:93:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/meta.html";i:1582941334;s:105:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/freight/common/checkBox.html";i:1582941334;s:101:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/setting/price/price.html";i:1582941334;s:99:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/setting/price/buy.html";i:1582941334;s:100:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/setting/price/line.html";i:1582941334;s:101:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/setting/price/drive.html";i:1582941334;s:95:"/www/wwwroot/linux.henan863.cn/addons/make_speed/core/application/admin/view/common/script.html";i:1582941334;}*/ ?>
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
            <li  class="active"><a href="#price" data-toggle="tab">帮送价格配置</a></li>
            <li><a href="#buy" data-toggle="tab">帮买价格配置</a></li>
            <li><a href="#line" data-toggle="tab">万能服务价格配置</a></li>
            <li><a href="#drive" data-toggle="tab">代驾价格配置</a></li>
        </ul>
    </div>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="price">
                <form id="price-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="setting/price/add">

    <div class="form-group">
        <label class="col-sm-1 control-label">起步</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" value="<?php echo isset($result['min_distance'])?$result['min_distance']: ''; ?>" name="price[min_distance]" placeholder="输入最小路程">
                <div class="input-group-addon">公里</div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" value="<?php echo isset($result['min_weight'])?$result['min_weight']: ''; ?>" name="price[min_weight]" placeholder="输入最低公斤">
                <div class="input-group-addon">公斤</div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" value="<?php echo isset($result['initial_price'])?$result['initial_price']: ''; ?>" name="price[initial_price]" placeholder="起步价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>几公里重量以内,起步价</span>
    </div>

    <hr>
    <?php if(!(empty($result['distance']) || (($result['distance'] instanceof \think\Collection || $result['distance'] instanceof \think\Paginator ) && $result['distance']->isEmpty()))): if(is_array($result['distance']) || $result['distance'] instanceof \think\Collection || $result['distance'] instanceof \think\Paginator): if( count($result['distance'])==0 ) : echo "" ;else: foreach($result['distance'] as $dk=>$dv): ?>
    <div class="form-group bsaddgroup">
        <label class="col-sm-1 control-label">续程</label>
        <div class="col-sm-2" style="">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" value="<?php echo isset($dk)?$dk: ''; ?>" name="price[distance][]" placeholder="公里数">
                <div class="input-group-addon">公里以后</div>
            </div>
        </div>

        <label class="control-label col-sm-1">每公里加收</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" value="<?php echo isset($dv)?$dv: ''; ?>" name="price[distance_price][]" placeholder="价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block" style="margin-top: 1px;">
                <button type="button"  class="btn btnHight btn-success bsadd"><i class="fa fa-plus "></i></button>
                <button type="button"  class="btn btnHight btn-danger bsdel" ><i class="fa fa-times"></i></button>
               <i class="fa fa-info-circle mr-xs"></i>此续程范围超出部分到下个续程间,每公里加收费用
        </span>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; else: ?>
    <div class="form-group bsaddgroup">
        <label class="col-sm-1 control-label">续程</label>
        <div class="col-sm-2" style="">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" value="" name="price[distance][]" placeholder="公里数">
                <div class="input-group-addon">公里以后</div>
            </div>
        </div>

        <label class="control-label col-sm-1">每公里加收</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" value="" name="price[distance_price][]" placeholder="价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block" style="margin-top: 1px;">
                <button type="button"  class="btn btnHight btn-success bsadd"><i class="fa fa-plus "></i></button>
                <button type="button"  class="btn btnHight btn-danger bsdel" ><i class="fa fa-times"></i></button>
               <i class="fa fa-info-circle mr-xs"></i>此续程范围超出部分到下个续程间,每公里加收费用
        </span>
    </div>
    <?php endif; ?>
    <hr>

    <?php if(!(empty($result['weight']) || (($result['weight'] instanceof \think\Collection || $result['weight'] instanceof \think\Paginator ) && $result['weight']->isEmpty()))): if(is_array($result['weight']) || $result['weight'] instanceof \think\Collection || $result['weight'] instanceof \think\Paginator): if( count($result['weight'])==0 ) : echo "" ;else: foreach($result['weight'] as $wk=>$wv): ?>
    <div class="form-group addweight">
        <label class="col-sm-1 control-label">续重</label>
        <div class="col-sm-2" style="">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" name="price[weight][]" value="<?php echo isset($wk)?$wk: ''; ?>" placeholder="公斤数">
                <div class="input-group-addon">公斤以后</div>
            </div>
        </div>

        <label class="control-label col-sm-1">每公斤加收</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" name="price[weight_price][]" value="<?php echo isset($wv)?$wv: ''; ?>" placeholder="价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block" style="margin-top: 1px;">
                <button type="button"  class="btn btnHight btn-success wadd"><i class="fa fa-plus "></i></button>
                <button type="button"  class="btn btnHight btn-danger wdel" ><i class="fa fa-times"></i></button>
               <i class="fa fa-info-circle mr-xs"></i>此续重范围超出部分到下个续重间,每公斤加收费用
        </span>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; else: ?>
    <div class="form-group addweight">
        <label class="col-sm-1 control-label">续重</label>
        <div class="col-sm-2" style="">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" name="price[weight][]" value="" placeholder="公斤数">
                <div class="input-group-addon">公斤以后</div>
            </div>
        </div>

        <label class="control-label col-sm-1">每公斤加收</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" name="price[weight_price][]" value="" placeholder="价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block" style="margin-top: 1px;">
                <button type="button"  class="btn btnHight btn-success wadd"><i class="fa fa-plus "></i></button>
                <button type="button"  class="btn btnHight btn-danger wdel" ><i class="fa fa-times"></i></button>
               <i class="fa fa-info-circle mr-xs"></i>此续重范围超出部分到下个续重间,每公斤加收费用
        </span>
    </div>
    <?php endif; ?>

    <hr>

    <div class="form-group">
        <label class="col-sm-1 control-label">价格调度</label>
        <div class="col-sm-5" style="">
            <input type="text" data-rule="" class="form-control" name="price[change_price]" value="<?php echo isset($result['change_price'])?$result['change_price']: ''; ?>" placeholder="价格调整额度">
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>根据需供情况,自由动态调整价格(-或+)</span>
    </div>

    <?php if(isset($result['night_price']) && is_array( $result['night_price'] )): foreach($result['night_price'] as $k=>$v): ?>
    <div class="form-group addNightPrice">
        <label class="col-sm-1 control-label">夜间费</label>
        <div class="col-sm-5" style="display: flex;flex-direction: row">
            <div class="col-lg-4" style='padding-left: 0'>
                <input type="text" data-rule="require"  data-date-use-strict="true" placeholder="开始"
                       data-date-format="HH:mm"	class="form-control datetimepicker" name="night[start][]" value="<?php echo $v['start']; ?>">
            </div>
            <span style='font-weight:bold;float:left;line-height:31px'>~</span>
            <div class="col-lg-4">
                <input type="text" data-rule="require" data-date-use-strict="true" placeholder="结束"
                       data-date-format="HH:mm" class="form-control datetimepicker" name="night[end][]" value="<?php echo $v['end']; ?>">
            </div>
            <span style='font-weight:bold;float:left;line-height:31px'>￥</span>
            <div class="col-lg-4">
                <input type="number" placeholder="价格" style="width: 142px;" data-rule="require"  class="form-control " name="night[price][]" value="<?php echo $v['price']; ?>">
            </div>
        </div>
        <span class="help-block">
                    <button type="button"  class="btn btnHight btn-success addPrice"><i class="fa fa-plus "></i></button>
                    <button type="button"  class="btn btnHight btn-danger delPrice" ><i class="fa fa-times"></i></button>
                    <i class="fa fa-info-circle mr-xs"></i>设置夜间时间段范围(晚上至次日早晨时间【例: 22~6】)
        </span>
    </div>
    <?php endforeach; else: ?>
    <div class="form-group addNightPrice">
        <label class="col-sm-1 control-label">夜间费</label>
        <div class="col-sm-5" style="display: flex;flex-direction: row">
            <div class="col-lg-4" style='padding-left: 0'>
                <input type="text" data-rule="require"  data-date-use-strict="true" placeholder="开始"
                       data-date-format="HH:mm"	class="form-control datetimepicker" name="night[start][]" value="">
            </div>
            <span style='font-weight:bold;float:left;line-height:31px'>~</span>
            <div class="col-lg-4">
                <input type="text" data-rule="require" data-date-use-strict="true" placeholder="结束"
                       data-date-format="HH:mm" class="form-control datetimepicker" name="night[end][]" value="">
            </div>
            <span style='font-weight:bold;float:left;line-height:31px'>￥</span>
            <div class="col-lg-4">
                <input type="number" placeholder="价格" style="width: 142px;" data-rule="require"  class="form-control " name="night[price][]" value="">
            </div>
        </div>
        <span class="help-block">
                    <button type="button"  class="btn btnHight btn-success addPrice"><i class="fa fa-plus "></i></button>
                    <button type="button"  class="btn btnHight btn-danger delPrice" ><i class="fa fa-times"></i></button>
                    <i class="fa fa-info-circle mr-xs"></i>设置夜间时间段范围(晚上至次日早晨时间【例: 22~6】)
        </span>
    </div>
    <?php endif; ?>

    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>
            </div>

            <div class="tab-pane fade" id="buy">
                <form id="buy-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="setting/price/buy">

    <div class="form-group">
        <label class="col-sm-1 control-label">起步</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" value="<?php echo isset($result['buy_min_distance'])?$result['buy_min_distance']: ''; ?>" name="price[buy_min_distance]" placeholder="输入最低路程">
                <div class="input-group-addon">公里</div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" value="<?php echo isset($result['buy_min_weight'])?$result['buy_min_weight']: ''; ?>" name="price[buy_min_weight]" placeholder="输入最低公斤">
                <div class="input-group-addon">公斤</div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" value="<?php echo isset($result['buy_initial_price'])?$result['buy_initial_price']: ''; ?>" name="price[buy_initial_price]" placeholder="起步价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>几公里重量以内,起步价</span>
    </div>

    <hr>
    <?php if(!(empty($result['buy_distance']) || (($result['buy_distance'] instanceof \think\Collection || $result['buy_distance'] instanceof \think\Paginator ) && $result['buy_distance']->isEmpty()))): if(is_array($result['buy_distance']) || $result['buy_distance'] instanceof \think\Collection || $result['buy_distance'] instanceof \think\Paginator): if( count($result['buy_distance'])==0 ) : echo "" ;else: foreach($result['buy_distance'] as $dk=>$dv): ?>
    <div class="form-group bmaddgroup">
        <label class="col-sm-1 control-label">续程</label>
        <div class="col-sm-2" style="">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" value="<?php echo isset($dk)?$dk: ''; ?>" name="price[buy_distance][]" placeholder="公里数">
                <div class="input-group-addon">公里以后</div>
            </div>
        </div>

        <label class="control-label col-sm-1">每公里加收</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" value="<?php echo isset($dv)?$dv: ''; ?>" name="price[buy_distance_price][]" placeholder="价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block" style="margin-top: 1px;">
                <button type="button"  class="btn btnHight btn-success bmadd"><i class="fa fa-plus "></i></button>
                <button type="button"  class="btn btnHight btn-danger bmdel" ><i class="fa fa-times"></i></button>
               <i class="fa fa-info-circle mr-xs"></i>此续程范围超出部分到下个续程间,每公里加收费用
        </span>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; else: ?>
    <div class="form-group bmaddgroup">
        <label class="col-sm-1 control-label">续程</label>
        <div class="col-sm-2" style="">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" value="" name="price[buy_distance][]" placeholder="公里数">
                <div class="input-group-addon">公里以后</div>
            </div>
        </div>

        <label class="control-label col-sm-1">每公里加收</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" value="" name="price[buy_distance_price][]" placeholder="价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block" style="margin-top: 1px;">
                <button type="button"  class="btn btnHight btn-success bmadd"><i class="fa fa-plus "></i></button>
                <button type="button"  class="btn btnHight btn-danger bmdel" ><i class="fa fa-times"></i></button>
               <i class="fa fa-info-circle mr-xs"></i>此续程范围超出部分到下个续程间,每公里加收费用
        </span>
    </div>
    <?php endif; ?>
    <hr>

    <?php if(!(empty($result['buy_weight']) || (($result['buy_weight'] instanceof \think\Collection || $result['buy_weight'] instanceof \think\Paginator ) && $result['buy_weight']->isEmpty()))): if(is_array($result['buy_weight']) || $result['buy_weight'] instanceof \think\Collection || $result['buy_weight'] instanceof \think\Paginator): if( count($result['buy_weight'])==0 ) : echo "" ;else: foreach($result['buy_weight'] as $wk=>$wv): ?>
    <div class="form-group bmweight">
        <label class="col-sm-1 control-label">续重</label>
        <div class="col-sm-2" style="">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="price[buy_weight][]" value="<?php echo isset($wk)?$wk: ''; ?>" placeholder="公斤数">
                <div class="input-group-addon">公斤以后</div>
            </div>
        </div>

        <label class="control-label col-sm-1">每公斤加收</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="price[buy_weight_price][]" value="<?php echo isset($wv)?$wv: ''; ?>" placeholder="价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block" style="margin-top: 1px;">
                <button type="button"  class="btn btnHight btn-success mwadd"><i class="fa fa-plus "></i></button>
                <button type="button"  class="btn btnHight btn-danger mwdel" ><i class="fa fa-times"></i></button>
               <i class="fa fa-info-circle mr-xs"></i>此续重范围超出部分到下个续重间,每公斤加收费用
        </span>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; else: ?>
    <div class="form-group bmweight">
        <label class="col-sm-1 control-label">续重</label>
        <div class="col-sm-2" style="">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="price[buy_weight][]" value="" placeholder="公斤数">
                <div class="input-group-addon">公斤以后</div>
            </div>
        </div>

        <label class="control-label col-sm-1">每公斤加收</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="price[buy_weight_price][]" value="" placeholder="价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block" style="margin-top: 1px;">
                <button type="button"  class="btn btnHight btn-success mwadd"><i class="fa fa-plus "></i></button>
                <button type="button"  class="btn btnHight btn-danger mwdel" ><i class="fa fa-times"></i></button>
               <i class="fa fa-info-circle mr-xs"></i>此续重范围超出部分到下个续重间,每公斤加收费用
        </span>
    </div>
    <?php endif; ?>

    <hr>

    <div class="form-group">
        <label class="col-sm-1 control-label">价格调度</label>
        <div class="col-sm-5" style="">
            <input type="number" data-rule="" class="form-control" name="price[buy_change_price]" value="<?php echo isset($result['buy_change_price'])?$result['buy_change_price']: ''; ?>" placeholder="价格调整额度">
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>根据需供情况,自由动态调整价格(-或+)</span>
    </div>

    <div class="form-group">
        <label class="col-sm-1 control-label">无电梯楼层费用</label>
        <div class="col-sm-2" style="">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="price[buy_floor_price][0]" value="<?php echo isset($result['buy_floor_price'][0])?$result['buy_floor_price'][0]: ''; ?>" >
                <div class="input-group-addon">层以后</div>
            </div>
        </div>

        <label class="control-label col-sm-1">每层楼加收</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" name="price[buy_floor_price][1]" value="<?php echo isset($result['buy_floor_price'][1])?$result['buy_floor_price'][1]: ''; ?>" placeholder="价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>每层加收费用</span>
    </div>

<!--    <div class="form-group">-->
<!--        <label class="col-sm-1 control-label">夜间费</label>-->
<!--        <div class="col-sm-5" style="">-->
<!--            <input type="number" data-rule="" class="form-control" name="price[buy_night_price]" value="result['buy_night_price'] ?? ''}" placeholder="夜间费额度">-->
<!--        </div>-->
<!--        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>夜间加收设定额度的补贴费</span>-->
<!--    </div>-->

<!--    <div class="form-group">-->
<!--        <label class="col-sm-1 control-label">夜间时间段</label>-->
<!--        <div class="col-sm-5" style="">-->
<!--            <div class="col-lg-5" style='padding-left: 0'>-->
<!--                <input type="text" data-rule="" class="form-control" name="price[buy_night_time][0]" value="result['buy_night_time'][0] ?? ''}">-->
<!--            </div>-->
<!--            <span style='font-weight:bold;float:left;line-height:31px'>~</span>-->
<!--            <div class="col-lg-5">-->
<!--                <input type="text" data-rule="" class="form-control" name="price[buy_night_time][1]" value="esult['buy_night_time'][1] ?? ''}">-->
<!--            </div>-->
<!--        </div>-->
<!--        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>设置夜间时间段范围(晚上至次日早晨时间【例: 22~6】)</span>-->
<!--    </div>-->

    <?php if(isset($result['buy_night_price']) && is_array($result['buy_night_price'])): foreach($result['buy_night_price'] as $k=>$v): ?>
    <div class="form-group addNightPrice">
        <label class="col-sm-1 control-label">夜间费</label>
        <div class="col-sm-5" style="display: flex;flex-direction: row">
            <div class="col-lg-4" style='padding-left: 0'>
                <input type="text" data-rule="require"  data-date-use-strict="true" placeholder="开始"
                       data-date-format="HH:mm"	class="form-control datetimepicker" name="night[start][]" value="<?php echo $v['start']; ?>">
            </div>
            <span style='font-weight:bold;float:left;line-height:31px'>~</span>
            <div class="col-lg-4">
                <input type="text" data-rule="require" data-date-use-strict="true" placeholder="结束"
                       data-date-format="HH:mm" class="form-control datetimepicker" name="night[end][]" value="<?php echo $v['end']; ?>">
            </div>
            <span style='font-weight:bold;float:left;line-height:31px'>￥</span>
            <div class="col-lg-4">
                <input type="number" placeholder="价格" style="width: 142px;" data-rule="require"  class="form-control " name="night[price][]" value="<?php echo $v['price']; ?>">
            </div>
        </div>
        <span class="help-block">
                    <button type="button"  class="btn btnHight btn-success addPrice"><i class="fa fa-plus "></i></button>
                    <button type="button"  class="btn btnHight btn-danger delPrice" ><i class="fa fa-times"></i></button>
                    <i class="fa fa-info-circle mr-xs"></i>设置夜间时间段范围(晚上至次日早晨时间【例: 22~6】)
        </span>
    </div>
    <?php endforeach; else: ?>
    <div class="form-group addNightPrice">
        <label class="col-sm-1 control-label">夜间费</label>
        <div class="col-sm-5" style="display: flex;flex-direction: row">
            <div class="col-lg-4" style='padding-left: 0'>
                <input type="text" data-rule="require"  data-date-use-strict="true" placeholder="开始"
                       data-date-format="HH:mm"	class="form-control datetimepicker" name="night[start][]" value="">
            </div>
            <span style='font-weight:bold;float:left;line-height:31px'>~</span>
            <div class="col-lg-4">
                <input type="text" data-rule="require" data-date-use-strict="true" placeholder="结束"
                       data-date-format="HH:mm" class="form-control datetimepicker" name="night[end][]" value="">
            </div>
            <span style='font-weight:bold;float:left;line-height:31px'>￥</span>
            <div class="col-lg-4">
                <input type="number" placeholder="价格" style="width: 142px;" data-rule="require"  class="form-control " name="night[price][]" value="">
            </div>
        </div>
        <span class="help-block">
                    <button type="button"  class="btn btnHight btn-success addPrice"><i class="fa fa-plus "></i></button>
                    <button type="button"  class="btn btnHight btn-danger delPrice" ><i class="fa fa-times"></i></button>
                    <i class="fa fa-info-circle mr-xs"></i>设置夜间时间段范围(晚上至次日早晨时间【例: 22~6】)
        </span>
    </div>
    <?php endif; ?>

    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>
            </div>

            <div class="tab-pane fade" id="line">
                <form id="price-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="setting/price/line">

    <div class="form-group">
        <label class="col-sm-1 control-label">服务起步价</label>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="number" data-rule="" class="form-control" value="<?php echo isset($result['line_initial_price'])?$result['line_initial_price']: ''; ?>" name="price[line_initial_price]" placeholder="起步价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>万能服务服务起步价格</span>
    </div>

    <hr>

    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed"><?php echo __('OK'); ?></button>
            <!--<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>-->
        </div>
    </div>
</form>
            </div>

            <div class="tab-pane fade" id="drive">
                <form id="driver-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="setting/price/drive">
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">收费模式:</label>
        <div class="col-xs-12 col-sm-6">
            <div class="radio">
                <label id="distance_charge">
                    <input  name="price[dcharge_type]" type="radio" value="1"  <?php if($result['dcharge_type'] == '1'): ?> checked <?php endif; ?> />按规划路线距离计费
                </label>
                <label id="real_time">
                    <input  name="price[dcharge_type]" type="radio" value="2"  <?php if($result['dcharge_type'] == '2'): ?> checked <?php endif; ?> />实时计费
                </label>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>默认按路线规划路线计费</span>
    </div>

    <div class="form-group <?php if($result['dcharge_type'] == 1): ?> hidden <?php endif; ?>" id="amap_driver_key">
        <label class="control-label col-xs-12 col-sm-2">高德地图key:</label>
        <div class="col-xs-12 col-sm-6">
            <input type="text" value="<?php echo isset($result['amap_driver_key'])?$result['amap_driver_key']: ''; ?>" name="price[amap_driver_key]" class="form-control"  placeholder="高德地图web服务key" />
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i><a target="_blank" href="https://lbs.amap.com/dev/key/app">点击申请</a>添加key时服务平台请选择Web服务</span>

    </div>
    <div class="form-group <?php if($result['dcharge_type'] == 1): ?> hidden <?php endif; ?>" id="amap_servier_id">
        <label class="control-label col-xs-12 col-sm-2">serviceID:</label>
        <div class="col-xs-12 col-sm-6">
            <spance class="form-control" ><?php echo isset($result['amap_service_id'])?$result['amap_service_id']: ''; ?></spance>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>无需填写</span>
    </div>

    <hr>
    <div class="form-group">
        <label class="col-sm-1 control-label">起步</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" value="<?php echo isset($result['drive_min_distance'])?$result['drive_min_distance']: ''; ?>" name="price[drive_min_distance]" placeholder="输入最小路程">
                <div class="input-group-addon">公里</div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" value="<?php echo isset($result['drive_initial_price'])?$result['drive_initial_price']: ''; ?>" name="price[drive_initial_price]" placeholder="起步价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>几公里重量以内,起步价</span>
    </div>


    <hr>
    <?php if(!(empty($result['drive_distance']) || (($result['drive_distance'] instanceof \think\Collection || $result['drive_distance'] instanceof \think\Paginator ) && $result['drive_distance']->isEmpty()))): if(is_array($result['drive_distance']) || $result['drive_distance'] instanceof \think\Collection || $result['drive_distance'] instanceof \think\Paginator): if( count($result['drive_distance'])==0 ) : echo "" ;else: foreach($result['drive_distance'] as $dk=>$dv): ?>
    <div class="form-group addgroup">
        <label class="col-sm-1 control-label">续程</label>
        <div class="col-sm-2" style="">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" value="<?php echo isset($dk)?$dk: ''; ?>" name="price[drive_distance][]" placeholder="公里数">
                <div class="input-group-addon">公里以后</div>
            </div>
        </div>

        <label class="control-label col-sm-1">每公里加收</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" value="<?php echo isset($dv)?$dv: ''; ?>" name="price[drive_distance_price][]" placeholder="价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block" style="margin-top: 1px;">
                <button type="button"  class="btn btnHight btn-success add"><i class="fa fa-plus "></i></button>
                <button type="button"  class="btn btnHight btn-danger del" ><i class="fa fa-times"></i></button>
               <i class="fa fa-info-circle mr-xs"></i>此续程范围超出部分到下个续程间,每公里加收费用
        </span>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; else: ?>
    <div class="form-group addgroup">
        <label class="col-sm-1 control-label">续程</label>
        <div class="col-sm-2" style="">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" value="" name="price[drive_distance][]" placeholder="公里数">
                <div class="input-group-addon">公里以后</div>
            </div>
        </div>

        <label class="control-label col-sm-1">每公里加收</label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" data-rule="" class="form-control" name="price[drive_distance_price][]" value="" placeholder="价格">
                <div class="input-group-addon">元</div>
            </div>
        </div>
        <span class="help-block" style="margin-top: 1px;">
                <button type="button"  class="btn btnHight btn-success add"><i class="fa fa-plus "></i></button>
                <button type="button"  class="btn btnHight btn-danger del" ><i class="fa fa-times"></i></button>
                <i class="fa fa-info-circle mr-xs"></i>此续程范围超出部分到下个续程间,每公里加收费用
        </span>
    </div>

    <?php endif; ?>
    <hr>

    <div class="form-group">
        <label class="col-sm-1 control-label">价格调度</label>
        <div class="col-sm-5" style="">
            <input type="text" data-rule="" class="form-control" name="price[drive_change_price]" value="<?php echo isset($result['drive_change_price'])?$result['drive_change_price']: ''; ?>" placeholder="价格调整额度">
        </div>
        <span class="help-block"><i class="fa fa-info-circle mr-xs"></i>根据需供情况,自由动态调整价格(-或+)</span>
    </div>

    <?php if(isset($result['drive_night_price']) && is_array($result['drive_night_price'])): foreach($result['drive_night_price'] as $k=>$v): ?>
    <div class="form-group addNightPrice">
        <label class="col-sm-1 control-label">夜间费</label>
        <div class="col-sm-5" style="display: flex;flex-direction: row">
            <div class="col-lg-4" style='padding-left: 0'>
                <input type="text" data-rule="require"  data-date-use-strict="true" placeholder="开始"
                       data-date-format="HH:mm"	class="form-control datetimepicker" name="night[start][]" value="<?php echo $v['start']; ?>">
            </div>
            <span style='font-weight:bold;float:left;line-height:31px'>~</span>
            <div class="col-lg-4">
                <input type="text" data-rule="require" data-date-use-strict="true" placeholder="结束"
                       data-date-format="HH:mm" class="form-control datetimepicker" name="night[end][]" value="<?php echo $v['end']; ?>">
            </div>
            <span style='font-weight:bold;float:left;line-height:31px'>￥</span>
            <div class="col-lg-4">
                <input type="number" placeholder="价格" style="width: 142px;" data-rule="require"  class="form-control " name="night[price][]" value="<?php echo $v['price']; ?>">
            </div>
        </div>
        <span class="help-block">
                    <button type="button"  class="btn btnHight btn-success addPrice"><i class="fa fa-plus "></i></button>
                    <button type="button"  class="btn btnHight btn-danger delPrice" ><i class="fa fa-times"></i></button>
                    <i class="fa fa-info-circle mr-xs"></i>设置夜间时间段范围(晚上至次日早晨时间【例: 22~6】)
        </span>
    </div>
    <?php endforeach; else: ?>
    <div class="form-group addNightPrice">
        <label class="col-sm-1 control-label">夜间费</label>
        <div class="col-sm-5" style="display: flex;flex-direction: row">
            <div class="col-lg-4" style='padding-left: 0'>
                <input type="text" data-rule="require"  data-date-use-strict="true" placeholder="开始"
                       data-date-format="HH:mm"	class="form-control datetimepicker" name="night[start][]" value="">
            </div>
            <span style='font-weight:bold;float:left;line-height:31px'>~</span>
            <div class="col-lg-4">
                <input type="text" data-rule="require" data-date-use-strict="true" placeholder="结束"
                       data-date-format="HH:mm" class="form-control datetimepicker" name="night[end][]" value="">
            </div>
            <span style='font-weight:bold;float:left;line-height:31px'>￥</span>
            <div class="col-lg-4">
                <input type="number" placeholder="价格" style="width: 142px;" data-rule="require"  class="form-control " name="night[price][]" value="">
            </div>
        </div>
        <span class="help-block">
                    <button type="button"  class="btn btnHight btn-success addPrice"><i class="fa fa-plus "></i></button>
                    <button type="button"  class="btn btnHight btn-danger delPrice" ><i class="fa fa-times"></i></button>
                    <i class="fa fa-info-circle mr-xs"></i>设置夜间时间段范围(晚上至次日早晨时间【例: 22~6】)
        </span>
    </div>
    <?php endif; ?>

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
<script src="/addons/make_speed/core/public//assets/libs/jquery/dist/jquery.min.js" type="text/javascript"></script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/addons/make_speed/core/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/addons/make_speed/core/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>
