define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'person/invoice/index',
                    add_url: 'person/invoice/add',
                    edit_url: 'person/invoice/edit',
                    del_url: 'person/invoice/del',
                    multi_url: 'person/invoice/multi',
                    table: 'user_invoice',
                }
            });

            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索 发票抬头/手机号";};

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'), operate:false},
                        {field: 'users.nick_name', title: __('User_id'), operate:'LIKE'},
                        {field: 'type', title: __('Type'),searchList:{0:__('Type 0'), 1:__('Type 1')}, formatter:Table.api.formatter.flag},
                        {field: 'type_name', title: __('Type_name'), operate:'LIKE'},
                        {field: 'mobile', title: __('Mobile'), operate:'LIKE'},
                        {field: 'email', title: __('Email')},
                        {field: 'content', title: __('Content')},
                        {field: 'amount', title: __('Amount'), operate:'BETWEEN'},
                        {field: 'status', title: __('Status'),searchList:{0:__('Status 0'), 1:__('Status 1'), 2:__('Status 2')}, custom:{0:'primary',1:'danger',2:'success'}, formatter:Table.api.formatter.status},
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
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});