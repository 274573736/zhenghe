var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {},
    onLoad: function(e) {
        var a = this;
        app.setNavigation(), homeModule.riderHandboookDetail({
            id: e.id
        }).then(function(e) {
            wx.setNavigationBarTitle({
                title: e.title
            }), a.setData({
                item: e
            });
        }, function(e) {});
    },
    onReady: function() {},
    onShow: function() {},
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