var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp(), WxParse = require("../../../utils/wxParse/wxParse.js");

Page({
    data: {
        detail: ""
    },
    onLoad: function(e) {
        var a = this, t = e.id;
        homeModule.carDetail({
            id: t
        }).then(function(e) {
            WxParse.wxParse("article", "html", e.car_detail, a, 0), wx.setNavigationBarTitle({
                title: e.title
            });
        }, function(e) {});
    },
    onReady: function() {
        app.setNavigation();
    },
    onShareAppMessage: function() {
        return app.getShare(), {
            title: app.globalData.syStem.user_program_title,
            path: "/make_speed/router/router?recommend_id=" + app.globalData.user_id,
            imageUrl: app.globalData.syStem.user_share_img ? app.globalData.syStem.user_share_img : ""
        };
    }
});