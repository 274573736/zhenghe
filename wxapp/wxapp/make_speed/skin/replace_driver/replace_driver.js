var _home = require("../../../modules/home"), _address = require("../../../modules/address"), _setting = require("../../../modules/setting"), settingModule = new _setting.setting(), addressModule = new _address.address(), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        time_bg: !0,
        pay_bg: !0,
        tip_bg: !0,
        remark_bg: !0,
        hour: "立即",
        minute: "",
        isImmediately: 0,
        xday: "",
        remark: "",
        tip_money: 0,
        pay_method: 2,
        distance: 0,
        coupons: {},
        money: 0,
        actual_payment: -1,
        price_detail: {},
        my_money: 0,
        order_type: 3,
        is_pay: !0,
        showcheck: -1,
        red_bag: !1,
        new_person: {},
        is_login: !0,
        loading: !1,
        type: 1
    },
    onLoad: function(e) {
        var t = this;
        wx.setStorageSync("is_remove_shou", 1), wx.removeStorageSync("coupons"), app.getAppSetting(3), 
        app.connectWs(), homeModule.driverType().then(function(e) {
            t.setData({
                type: e.type
            });
        }, function(e) {});
    },
    onReady: function() {},
    onShow: function() {
        this.isCoupons(), this.examineAddress();
    },
    closeIndexImg: function() {
        this.setData({
            red_bag: !1
        });
    },
    showDetail: function() {
        wx.navigateTo({
            url: "../show_detail/show_detail"
        });
    },
    authBtn: function() {
        this.setData({
            is_login: !0
        });
    },
    topPrice: function() {
        wx.navigateTo({
            url: "/make_speed/price_des/price_des"
        });
    },
    confirm: function(e) {
        var a = this, t = this.data.price_detail.coupon_money, i = this.data.coupons.id;
        i || t || (t = i = 0);
        var o = this.data.pay_method, n = wx.getStorageSync("fahuo");
        if (!n.title) return app.hint("请选择出发地~");
        var s = wx.getStorageSync("shouhuo");
        if (!s.title) return app.hint("请选择目的地~");
        var r = wx.getStorageSync("city"), d = {};
        "立即" == this.data.hour ? d = 1 : ((d = {}).day = this.data.day, d.hour = this.data.hour, 
        d.minute = this.data.minute);
        var u = {
            remark: this.data.remark,
            distance: this.data.distance,
            time: d,
            coupons_id: i,
            city: r,
            coupons_money: t,
            order_type: this.data.order_type,
            pay_method: o,
            moneys: this.data.money,
            night_price: this.data.price_detail.night_price,
            change_price: this.data.price_detail.change_price,
            discount_price: this.data.price_detail.discount_price,
            distance_price: this.data.price_detail.distance_price,
            actual_payment: this.data.actual_payment,
            tip_money: this.data.tip_money,
            fahuo: n,
            shouhuo: s
        };
        settingModule.auth(0).then(function(e) {
            if (e) {
                if (a.data.loading) return;
                if ("function" == typeof wx.requestSubscribeMessage) {
                    var t = app.globalData.syStem;
                    return void wx.requestSubscribeMessage({
                        tmplIds: [ t.template_id, t.accepted_template_id, t.complete_template_id ],
                        complete: function(e) {
                            a.setData({
                                loading: !0
                            }), homeModule.toOrder(u).then(function(e) {
                                if (2 == a.data.type) return app.closeWs(), app.hint("下单成功~", "success"), void setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/make_speed/order_pay/order_pay?order_id=" + e.order_id + "&status=2"
                                    });
                                }, 400);
                                a.pay(e.order_id, o);
                            }, function(e) {
                                a.setData({
                                    loading: !1
                                });
                            });
                        },
                        fail: function(e) {
                            a.setData({
                                loading: !1
                            });
                        }
                    });
                }
                return a.setData({
                    loading: !0
                }), void homeModule.toOrder(u).then(function(e) {
                    if (2 == a.data.type) return app.closeWs(), app.hint("下单成功~", "success"), void setTimeout(function() {
                        wx.redirectTo({
                            url: "/make_speed/order_pay/order_pay?order_id=" + e.order_id + "&status=2"
                        });
                    }, 400);
                    a.pay(e.order_id, o);
                }, function(e) {
                    a.setData({
                        loading: !1
                    });
                });
            }
            a.setData({
                is_login: !1
            });
        }, function(e) {});
    },
    pay: function(a, i) {
        var o = this;
        homeModule.pay({
            id: a,
            pay_method: i
        }).then(function(e) {
            var t = e.data;
            2 != i ? o.paySuccess(a, t) : homeModule.confirmPay(e.pay_params).then(function(e) {
                o.paySuccess(a, t);
            }, function(e) {
                o.failPay(a);
            });
        }, function(e) {
            o.failPay(a);
        });
    },
    paySuccess: function(e, t) {
        app.sendWs("type=place_order&order_id=" + e + "&data=" + t), app.closeWs(), app.hint("支付成功~", "success"), 
        setTimeout(function() {
            wx.redirectTo({
                url: "/make_speed/order_pay/order_pay?order_id=" + e + "&status=2"
            });
        }, 400);
    },
    failPay: function(e) {
        wx.redirectTo({
            url: "/make_speed/order_pay/order_pay?order_id=" + e + "&status=0"
        });
    },
    isCoupons: function() {
        var e = wx.getStorageSync("coupons");
        e ? this.setData({
            coupons: e
        }) : this.setData({
            coupons: {}
        });
    },
    examineAddress: function() {
        var t = this, e = wx.getStorageSync("fahuo"), a = wx.getStorageSync("shouhuo");
        if (e.title && a.title) var i = setInterval(function() {
            app.globalData.syStem.gaode_key && (clearInterval(i), addressModule.getDistance(2, app.globalData.syStem.gaode_key, e, a).then(function(e) {
                t.setData({
                    distance: e
                }), t.getPrice(e);
            }, function(e) {}));
        }, 10, e, a);
    },
    getPrice: function(e) {
        homeModule.moneys(this, e, "", this.data.order_type);
    },
    sTime: function(e) {
        var a = this, t = e.detail.select;
        1 == t ? (this.setData({
            day: e.detail.day,
            hour: e.detail.hour,
            minute: e.detail.minute,
            isImmediately: e.detail.isImmediately,
            time_bg: !0
        }), this.getPrice(this.data.distance)) : 2 == t ? this.setData({
            time_bg: !0
        }) : homeModule.getTime().then(function(e) {
            var t = homeModule.date(e.days, e.hours, e.minutes, 3);
            a.setData({
                xTime: t,
                time_bg: !1
            });
        }, function(e) {});
    },
    sTip: function(e) {
        var t = e.detail.select;
        1 == t ? (this.setData({
            tip_bg: !0,
            tip_money: e.detail.tip_money
        }), this.getPrice(this.data.distance)) : 2 == t ? this.setData({
            tip_bg: !0
        }) : this.setData({
            tip_bg: !1
        });
    },
    sCoupon: function() {
        wx.navigateTo({
            url: "/make_speed/coupons/coupons?distance=" + this.data.distance + "&money=" + this.data.money
        });
    },
    sPay: function(e) {
        var t = this, a = e.detail.select;
        1 == a ? this.setData({
            pay_bg: !0,
            pay_method: e.detail.pay_method
        }) : 2 == a ? this.setData({
            pay_bg: !0
        }) : homeModule.getMoney().then(function(e) {
            t.setData({
                pay_bg: !1,
                my_money: e.valid
            });
        }, function(e) {});
    },
    sRemark: function(e) {
        var t = e.detail.select;
        1 == t ? this.setData({
            remark_bg: !0,
            remark: e.detail.remark
        }) : 2 == t ? this.setData({
            remark_bg: !0
        }) : this.setData({
            remark_bg: !1
        });
    },
    onHide: function() {},
    onUnload: function() {
        wx.removeStorageSync("coupons"), app.closeWs();
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