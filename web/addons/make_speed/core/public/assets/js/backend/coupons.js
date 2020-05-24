define(['jquery', 'bootstrap', 'backend', 'table', 'form','upload'], function ($, undefined, Backend, Table, Form, Upload) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'coupons/index',
                    add_url: 'coupons/add',
                    edit_url: 'coupons/edit',
                    del_url: 'coupons/del',
                    multi_url: 'coupons/multi',
                    table: 'coupons',
                }
            });

            var table = $("#table");

            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索 优惠券标题";};

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'),operate:false},
                        {field: 'title', title: __('Title'),operate:'LIKE'},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'satisfy_money', title: __('Satisfy_money'), operate:'BETWEEN'},
                        {field: 'day', title: __('Day'),formatter:Controller.api.formatter.day},
                        {field: 'count', title: '统计情况',formatter:Controller.api.formatter.count},
                        {field: 'type', title: __('Type'),searchList:{0:__('Type 0'),1:__('Type 1'),2:__('Type 2'),3:__('Type 3'),4:__('Type 4')}, formatter:Table.api.formatter.flag,},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });


            // 绑定TAB事件
            $('.panel-heading a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var field = $(this).closest("ul").data("field");
                var value = $(this).data("value");
                var options = table.bootstrapTable('getOptions');
                options.pageNumber = 1;
                options.queryParams = function (params) {
                    var filter = {};
                    if (value !== '') {
                        filter[field] = value;
                    }
                    params.filter = JSON.stringify(filter);
                    return params;
                };
                table.bootstrapTable('refresh', {});
                return false;
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
                day:function(value, row, index){
                    return (value*1>0) ? value+'天' : '无限制';
                },
                count:function(value, row, index){
                    return '已获得:'+value+'|已使用:'+row.count1;
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };

    //生成随机兑换码
    $('#set_rand_code').click(function (e) {
        e.preventDefault();
        var str = Math.random().toString(32);
        $('input[name="row[code]"]').val((str.substr(str.length - 8)).toUpperCase());
    });
    //清楚
    $('#clear_rand_code').click(function(e){
        e.preventDefault();
        $('input[name="row[code]"]').val('');
    });

    return Controller;
});