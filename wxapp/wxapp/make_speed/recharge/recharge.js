var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        moneys_array: [ 20, 30, 50, 100, 200, 300, 500 ],
        idx: -1,
        value: 0,
        money: 0,
        is_business: 0,
        list: [],
        protocol: !1
    },
    onLoad: function(t) {
        var e = t.is_business || 0, a = t.money || 0;
        this.setData({
            money: a,
            is_business: e
        }), this.list(e);
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    list: function() {
        var e = this;
        1 != (0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0) ? homeModule.rechargeValid({
            list: 1
        }).then(function(t) {
            e.setData({
                list: t
            });
        }, function(t) {}) : homeModule.businessRecharge({
            list: 1,
            bid: app.globalData.business_id
        }).then(function(t) {
            e.setData({
                list: t
            });
        }, function(t) {});
    },
    selected: function(t) {
        var e = t.currentTarget.dataset.idx;
        this.setData({
            idx: e
        });
    },
    bindInput: function(t) {
        var e = t.detail.value.replace(/[^\d.]/g, "");
        this.setData({
            value: e,
            idx: -1
        });
    },
    rechargeProtocol: function() {
        wx.navigateTo({
            url: "../protocol/protocol?title=充值协议&type=user_recharge"
        });
    },
    confirm: function() {
        var e = this, t = this.data.idx, a = this.data.value, o = this.data.list.list;
        if (t < 0 && (0 == a || "" == a)) return app.hint("请先选择金额");
        if (!this.data.protocol) return app.hint("请同意充值协议~");
        var n = 0;
        0 <= t && (n = o[t]), 0 < a && t < 0 && (n = a), 1 != this.data.is_business ? homeModule.rechargeValid({
            money: n
        }).then(function(t) {
            e.paySuccess(t.pay_params);
        }, function(t) {}) : homeModule.businessRecharge({
            money: n,
            bid: app.globalData.business_id
        }).then(function(t) {
            e.paySuccess(t.pay_params);
        }, function(t) {});
    },
    paySuccess: function(t) {
        homeModule.confirmPay(t).then(function(t) {
            app.hint("充值成功！", "success"), setTimeout(function() {
                wx.navigateBack({
                    delta: 1
                });
            }, 400);
        }, function(t) {
            console.log("支付失败");
        });
    },
    coopration: function() {
        wx.navigateTo({
            url: "../protocol/protocol?title=充值协议&type=user_recharge"
        });
    },
    checkboxChange: function(t) {
        this.setData({
            protocol: t.detail.value[0] || !1
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