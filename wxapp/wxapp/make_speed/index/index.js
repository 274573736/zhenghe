var _home = require("../../modules/home.js"), _address = require("../../modules/address"), addressModule = new _address.address(), homeModule = new _home.home(), app = getApp();

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
        banner_list: [],
        tip_1: !1,
        tip_2: !1,
        red_bag: !1,
        new_person: {},
        showcheck: -1,
        img_url: app.globalData.img_url,
        is_tip_collect: !1
    },
    onLoad: function(t) {
        wx.removeStorageSync("coupons"), app.getAppSetting(0), this.getGoodsList(), this.getBanner(), 
        this.getIsNewCoupons();
    },
    onReady: function() {},
    onShow: function() {
        this.isCoupons(), this.examineAddress();
    },
    signTip: function() {
        wx.getStorageSync("tip_1") ? wx.getStorageSync("tip_2") ? this.getIsNewCoupons() : this.setData({
            tip_2: !0
        }) : this.setData({
            tip_1: !0
        });
    },
    tip: function(t) {
        1 == t.detail.tip ? (this.setData({
            tip_1: !1,
            tip_2: !0
        }), wx.setStorageSync("tip_1", !0)) : (this.setData({
            tip_2: !1
        }), wx.setStorageSync("tip_2", !0), this.getIsNewCoupons());
    },
    toOtherPath: function(t) {
        var e = t.currentTarget.dataset.idx, a = this.data.banner_list[e];
        1 != a.type ? a.path && ("/make_speed/big_customer/info/info" != a.path ? wx.navigateTo({
            url: a.path
        }) : this.toBusiness()) : wx.navigateToMiniProgram({
            appId: a.appid,
            path: a.app_url
        });
    },
    toBusiness: function() {
        homeModule.businessStatus().then(function(t) {
            var e = t[0];
            0 == e ? wx.showModal({
                title: "提示",
                content: "大客户审核暂未通过，是否要前往修改提交信息~",
                success: function(t) {
                    t.confirm ? wx.navigateTo({
                        url: "/make_speed/big_customer/join/join?type=1"
                    }) : t.cancel && console.log("用户点击取消");
                }
            }) : -1 == e ? wx.navigateTo({
                url: "/make_speed/big_customer/join/join?type=0"
            }) : 0 < e && (app.globalData.business_id = e, wx.navigateTo({
                url: "/make_speed/big_customer/info/info?id=" + e
            }));
        }, function(t) {});
    },
    confirm: function() {
        if (!wx.getStorageSync("fahuo").person_tel) return app.hint("请选择发件地址~");
        if (!wx.getStorageSync("shouhuo").person_tel) return app.hint("请选择收件地址~");
        var t = this.data.goods_idx;
        if (t < 0) return app.hint("请选择物品类型");
        var e = this.data.goods_list[t].id, a = this.data.goods_list[t].name, i = this.data.price_detail.coupon_money, o = this.data.coupons.id;
        o || i || (i = o = 0);
        var s = wx.getStorageSync("city"), n = {};
        "立即取件" == this.data.hour ? n = 1 : ((n = {}).day = this.data.day, n.hour = this.data.hour, 
        n.minute = this.data.minute);
        var r = {
            weight_num: this.data.weight,
            remark: this.data.remark,
            distance: this.data.distance,
            duration: this.data.duration,
            time: n,
            coupons_id: o,
            standard_id: e,
            city: s,
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
        wx.setStorageSync("order", r), wx.navigateTo({
            url: "../order/order"
        });
    },
    getBanner: function() {
        var e = this;
        homeModule.getBanner().then(function(t) {
            e.setData({
                banner_list: t
            });
        }, function(t) {});
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
            url: "../coupons/coupons?distance=" + this.data.distance + "&money=" + this.data.money + "&order_type=0"
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
    closeIndexImg: function() {
        this.setData({
            red_bag: !1
        }), app.collectTip(this);
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