var _home = require("../../../modules/home"), _address = require("../../../modules/address"), homeModule = new _home.home(), addressModule = new _address.address(), app = getApp();

Page({
    data: {
        protocol: !0,
        money_protocol: !0,
        time_bg: !0,
        day: "",
        hour: "立即",
        minute: "",
        isImmediately: 0,
        xday: "",
        record: !0,
        audio_url: "",
        shouhuo: "",
        loading: !1,
        name: "",
        tel: "",
        distance: 0,
        small_tel: ""
    },
    onLoad: function(e) {
        app.connectWs(), wx.removeStorageSync("shouhuo_temporary"), wx.removeStorageSync("shouhuo");
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        this.getDistance();
    },
    onHide: function() {},
    oftenAddress: function() {
        wx.navigateTo({
            url: "/make_speed/address_resort/address_resort?type=1&order_type=big"
        });
    },
    fontDiscern: function() {
        wx.navigateTo({
            url: "/make_speed/tool/font_discern/font_discern?id=1"
        });
    },
    imgDiscern: function() {
        return app.hint("名片识别暂未开通~");
    },
    confirm: function(e) {
        var a = this, t = {};
        "立即" == this.data.hour ? t = 1 : ((t = {}).day = this.data.day, t.hour = this.data.hour, 
        t.minute = this.data.minute);
        var i = e.detail.value;
        return i.tel ? /^1(3|4|5|6|7|8|9)\d{9}$/.test(i.tel) ? this.data.money_protocol ? this.data.protocol ? void (this.data.loading || (this.setData({
            loading: !0
        }), homeModule.aKeyOrder({
            time: t,
            name: i.name,
            phone: i.tel,
            remark: i.remark,
            extension_number: i.extension_number,
            distance: this.data.distance,
            price: this.data.price,
            shouhuo: this.data.shouhuo,
            bid: app.globalData.business_id,
            audio_url: this.data.audio_url
        }).then(function(e) {
            var t = e.order_id;
            if (app.sendWs("type=place_order&order_id=" + t + "&data=" + e.data), app.closeWs(), 
            app.hint("支付成功~", "success"), a.data.shouhuo) {
                var o = a.data.shouhuo;
                o.person_name = i.name, o.person_tel = i.tel, o.person_address = "电话联系", app.delRepeat(o, 1, 1);
            }
            setTimeout(function() {
                wx.redirectTo({
                    url: "/make_speed/order_pay/order_pay?order_id=" + t + "&status=2"
                });
            }, 400);
        }, function(e) {
            a.setData({
                loading: !1
            });
        }))) : app.hint("请勾选合作协议和扣款协议~") : app.hint("请同意扣款协议~") : app.hint("请填写正确的手机号~") : app.hint("手机号码不能为空~");
    },
    getDistance: function() {
        var t = this;
        this.setData({
            loading: !0
        });
        var e = wx.getStorageSync("shouhuo_temporary");
        e.title && this.setData({
            shouhuo: e
        });
        var o = wx.getStorageSync("shouhuo");
        o.person_tel && this.setData({
            name: o.person_name,
            tel: o.person_tel
        });
        var a = wx.getStorageSync("business");
        a && e && a.location && e.title ? addressModule.getDistance(2, app.globalData.syStem.gaode_key, a, e).then(function(e) {
            t.getPrice(e);
        }, function(e) {}) : this.getPrice();
    },
    getPrice: function() {
        var t = this, o = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0;
        homeModule.aKeyOrderPrice({
            id: app.globalData.business_id,
            distance: o
        }).then(function(e) {
            t.setData({
                distance: o,
                price: e.money,
                loading: !1
            });
        }, function(e) {});
    },
    voiceUrl: function(e) {
        this.setData({
            audio_url: e.detail.audio_url
        });
    },
    sTime: function(e) {
        var o = this, t = e.detail.select;
        1 == t ? this.setData({
            day: e.detail.day,
            hour: e.detail.hour,
            minute: e.detail.minute,
            isImmediately: e.detail.isImmediately,
            time_bg: !0
        }) : 2 == t ? this.setData({
            time_bg: !0
        }) : homeModule.getTime().then(function(e) {
            var t = homeModule.date(e.days, e.hours, e.minutes, 2);
            o.setData({
                xTime: t,
                time_bg: !1
            });
        }, function(e) {});
    },
    toAddress: function() {
        wx.navigateTo({
            url: "/make_speed/address_map/address_map?id=1"
        });
    },
    delAddress: function() {
        wx.removeStorageSync("shouhuo_temporary"), this.setData({
            shouhuo: ""
        }), this.getDistance();
    },
    moneyProtocol: function() {
        this.setData({
            money_protocol: !this.data.money_protocol
        });
    },
    toProtocol: function(e) {
        var t = e.currentTarget.dataset.id;
        0 == t ? this.setData({
            protocol: !this.data.protocol
        }) : 1 == t ? wx.navigateTo({
            url: "/make_speed/protocol/protocol?title=合作协议&staff=1&type=business_hezuo"
        }) : 2 == t && wx.navigateTo({
            url: "/make_speed/protocol/protocol?title=扣款协议&staff=1&type=business_kk"
        });
    },
    onUnload: function() {
        wx.removeStorageSync("shouhuo_temporary"), wx.removeStorageSync("shouhuo");
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});