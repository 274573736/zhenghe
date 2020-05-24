var _address = require("../../modules/address"), _wechatMap = require("../../modules/wechatMap"), addressModule = new _address.address(), wechatMapModule = new _wechatMap.wechatMap(), app = getApp();

Component({
    properties: {
        fahuo: {
            type: Object
        },
        addressor: {
            type: Object
        },
        direction: {
            type: Object
        },
        img_url: {
            type: String
        },
        help: {
            type: Boolean
        },
        buy_type: {
            type: Number
        },
        driver: {
            type: Number
        }
    },
    data: {
        fahuo: {},
        shouhuo: {}
    },
    lifetimes: {
        attached: function() {
            this.setAddress(!0);
        }
    },
    pageLifetimes: {
        show: function() {
            this.setAddress();
        }
    },
    methods: {
        setAddress: function() {
            var a = this, e = 0 < arguments.length && void 0 !== arguments[0] && arguments[0], r = wx.getStorageSync("fahuo") || {}, t = wx.getStorageSync("shouhuo") || {};
            1 == this.data.help && e ? (!t || t && !t.ad_info) && addressModule.getCurrentCityMessage().then(function(e) {
                var t = e[0];
                if (t) {
                    wx.setStorageSync("shouhuo_temporary", t);
                    var s = app.globalData.syStem.user_mobile || wx.getStorageSync("phone");
                    t.person_name = "", t.person_tel = s, t.person_address = "电话联系", a.setData({
                        fahuo: r,
                        shouhuo: t
                    }), wx.setStorageSync("shouhuo", t), a.triggerEvent("examineAddress", {}, {});
                }
            }) : this.setData({
                fahuo: r,
                shouhuo: t
            });
        },
        sBuyType: function(e) {
            var t = e.currentTarget.dataset.idx;
            this.triggerEvent("buyType", {
                buy_type: t
            }, {});
        },
        toAddress: function(e) {
            var t = e.currentTarget.dataset.id, s = this.data.help;
            if (0 != t || 1 != s) {
                if (0 == t && 1 != s) return wx.setStorageSync("address_type", t), void wx.navigateTo({
                    url: "/make_speed/address/address?id=" + t + "&is_phone=1&is_all=1"
                });
                var a = 0;
                1 == s && (a = 1), wx.navigateTo({
                    url: "/make_speed/address/address?id=" + t + "&is_phone=" + a
                });
            } else wechatMapModule.openLocationMap(1, 0, !1);
        },
        toDriverAddress: function(e) {
            var t = e.currentTarget.dataset.id, s = 0, a = 0;
            wx.setStorageSync("address_type", t), 0 == t ? (a = s = 1, wx.navigateTo({
                url: "/make_speed/address_driver/address_driver?id=" + t + "&is_all=" + a + "&is_phone=" + s
            })) : wechatMapModule.openLocationMap(3, t, !1);
        },
        oftenAddress: function(e) {
            wx.navigateTo({
                url: "/make_speed/address_resort/address_resort"
            });
        }
    }
});