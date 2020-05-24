var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp(), WxParse = require("../../utils/wxParse/wxParse.js");

Page({
    data: {
        protocol: ""
    },
    onLoad: function(t) {
        var o = this;
        wx.setNavigationBarTitle({
            title: t.title
        }), t.isHomemaking ? homeModule.getHomemakingDes({
            id: t.id || 0
        }).then(function(e) {
            WxParse.wxParse("article", "html", e.service_desc, o, 0);
        }, function(e) {}) : t.staff ? homeModule.businessSetting().then(function(e) {
            WxParse.wxParse("article", "html", e[t.type], o, 0);
        }, function(e) {}) : t.system_index ? homeModule.getSystemMessageDetail({
            id: t.id
        }).then(function(e) {
            WxParse.wxParse("article", "html", e.content, o, 0);
        }, function(e) {}) : homeModule.getProtocol({
            type: t.type
        }).then(function(e) {
            WxParse.wxParse("article", "html", e.content, o, 0);
        }, function(e) {});
    },
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