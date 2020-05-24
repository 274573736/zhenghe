define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'carhailing/line/index' + location.search,
                    add_url: 'carhailing/line/add',
                    edit_url: 'carhailing/line/edit',
                    del_url: 'carhailing/line/del',
                    multi_url: 'carhailing/line/multi',
                    table: 'carhailing_line',
                }
            });

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
                        {field: 'name', title: __('Name')},
                        {field: 'starting', title: __('Starting'),formatter:Controller.api.formatter.address,operate:false},
                        {field: 'adult_price', title: '票价', operate:'BETWEEN',formatter:Controller.api.formatter.price},
                        {field: 'child_price', title: __('Child_price'), operate:'BETWEEN',visible:false},
                        {field: 'open_time', title: __('Open_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'close_time', title: __('Close_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'appointment_time', title: __('Appointment_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'taking_long', title: __('Taking_long'),formatter:function(val,row,index){
                                return val + "<span style='color: #128f76'> 分</span>";
                            }
                        },
                        {field: 'push_money', title: __('Push_money'),formatter:function(val,row,index){
                                return val + "<span style='color: #128f76'> %</span>";
                            }
                        },
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            $('#point').on('click', function () {
                Fast.api.open('carhailing/pickup_point/index','接送点管理');
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            formatter:{
                address:function(value, row, index){
                    var start = row.city ? row.city.name : '';
                    var end   = row.end_city ? row.end_city.name : '';
                    var html = '<span class="" style="color:#3498E2">起：</span><span>' + start  + '</span>'
                        + '<br><span class="" style="color: #E74C3C">终：</span><span>' + end + '</span>';
                    return html;
                },
                price:function(val,row,index){
                    var adult_price = row.adult_price ? row.adult_price : '';
                    var child_price = row.child_price ? row.child_price : '';
                    var html = '<span class="" style="color:#3498E2">成人价：</span><span>￥' + adult_price  + '</span>'
                        + '<br><span class="" style="color: #E74C3C">儿童价：</span><span>￥' + child_price + '</span>';
                    return html;
                },
            },

            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});