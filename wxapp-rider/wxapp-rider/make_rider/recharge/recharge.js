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
        is_cash: 0,
        recharge_money: ""
    },
    onLoad: function(e) {
        app.setNavigation();
        var a = 1 * wx.getStorageSync("money"), n = app.globalData.syStem.is_can_accept, t = 1 * app.globalData.syStem.rider_bondmoney, o = t - 1 * e.cash_money;
        0 <= o && (o = Math.ceil(o)), this.setData({
            money: a,
            is_cash: n,
            cash: t,
            recharge_money: 0 < o ? o : "",
            recharge_num: 0 < o ? o : 0
        });
    },
    onReady: function() {},
    onShow: function() {
        app.listenWss(this);
    },
    rechargeNum: function(e) {
        var a = e.detail.value;
        a = a.replace(/[^\d.]/g, ""), this.setData({
            recharge_num: a
        });
    },
    confirm: function() {
        var e = this.data.recharge_num;
        if (!e) return app.hint("请填写充值金额");
        homeModule.recharge({
            money: e
        }).then(function(e) {
            homeModule.confirmPay(e.pay_params).then(function(e) {
                homeModule.getSystem().then(function(e) {
                    app.globalData.syStem = e, app.hint("充值成功~", "success"), setTimeout(function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }, 400);
                }, function(e) {});
            }, function(e) {});
        }, function(e) {});
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