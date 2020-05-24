var _home = require("../../../modules/home"), _wechatMap = require("../../../modules/wechatMap"), homeModule = new _home.home(), wechatMapModule = new _wechatMap.wechatMap(), app = getApp();

Page({
    data: {
        input_bg: !0,
        time_bg: !0,
        pay_bg: !0,
        remark_bg: !0,
        money: 0,
        remark: "",
        pay_method: 2,
        goods_list: [],
        fahuo: "",
        name: "",
        tel: "",
        coupons_money: 0,
        service_money: 0,
        my_money: 0,
        coupons: {},
        day: "",
        hour: "立即",
        minute: "",
        isImmediately: 0,
        xday: "",
        price_detail: {},
        actual_payment: -1,
        discount: 0,
        order_type: 6,
        phone: "",
        address_des: "",
        address: "",
        person_name: "",
        offer: 0,
        imgs: "",
        img_temp: [],
        hupload_img_switch: 0
    },
    onLoad: function(e) {
        wx.setStorageSync("is_remove_shou", 1), wx.removeStorageSync("coupons");
        var t = wx.getStorageSync("fahuo") || {}, a = app.globalData.syStem.user_mobile || wx.getStorageSync("phone");
        a = a || "", this.setData({
            offer: e.offer || 0,
            id: e.id || 0,
            title: e.title || "",
            phone: t.person_tel ? t.person_tel : a,
            tel: t.person_tel ? t.person_tel : a,
            address_des: t.person_address ? t.person_address : "",
            address: t.person_address ? t.person_address : "",
            person_name: t.person_name ? t.person_name : "",
            name: t.person_name ? t.person_name : "",
            hupload_img_switch: app.globalData.syStem.hupload_img_switch
        });
    },
    onReady: function() {
        app.setNavigation(), wx.setNavigationBarTitle({
            title: app.globalData.syStem.business_type[5].title
        });
    },
    onShow: function() {
        var e = wx.getStorageSync("fahuo_temporary");
        e.title && this.setData({
            fahuo: e
        }), this.pirceParam();
    },
    confirm: function() {
        var e = this.data.fahuo;
        if (!e.title) return app.hint("请先选择地址");
        var t = this.data.tel;
        if (!t) return app.hint("请输入号码~");
        if (!/^1(3|4|5|6|7|8|9)\d{9}$/.test(t)) return app.hint("请填写正确的手机号");
        e.person_name = this.data.name, e.person_tel = t, e.person_address = this.data.address_des || "电话联系", 
        wx.setStorageSync("fahuo", e);
        var a = this.data.price_detail.coupon_money, o = this.data.coupons.id;
        o || a || (a = o = 0);
        var i = {};
        "立即" == this.data.hour ? i = 1 : ((i = {}).day = this.data.day, i.hour = this.data.hour, 
        i.minute = this.data.minute);
        var s = {
            remark: this.data.remark,
            time: i,
            city: wx.getStorageSync("city"),
            coupons_id: o,
            coupons_money: a,
            buy_type: 1,
            order_type: this.data.order_type,
            fahuo: e,
            cate_id: this.data.id,
            imgs: this.data.imgs,
            pay_method: this.data.pay_method,
            moneys: this.data.service_money,
            actual_payment: this.data.actual_payment,
            distance_price: this.data.price_detail.distance_price
        };
        wx.setStorageSync("order", s), wx.redirectTo({
            url: "/make_speed/order/order"
        });
    },
    imgUpload: function(e) {
        this.setData({
            img_temp: e.detail.img_temp,
            imgs: e.detail.imgs
        });
    },
    pirceParam: function() {
        var t = this;
        homeModule.getHomemakingprice({
            type: 6,
            city: wx.getStorageSync("city"),
            cate_id: this.data.id
        }).then(function(e) {
            t.setData({
                service_money: e.distance_price,
                actual_payment: e.money
            }), t.getPrice(e.money, e.discount_price, e.night_price, e.change_price);
        }, function(e) {});
    },
    getPrice: function() {
        var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, t = arguments[1], a = arguments[2], o = arguments[3], i = wx.getStorageSync("coupons") || {}, s = 0, n = e;
        i && i.satisfy_money && (1 * i.satisfy_money <= e && (e = (e - (s = 1 * i.coupons_money)).toFixed(2)));
        var r = {};
        r.night_price = a, r.change_price = o, r.tip_money = 0, r.actual_payment = e, r.coupon_money = s, 
        r.weight = 0, r.distance = 0, r.discount_price = t, r.order_type = 6, r.floor_price = 0, 
        r.distance_price = n, wx.setStorageSync("price_detail", r), this.setData({
            actual_payment: e,
            service_money: n,
            price_detail: r,
            coupons_money: s,
            coupons: i
        });
    },
    sTime: function(e) {
        var a = this, t = e.detail.select;
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
            a.setData({
                xTime: t,
                time_bg: !1
            });
        }, function(e) {});
    },
    sCoupon: function() {
        wx.navigateTo({
            url: "/make_speed/coupons/coupons?distance=0&money=" + this.data.service_money + "&order_type=6"
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
    name: function(e) {
        this.setData({
            name: e.detail.value
        });
    },
    tel: function(e) {
        this.setData({
            tel: e.detail.value
        });
    },
    addressDes: function(e) {
        this.setData({
            address_des: e.detail.value
        });
    },
    toAddress: function() {
        wechatMapModule.openLocationMap(5, 0, !1);
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
    desBtn: function() {
        wx.navigateTo({
            url: "/make_speed/protocol/protocol?isHomemaking=1&title=" + this.data.title + "&id=" + this.data.id
        });
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