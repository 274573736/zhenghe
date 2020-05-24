var _home = require("../../modules/home"), _address = require("../../modules/address"), addressModule = new _address.address(), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        time_bg: !0,
        weight_bg: !0,
        pay_bg: !0,
        tip_bg: !0,
        floor_bg: !0,
        imgs: "",
        img_temp: [],
        goods_list: [],
        goods_idx: 0,
        day: "",
        hour: "立即帮买",
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
        help: 1,
        buy_type: 0,
        floor: [ -1 ],
        goods_predict: 0,
        bargain: 0,
        showcheck: -1,
        red_bag: !1,
        new_person: {},
        is_tip_collect: !1,
        fahuo: {},
        shouhuo: {}
    },
    onLoad: function(t) {
        wx.removeStorageSync("coupons"), app.getAppSetting(1), this.getIsNewCoupons(), this.getGoods();
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        this.isCoupons(), this.examineAddress();
    },
    closeIndexImg: function() {
        this.setData({
            red_bag: !1
        }), app.collectTip(this);
    },
    getIsNewCoupons: function() {
        var a = this;
        homeModule.getIsNewCoupons().then(function(t) {
            t.money && 0 < parseFloat(t.money) ? a.setData({
                new_person: t,
                red_bag: !0
            }) : app.collectTip(a);
        }, function(t) {});
    },
    imgUpload: function(t) {
        this.setData({
            img_temp: t.detail.img_temp,
            imgs: t.detail.imgs
        });
    },
    confirm: function() {
        var t = this.data.shouhuo, a = this.data.fahuo;
        if (!t.person_tel) return app.hint("选择收货地址");
        var e = this.data.goods_idx;
        if (e < 0) return app.hint("请选择物品类型");
        var i = this.data.goods_list[e].id, o = this.data.goods_list[e].name, s = this.data.price_detail.coupon_money, n = this.data.coupons.id;
        n || s || (s = n = 0);
        var d = wx.getStorageSync("city"), r = {};
        if ("立即帮买" == this.data.hour ? r = 1 : ((r = {}).day = this.data.day, r.hour = this.data.hour, 
        r.minute = this.data.minute), this.data.floor[0] < 0) return app.hint("请选择楼层~");
        var h = {
            weight_num: this.data.weight,
            remark: this.data.remark,
            distance: this.data.distance,
            duration: this.data.duration,
            time: r,
            hour: "立即帮买",
            coupons_id: n,
            standard_id: i,
            city: d,
            imgs: this.data.imgs,
            coupons_money: s,
            goods_name: o,
            order_type: 1,
            buy_type: this.data.buy_type,
            pay_method: this.data.pay_method,
            moneys: this.data.money,
            floor: this.data.floor[0],
            goods_predict: this.data.goods_predict,
            bargain: this.data.bargain,
            night_price: this.data.price_detail.night_price,
            change_price: this.data.price_detail.change_price,
            discount_price: this.data.price_detail.discount_price,
            distance_price: this.data.price_detail.distance_price,
            actual_payment: this.data.actual_payment,
            tip_money: this.data.tip_money,
            floor_price: this.data.price_detail.floor_price,
            fahuo: 1 == this.data.buy_type ? "" : a,
            shouhuo: t
        };
        wx.setStorageSync("order", h), wx.navigateTo({
            url: "../order/order"
        });
    },
    goodsPredict: function(t) {
        this.setData({
            goods_predict: t.detail.value
        });
    },
    bargain: function(t) {
        this.setData({
            bargain: t.currentTarget.dataset.id
        });
    },
    sGoods: function(t) {
        this.setData({
            goods_idx: t.currentTarget.dataset.idx
        });
    },
    textarea: function(t) {
        this.setData({
            remark: t.detail.value
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
        var a = this, t = wx.getStorageSync("fahuo") || {}, e = wx.getStorageSync("shouhuo") || {};
        if (this.setData({
            fahuo: t,
            shouhuo: e
        }), t.title && e.person_tel || e.person_tel && 1 == this.data.buy_type) {
            if (1 == this.data.buy_type) return void this.getPrice(5, this.data.weight);
            var i = setInterval(function() {
                app.globalData.syStem.gaode_key && (clearInterval(i), addressModule.getDistance(3, app.globalData.syStem.gaode_key, t, e).then(function(t) {
                    a.setData({
                        distance: t.distance,
                        duration: t.duration
                    }), a.getPrice(t.distance, a.data.weight);
                }, function(t) {}));
            }, 10, t, e);
        } else this.setData({
            distance: 0,
            actual_payment: -1
        });
    },
    getPrice: function(t, a) {
        if (1 == this.data.buy_type) {
            var e = this.data.shouhuo;
            e && e.person_tel && homeModule.moneys(this, 0, a, 1, this.data.floor[0]);
        } else homeModule.moneys(this, t, a, 1, this.data.floor[0]);
    },
    getGoods: function() {
        var a = this;
        homeModule.getGoodsList({
            order_type: 1
        }).then(function(t) {
            a.setData({
                goods_list: t
            });
        }, function(t) {});
    },
    buyType: function(t) {
        var a = t.detail.buy_type;
        1 == a && this.setData({
            duration: 0
        }), this.setData({
            buy_type: a
        }), this.examineAddress();
    },
    sFloor: function(t) {
        var a = t.detail.select;
        1 == a ? (this.setData({
            floor_bg: !0,
            floor: t.detail.floor
        }), this.getPrice(this.data.distance, this.data.weight)) : 2 == a ? this.setData({
            floor_bg: !0
        }) : this.setData({
            floor_bg: !1,
            floor: this.data.floor
        });
    },
    sTime: function(t) {
        var e = this, a = t.detail.select;
        1 == a ? (this.setData({
            day: t.detail.day,
            hour: t.detail.hour,
            minute: t.detail.minute,
            isImmediately: t.detail.isImmediately,
            time_bg: !0
        }), this.getPrice(this.data.distance, this.data.weight)) : 2 == a ? this.setData({
            time_bg: !0
        }) : homeModule.getTime().then(function(t) {
            var a = homeModule.date(t.days, t.hours, t.minutes, 1);
            e.setData({
                xTime: a,
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
        var a = t.currentTarget.dataset.id, e = this.data.weight;
        if (0 == a) {
            if (1 == e) return;
            e--, this.setData({
                weight: e
            });
        } else e++, this.setData({
            weight: e
        });
        this.getPrice(this.data.distance, e);
    },
    sTip: function(t) {
        var a = t.detail.select;
        1 == a ? (this.setData({
            tip_bg: !0,
            tip_money: t.detail.tip_money
        }), this.getPrice(this.data.distance, this.data.weight)) : 2 == a ? this.setData({
            tip_bg: !0
        }) : this.setData({
            tip_bg: !1
        });
    },
    sCoupon: function() {
        if (this.data.goods_idx < 0) return app.hint("请先选择物品类型");
        wx.navigateTo({
            url: "../coupons/coupons?distance=" + this.data.distance + "&money=" + this.data.money + "&order_type=1"
        });
    },
    sPay: function(t) {
        var a = this;
        if (this.data.goods_idx < 0) return app.hint("请先选择物品类型");
        var e = t.detail.select;
        1 == e ? this.setData({
            pay_bg: !0,
            pay_method: t.detail.pay_method
        }) : 2 == e ? this.setData({
            pay_bg: !0
        }) : homeModule.getMoney().then(function(t) {
            a.setData({
                pay_bg: !1,
                my_money: t.valid
            });
        }, function(t) {});
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