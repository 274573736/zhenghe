define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index:function(){

            //代驾
            $("#driver-form").on("click",'.add',function(){
                var groupDOM = $(this).closest(".addgroup");
                var htmlText =  groupDOM.prop("outerHTML");
                groupDOM.after(htmlText);
            })
            $("#driver-form").on("click",'.del',(function(){
                var groupCount = $(".addgroup").length;
                if(groupCount == 1){
                    return;
                }
                var groupDOM = $(this).closest(".addgroup");
                groupDOM.remove();
            }))
            $("#distance_charge").click(function(){
                $("#amap_servier_id").addClass('hidden');
                $("#amap_driver_key").addClass('hidden');
            })
            $("#real_time").click(function(){
                $("#amap_servier_id").removeClass('hidden');
                $("#amap_driver_key").removeClass('hidden');

            })
            //end

            //帮送
            $("#price-form").on("click",'.bsadd',function(){
                var groupDOM = $(this).closest(".bsaddgroup");
                var htmlText =  groupDOM.prop("outerHTML");
                groupDOM.after(htmlText);
            })
            $("#price-form").on("click",'.bsdel',(function(){
                var groupCount = $(".bsaddgroup").length;
                if(groupCount == 1){
                    return;
                }
                var groupDOM = $(this).closest(".bsaddgroup");
                groupDOM.remove();
            }))
            //续重
            $("#price-form").on("click",'.wadd',function(){
                var groupDOM = $(this).closest(".addweight");
                var htmlText =  groupDOM.prop("outerHTML");
                groupDOM.after(htmlText);
            })
            $("#price-form").on("click",'.wdel',(function(){
                var groupCount = $(".addweight").length;
                if(groupCount == 1){
                    return;
                }
                var groupDOM = $(this).closest(".addweight");
                groupDOM.remove();
            }))
            //end

            //帮买
            $("#buy-form").on("click",'.bmadd',function(){
                var groupDOM = $(this).closest(".bmaddgroup");
                var htmlText =  groupDOM.prop("outerHTML");
                groupDOM.after(htmlText);
            })
            $("#buy-form").on("click",'.bmdel',(function(){
                var groupCount = $(".bmaddgroup").length;
                if(groupCount == 1){
                    return;
                }
                var groupDOM = $(this).closest(".bmaddgroup");
                groupDOM.remove();
            }))
            //续重
            $("#buy-form").on("click",'.mwadd',function(){
                var groupDOM = $(this).closest(".bmweight");
                var htmlText =  groupDOM.prop("outerHTML");
                groupDOM.after(htmlText);
            })
            $("#buy-form").on("click",'.mwdel',(function(){
                var groupCount = $(".bmweight").length;
                if(groupCount == 1){
                    return;
                }
                var groupDOM = $(this).closest(".bmweight");
                groupDOM.remove();
            }))
            //end

            //帮买夜间
            $("#buy-form").on("click",'.addPrice',function(){
                var groupDOM = $(this).closest(".addNightPrice");
                var htmlText =  groupDOM.prop("outerHTML");
                groupDOM.after(htmlText);
                Controller.api.bindevent();
            })
            $("#buy-form").on("click",'.delPrice',(function(){
                var groupCount = $(".addNightPrice").length;
                if(groupCount == 1){
                    return;
                }
                var groupDOM = $(this).closest(".addNightPrice");
                groupDOM.remove();
            }))

            //帮送夜间
            $("#price-form").on("click",'.addPrice',function(){
                var groupDOM = $(this).closest(".addNightPrice");
                var htmlText =  groupDOM.prop("outerHTML");
                groupDOM.after(htmlText);
                Controller.api.bindevent();
            })
            $("#price-form").on("click",'.delPrice',(function(){
                var groupCount = $(".addNightPrice").length;
                if(groupCount == 1){
                    return;
                }
                var groupDOM = $(this).closest(".addNightPrice");
                groupDOM.remove();
            }))

            //代驾
            $("#driver-form").on("click",'.addPrice',function(){
                var groupDOM = $(this).closest(".addNightPrice");
                var htmlText =  groupDOM.prop("outerHTML");
                groupDOM.after(htmlText);
                Controller.api.bindevent();
            })
            $("#driver-form").on("click",'.delPrice',(function(){
                var groupCount = $(".addNightPrice").length;
                if(groupCount == 1){
                    return;
                }
                var groupDOM = $(this).closest(".addNightPrice");
                groupDOM.remove();
            }))


            Controller.api.bindevent();

        },
        buy:function(){
            Controller.api.bindevent();
        },
        price:function(){
            Controller.api.bindevent();
        },
        driver:function(){
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