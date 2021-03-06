<?php defined('IN_IA') or exit('Access Denied');?><?php  include itemplate('public/header', TEMPLATE_INCLUDEPATH);?>
<form action="" class="form-horizontal form-filter">
	<?php  echo tpl_form_filter_hidden('order/distribute/index');?>
	<div class="form-group form-inline">
		<label class="col-xs-12 col-sm-3 col-md-2 control-label">选择代理区域</label>
		<div class="col-sm-4 col-xs-4">
			<select name="agentid" class="select2 js-select2 form-control width-130">
				<option value="0">选择代理区域</option>
				<?php  if(is_array($_W['agents'])) { foreach($_W['agents'] as $agent) { ?>
					<option value="<?php  echo $agent['id'];?>" <?php  if($agentid == $agent['id']) { ?>selected<?php  } ?>><?php  echo $agent['area'];?></option>
				<?php  } } ?>
			</select>
		</div>
	</div>
</form>
<div class="dispatch">
	<div class="alert alert-warning">
		<span>订单数据为当日订单数据</span>
	</div>
	<div class="clearfix distribute-container">
		<div class="map">
			<div id="allmap"></div>
		</div>
	</div>
</div>

<script type="text/javascript" src="//webapi.amap.com/maps?v=1.4.1&key=550a3bf0cb6d96c3b43d330fb7d86950&plugin=AMap.Driving,AMap.Geocoder,AMap.ToolBar"></script>
<script>
	irequire(['web/tiny'], function(tiny){
		var config = <?php  echo json_encode($_W['we7_wmall']['config']['takeout']['range']);?>;
		var map = new AMap.Map('allmap', {
			resizeEnable: true,
			zoom: 14,
			center: [config.map.location_y, config.map.location_x]
		});
		map.addControl(new AMap.ToolBar());
		var orders = <?php  echo json_encode($orders);?>;
		$.each(orders, function(k, order) {
			if(order.location_y && order.location_x) {
				marker = new AMap.Marker({
					icon: "//webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
					position: [order.location_y, order.location_x]
				});
				marker.setMap(map);
			}
		});
	});
</script>

<?php  include itemplate('public/footer', TEMPLATE_INCLUDEPATH);?>
