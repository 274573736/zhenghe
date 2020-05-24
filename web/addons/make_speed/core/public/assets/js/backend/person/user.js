define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'person/user/index',
                    add_url: 'person/user/add',
                    edit_url: 'person/user/edit',
                    detail_url: 'person/user/detail',
                    coupon_url: 'person/user/coupon',
                    multi_url: 'person/user/multi',
                    table: 'user',
                }
            });

            //扩展行按钮点击事件
            var eventBtn = [];
            eventBtn['click .btn-detailone'] = function (e, value, row, index) {
                e.stopPropagation();
                e.preventDefault();
                var table = $(this).closest('table');
                var options = table.bootstrapTable('getOptions');
                var ids = row[options.pk];
                row = $.extend({}, row ? row : {}, {ids: ids});
                var url = options.extend.detail_url;
                Fast.api.open(Table.api.replaceurl(url, row, table), __('Detail'), $(this).data() || {});
            };

            eventBtn['click .btn-coupon'] = function (e, value, row, index) {
                e.stopPropagation();
                e.preventDefault();
                var table = $(this).closest('table');
                var options = table.bootstrapTable('getOptions');
                var ids = row[options.pk];
                row = $.extend({}, row ? row : {}, {ids: ids});
                var url = options.extend.coupon_url;
                Fast.api.open(Table.api.replaceurl(url, row, table), __('Detail'), $(this).data() || {});
            };

            var table = $("#table");
            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "搜索 昵称/手机号";};
            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'),operate:false},
                        {field: 'nick_name', title: '用户昵称',align:'left',formatter:Controller.api.formatter.name,},
                        {field: 'sex', title: __('Sex'),width:100,formatter:Controller.api.formatter.sex},
                        {field: 'recommend_name', title: '推荐人',formatter:Controller.api.formatter.recommend},
                        {field: 'usergrade', title: __('User_grade'),width:150, formatter:Controller.api.formatter.grade},
                        {field: 'valid', title: __('Valid'),width:150, operate:'BETWEEN'},
                        {field: 'grow', title: __('Grow'),width:130, operate:'BETWEEN'},
                        {field: 'gral', title: __('Gral'),width:130, operate:'BETWEEN'},
                        {field: 'operate', title: __('Operate'), table: table, events: $.extend(eventBtn ,Table.api.events.operate || []),
                            buttons: [{
                                name: 'detail',
                                icon: 'fa fa-list',
                                title: __('Detail'),
                                extend: 'data-toggle="tooltip"',
                                classname: 'btn btn-xs btn-primary btn-detailone',
                                url: $.fn.bootstrapTable.defaults.extend.detail_url
                            },
                            {
                                name: 'coupon',
                                icon: 'fa fa-credit-card-alt',
                                title: '分配优惠券',
                                extend: 'data-toggle="tooltip"',
                                classname: 'btn btn-xs btn-info btn-coupon',
                                url: $.fn.bootstrapTable.defaults.extend.coupon_url
                            }
                            ],

                            formatter: Table.api.formatter.operate
                        }
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
        coupon: function () {
            Controller.api.bindevent();
        },
        api: {
            formatter:{
                name:function(value, row, index){
                    row.avatar = row.avatar ? row.avatar : '/assets/img/avatar.png';
                    var classname = typeof this.classname !== 'undefined' ? this.classname : 'img-sm img-center';
                    return '<a href="' + Fast.api.cdnurl(row.avatar) + '" target="_blank"><img class="' + classname + '" src="' + Fast.api.cdnurl(row.avatar) + '" /></a>'+'&nbsp;&nbsp;'+ row.nick_name;
                },
                sex:function(value, row, index){
                    return value ? '<span class="text-info">男</span>' : '<span class="text-danger">女</span>';
                },
                grade:function(value, row, index){
                    if(value==null)
                        return '普通用户';

                    return '<span class="text-info">'+value+'</span>';
                },
                recommend:function(value, row, index){
                    if(value && value!==null) {
                        return value;
                    }else if(row.recommend_riders!==null){
                        return row.recommend_riders + '(骑手)';
                    }else{
                        return '无';
                    }
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});