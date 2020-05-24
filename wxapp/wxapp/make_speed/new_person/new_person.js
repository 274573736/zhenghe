var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        phone: 0,
        code: 0,
        redbagData: {}
    },
    onLoad: function(e) {
        var t = this;
        homeModule.getRecommendRedbag({
            is_init: 1
        }).then(function(e) {
            t.setData({
                redbagData: e
            });
        }, function(e) {});
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    activity: function() {
        wx.navigateTo({
            url: "../protocol/protocol?title=活动规则&type=user_redbao"
        });
    },
    phone: function(e) {
        this.setData({
            phone: e.detail.value
        });
    },
    code: function(e) {
        this.setData({
            code: e.detail.value
        });
    },
    sendCode: function() {
        var e = this.data.phone;
        return e ? /^1[3|4|5|6|7|8|9][0-9]\d{8}$/.test(e) ? void homeModule.getRecommendRedbag({
            mobile: e,
            is_send: 1
        }) : app.hint("手机号输入有误") : app.hint("手机号不能为空");
    },
    confirm: function() {
        var t = this, e = this.data.phone, a = this.data.code;
        return e ? /^1[3|4|5|6|7|8|9][0-9]\d{8}$/.test(e) ? a ? void homeModule.getRecommendRedbag({
            is_send: "",
            code: a,
            id: this.data.redbagData.id,
            mobile: e
        }).then(function(e) {
            wx.showModal({
                title: "领取成功",
                content: "恭喜您成功领取" + t.data.redbagData.money + "元优惠券，赶快去下单使用吧！",
                showCancel: !1,
                success: function(e) {
                    e.confirm && app.toUrl(app.globalData.syStem);
                }
            });
        }, function(e) {
            app.toUrl(app.globalData.syStem);
        }) : app.hint("验证码不能为空") : app.hint("手机号输入有误") : app.hint("手机号不能为空");
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