var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        top_item: [ "可用优惠券", "失效券" ],
        top_p: "0 80rpx 0 80rpx",
        idx: 0,
        list: [],
        order_type: 0,
        distance: 0,
        money: 0
    },
    onLoad: function(e) {
        var t = 0 <= e.order_type ? e.order_type : -1, o = 0 <= e.money ? e.money : 0, n = 0 <= e.distance ? e.distance : 0;
        this.setData({
            order_type: t,
            money: o,
            distance: n
        }), this.getCoupons(t);
    },
    getCoupons: function(e) {
        var t = this;
        homeModule.getCoupons({
            type: this.data.idx,
            order_type: e
        }).then(function(e) {
            t.setData({
                list: e
            });
        }, function(e) {
            t.setData({
                list: []
            });
        });
    },
    getCodeCoupon: function(e) {
        var t = this, o = e.detail.code;
        homeModule.getCodeCoupon({
            code: o
        }).then(function(e) {
            app.hint("兑换成功~"), t.getCoupons(t.data.order_type);
        }, function(e) {});
    },
    Getidx: function(e) {
        var t = e.detail.idx;
        this.setData({
            idx: t
        }), this.getCoupons(this.data.order_type);
    },
    scrollSole: function() {},
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return app.getShare(), {
            title: app.globalData.syStem.user_program_title,
            path: "/make_speed/router/router?recommend_id=" + app.globalData.user_id,
            imageUrl: app.globalData.syStem.user_share_img ? app.globalData.syStem.user_share_img : ""
        };
    }
});