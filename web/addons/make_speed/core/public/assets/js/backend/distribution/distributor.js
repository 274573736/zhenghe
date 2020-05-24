define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'distribution/distributor/index' + location.search,
                    edit_url: 'distribution/distributor/edit',
                    del_url: 'distribution/distributor/del',
                    detail_url: 'distribution/distributor/detail',
                    table: 'distribution_distributor',
                }
            });

            var table = $("#table");
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


            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: 'id'},
                        {field: 'user', title: '用户信息',formatter:function(value,row,index){
                                if(!value){
                                    value = {};
                                    value.avatar = value.avatar  ? value.avatar : '/assets/img/avatar.png';
                                    value.nick_name = '';
                                }
                                var classname = 'img-sm img-center';
                                return '<img style="cursor:pointer" class="' + classname + '" src="' + Fast.api.cdnurl(value.avatar) + '" />'+'&nbsp;&nbsp;'+value.nick_name
                            },events:Controller.api.formatter.showUser,
                        },
                        {field: 'superior', title: '上级',formatter:function(value,row,index){
                                if(!value){
                                    value = {};
                                    value.avatar = value.avatar  ? value.avatar : '/assets/img/avatar.png';
                                    value.nick_name = '无';
                                }
                                var classname = 'img-sm img-center';
                                return '<img style="cursor:pointer" class="' + classname + '" src="' + Fast.api.cdnurl(value.avatar) + '" />'+'&nbsp;&nbsp;'+value.nick_name
                            },events:Controller.api.formatter.showUser,
                        },
                        {field: 'name', title: __('Name')},
                        {field: 'phone', title: __('Phone')},
                        {field: 'commission', title: __('Commission'), operate:'BETWEEN'},
                        {field: 'pay_commission', title: __('Pay_commission'), operate:'BETWEEN'},
                        {field: 'count_commission', title: __('Count_commission'), operate:'BETWEEN'},
                        {field: 'grade.name',title:'等级'},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1'),"2" : '审核失败'}, formatter: Table.api.formatter.status},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table,  events: $.extend(eventBtn ,Table.api.events.operate || []), formatter: Table.api.formatter.operate,
                            buttons: [
                                {
                                    name: 'ajax',
                                    title: '生成海报',
                                    classname: 'btn btn-xs btn-success btn-magic btn-ajax', //btn-ajax
                                    icon: 'fa fa-magic',
                                    url: 'distribution/distributor/poster',
                                    success: function (data, ret) {
                                        Layer.photos({
                                            photos: {
                                                "data": [{src:Fast.api.cdnurl(data.img)}]
                                            },
                                            anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
                                        });
                                        return false;
                                        console.log(data);
                                        var html = "<image  src='"+data.img+"'></image>"
                                        Layer.open({
                                            title:'鼠标右键另存为保存'
                                            ,content : html
                                            ,area: ['800px', '600px']
                                            ,yes: function(index, layero){
                                                layer.closeAll();
                                            }
                                        });
                                        return false;
                                    },
                                    error: function (data, ret) {
                                        console.log(data, ret);
                                        Layer.alert(ret.msg);
                                        return false;
                                    }
                                },
                                {
                                    name: 'detail',
                                    icon: 'fa fa-list',
                                    title: __('Detail'),
                                    extend: 'data-toggle="tooltip"',
                                    classname: 'btn btn-xs btn-primary btn-detailone',
                                    url: $.fn.bootstrapTable.defaults.extend.detail_url
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
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            },
            formatter:{
                showUser: {
                    'click .img-center': function (e, value, row, index) {
                        Fast.api.open('distribution/distributor/userInfo?id='+value.id,'用户信息',{
                            area:['800px','300px'],
                            success:function(){
                               // Fast.api.ajax({
                               //     url:'distribution/distributor/userInfo',
                               //     data:{
                               //         'id' :1
                               //     },
                               //     success:function(re){
                               //         Layer.close(layer.index);
                               //     }
                               // })
                            }
                        });
                    }
                }
            }
        }
    };
    return Controller;
});