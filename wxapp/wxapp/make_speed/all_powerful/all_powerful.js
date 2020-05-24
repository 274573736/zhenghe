var _home = require("../../modules/home"), _wechatMap = require("../../modules/wechatMap"), homeModule = new _home.home(), wechatMapModule = new _wechatMap.wechatMap(), app = getApp();

Page({
    data: {
        input_bg: !0,
        time_bg: !0,
        pay_bg: !0,
        money: 0,
        record: !0,
        bargain: 1,
        goods_predict: 0,
        remark: "",
        pay_method: 2,
        goods_list: [],
        goods_idx: 0,
        shouhuo: "",
        name: "",
        tel: "",
        min_money: 10,
        service_money: 100,
        my_money: 0,
        coupons: {},
        day: "",
        hour: "立即",
        minute: "",
        isImmediately: 0,
        xday: "",
        price_detail: {},
        actual_payment: -1,
        audio_url: "",
        discount: 0,
        order_type: 2,
        showcheck: -1,
        red_bag: !1,
        new_person: {},
        is_tip_collect: !1,
        max_money: 100,
        phone: "",
        imgs: "",
        img_temp: [],
        unservice_img_switch: 0
    },
    onLoad: function(t) {
        wx.removeStorageSync("coupons"), app.getAppSetting(2), this.getIsNewCoupons(), this.getGoods();
        var e = app.globalData.syStem.user_mobile || wx.getStorageSync("phone");
        this.setData({
            phone: e || "",
            tel: e || "",
            unservice_img_switch: app.globalData.syStem.unservice_img_switch
        });
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        var t = wx.getStorageSync("shouhuo_temporary");
        t.title && this.setData({
            shouhuo: t
        }), this.isCoupons(), this.pirceParam();
    },
    imgUpload: function(t) {
        this.setData({
            img_temp: t.detail.img_temp,
            imgs: t.detail.imgs
        });
    },
    closeIndexImg: function() {
        this.setData({
            red_bag: !1
        }), app.collectTip(this);
    },
    voiceUrl: function(t) {
        this.setData({
            audio_url: t.detail.audio_url
        });
    },
    showDetail: function() {
        wx.navigateTo({
            url: "../show_detail/show_detail"
        });
    },
    getIsNewCoupons: function() {
        var e = this;
        homeModule.getIsNewCoupons().then(function(t) {
            t.money && 0 < parseFloat(t.money) ? e.setData({
                new_person: t,
                red_bag: !0
            }) : app.collectTip(e);
        }, function(t) {});
    },
    confirm: function() {
        var t = this.data.shouhuo;
        if (!t.title) return app.hint("请先选择地址");
        var e = this.data.goods_idx;
        if (e < 0) return app.hint("请选服务类型~");
       // var a = this.data.goods_list[e].id, i = this.data.goods_list[e].name, o = this.data.goods_predict, n = this.data.name;
        if (!n) return app.hint("请输入姓名~");
        var s = this.data.tel;
        if (!s) return app.hint("请输入号码~");
        if (!/^1(3|4|5|6|7|8|9)\d{9}$/.test(s)) return app.hint("请填写正确的手机号");
        t.person_name = n, t.person_tel = s, wx.setStorageSync("shouhuo", t);
        var r = this.data.price_detail.coupon_money, d = this.data.coupons.id;
        d || r || (r = d = 0);
        var c = wx.getStorageSync("city"), u = {};
        "立即" == this.data.hour ? u = 1 : ((u = {}).day = this.data.day, u.hour = this.data.hour, 
        u.minute = this.data.minute);
        var p = {
            remark: this.data.remark,
            goods_predict: o,
            time: u,
            standard_id: a,
            goods_name: i,
            city: c,
            imgs: this.data.imgs,
            coupons_id: d,
            buy_type: 1,
            coupons_money: r,
            order_type: this.data.order_type,
            shouhuo: t,
            audio_url: this.data.audio_url,
            bargain: this.data.bargain,
            pay_method: this.data.pay_method,
            moneys: this.data.service_money,
            actual_payment: this.data.actual_payment,
            distance_price: this.data.price_detail.distance_price,
            discount_price: this.data.price_detail.discount_price
        };
        wx.setStorageSync("order", p), wx.navigateTo({
            url: "../order/order"
        });
    },
    pirceParam: function() {
        var e = this;
        homeModule.calculateMoney({
            order_type: 2,
            city: wx.getStorageSync("city")
        }).then(function(t) {
            e.setData({
                min_money: t.distance_price,
                service_money: t.distance_price,
                actual_payment: t.money,
                discount: t.discount,
                max_money: t.max_money
            }), e.getPrice(t.distance_price);
        }, function(t) {});
    },
    getPrice: function() {
        var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, e = this.data.discount, a = t;
        e && (a = (t * e).toFixed(2));
        var i = this.data.coupons, o = 0;
        i.satisfy_money && (1 * i.satisfy_money <= t && (a = (a - (o = 1 * i.coupons_money)).toFixed(2)));
        var n = {
            night_price: 0,
            change_price: 0,
            tip_money: 0
        };
        n.actual_payment = a, n.coupon_money = o, n.weight = 0, n.distance = 0, n.discount_price = (t * (1 - e)).toFixed(2), 
        n.order_type = 2, n.floor_price = 0, n.distance_price = t, wx.setStorageSync("price_detail", n), 
        this.setData({
            actual_payment: a,
            service_money: t,
            price_detail: n
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
    sTime: function(t) {
        var a = this, e = t.detail.select;
        1 == e ? this.setData({
            day: t.detail.day,
            hour: t.detail.hour,
            minute: t.detail.minute,
            isImmediately: t.detail.isImmediately,
            time_bg: !0
        }) : 2 == e ? this.setData({
            time_bg: !0
        }) : homeModule.getTime().then(function(t) {
            var e = homeModule.date(t.days, t.hours, t.minutes, 2);
            a.setData({
                xTime: e,
                time_bg: !1
            });
        }, function(t) {});
    },
    sCoupon: function() {
        if (this.data.goods_idx < 0) return app.hint("请先选择服务类型");
        wx.navigateTo({
            url: "../coupons/coupons?distance=" + this.data.distance + "&money=" + this.data.service_money + "&order_type=2"
        });
    },
    sPay: function(t) {
        var e = this;
        if (this.data.goods_idx < 0) return app.hint("请先选择服务类型");
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
    slider: function(t) {
        this.getPrice(t.detail.value), this.setData({
            service_money: t.detail.value
        });
    },
    name: function(t) {
        this.setData({
            name: t.detail.value
        });
    },
    tel: function(t) {
        this.setData({
            tel: t.detail.value
        });
    },
    toAddress: function() {
        wechatMapModule.openLocationMap(2, 1, !1);
    },
    sGoods: function(t) {
        this.setData({
            goods_idx: t.currentTarget.dataset.idx
        });
    },
    getGoods: function() {
        var e = this;
        homeModule.getGoodsList({
            order_type: 2
        }).then(function(t) {
            e.setData({
                goods_list: t
            });
        }, function(t) {});
    },
    textarea: function(t) {
        this.setData({
            remark: t.detail.value
        });
    },
    bargain: function(t) {
        this.setData({
            bargain: t.currentTarget.dataset.id
        });
    },
    showInput: function() {
        this.setData({
            input_bg: !1
        });
    },
    inputMoney: function(t) {
        this.setData({
            money: t.detail.value
        });
    },
    cancelBtn: function() {
        this.setData({
            input_bg: !0
        });
    },
    confirmBtn: function() {
        if (this.data.money >= parseFloat(this.data.min_money)) {
            var t = this.data.money;
            this.setData({
                input_bg: !0,
                service_money: t
            }), this.getPrice(t);
        } else app.hint("不能低于起步价~");
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