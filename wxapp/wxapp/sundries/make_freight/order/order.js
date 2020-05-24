var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        showModalStatus: !1,
        animationData: "",
        pay_bg: !0,
        pay_method: 2,
        pay_type: 0,
        remark_bg: !0,
        fahuo: {},
        shouhou: {},
        goods: {},
        distance: 0,
        price: 0,
        remark: "",
        coupons: {},
        coupon_money: 0,
        loading: !1,
        total_coupon: 0,
        is_show: !0,
        is_use_coupon: !1,
        formId: "",
        is_carry: !1,
        is_init: !1,
        volume: 0
    },
    onLoad: function(a) {
        wx.removeStorageSync("coupons"), this.init(a), app.connectWs();
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        var a = this, t = setInterval(function() {
            a.data.is_init && (clearInterval(t), a.isCoupons());
        }, 10);
    },
    carryBtn: function(a) {
        this.setData({
            is_carry: a.detail.value
        }), this.isCoupons();
    },
    init: function(a) {
        this.setData({
            fahuo: wx.getStorageSync("fahuo"),
            shouhuo: wx.getStorageSync("shouhuo"),
            goods: wx.getStorageSync("goods"),
            time: a.time || "立即取货",
            distance: a.distance,
            price: a.price,
            real_price: a.price,
            mileage: a.mileage,
            volume_car: a.volume_car,
            volume: a.volume,
            weight: a.weight,
            is_init: !0
        });
    },
    isCoupons: function() {
        var n = this;
        this.setData({
            loading: !0
        }), homeModule.predictPrice({
            distance: this.data.distance,
            car_id: this.data.goods.id,
            weight: this.data.weight,
            car_type: this.data.volume_car,
            switch: this.data.is_carry ? 1 : 0,
            cube: this.data.volume
        }).then(function(a) {
            var t = a.price, e = a.price, o = wx.getStorageSync("coupons") || {}, i = !1;
            o && o.coupons_money && (1 * o.satisfy_money <= e && (i = !0, t = (e - 1 * o.coupons_money).toFixed(2)));
            n.setData({
                coupons: o,
                real_price: t,
                price: e,
                is_use_coupon: i,
                loading: !1
            });
            var s = wx.getStorageSync("price_detail");
            s.coupon_money = 0, s.distance_price = 1 * a.init_price + 1 * a.mileage, s.actual_payment = t, 
            s.weight = n.data.weight, s.carry = a.load, s.weight_fee = a.weight, s.carload_fee = a.total_car, 
            s.cube_price = a.cube_price, s.volume = n.data.volume, wx.setStorageSync("price_detail", s);
        }, function(a) {});
    },
    sCoupon: function() {
        wx.navigateTo({
            url: "/make_speed/coupons/coupons?distance=" + this.data.distance + "&money=" + this.data.price + "&order_type=4"
        });
    },
    noUseCoupon: function() {
        wx.removeStorageSync("coupons"), this.isCoupons();
    },
    hiddenDetail: function() {
        var a = this.data.is_show;
        this.setData({
            is_show: !a
        });
    },
    confirm: function(a) {
        var t = this;
        if (!this.data.loading) {
            this.setData({
                loading: !0,
                formId: a.detail.formId
            });
            var e = this.data.fahuo, o = this.data.shouhuo, i = this.data.goods;
            homeModule.postOrder({
                coupons_id: this.data.coupons.id || 0,
                pay_method: this.data.pay_method,
                distance: this.data.distance,
                remark: this.data.remark,
                moneys: this.data.price,
                actual_payment: this.data.real_price,
                tip_money: 0,
                night_price: 0,
                car_id: i.id,
                get_time: this.data.time,
                distance_price: this.data.mileage,
                fahuo: e,
                shouhuo: o,
                city: wx.getStorageSync("city"),
                weight: this.data.weight,
                switch: this.data.is_carry ? 1 : 0,
                car_type: this.data.volume_car,
                cube: this.data.volume
            }).then(function(a) {
                t.pay(a.order_id), wx.removeStorageSync("coupons");
            }, function(a) {
                t.setData({
                    loading: !1
                });
            });
        }
    },
    pay: function(e) {
        var o = this, i = this.data.pay_method;
        homeModule.payFreight({
            id: e,
            pay_method: i
        }).then(function(a) {
            var t = a.data;
            2 != i ? o.paySuccess(e, t) : homeModule.confirmPay(a.pay_params).then(function(a) {
                o.paySuccess(e, t);
            }, function(a) {
                o.failPay(e);
            });
        }, function(a) {
            o.failPay(e);
        });
    },
    paySuccess: function(a, t) {
        app.sendWs("type=place_order&order_id=" + a + "&data=" + t), app.closeWs();
        var e = "支付成功~";
        3 == this.data.pay_method && (e = "下单成功~"), app.hint(e, "success"), setTimeout(function() {
            wx.redirectTo({
                url: "/make_speed/order_pay/order_pay?order_type=5&status=2&order_id=" + a
            });
        }, 400, a);
    },
    failPay: function(a) {
        setTimeout(function() {
            wx.redirectTo({
                url: "/make_speed/order_pay/order_pay?order_type=5&status=0&order_id=" + a
            });
        }, 400, a);
    },
    sRemark: function(a) {
        var t = a.detail.select;
        1 == t ? this.setData({
            remark_bg: !0,
            remark: a.detail.remark
        }) : 2 == t ? this.setData({
            remark_bg: !0
        }) : this.setData({
            remark_bg: !1
        });
    },
    sPay: function(a) {
        var t = this, e = a.detail.select;
        1 == e ? this.setData({
            pay_bg: !0,
            pay_method: a.detail.pay_method
        }) : 2 == e ? this.setData({
            pay_bg: !0
        }) : homeModule.getMoney().then(function(a) {
            t.setData({
                pay_bg: !1,
                my_money: a.valid
            });
        }, function(a) {});
    },
    onHide: function() {},
    onUnload: function() {
        wx.removeStorageSync("coupons");
    },
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