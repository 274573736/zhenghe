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
        pay_method: {
            type: Number,
            value: 2
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
        order_type: {
            type: Number
        },
        charg_type: {
            type: Number
        }
    },
    data: {},
    methods: {
        closeBJ: function() {
            this.triggerEvent("closeBJ", {}, {});
        },
        payWay: function(e) {
            var a = this, t = this, o = e.currentTarget.id, r = this.data.order_id;
            if (r <= 0) return this.properties.my_money <= this.properties.pay_price && 1 == o ? app.hint("余额不足") : this.triggerEvent("payMethod", {
                pay_method: o
            }, {});
            if (1 == o) {
                if (this.data.my_money < this.data.pay_price) return app.hint("余额不足");
                wx.showModal({
                    title: "支付类型",
                    content: "余额支付",
                    success: function(e) {
                        if (e.confirm) {
                            if (5 == a.data.order_type) return void homeModule.payFreight({
                                id: r,
                                pay_method: o
                            }).then(function(e) {
                                2 != a.data.charg_type && app.sendWs("type=place_order&order_id=" + r + "&data=" + e.data), 
                                t.triggerEvent("payMethod", {
                                    pay_method: o
                                }, {});
                            }, function(e) {});
                            homeModule.amount("pay", {
                                pay_method: o,
                                id: r
                            }).then(function(e) {
                                2 != a.data.charg_type && app.sendWs("type=place_order&order_id=" + r + "&data=" + e.data), 
                                t.triggerEvent("payMethod", {
                                    pay_method: o
                                }, {});
                            }, function(e) {});
                        } else e.cancel && console.log("用户点击取消");
                    }
                });
            } else if (2 == o) {
                if (5 == this.data.order_type) return void homeModule.payFreight({
                    id: r,
                    pay_method: o
                }).then(function(t) {
                    homeModule.confirmPay(t.pay_params).then(function(e) {
                        app.sendWs("type=place_order&order_id=" + r + "&data=" + t.data), a.triggerEvent("payMethod", {
                            pay_method: o
                        }, {});
                    }, function(e) {
                        a.failPay(r);
                    });
                }, function(e) {});
                homeModule.pay({
                    id: r
                }).then(function(t) {
                    homeModule.confirmPay(t.pay_params).then(function(e) {
                        2 != a.data.charg_type && app.sendWs("type=place_order&order_id=" + r + "&data=" + t.data), 
                        a.triggerEvent("payMethod", {
                            pay_method: o
                        }, {});
                    }, function(e) {});
                }, function(e) {
                    console.log("支付失败");
                });
            }
        }
    }
});