var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        idx: 0,
        question: {},
        tel: 0
    },
    onLoad: function(e) {
        var t = this;
        homeModule.getProtocol({
            type: "user_helper"
        }).then(function(e) {
            t.setData({
                question: e.content.question,
                tel: e.content.phone
            });
        }, function(e) {});
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    lookQuestion: function(e) {
        var t = e.currentTarget.dataset.idx;
        this.setData({
            idx: t
        });
    },
    tel: function() {
        if (!this.data.tel) return app.hint("暂未设置客服~");
        wx.makePhoneCall({
            phoneNumber: this.data.tel
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