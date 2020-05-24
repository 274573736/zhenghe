var app = getApp();

Component({
    properties: {
        hidden: {
            type: Boolean
        },
        standard: {
            type: []
        }
    },
    data: {
        tip: [ "不加小费", "1元", "3元", "5元", "7元", "10元", "20元", "其他" ],
        idx: 0,
        other: !0
    },
    methods: {
        standard_bj: function() {
            console.log(2), this.triggerEvent("standard_bg", {
                standard_bg: !0
            }, {}), this.setData({
                hidden: !0
            });
        },
        selected: function(t) {
            var a = t.currentTarget.dataset.idx;
            this.setData({
                idx: a
            }), 7 == a ? this.setData({
                other: !1
            }) : this.setData({
                other: !0
            });
        },
        input: function(t) {
            var a = t.detail.value;
            this.setData({
                val: a
            });
        },
        confirm: function() {
            var t = this.data.idx, a = this.data.tip, e = 0;
            if (a) {
                if (0 < t && t < a.length - 1) e = parseInt(a[t]); else if (t == a.length - 1) {
                    var i = this.data.val;
                    if (!i) return app.hint("输入金额不能为空"), "";
                    e = i;
                }
                this.triggerEvent("tipSelected", {
                    tip_money: e
                }, {});
            }
        }
    }
});