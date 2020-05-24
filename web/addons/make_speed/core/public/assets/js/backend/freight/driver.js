define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'freight/driver/index' + location.search,
                    add_url: 'freight/driver/add',
                    edit_url: 'freight/driver/edit',
                    del_url: 'freight/driver/del',
                    multi_url: 'freight/driver/multi',
                    table: 'driver',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: 'Id'},
                        {field: 'rider.real_name', title: '认证骑手'},
                        {field:'car','title':'认证车型'},
                        {field: 'drivers_license', title: '驾驶证', events: Controller.api.formatter.image, formatter:function (value, row, index) {
                            value = value ? value : '/assets/img/blank.gif';
                            var classname = typeof this.classname !== 'undefined' ? this.classname : 'img-sm img-center';
                            return '<img  style="cursor: pointer;" class="' + classname + '" src="' + Fast.api.cdnurl(value) + '" />';
                        }
                        },
                        {field: 'car_img', title: '车辆图片', events: Controller.api.formatter.image, formatter:function (value, row, index) {
                                value = value ? value : '/assets/img/blank.gif';
                                var classname = typeof this.classname !== 'undefined' ? this.classname : 'img-sm img-center';
                                return '<img  style="cursor: pointer;" class="' + classname + '" src="' + Fast.api.cdnurl(value) + '" />';
                            }
                        },
                        {field: 'plate_number', title: '车牌号'},
                        {field: 'status', title: '审核状态',searchList:{0:'待审核',1:'审核通过',2:'审核失败'},formatter:Table.api.formatter.status},
                        {field: 'create_time', title: '申请时间', operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ],

                ],

            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            $('#edit-form').validator({
                ignore: ':hidden'
            });

            var val = $("input[type='radio']:checked").val();
            if(val == 2){
                $("#pcau").removeClass('hide');
                $("#pcau").show();
            }

            $(':radio').click(function(){
                var value = $(this).val();
                if(value == 2){
                    $("#pcau").removeClass('hide');
                    $("#pcau").show();
                }else{
                    $("#pcau").hide();
                }
            });
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
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