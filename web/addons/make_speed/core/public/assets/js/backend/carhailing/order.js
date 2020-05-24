define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'carhailing/order/index' + location.search,
                    edit_url: 'carhailing/order/edit',
                    del_url: 'carhailing/order/del',
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
                        {field: 'order_code', title: __('Order_code')},
                        {field: 'user', title: __('User_id'),formatter:function(val,row,index){
                                if(val){
                                    return val.nick_name;
                                }
                            }
                        },
                        {field: 'address', title: __('Phone'),formatter:function(val,row,index){
                                if(val){
                                    return val.begin_phone;
                                }
                            }
                        },
                        {field: 'get_time', title: __('Get_time')},
                        {field: 'description', title: __('Description')},
                        {field: 'payment', title: __('Payment'), searchList: {"1":__('Payment 1'),"2":__('Payment 2')}, formatter: Table.api.formatter.normal},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1'),"2":__('Status 2'),"3":__('Status 3'),"4":__('Status 4'),"5":__('Status 5'),"6":__('Status 6')}, formatter: Table.api.formatter.status},
                        {field: 'add_time', title: __('Add_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate,
                            buttons: [{
                                name: 'detail',
                                icon: 'fa fa-list',
                                title: __('Detail'),
                                extend: 'data-toggle="tooltip"',
                                classname: 'btn btn-xs btn-primary btn-dialog',
                                url: 'carhailing/order/detail'
                            }], formatter: Table.api.formatter.operate}
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