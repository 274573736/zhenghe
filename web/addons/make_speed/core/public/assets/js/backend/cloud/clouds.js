define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'cloud/clouds/index',
                    add_url: 'cloud/clouds/add',
                    edit_url: 'cloud/clouds/edit',
                    del_url: 'cloud/clouds/del',
                    multi_url: 'cloud/clouds/multi',
                    table: 'clouds',
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
                        {field: 'modules_name', title: __('Modules_name')},
                        {field: 'name', title: __('Name')},
                        {field: 'appid', title: __('Appid')},
                        {field: 'token', title: __('Token')},
                        {field: 'add_time', title: __('Add_time'), operate:'RANGE', addclass:'datetimerange', datetimeFormat:'YYYY-MM-DD',formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });


            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            $("#add-form").on("click",'.add',function(){
                var groupDOM = $(this).closest(".addgroup");
                var htmlText =  groupDOM.prop("outerHTML");
                groupDOM.after(htmlText);
            })
            $("#add-form").on("click",'.del',(function(){
                var groupCount = $(".addgroup").length;
                if(groupCount == 1){
                    return;
                }
                var groupDOM = $(this).closest(".addgroup");
                groupDOM.remove();
            }))
            Controller.api.bindevent();
        },
        edit: function () {
            $("#edit-form").on("click",'.add',function(){
                var groupDOM = $(this).closest(".addgroup");
                var htmlText =  groupDOM.prop("outerHTML");
                groupDOM.after(htmlText);
            })
            $("#edit-form").on("click",'.del',(function(){
                var groupCount = $(".addgroup").length;
                if(groupCount == 1){
                    return;
                }
                var groupDOM = $(this).closest(".addgroup");
                groupDOM.remove();
            }))
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