var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Component({
    properties: {
        hidden: {
            type: Boolean
        },
        my_money: {
            type: Number,
            value: 0
        },
        is_money: {
            type: Boolean,
            value: !0
        },
        pay_price: {
            type: Number
        },
        order_id: {
            type: Number
        },
        img_url: {
            type: String
        },
        business_id: {
            type: Number
        }
    },
    data: {},
    methods: {
        closeBJ: function() {
            this.triggerEvent("closeBJ", {}, {});
        },
        payWay: function(e) {
            var t = this, i = e.currentTarget.id, r = this.data.order_id, o = this.data.my_money, p = this.data.pay_price;
            return r <= 0 ? o <= p && 1 == i ? app.hint("余额不足") : this.triggerEvent("payMethod", {
                pay_method: i
            }, {}) : 1 == i ? o < p ? app.hint("余额不足") : void wx.showModal({
                title: "支付类型",
                content: "余额支付",
                success: function(e) {
                    if (e.confirm) {
                        if (0 == t.data.business_id) return void t.updateOrder(p, i, r);
                        t.businessTip(p, i, r);
                    }
                }
            }) : void (0 != this.data.business_id ? this.businessTip(p, i, r) : this.updateOrder(p, i, r));
        },
        updateOrder: function(e, i, r) {
            var o = this;
            homeModule.updateOrder({
                tip_money: e,
                pay_method: i,
                id: r
            }).then(function(t) {
                if (1 == i) return app.sendWs("type=place_order&order_id=" + r + "&data=" + t.accept_rider), 
                app.hint("支付小费成功", "success"), void o.triggerEvent("payMethod", {
                    pay_method: i
                }, {});
                homeModule.confirmPay(t.pay_params).then(function(e) {
                    app.sendWs("type=place_order&order_id=" + r + "&data=" + t.accept_rider), app.hint("支付小费成功！", "success"), 
                    o.triggerEvent("payMethod", {
                        pay_method: i
                    }, {});
                }, function(e) {
                    console.log(e);
                });
            });
        },
        businessTip: function(e, t, i) {
            var r = this;
            homeModule.businessTip({
                id: i,
                tip_money: e,
                pay_method: t
            }).then(function(e) {
                app.sendWs("type=place_order&order_id=" + i + "&data=" + e.accept_rider), app.hint("支付小费成功", "success"), 
                r.triggerEvent("payMethod", {
                    pay_method: t
                }, {});
            }, function(e) {});
        }
    }
});