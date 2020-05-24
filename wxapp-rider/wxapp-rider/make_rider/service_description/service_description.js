var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        protocol: ""
    },
    onLoad: function(o) {
        var e = this;
        app.setNavigation(), homeModule.getProtocol({
            type: "rider_bean"
        }).then(function(o) {
            console.log(o), e.setData({
                protocol: o.content
            });
        }, function(o) {});
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