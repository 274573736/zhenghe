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
        title: "",
        nav_height: 0,
        statusBar: 0,
        banner_list: [],
        cardCur: 0,
        cardFreightCur: 0,
        is_tip_collect: !1
    },
    onLoad: function(e) {
        var n = this;
        this.getBusinessType(e.type), this.getBanner(), app.getAppSetting(-2), this.getIsNewCoupons(), 
        app.goingOrder(homeModule), wx.getSystemInfo({
            success: function(e) {
                var t = e.statusBarHeight, a = wx.getMenuButtonBoundingClientRect(), o = a.bottom + a.top - e.statusBarHeight;
                n.setData({
                    statusBar: t,
                    nav_height: o
                });
            }
        }), this.topSwiper();
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
        var t = e.currentTarget.dataset.url, a = e.currentTarget.dataset.type, o = e.currentTarget.dataset.app_url, n = e.currentTarget.dataset.appid;
        if (2 != parseInt(a)) switch (t) {
          case "no":
            break;

          default:
            wx.navigateTo({
                url: t
            });
        } else wx.navigateToMiniProgram({
            appId: n,
            path: o
        });
    },
    toOtherPath: function(e) {
        var t = e.currentTarget.dataset.idx, a = this.data.banner_list[t];
        1 != a.type ? a.path && ("/make_speed/big_customer/info/info" != a.path ? wx.navigateTo({
            url: a.path
        }) : this.toBusiness()) : wx.navigateToMiniProgram({
            appId: a.appid,
            path: a.app_url
        });
    },
    toBusiness: function() {
        homeModule.businessStatus().then(function(e) {
            var t = e[0];
            0 == t ? wx.showModal({
                title: "提示",
                content: "大客户审核暂未通过，是否要前往修改提交信息~",
                success: function(e) {
                    e.confirm ? wx.navigateTo({
                        url: "/make_speed/big_customer/join/join?type=1"
                    }) : e.cancel && console.log("用户点击取消");
                }
            }) : -1 == t ? wx.navigateTo({
                url: "/make_speed/big_customer/join/join?type=0"
            }) : 0 < t && (app.globalData.business_id = t, wx.navigateTo({
                url: "/make_speed/big_customer/info/info?id=" + t
            }));
        }, function(e) {});
    },
    cardSwiper: function(e) {
        this.setData({
            cardCur: e.detail.current
        });
    },
    cardFreightSwiper: function(e) {
        this.setData({
            cardFreightCur: e.detail.current
        });
    },
    getBanner: function() {
        var t = this;
        homeModule.getBanner().then(function(e) {
            t.setData({
                banner_list: e
            });
        }, function(e) {});
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
        var e = wx.getStorageSync("fahuo") || wx.getStorageSync("fahuo_temporary") || {}, t = wx.getStorageSync("shouhuo") || {};
        e.title && !e.person_tel && app.globalData.syStem.user_mobile && (e.person_tel = app.globalData.syStem.user_mobile), 
        this.setData({
            fahuo: e,
            shouhuo: t
        }), e.title && e.person_tel && (e.person_address = e.person_address ? e.person_address : "电话联系", 
        wx.setStorageSync("fahuo", e));
    },
    topItem: function(e) {
        var t = e.currentTarget.dataset.idx, a = e.currentTarget.dataset.type, o = this.data.fahuo, n = wx.getStorageSync("shouhuo");
        o && o.title && o.person_tel && n && n.title && (3 == a || 3 != a && n.person_tel) && (wx.removeStorageSync("shouhuo"), 
        this.setData({
            shouhuo: {}
        })), this.setData({
            idx: t,
            type: a
        });
    },
    getBusinessType: function() {
        var n = this, s = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : -1;
        homeModule.getBusinessType().then(function(e) {
            var t = 0, a = 0;
            if (e.length) {
                for (var o = 0; o < e.length; o++) if (e[o].status && (e[o].type == s && -1 < s || -1 == s)) {
                    a = e[o].type, t = o;
                    break;
                }
                n.setData({
                    top: e,
                    type: a,
                    idx: t
                });
            }
        }, function(e) {});
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