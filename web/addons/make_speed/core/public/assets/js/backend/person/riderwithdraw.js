define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'person/riderwithdraw/index',
                    add_url: 'person/riderwithdraw/add',
                    edit_url: 'person/riderwithdraw/edit',
                    del_url: 'person/riderwithdraw/del',
                    multi_url: 'person/riderwithdraw/multi',
                    table: 'rider_withdraw',
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
                        {field: 'trade_code', title: __('Trade_code')},
                        {field: 'tx_type', title: '提现类型',searchList:{0:'余额提现', 1:'保证金提现'},  custom:{0:'primary',1:'info'},formatter: Table.api.formatter.flag},
                        {field: 'type', title: '打款转账类型',searchList:{0:__('Type 0'), 1:__('Type 1'), 2:__('Type 2')},  custom:{0:'primary',1:'primary',2:'primary'},formatter: Table.api.formatter.status},
                        {field: 'ridername', title: __('Rider_id'),formatter:Controller.api.formatter.rider},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'description', title: __('Description')},
                        {field: 'status', title: __('Status'),searchList:{0:__('Status 0'), 1:__('Status 1'), 2:__('Status 2')},  custom:{0:'primary',1:'danger',2:'success'},formatter: Table.api.formatter.status},
                        {field: 'add_time', title: __('Add_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
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
            formatter:{
                rider:function(value,row,index){
                    return row.ridermobile ? value+' / '+row.ridermobile : value;
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});