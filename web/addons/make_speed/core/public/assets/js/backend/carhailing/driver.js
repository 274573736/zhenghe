define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'carhailing/driver/index' + location.search,
                    add_url: 'carhailing/driver/add',
                    edit_url: 'carhailing/driver/edit',
                    del_url: 'carhailing/driver/del',
                    multi_url: 'carhailing/driver/multi',
                    table: 'rider_driver',
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
                        {field: 'id', title: '编号'},
                        {field: 'rider', title: '姓名',formatter:function(val,row,index){
                                if(val){
                                    return val.real_name;
                                }
                                return '无';
                            }
                        },
                        {field: 'rider', title: '电话',formatter:function(val,row,index){
                                if(val){
                                    return val.mobile;
                                }
                                return '无';
                            }
                        },
                        {field: 'card_num', title: __('Card_num')},
                        {field: 'driver_years', title: __('Driver_years'), operate:'BETWEEN'},
                        {field: 'driver_exp_time', title: __('Driver_exp_time'), operate:'RANGE', datetimeFormat:'YYYY-MM-DD',addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'work_status', title: __('Work_status'), searchList: {"1":__('Work_status 1'),"2":__('Work_status 2'),"3":__('Work_status 3')}, formatter: Table.api.formatter.status},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1'),"2":__('Status 2')}, formatter: Table.api.formatter.status},
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