var _home = require("../../../modules/home.js"), _address = require("../../../modules/address"), addressModule = new _address.address(), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        city: "",
        time_bg: !0,
        weight_bg: !0,
        pay_bg: !0,
        tip_bg: !0,
        remark_bg: !0,
        goods_list: [],
        goods_idx: 0,
        day: "",
        hour: "立即取件",
        minute: "",
        isImmediately: 0,
        xday: "",
        remark: "",
        tip_money: 0,
        my_money: 0,
        weight: 1,
        distance: 0,
        duration: 0,
        coupons: {},
        money: 0,
        actual_payment: -1,
        price_detail: {},
        pay_method: 2,
        new_person: {},
        img_url: app.globalData.img_url
    },
    onLoad: function(t) {
        wx.setStorageSync("is_remove_shou", 1), wx.removeStorageSync("coupons"), this.getGoodsList(), 
        wx.setNavigationBarTitle({
            title: app.globalData.syStem.business_type[0].title
        });
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        this.isCoupons(), this.examineAddress();
    },
    confirm: function() {
        if (!wx.getStorageSync("fahuo").person_tel) return app.hint("请选择发件地址~");
        if (!wx.getStorageSync("shouhuo").person_tel) return app.hint("请选择收件地址~");
        var t = this.data.goods_idx;
        if (t < 0) return app.hint("请选择物品类型");
        var e = this.data.goods_list[t].id, a = this.data.goods_list[t].name, i = this.data.price_detail.coupon_money, s = this.data.coupons.id;
        s || i || (i = s = 0);
        var o = wx.getStorageSync("city"), n = {};
        "立即取件" == this.data.hour ? n = 1 : ((n = {}).day = this.data.day, n.hour = this.data.hour, 
        n.minute = this.data.minute);
        var d = {
            weight_num: this.data.weight,
            remark: this.data.remark,
            distance: this.data.distance,
            duration: this.data.duration,
            time: n,
            coupons_id: s,
            standard_id: e,
            city: o,
            hour: "立即取件",
            coupons_money: i,
            goods_name: a,
            order_type: 0,
            pay_method: this.data.pay_method,
            moneys: this.data.money,
            night_price: this.data.price_detail.night_price,
            change_price: this.data.price_detail.change_price,
            discount_price: this.data.price_detail.discount_price,
            distance_price: this.data.price_detail.distance_price,
            actual_payment: this.data.actual_payment,
            tip_money: this.data.tip_money
        };
        wx.setStorageSync("order", d), wx.navigateTo({
            url: "/make_speed/order/order"
        });
    },
    isCoupons: function() {
        var t = wx.getStorageSync("coupons");
        t ? this.setData({
            coupons: t
        }) : this.setData({
            coupons: {}
        });
    },
    examineAddress: function() {
        var e = this, t = wx.getStorageSync("fahuo"), a = wx.getStorageSync("shouhuo");
        if (t.person_tel && a.person_tel) var i = setInterval(function() {
            app.globalData.syStem.gaode_key && (clearInterval(i), addressModule.getDistance(3, app.globalData.syStem.gaode_key, t, a).then(function(t) {
                e.setData({
                    distance: t.distance,
                    duration: t.duration
                }), e.getPrice(t.distance, e.data.weight);
            }, function(t) {}));
        }, 10, t, a);
    },
    getGoodsList: function() {
        var e = this;
        homeModule.getGoodsList({
            order_type: 0
        }).then(function(t) {
            e.setData({
                goods_list: t
            });
        }, function(t) {});
    },
    selectGoods: function(t) {
        var e = t.detail.formId;
        return app.setFormId(e), wx.getStorageSync("fahuo").person_tel ? wx.getStorageSync("shouhuo").person_tel ? void this.setData({
            goods_idx: t.currentTarget.dataset.idx
        }) : app.hint("请先填写收货地址~") : app.hint("请先填写发货地址~");
    },
    getPrice: function(t, e) {
        homeModule.moneys(this, t, e);
    },
    sTime: function(t) {
        var a = this, e = t.detail.select;
        1 == e ? (this.setData({
            day: t.detail.day,
            hour: t.detail.hour,
            minute: t.detail.minute,
            isImmediately: t.detail.isImmediately,
            time_bg: !0
        }), this.getPrice(this.data.distance, this.data.weight)) : 2 == e ? this.setData({
            time_bg: !0
        }) : homeModule.getTime().then(function(t) {
            var e = homeModule.date(t.days, t.hours, t.minutes, 0);
            a.setData({
                xTime: e,
                time_bg: !1
            });
        }, function(t) {});
    },
    sWeight: function(t) {
        this.setData({
            weight: t.detail.value
        }), this.getPrice(this.data.distance, t.detail.value);
    },
    weight: function(t) {
        var e = t.currentTarget.dataset.id, a = this.data.weight;
        if (0 == e) {
            if (1 == a) return;
            a--, this.setData({
                weight: a
            });
        } else a++, this.setData({
            weight: a
        });
        this.getPrice(this.data.distance, a);
    },
    sTip: function(t) {
        var e = t.detail.select;
        1 == e ? (this.setData({
            tip_bg: !0,
            tip_money: t.detail.tip_money
        }), this.getPrice(this.data.distance, this.data.weight)) : 2 == e ? this.setData({
            tip_bg: !0
        }) : this.setData({
            tip_bg: !1
        });
    },
    sCoupon: function() {
        if (this.data.goods_idx < 0) return app.hint("请先选择物品类型");
        wx.navigateTo({
            url: "/make_speed/coupons/coupons?distance=" + this.data.distance + "&money=" + this.data.money + "&order_type=0"
        });
    },
    sPay: function(t) {
        var e = this;
        if (this.data.goods_idx < 0) return app.hint("请先选择物品类型");
        var a = t.detail.select;
        1 == a ? this.setData({
            pay_bg: !0,
            pay_method: t.detail.pay_method
        }) : 2 == a ? this.setData({
            pay_bg: !0
        }) : homeModule.getMoney().then(function(t) {
            e.setData({
                pay_bg: !1,
                my_money: t.valid
            });
        }, function(t) {});
    },
    sRemark: function(t) {
        var e = t.detail.select;
        1 == e ? this.setData({
            remark_bg: !0,
            remark: t.detail.remark
        }) : 2 == e ? this.setData({
            remark_bg: !0
        }) : this.setData({
            remark_bg: !1
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