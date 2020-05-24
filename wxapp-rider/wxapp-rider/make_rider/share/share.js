var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        top_id: 0,
        share_bg: !0,
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl,
        list: {}
    },
    onLoad: function(e) {
        var t = this;
        homeModule.riderInviteLog().then(function(e) {
            t.setData({
                list: e
            });
        }, function(e) {}), app.setNavigation(), this.getPoster();
    },
    copy: function() {
        var e = this.data.list[0].invite_code;
        wx.setClipboardData({
            data: e,
            success: function(e) {}
        });
    },
    getPoster: function() {
        homeModule.getRiderPoster().then(function(e) {
            var t = homeModule.developFile(e.rider_img), o = homeModule.developFile(e.user_url);
            Promise.all([ t, o ]).then(function(e) {
                wx.setStorageSync("rider_bg_img", e[0]), wx.setStorageSync("user_bg_img", e[1]);
            }, function(e) {});
        }, function(e) {});
    },
    topActive: function(e) {
        this.setData({
            top_id: e.currentTarget.dataset.idx
        });
    },
    shareBtn: function() {
        this.setData({
            share_bg: !1
        });
    },
    closeShare: function() {
        this.setData({
            share_bg: !0
        });
    },
    posterBtn: function() {
        0 == this.data.top_id ? wx.navigateTo({
            url: "../poster/poster"
        }) : wx.navigateTo({
            url: "../poster_user/poster_user"
        });
    },
    shareRule: function() {
        wx.navigateTo({
            url: "../bean_description/bean_description?title=分享说明&type=rider_activity"
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(e) {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});