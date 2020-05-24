var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        server_type: [],
        server_list: [],
        server_select: 0
    },
    onLoad: function(e) {
        var t = this;
        homeModule.getHomemakingList().then(function(e) {
            t.setData({
                server_list: e
            });
        }, function(e) {});
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    serverType: function(e) {
        this.setData({
            server_select: e.currentTarget.dataset.idx
        });
    },
    goodsBtn: function(e) {
        wx.navigateTo({
            url: "/sundries/homemaking/order/order?id=" + e.currentTarget.dataset.id + "&title=" + e.currentTarget.dataset.title + "&offer=" + e.currentTarget.dataset.offer
        });
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