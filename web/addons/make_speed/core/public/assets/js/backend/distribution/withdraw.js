define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'distribution/withdraw/index' + location.search,
                    edit_url: 'distribution/withdraw/edit',
                    del_url: 'distribution/withdraw/del',
                    table: 'distribution_withdraw',
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
                        {field: 'order_num', title: __('Order_num')},
                        {field: 'distributor', title: '申请人',operate:false,formatter:function(val,row,index){
                                if(val){
                                    return val.name+'/'+val.phone;
                                }
                            }
                        },
                        {field: 'amount', title: __('Amount'), operate:'BETWEEN'},
                        {field: 'server_charge', title: __('Server_charge'), operate:'BETWEEN'},
                        {field: 'status', title: __('Status'), searchList: {"0":'待审核',"1":'待打款','2':'已打款','3':'审核失败'}, formatter: Table.api.formatter.status},
                        {field: 'type', title: __('Type'), searchList: {"1":__('Type 1'),"2":__('Type 2'),"3":__('Type 3')}, formatter: Table.api.formatter.normal},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
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