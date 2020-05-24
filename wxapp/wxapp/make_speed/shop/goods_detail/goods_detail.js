var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        list: {}
    },
    onLoad: function(e) {
        var t = this;
        homeModule.getGoodsDetail({
            id: e.id
        }).then(function(e) {
            t.setData({
                list: e
            });
        }, function(e) {});
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    conversionBtn: function(e) {
        var t = e.currentTarget.dataset.id;
        homeModule.buyCoupon({
            id: t
        }).then(function(e) {
            app.hint("恭喜兑换成功~"), setTimeout(function() {
                wx.navigateBack({
                    delta: 1
                });
            }, 400);
        }, function(e) {});
    },
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