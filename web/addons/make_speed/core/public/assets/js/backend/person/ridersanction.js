define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    $('#c-class').change(function(){
        var i = ($(this).val()) *1;

        var metric = $("#c-metric").parents('.form-group');
        var begin  = $("#c-begin_time").parents('.form-group');
        var end    = $("#c-end_time").parents('.form-group');

        switch (i){
            case 0:
                metric.hasClass("hide") && metric.removeClass('hide');
                begin.hasClass("hide") || begin.addClass('hide');
                end.hasClass("hide") || end.addClass('hide');
                break;

            case 1:
                metric.hasClass("hide") || metric.addClass('hide');
                begin.hasClass("hide") || begin.addClass('hide');
                end.hasClass("hide") || end.addClass('hide');
                break;

            case 2:
                metric.hasClass("hide") || metric.addClass('hide');
                begin.hasClass("hide") && begin.removeClass('hide');
                end.hasClass("hide") && end.removeClass('hide');
                break;

            case 3:
                metric.hasClass("hide") || metric.addClass('hide');
                begin.hasClass("hide") && begin.removeClass('hide');
                end.hasClass("hide") && end.removeClass('hide');
                break;
            default :
                console.log(i+typeof(i));
        }

    });

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'person/ridersanction/index',
                    add_url: 'person/ridersanction/add',
                    edit_url: 'person/ridersanction/edit',
                    del_url: 'person/ridersanction/del',
                    multi_url: 'person/ridersanction/multi',
                    table: 'rider_sanction',
                }
            });

            var table = $("#table");
            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索 骑手名称/手机号";};
            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'riders.real_name', title: __('Rider_id'), formatter:Controller.api.formatter.rider},
                        {field: 'type', title: __('Type'), searchList: {"0":__('Type 0'),"1":__('Type 1')}, custom:{"0":'danger',"1":'success'}, formatter: Table.api.formatter.normal},
                        {field: 'class', title: __('Class'), searchList: {"0":__('Class 0'),"1":__('Class 1'),"2":__('Class 2')}, custom:{"0":'primary',"1":'primary',"2":'primary'}, formatter: Table.api.formatter.normal},
                        {field: 'metric', title: __('Metric')},
                        {field: 'reason', title: __('Reason')},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1'),"2":__('Status 2')},custom:{"0":'primary',"1":'warning',"2":'success'}, formatter: Table.api.formatter.normal},
                        {field: 'add_time', title: __('Add_time'), operate:'RANGE', addclass:'datetimerange',datetimeFormat:"YYYY-MM-DD HH:mm", formatter: Table.api.formatter.datetime},
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
                    row.avatar = row.avatar ? row.avatar : '/assets/img/avatar.gif';
                    var classname = typeof this.classname !== 'undefined' ? this.classname : 'img-sm img-center';
                    return '<a href="' + Fast.api.cdnurl(row.avatar) + '" target="_blank"><img class="' + classname + '" src="' + Fast.api.cdnurl(row.avatar) + '" /></a>'+'&nbsp;&nbsp;'+ row.ridername;
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});