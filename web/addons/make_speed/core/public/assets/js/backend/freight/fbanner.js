define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'freight/fbanner/index' + location.search,
                    add_url: 'freight/fbanner/add',
                    edit_url: 'freight/fbanner/edit',
                    del_url: 'freight/fbanner/del',
                    table: 'fbanner',
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
                        //{field: 'url', title: __('Url'), formatter: Table.api.formatter.url},
                        {field: 'image', title: __('Image'), events: Controller.api.formatter.image, formatter: function (value, row, index) {
                            value = value ? value : '/assets/img/blank.gif';
                            var classname = typeof this.classname !== 'undefined' ? this.classname : 'img-sm img-center';
                            return '<img  style="cursor: pointer;" class="' + classname + '" src="' + Fast.api.cdnurl(value) + '" />';
                        }},
                        {field: 'sort', title: __('Sort')},
                        {field: 'show_switch', title: __('Show_switch'),formatter:function(val,index,row){
                            if(val == 0){
                                return "<span class='label label-danger'>隐藏</span>";
                            }else{
                                return "<span class='label label-success'>显示</span>";
                            }
                        }},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            $("#select_app").click(function(e){
                $("#appid").removeClass('hide');
                $("#pages").removeClass('hide');
                $("#select_page").hide();
            })

            $("#page").click(function(e){
                $("#appid").addClass('hide');
                $("#pages").addClass('hide');
                $("#select_page").show();
            })
            Controller.api.bindevent();
        },
        edit: function () {
            $("#select_app").click(function(e){
                $("#appid").removeClass('hide');
                $("#pages").removeClass('hide');
                $("#select_page").addClass('hide');
            })

            $("#page").click(function(e){
                $("#appid").addClass('hide');
                $("#pages").addClass('hide');
                $("#select_page").removeClass('hide');
            })

            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                $('form[role=form]').validator({
                    ignore: ':hidden'
                });
                Form.api.bindevent($("form[role=form]"));
            },
            formatter:{
                image: {
                    'click .img-center': function (e, value, row, index) {
                        var data = [];
                        value = value.split(",");
                        $.each(value, function (index, value) {
                            data.push({
                                src: Fast.api.cdnurl(value),
                            });
                        });
                        Layer.photos({
                            photos: {
                                "data": [{src:$(this).attr('src')}]
                            },
                            anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
                        });
                    },
                }
            }
        }
    };
    return Controller;
});