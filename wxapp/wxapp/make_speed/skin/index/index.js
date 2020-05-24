var _home = require("../../../modules/home"), _address = require("../../../modules/address"), addressModule = new _address.address(), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        idx: -1,
        type: -1,
        fahuo: {},
        shouhuo: {},
        red_bag: !1,
        new_person: {},
        city: "",
        district: "",
        top: [],
        is_tip_collect: !1
    },
    onLoad: function(e) {
        this.getBusinessType(e.type), app.getAppSetting(-1), this.getIsNewCoupons(), app.goingOrder(homeModule), 
        this.topSwiper();
    },
    onReady: function() {
        addressModule.getCurrentCity(this);
    },
    onShow: function() {
        this.updateAddress();
    },
    onHide: function() {},
    topSwiper: function() {
        var t = this;
        homeModule.topSwiper().then(function(e) {
            t.setData({
                top_swiper: e
            });
        }, function(e) {});
    },
    jump: function(e) {
        var t = e.currentTarget.dataset.url, a = e.currentTarget.dataset.type, s = e.currentTarget.dataset.app_url, o = e.currentTarget.dataset.appid;
        if (2 != parseInt(a)) switch (t) {
          case "no":
            break;

          default:
            wx.navigateTo({
                url: t
            });
        } else wx.navigateToMiniProgram({
            appId: o,
            path: s
        });
    },
    cardFreightSwiper: function(e) {
        this.setData({
            cardFreightCur: e.detail.current
        });
    },
    getIsNewCoupons: function() {
        var t = this;
        homeModule.getIsNewCoupons().then(function(e) {
            e.money && 0 < parseFloat(e.money) ? t.setData({
                new_person: e,
                red_bag: !0
            }) : app.collectTip(t);
        }, function(e) {});
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
    toInfo: function() {
        app.getApplicationIsAuth().then(function(e) {
            1 == e && wx.navigateTo({
                url: "/make_speed/info/info"
            });
        }, function(e) {});
    },
    examineAddress: function(e) {
        var t = this.data.fahuo || {}, a = e.detail.fahuo || {};
        !t.person_tel && app.globalData.syStem.user_mobile && (t.person_tel = app.globalData.syStem.user_mobile), 
        a.person_name = t.person_name, a.person_tel = t.person_tel, a.person_address = t.person_address, 
        this.setData({
            fahuo: a
        }), a.title && t.person_tel && (a.person_address = t.person_address ? t.person_address : "电话联系", 
        wx.setStorageSync("fahuo", a));
    },
    updateAddress: function() {
        wx.getStorageSync("is_remove_shou") && (wx.removeStorageSync("is_remove_shou"), 
        wx.removeStorageSync("shouhuo"));
        var e = wx.getStorageSync("fahuo") || {}, t = wx.getStorageSync("shouhuo") || {};
        e.title && !e.person_tel && app.globalData.syStem.user_mobile && (e.person_tel = app.globalData.syStem.user_mobile), 
        this.setData({
            fahuo: e,
            shouhuo: t
        }), e.title && e.person_tel && (e.person_address = e.person_address ? e.person_address : "电话联系", 
        wx.setStorageSync("fahuo", e));
    },
    topItem: function(e) {
        var t = e.currentTarget.dataset.idx, a = e.currentTarget.dataset.type, s = this.data.fahuo, o = wx.getStorageSync("shouhuo");
        s && s.title && s.person_tel && o && o.title && (3 == a || 3 != a && o.person_tel) && (wx.removeStorageSync("shouhuo"), 
        this.setData({
            shouhuo: {}
        })), this.setData({
            idx: t,
            type: a
        });
    },
    getBusinessType: function() {
        var o = this, r = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : -1;
        homeModule.getBusinessType().then(function(e) {
            var t = 0, a = 0;
            if (e.length) {
                for (var s = 0; s < e.length; s++) if (e[s].status && (e[s].type == r && -1 < r || -1 == r)) {
                    a = e[s].type, t = s;
                    break;
                }
                o.setData({
                    top: e,
                    type: a,
                    idx: t
                });
            }
        }, function(e) {});
    },
    toAddress: function(e) {
        this.data.fahuo && wx.setStorageSync("fahuo", this.data.fahuo);
        var t = e.currentTarget.dataset.id;
        0 != t ? wx.navigateTo({
            url: "/make_speed/address/address?id=" + t + "&skin=1&is_all=1"
        }) : wx.navigateTo({
            url: "/make_speed/address/address?id=" + t + "&skin=1&is_all=1&is_phone=1"
        });
    },
    oftenAddress: function(e) {
        var t = e.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/make_speed/address_resort/address_resort?type=" + t + "&skin=1&skin_type=" + this.data.type
        });
    },
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