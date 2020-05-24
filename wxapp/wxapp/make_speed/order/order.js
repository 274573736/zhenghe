var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        fahuo: {},
        shouhuo: {},
        order: {},
        loading: !1,
        gy_discount: 0
    },
    onLoad: function(a) {
        var t = wx.getStorageSync("fahuo"), e = wx.getStorageSync("shouhuo"), o = wx.getStorageSync("order"), r = 100 * app.globalData.syStem.gy_discount;
        this.setData({
            fahuo: t,
            shouhuo: e,
            order: o,
            gy_discount: r
        }), app.connectWs();
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    confirm: function(a) {
        var t = this;
        if (!this.data.loading) {
            this.setData({
                loading: !0
            });
            var e = this.data.order.pay_method, o = this.data.order.order_type, r = {};
            0 == o ? r = {
                weight_num: this.data.order.weight_num,
                remark: this.data.order.remark,
                distance: this.data.order.distance,
                duration: this.data.order.duration || 0,
                time: this.data.order.time,
                coupons_id: this.data.order.coupons_id,
                standard_id: this.data.order.standard_id,
                pay_method: e,
                order_type: o,
                city: wx.getStorageSync("city"),
                moneys: this.data.order.moneys,
                night_price: this.data.order.night_price,
                change_price: this.data.order.change_price,
                discount_price: this.data.order.discount_price,
                distance_price: this.data.order.distance_price,
                actual_payment: this.data.order.actual_payment,
                tip_money: this.data.order.tip_money,
                fahuo: this.data.fahuo,
                shouhuo: this.data.shouhuo
            } : (r = wx.getStorageSync("order")).buy_type = 0, homeModule.toOrder(r).then(function(a) {
                t.pay(a.order_id, e);
            }, function(a) {
                t.setData({
                    loading: !1
                });
            });
        }
    },
    pay: function(e, o) {
        var r = this;
        homeModule.pay({
            id: e,
            pay_method: o
        }).then(function(a) {
            var t = a.data;
            2 != o ? r.paySuccess(e, t) : homeModule.confirmPay(a.pay_params).then(function(a) {
                r.paySuccess(e, t);
            }, function(a) {
                r.failPay(e);
            });
        }, function(a) {
            r.failPay(e);
        });
    },
    paySuccess: function(a, t) {
        app.sendWs("type=place_order&order_id=" + a + "&data=" + t), app.closeWs(), app.hint("支付成功~", "success"), 
        setTimeout(function() {
            wx.redirectTo({
                url: "../order_pay/order_pay?order_id=" + a + "&status=2"
            });
        }, 400);
    },
    failPay: function(a) {
        setTimeout(function() {
            wx.redirectTo({
                url: "../order_pay/order_pay?order_id=" + a + "&status=0"
            });
        }, 400);
    },
    onHide: function() {},
    onUnload: function() {
        app.closeWs();
    },
    onShareAppMessage: function() {
        return app.getShare(), {
            title: app.globalData.syStem.user_program_title,
            path: "/make_speed/router/router?recommend_id=" + app.globalData.user_id,
            imageUrl: app.globalData.syStem.user_share_img ? app.globalData.syStem.user_share_img : ""
        };
    }
});