Component({
    properties: {
        close_order: {
            type: Boolean,
            value: !0
        }
    },
    data: {},
    methods: {
        closeOrderClose: function() {
            this.triggerEvent("closeOrderClose", {}, {});
        },
        confirmClose: function(e) {
            var t = this;
            if ("function" != typeof wx.requestSubscribeMessage) this.triggerEvent("confirmClose", {}, {}); else {
                var o = getApp().globalData.syStem;
                wx.requestSubscribeMessage({
                    tmplIds: [ o.cancel_template_id ],
                    complete: function(e) {
                        t.triggerEvent("confirmClose", {}, {});
                    }
                });
            }
        },
        closeOrder: function() {
            wx.navigateTo({
                url: "../protocol/protocol?title=取消订单规则&type=user_cancel"
            });
        }
    }
});