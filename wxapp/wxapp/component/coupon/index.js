var app = getApp();

Component({
    properties: {
        hidden: {
            type: Boolean
        },
        coupons: {
            type: Array
        },
        all: {
            type: Boolean,
            value: !0
        },
        moneys: {
            type: Number,
            value: 0
        },
        distance: {
            type: Number,
            value: 0
        },
        img_url: {
            type: String
        }
    },
    data: {},
    methods: {
        coupons_bj: function() {
            this.setData({
                hidden: !0
            }), this.triggerEvent("coupons_bg", {}, {});
        },
        useCoupons: function(t) {
            var e = {};
            return e.id = t.currentTarget.dataset.id, e.coupons_money = t.currentTarget.dataset.money, 
            e.satisfy_money = t.currentTarget.dataset.satisfy, t.currentTarget.dataset.satisfy > this.data.moneys ? app.hint("满" + t.currentTarget.dataset.satisfy + "元使用") : 0 < t.currentTarget.dataset.distance && t.currentTarget.dataset.distance < this.data.distance ? app.hint(t.currentTarget.dataset.distance + "公里内使用") : (wx.setStorageSync("coupons", e), 
            void wx.navigateBack({
                delta: 1
            }));
        },
        noUseCoupons: function() {
            wx.removeStorageSync("coupons"), wx.navigateBack({
                delta: 1
            });
        }
    }
});