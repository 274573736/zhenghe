<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="we7-page-tab">
	<li class="active"><?php  echo $_W['account']['type_name'];?>用户数据统计</li>
</ul>
<div class="api" id="js-statistics-fans-display" ng-controller="FansStatisticeCtrl" ng-cloak>
	<div class="panel we7-panel api-target">
		<div class="panel-heading">今日/昨日关键指标</div>
		<div class="panel-body we7-padding-vertical">
			<div class="col-sm-4 text-center">
				<div class="title">新关注人数</div>
				<div>
					<span class="today"><?php  echo $today_stat['new'];?></span>
					<span class="yesterday">/ <?php  echo $yesterday_stat['new'];?></span>
				</div>
			</div>
			<div class="col-sm-4 text-center">
				<div class="title">取消关注人数</div>
				<div>
					<span class="today"><?php  echo $today_stat['cancel'];?></span>
					<span class="yesterday">/ <?php  echo $yesterday_stat['cancel'];?></span>
				</div>
			</div>
			<div class="col-sm-4 text-center">
				<div class="title">累计关注人数</div>
				<div>
					<span class="today"><?php  echo $today_stat['cumulate'];?></span>
					<span class="yesterday">/ <?php  echo $yesterday_stat['cumulate'];?></span>
				</div>
			</div>
		</div>
	</div>
	<div class="panel we7-panel">
		<div class="panel-heading tab">
			<a href="javascript:;">关键指标详解</a>
			<a href="javascript:;" ng-class="{'active': fansDivideType == 'bynew'}" ng-click="changeDivideType('bynew')">新关注人数</a>
			<a href="javascript:;" ng-class="{'active': fansDivideType == 'bycancel'}" ng-click="changeDivideType('bycancel')">取消关注人数</a>
			<a href="javascript:;" ng-class="{'active': fansDivideType == 'bytotal'}" ng-click="changeDivideType('bytotal')">累计关注人数</a>
		</div>
		<div class="panel-body data-view">
			<div class="tab-bar-time clearfrix">
				<span class="we7-margin-right">时间</span>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default" ng-class="{'active': fansTimeType == 'week'}" ng-click="getFansApi('week')">周统计</button>
					<button type="button" class="btn btn-default" ng-class="{'active': fansTimeType == 'month'}" ng-click="getFansApi('month')">月统计</button>
					<div class="btn-group" role="group">
						<button class="btn btn-default daterange daterange-date" we7-date-range-picker ng-model="dateRange"><span>{{dateRange.startDate}} </span>至<span> {{dateRange.endDate}}</span> <i class="fa fa-calendar"></i></button>
					</div>
				</div>
			</div>
			<div class="col-sm-12" id="chart-line" style="height:500px"></div>
		</div>
	</div>
</div>
<script>
require(['daterangepicker'], function() {
	angular.module('statisticsApp').value('config', {
		'links': {
			'fansApi': "<?php  echo url('statistics/fans/get_fans_api')?>",
		},
	});
	angular.bootstrap($('#js-statistics-fans-display'), ['statisticsApp']);
})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>