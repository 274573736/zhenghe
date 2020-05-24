define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'freight/vehicle/index' + location.search,
                    add_url: 'freight/vehicle/add',
                    edit_url: 'freight/vehicle/edit',
                    del_url: 'freight/vehicle/del',
                    multi_url: 'freight/vehicle/multi',
                    table: 'vehicle',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                commonSearch:false,
                search:false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'title', title: __('Title')},
                        {field: 'image', title: '车辆图片', events: Controller.api.formatter.image, formatter:function (value, row, index) {
                            value = value ? value : '/assets/img/blank.gif';
                            var classname = typeof this.classname !== 'undefined' ? this.classname : 'img-sm img-center';
                            return '<img  style="cursor: pointer;" class="' + classname + '" src="' + Fast.api.cdnurl(value) + '" />';
                        }
                        },
                        {field: 'load', title: __('Load')},
                        //{field: 'size', title: '车身'},
                        {field: 'starting_price', title: __('Starting_price'), operate:'BETWEEN'},
                        {field: 'starting_km', title: __('Starting_km')},
                        {field: 'status', title: '状态',formatter:function(val,row,index){
                            if(val == 0){
                                return "<span class='label label-danger'>隐藏</span>";
                            }else{
                                return "<span class='label label-success'>显示</span>";
                            }
                        }},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'sort', title: __('Sort')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ],

                ],
                onLoadSuccess:function(){
                    $(".btn-editone").data("area", ['960px','700px']);
                    $(".btn-add").data("area", ['960px','700px']);

                },
                onPostBody : function (options) {
                }
            });







            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            $("#add-form").on('click','#add_input',function(){
                var xucPerKmDOM = $(this).closest(".xucPerKm");
                var addHtml =  xucPerKmDOM.prop("outerHTML");
                xucPerKmDOM.after(addHtml);
            })

            $("#add-form").on("click",".xucPerKm .del_input",function(){
                var xCount = $('.xucPerKm').length;
                if(xCount == 1){
                    return;
                }
                var xucPerKmHTML = $(this).closest(".xucPerKm");
                xucPerKmHTML.remove();
            })


            $("#add-form").on('click','.add_weight',function(){
                var xucPerKmDOM = $(this).closest(".weight_group");
                var addHtml =  xucPerKmDOM.prop("outerHTML");
                xucPerKmDOM.after(addHtml);
            })
            $("#add-form").on("click",".weight_group .del_weight",function(){
                var xCount = $('.weight_group').length;
                if(xCount == 1){
                    return;
                }
                var xucPerKmHTML = $(this).closest(".weight_group");
                xucPerKmHTML.remove();
            })

            $("#add-form").on('click','.add_load',function(){
                var xucPerKmDOM = $(this).closest(".load_group");
                var addHtml =  xucPerKmDOM.prop("outerHTML");
                xucPerKmDOM.after(addHtml);
            })
            $("#add-form").on("click",".load_group .del_load",function(){
                var xCount = $('.load_group').length;
                if(xCount == 1){
                    return;
                }
                var xucPerKmHTML = $(this).closest(".load_group");
                xucPerKmHTML.remove();
            })


            $("#add-form").on('click','.add_cub',function(){
                var xucPerKmDOM = $(this).closest(".cub_group");
                var addHtml =  xucPerKmDOM.prop("outerHTML");
                xucPerKmDOM.after(addHtml);
            })
            $("#add-form").on("click",".cub_group .del_cub",function(){
                var xCount = $('.cub_group').length;
                if(xCount == 1){
                    return;
                }
                var xucPerKmHTML = $(this).closest(".cub_group");
                xucPerKmHTML.remove();
            })


            Controller.api.bindevent();
        },
        edit: function () {
            $("#edit-form").on('click','#add_input',function(){
                var xucPerKmDOM = $(this).closest(".xucPerKm");
                var addHtml =  xucPerKmDOM.prop("outerHTML");
                xucPerKmDOM.after(addHtml);
            })

            $("#edit-form").on("click",".xucPerKm .del_input",function(){
                var xCount = $('.xucPerKm').length;
                if(xCount == 1){
                    return;
                }
                var xucPerKmHTML = $(this).closest(".xucPerKm");
                xucPerKmHTML.remove();
            })


            $("#edit-form").on('click','.add_weight',function(){
                var xucPerKmDOM = $(this).closest(".weight_group");
                var addHtml =  xucPerKmDOM.prop("outerHTML");
                xucPerKmDOM.after(addHtml);
            })
            $("#edit-form").on("click",".weight_group .del_weight",function(){
                var xCount = $('.weight_group').length;
                if(xCount == 1){
                    return;
                }
                var xucPerKmHTML = $(this).closest(".weight_group");
                xucPerKmHTML.remove();
            })

            $("#edit-form").on('click','.add_load',function(){
                var xucPerKmDOM = $(this).closest(".load_group");
                var addHtml =  xucPerKmDOM.prop("outerHTML");
                xucPerKmDOM.after(addHtml);
            })
            $("#edit-form").on("click",".load_group .del_load",function(){
                var xCount = $('.load_group').length;
                if(xCount == 1){
                    return;
                }
                var xucPerKmHTML = $(this).closest(".load_group");
                xucPerKmHTML.remove();
            })

            $("#edit-form").on('click','.add_cub',function(){
                var xucPerKmDOM = $(this).closest(".cub_group");
                var addHtml =  xucPerKmDOM.prop("outerHTML");
                xucPerKmDOM.after(addHtml);
            })
            $("#edit-form").on("click",".cub_group .del_cub",function(){
                var xCount = $('.cub_group').length;
                if(xCount == 1){
                    return;
                }
                var xucPerKmHTML = $(this).closest(".cub_group");
                xucPerKmHTML.remove();
            })

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