var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        idx: -1,
        train_list: [],
        hint: !1,
        img_url: app.globalData.imgUrl
    },
    selectTrain: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.train_list[a];
        this.setData({
            idx: a
        }), wx.setStorageSync("train", e), wx.navigateBack({
            delta: 1
        });
    },
    onLoad: function(t) {
        var a = this;
        app.setNavigation();
        var e = t.city;
        homeModule.getTrain({
            city: e
        }).then(function(t) {
            if (console.log(t), t.error_code) return wx.removeStorageSync("train"), a.setData({
                hint: !1
            }), app.hint("该城市暂未开放");
            a.setData({
                train_list: t,
                hint: !0
            });
        }, function(t) {});
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