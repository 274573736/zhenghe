define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                //关闭双击编辑
                dblClickToEdit: false,

                extend: {
                    index_url: 'order/driveorder/index',
                    edit_url: 'order/driveorder/edit',
                    detail_url: 'order/driveorder/detail',
                    del_url: 'order/driveorder/del',
                    multi_url: 'order/driveorder/multi',
                    tasking_url: 'order/driveorder/tasking',
                    track_url: 'order/driveorder/track',
                    table: 'driveorder'
                }
            });


            //扩展行按钮点击事件
            var eventBtn = [];
            eventBtn['click .btn-detailone'] = function (e, value, row, index) {
                e.stopPropagation();
                e.preventDefault();
                var table = $(this).closest('table');
                var options = table.bootstrapTable('getOptions');
                var ids = row[options.pk];
                row = $.extend({}, row ? row : {}, {ids: ids});
                var url = options.extend.detail_url;
                Fast.api.open(Table.api.replaceurl(url, row, table), __('Detail'), $(this).data() || {});
            };
            eventBtn['click .btn-tasking'] = function (e, value, row, index) {
                e.stopPropagation();
                e.preventDefault();
                var table = $(this).closest('table');
                var options = table.bootstrapTable('getOptions');
                var ids = row[options.pk];
                row = $.extend({}, row ? row : {}, {ids: ids});
                var url = options.extend.tasking_url;
                Fast.api.open(Table.api.replaceurl(url, row, table), __('分配司机'), $(this).data() || {});
            };
            eventBtn['click .btn-track'] = function (e, value, row, index) {
                e.stopPropagation();
                e.preventDefault();
                var table = $(this).closest('table');
                var options = table.bootstrapTable('getOptions');
                var ids = row[options.pk];
                row = $.extend({}, row ? row : {}, {ids: ids});
                console.log(row)
                var url = options.extend.track_url;
                Fast.api.open(Table.api.replaceurl(url, row, table), '查看轨迹', $(this).data() || {});
            };

            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索订单号";};

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'city.name', title: __('City_id'), width:120, operate:'LIKE'},
                        {field: 'order_code', title: __('Order_code')},
                        {field: 'user.nick_name', title: __('User_id'),width:150, operate:'LIKE'},
                        {field: 'distance', title: __('Distance'),width:90, formatter:Controller.api.formatter.distance, operate:'BETWEEN'},
                        {field: 'total_price', title: __('Total_price'),width:120, formatter:Controller.api.formatter.price, operate:'BETWEEN'},
                        {field: 'pay_price', title: __('Pay_price'),width:120, formatter:Controller.api.formatter.payPrice, operate:'BETWEEN'},
                        {field: 'status', title: __('Status'),width:130,operate:false,searchList:{0:__('Status 0'),1:__('Status 1'),2:__('Status 2'),3:__('Status 3'),4:__('Status 4'),5:__('Status 5'),6:__('Status 6')},formatter:Table.api.formatter.status},
                        {field: 'charg_type', title: '计费类型',width:130,searchList:{1:'规划距离',2:'实时计费'},formatter:Table.api.formatter.status,operate:false},

                        {field: 'operate', title: __('Operate'), table: table, events: $.extend(eventBtn ,Table.api.events.operate || []),
                            buttons: [
                                {
                                    name: 'detail',
                                    icon: 'fa fa-google-wallet',
                                    title: '查看订单轨迹',
                                    extend: 'data-toggle="tooltip"',
                                    classname: 'btn btn-xs btn-primary btn-track',
                                    url: $.fn.bootstrapTable.defaults.extend.track_url
                                },
                                {
                                name: 'detail',
                                icon: 'fa fa-list',
                                title: __('Detail'),
                                extend: 'data-toggle="tooltip"',
                                classname: 'btn btn-xs btn-primary btn-detailone',
                                url: $.fn.bootstrapTable.defaults.extend.detail_url
                                },
                                {
                                    name: 'detail',
                                    icon: 'fa fa-hand-o-left',
                                    title: __('分配司机'),
                                    extend: 'data-toggle="tooltip"',
                                    classname: 'btn btn-xs btn-primary btn-tasking',
                                    url: $.fn.bootstrapTable.defaults.extend.tasking_url
                                }
                            ],

                            formatter: Table.api.formatter.operate
                        },
                    ]
                ]
            });

            // 绑定TAB事件
            $('.panel-heading a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var field = $(this).closest("ul").data("field");
                var value = $(this).data("value");
                var options = table.bootstrapTable('getOptions');
                options.pageNumber = 1;
                options.queryParams = function (params) {
                    var filter = {};
                    if (value !== '') {
                        filter[field] = value;
                    }
                    params.filter = JSON.stringify(filter);
                    return params;
                };

                table.bootstrapTable('refresh', {});
                return false;
            });

            // 为表格绑定事件
            Table.api.bindevent(table);

            //当双击单元格时
            table.on('dbl-click-row.bs.table', function (e, row, element, field) {
                $('.btn-detailone', element).trigger("click");
            });

        },
        add: function () {
            Controller.api.bindevent();
        },
        detail: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        tasking: function () {
            Controller.api.bindevent();
        },
        api: {
            formatter:{
                distance : function(value,row,index){
                    return '<span class="text-info">'+value+' km</span>';
                },
                goods : function(value,row,index){
                    return value ? value+' ('+row.weight+'kg)' : '无';
                },
                price : function(value,row,index){
                    return '<span class="text-primary">'+value+' 元</span>';
                },
                payPrice : function(value,row,index){
                    return '<span class="text-success">'+value+' 元</span>';
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});