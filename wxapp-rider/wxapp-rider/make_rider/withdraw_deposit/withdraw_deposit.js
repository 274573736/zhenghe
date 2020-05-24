var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        recharge_num: 0,
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl,
        money: 0,
        id: 2,
        pay_method: [ 0, 0, 1 ],
        moneys: "",
        is_cash: !1,
        cash: ""
    },
    onLoad: function(a) {
        app.setNavigation();
        var e = wx.getStorageSync("money"), t = wx.getStorageSync("cash");
        this.setData({
            money: e,
            cash: t
        });
    },
    onReady: function() {},
    onShow: function() {
        app.listenWss(this);
    },
    withdraw: function(a) {
        0 == a.currentTarget.dataset.idx ? this.setData({
            is_cash: !0,
            moneys: this.data.cash
        }) : this.setData({
            is_cash: !1,
            moneys: this.data.money
        });
    },
    selected: function(a) {
        var e = a.currentTarget.dataset.id, t = [ 0, 0, 0 ];
        t[e] = 1, this.setData({
            id: e,
            pay_method: t
        });
    },
    submit: function(a) {
        var e = this.data.id, t = a.detail.value, n = t.money.replace(/[^\d.]/g, ""), i = "";
        if (!n || n <= 0) return app.hint("提现金额不能为空");
        if (0 == e) {
            if (!t.alipay) return app.hint("支付宝不能为空");
            i = t.alipay;
        } else if (1 == e) {
            if (!t.open_blank) return app.hint("开户行不能为空");
            if (!t.blank_name) return app.hint("户名不能为空");
            if (!t.blank_num) return app.hint("卡号不能为空");
            i = t.open_blank + "|" + t.blank_name + "|" + t.blank_num;
        }
        homeModule.withdraw({
            money: n,
            des: i,
            type: e,
            is_cash: this.data.is_cash
        }).then(function(a) {
            homeModule.getSystem().then(function(a) {
                app.globalData.syStem = a, app.hint("提交成功", "success"), setTimeout(function() {
                    wx.navigateBack({
                        delta: 1
                    });
                }, 400);
            }, function(a) {});
        }, function(a) {});
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