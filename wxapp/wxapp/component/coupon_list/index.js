var app = getApp();

Component({
    properties: {
        hidden: {
            type: Boolean
        },
        list: {
            type: Array
        },
        distance: {
            type: Number
        },
        money: {
            type: Number
        }
    },
    data: {},
    methods: {
        coupons_bj: function() {
            this.setData({
                hidden: !0
            }), this.triggerEvent("coupons_bg", {}, {});
        },
        submit: function(t) {
            var e = t.detail.value.code;
            if (!e) return app.hint("请先输入兑换码~");
            this.triggerEvent("getCodeCoupon", {
                code: e
            }, {});
        },
        useCoupon: function(t) {
            if (!(this.data.money <= 0)) {
                var e = {}, a = this.data.list, n = t.currentTarget.dataset.idx;
                if (0 == a[n].status) {
                    var o = parseFloat(a[n].satisfy_money), i = parseFloat(this.data.money);
                    if (e.id = a[n].id, e.coupons_money = a[n].money, i < (e.satisfy_money = o)) return app.hint("满" + o + "元使用");
                    if (0 < parseFloat(a[n].distance) && parseFloat(a[n].distance) < parseFloat(this.data.distance)) return app.hint(a[n].distance + "公里内使用");
                    wx.setStorageSync("coupons", e), wx.navigateBack({
                        delta: 1
                    });
                }
            }
        },
        noUseCoupons: function() {
            wx.removeStorageSync("coupons"), wx.navigateBack({
                delta: 1
            });
        }
    }
});