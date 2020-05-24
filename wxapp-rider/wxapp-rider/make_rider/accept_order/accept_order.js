var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        underwayOrder: [],
        img_url: app.globalData.imgUrl,
        page: 1,
        isData: !0
    },
    onLoad: function(a) {
        app.setNavigation(), this.postData(1);
    },
    postData: function(e) {
        var r = this;
        if (1 < e && !this.data.isData) return app.hint("暂无更多的订单~");
        homeModule.getRiderOrder({
            status: 5,
            page: e
        }).then(function(a) {
            var t = a;
            t && 1 < e && (t = r.data.underwayOrder.concat(t)), r.setData({
                underwayOrder: t,
                page: e,
                isData: !0
            });
        }, function(a) {
            if (1 < e) return r.setData({
                isData: !1
            }), app.hint("暂无更多的订单~");
            r.setData({
                underwayOrder: {},
                page: e
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        app.listenWss(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = 10 * this.data.page / 10 + 1;
        this.postData(a);
    },
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});