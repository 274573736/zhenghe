define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                //关闭双击编辑
                dblClickToEdit: false,

                extend: {
                    index_url: 'order/cancel_order/index',
                    detail_url: 'order/cancel_order/detail',
                    del_url: 'order/cancel_order/del',
                    table: 'cancel_order',
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
                        // {field: 'id', title: __('Id')},
                        {field: 'order.id', title: '订单ID',operate:false},
                        {field: 'order.order_code', title: '订单号',operate:false},
                        {field: 'order.type', title: '订单类型', formatter: function (value, row, index) {
                                switch (value) {
                                    case 0 :
                                        return '跑腿';
                                    case 1:
                                        return '帮买';
                                    case 2:
                                        return '万能服务';
                                    case 3:
                                        return '代驾';
                                    case 5:
                                        return '货运';
                                    default:
                                        return '未知';
                                }
                            },operate:false
                        },
                        {field: 'rider.real_name', title: '接单骑手',operate:false},
                        {field: 'rider.mobile', title: '联系号码',operate:false},
                        {field: 'accept_time', title:'接单时间', operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'cancel_time', title:'取消时间', operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'),table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });


            // 为表格绑定事件
            Table.api.bindevent(table);

        },


        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});