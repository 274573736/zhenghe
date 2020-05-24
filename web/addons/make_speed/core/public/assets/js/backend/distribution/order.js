define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'distribution/order/index' + location.search,
                    add_url: 'distribution/order/add',
                    edit_url: 'distribution/order/edit',
                    del_url: 'distribution/order/del',
                    multi_url: 'distribution/order/multi',
                    table: 'order',
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
                        {field: 'order_number', title: __('Type')},
                        {field: 'pay_user',title:'下单用户',formatter:function(val,row,index){
                                if(!val){
                                    return '';
                                }
                                return val.nick_name
                            }
                        },
                        {field: 'price', title: '价格', operate:'BETWEEN'},
                        {field: 'commission',title:'佣金'},
                        {field: 'level',title:'佣金等级'},
                        {field: 'distribution.nick_name',title:'上级分销商'},
                        {field: 'status',title:'状态',searchList:{0:'待付款',1:'进行中',2:'已分佣',3:'已取消'},formatter:Table.api.formatter.status},
                        {field: 'create_time', title: '添加时间', operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
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
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});