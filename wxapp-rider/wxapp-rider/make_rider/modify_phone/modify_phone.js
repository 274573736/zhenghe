var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        phone: 0,
        idcard: "",
        code: "",
        img_url: app.globalData.imgUrl
    },
    phoneInput: function(e) {
        var t = e.detail.value;
        this.setData({
            phone: t
        });
    },
    codeInput: function(e) {
        var t = e.detail.value;
        this.setData({
            code: t
        });
    },
    code: function() {
        var e = this.data.phone;
        if (!/^1[3|4|5|6|7|8|9]\d{9}$/.test(e)) return app.hint("手机号输入有误");
        homeModule.riderEditMobile({
            is_send: 1,
            mobile: e
        }).then(function(e) {
            return app.hint("发送成功~");
        }, function(e) {});
    },
    form: function(e) {
        e.detail.value.idcard;
        var t = e.detail.value.phone, o = e.detail.value.code;
        return /^1(3|4|5|6|7|8|9)\d{9}$/.test(t) ? o ? void homeModule.riderEditMobile({
            mobile: t,
            code: o
        }).then(function(e) {
            wx.redirectTo({
                url: "../info/info"
            }), app.hint("修改成功", "success");
        }, function(e) {}) : app.hint("验证码不能为空") : app.hint("手机号输入有误");
    },
    onLoad: function(e) {
        app.setNavigation();
    },
    onReady: function() {},
    onShow: function() {
        app.listenWss(this);
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