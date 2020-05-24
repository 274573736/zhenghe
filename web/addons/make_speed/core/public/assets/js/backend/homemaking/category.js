define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'template'], function ($, undefined, Backend, Table, Form, Template) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    "index_url": "homemaking/category/index",
                    "add_url": "homemaking/category/add",
                    "edit_url": "homemaking/category/edit",
                    "del_url": "homemaking/category/del",
                    "multi_url": "homemaking/category/multi",
                    "table": "category"
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                sortName: 'sort',
                escape: false,
                columns: [
                    [
                        {field: 'state', checkbox: true,},
                        {field: 'id', title: 'ID'},
                        {field: 'title', title: __('Title'), align: 'left', formatter: Controller.api.formatter.title},
                        {field: 'icon', title: '图标',events: Controller.api.formatter.image, formatter: function (value, row, index) {
                                value = value ? value : '/assets/img/blank.gif';
                                var classname = typeof this.classname !== 'undefined' ? this.classname : 'img-sm img-center';
                                return '<img  style="cursor: pointer;" class="' + classname + '" src="' + Fast.api.cdnurl(value) + '" />';
                            }
                        },
                        {field: 'deposit', title: '服务金额',formatter:function(value,row,index){
                                if(row.pid != 0 ){
                                    return value;
                                }
                                return '无';
                            }
                        },
                        {field: 'commission_house', title: '抽佣比例',formatter:function(value,row,index){
                                if(row.pid != 0 ){
                                    return value;
                                }
                                return '无';
                            }
                        },
                        {field: 'offer', title: '预估价',formatter:function(value,row,index){
                                if(row.pid != 0 ){
                                    return value;
                                }
                                return '无';
                            }
                        },
                        {field: 'desc', title: '简述'},
                        {field: 'sort', title: '排序'},
                        {field: 'is_show', title: '是否显示', align: 'center', formatter: Table.api.formatter.toggle},
                        {field: 'create_time', title: '添加时间', operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {
                            field: 'id',
                            title: '<a href="javascript:;" class="btn btn-success btn-xs btn-toggle-all"><i class="fa fa-chevron-up"></i></a>',
                            operate: false,
                            formatter: Controller.api.formatter.subnode
                        },
                        {
                            field: 'operate',
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            formatter: Table.api.formatter.operate
                        }
                    ]
                ],
                pagination: false,
                search: false,
                commonSearch: false,
            });

            // 为表格绑定事件
            Table.api.bindevent(table);

            //当内容渲染完成后
            table.on('post-body.bs.table', function (e, settings, json, xhr) {
                //默认隐藏所有子节点
                //$("a.btn[data-id][data-pid][data-pid!=0]").closest("tr").hide();
                // $(".btn-node-sub.disabled").closest("tr").hide();

                //显示隐藏子节点
                $(".btn-node-sub").off("click").on("click", function (e) {
                    var status = $(this).data("shown") ? true : false;
                    $("a.btn[data-pid='" + $(this).data("id") + "']").each(function () {
                        $(this).closest("tr").toggle(!status);
                    });
                    $(this).data("shown", !status);
                    return false;
                });
                $(".btn-change[data-id],.btn-delone,.btn-dragsort").data("success", function (data, ret) {
                    Fast.api.refreshmenu();
                });

            });

            //批量删除后的回调
            $(".toolbar > .btn-del,.toolbar .btn-more~ul>li>a").data("success", function (e) {
                Fast.api.refreshmenu();
            });
            //展开隐藏一级
            $(document.body).on("click", ".btn-toggle", function (e) {
                $("a.btn[data-id][data-pid][data-pid!=0].disabled").closest("tr").hide();
                var that = this;
                var show = $("i", that).hasClass("fa-chevron-down");
                $("i", that).toggleClass("fa-chevron-down", !show);
                $("i", that).toggleClass("fa-chevron-up", show);
                $("a.btn[data-id][data-pid][data-pid!=0]").not('.disabled').closest("tr").toggle(show);
                $(".btn-node-sub[data-pid=0]").data("shown", show);
            });
            //展开隐藏全部
            $(document.body).on("click", ".btn-toggle-all", function (e) {
                var that = this;
                var show = $("i", that).hasClass("fa-plus");
                $("i", that).toggleClass("fa-plus", !show);
                $("i", that).toggleClass("fa-minus", show);
                $(".btn-node-sub.disabled").closest("tr").toggle(show);
                $(".btn-node-sub").data("shown", show);
            });
        },
        add: function () {
            $('#pid').on('change',function(){
                if(this.value != 0){
                    $('#deposit').removeClass('hide');
                    $('#commission').removeClass('hide');
                    $('#desc').removeClass('hide');
                    $('#offer').removeClass('hide');
                    $('#sdesc').removeClass('hide');
                }else{
                    $('#deposit').addClass('hide');
                    $('#commission').addClass('hide');
                    $('#desc').addClass('hide');
                    $('#offer').addClass('hide');
                    $('#sdesc').addClass('hide');

                }
            })
            Controller.api.bindevent();
        },
        edit: function () {
            var val = $('#pid  option:selected').val();
            if(val != 0){
                $('#deposit').removeClass('hide');
                $('#commission').removeClass('hide');
                $('#desc').removeClass('hide');
                $('#offer').removeClass('hide');
                $('#sdesc').removeClass('hide');

            }
            $('#pid').on('change',function(){
                if(this.value != 0){
                    $('#deposit').removeClass('hide');
                    $('#commission').removeClass('hide');
                    $('#desc').removeClass('hide');
                    $('#offer').removeClass('hide');
                    $('#sdesc').removeClass('hide');

                }else{
                    $('#deposit').addClass('hide');
                    $('#commission').addClass('hide');
                    $('#desc').addClass('hide');
                    $('#offer').addClass('hide');
                    $('#sdesc').addClass('hide');

                }
            })
            Controller.api.bindevent();
        },
        api: {
            formatter: {
                title: function (value, row, index) {
                    return !row.is_show  ? "<span class='text-muted'>" + value + "</span>" : value;
                },

                subnode: function (value, row, index) {
                    return '<a href="javascript:;" data-toggle="tooltip" title="' + '显示子分类' + '" data-id="' + row.id + '" data-pid="' + row.pid + '" class="btn btn-xs '
                        + (row.haschild == 1 ? 'btn-success' : 'btn-default disabled') + ' btn-node-sub"><i class="fa fa-sitemap"></i></a>';
                },
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
            },
            bindevent: function () {
                $(document).on('click', "input[name='row[ismenu]']", function () {
                    var name = $("input[name='row[name]']");
                    name.prop("placeholder", $(this).val() == 1 ? name.data("placeholder-menu") : name.data("placeholder-node"));
                });
                $("input[name='row[ismenu]']:checked").trigger("click");

                var iconlist = [];
                var iconfunc = function () {
                    Layer.open({
                        type: 1,
                        area: ['99%', '98%'], //宽高
                        content: Template('chooseicontpl', {iconlist: iconlist})
                    });
                };
                Form.api.bindevent($("form[role=form]"), function (data) {
                    Fast.api.refreshmenu();
                });
                $(document).on('click', ".btn-search-icon", function () {
                    if (iconlist.length == 0) {
                        $.get(Config.site.cdnurl + "/assets/libs/font-awesome/less/variables.less", function (ret) {
                            var exp = /fa-var-(.*):/ig;
                            var result;
                            while ((result = exp.exec(ret)) != null) {
                                iconlist.push(result[1]);
                            }
                            iconfunc();
                        });
                    } else {
                        iconfunc();
                    }
                });
                $(document).on('click', '#chooseicon ul li', function () {
                    $("input[name='row[icon]']").val('fa fa-' + $(this).data("font"));
                    Layer.closeAll();
                });
                $(document).on('keyup', 'input.js-icon-search', function () {
                    $("#chooseicon ul li").show();
                    if ($(this).val() != '') {
                        $("#chooseicon ul li:not([data-font*='" + $(this).val() + "'])").hide();
                    }
                });
            }
        }
    };
    return Controller;
});