var app = getApp();

Component({
    properties: {
        hidden: {
            type: Boolean,
            observer: function(t, e, a) {
                var n = this;
                t ? this.setData({
                    showAnimation: !1
                }) : setTimeout(function() {
                    n.setData({
                        showAnimation: !0
                    });
                }, 100);
            }
        },
        my_money: {
            type: Number,
            value: 0
        },
        money: {
            type: Number
        },
        pay_method: {
            type: Number
        },
        order_type: {
            type: Number
        }
    },
    data: {
        showAnimation: !1
    },
    methods: {
        confirmBtn: function(t) {
            var e = this.data.pay_method;
            this.triggerEvent("sPay", {
                select: 1,
                pay_method: e
            }, {});
        },
        sPay: function(t) {
            var e = t.currentTarget.dataset.id;
            if (1 == e) return this.data.my_money < this.data.money ? app.hint("余额不足") : void this.setData({
                pay_method: e
            });
            this.setData({
                pay_method: e
            });
        },
        closeBtn: function() {
            this.triggerEvent("sPay", {
                select: 2
            }, {});
        }
    }
});