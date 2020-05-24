var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        train: {},
        img_url: app.globalData.imgUrl,
        time: ""
    },
    onLoad: function(e) {
        var n = this;
        app.setNavigation(), e.message && wx.showModal({
            title: "拒绝原因",
            content: e.message,
            showCancel: !1,
            confirmText: "前往修改",
            success: function(e) {
                e.confirm && wx.reLaunch({
                    url: "../register/register"
                });
            }
        }), homeModule.appointmentSuccess().then(function(e) {
            var t = "";
            t = 0 == e.type ? e.morn : e.after, n.setData({
                train: e,
                time: t
            });
        }, function(e) {});
    },
    onReady: function() {},
    onShow: function() {},
    confirm: function() {
        homeModule.getRiderStatus().then(function(e) {
            if (4 == e.status) {
                var t = "../login/login";
                wx.getStorageSync("phone") && (t = "../index/index"), wx.reLaunch({
                    url: t
                });
            } else if (5 == e.status) {
                if (!e.message) return;
                wx.showModal({
                    title: "拒绝原因",
                    content: e.message,
                    showCancel: !1,
                    confirmText: "前往修改",
                    success: function(e) {
                        e.confirm && wx.reLaunch({
                            url: "../register/register"
                        });
                    }
                });
            } else wx.showModal({
                title: "温馨提醒",
                content: "您需要前往当地培训站点进行培训后，方能开始接单~",
                success: function(e) {
                    e.confirm ? console.log("用户点击确定") : e.cancel && console.log("用户点击取消");
                }
            });
        });
    },
    callRel: function() {
        var e = this.data.train.phone;
        wx.makePhoneCall({
            phoneNumber: e
        });
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