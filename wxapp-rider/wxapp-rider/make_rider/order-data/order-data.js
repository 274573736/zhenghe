var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl,
        order_total_price: 0,
        order_total_num: 0,
        list: []
    },
    onLoad: function(e) {
        var t = this;
        app.setNavigation();
        var o = e.order_total_price, a = e.order_total_num;
        this.setData({
            order_total_price: o,
            order_total_num: a
        }), homeModule.getOrderCount().then(function(e) {
            t.setData({
                list: e
            });
        }, function(e) {});
    },
    onReady: function() {},
    onShow: function() {
        app.listenWss(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});