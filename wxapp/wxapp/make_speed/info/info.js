var _home = require("../../modules/home"), _setting = require("../../modules/setting"), settingModule = new _setting.setting(), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        info: {},
        uid: 0,
        logo: "",
        auth: !1,
        is_login: !0,
        distributor_switch: 0,
        is_distributor: 0,
        is_business: -2,
        speed_copyright: ""
    },
    onLoad: function(t) {
        var i = this;
        this.isBusiness(), this.setData({
            uid: app.globalData.user_id,
            logo: app.globalData.syStem.rider_logo,
            speed_copyright: app.globalData.syStem.speed_copyright
        }), settingModule.auth(0).then(function(t) {
            t && i.setData({
                auth: !0
            });
        }, function(t) {});
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        this.getUserInfo(), this.distributorMsg();
    },
    handleContact: function(t) {},
    goLogin: function() {
        this.setData({
            is_login: !1
        });
    },
    authBtn: function(t) {
        t.detail.uid ? this.setData({
            uid: t.detail.uid,
            auth: !0,
            is_login: !0
        }) : this.setData({
            is_login: !0
        });
    },
    distributorBtn: function() {
        var i = this;
        settingModule.auth(0).then(function(t) {
            if (t) return 1 == i.data.is_distributor ? void wx.navigateTo({
                url: "/sundries/distributor/info/info"
            }) : 0 == i.data.is_distributor ? void wx.showModal({
                title: "温馨提示",
                content: app.globalData.syStem.distribution_name + "信息正在审核中，请您耐心等待~",
                showCancel: !1,
                success: function(t) {
                    t.confirm;
                }
            }) : void wx.navigateTo({
                url: "/sundries/distributor/join/join"
            });
            i.goLogin();
        }, function(t) {});
    },
    distributorMsg: function() {
        var i = this;
        homeModule.distributionConfig().then(function(t) {
            wx.setStorageSync("distributor", t), i.setData({
                distribution_name: app.globalData.syStem.distribution_name,
                distributor_switch: t.d_switch,
                is_distributor: t.is_distributor
            });
        }, function(t) {});
    },
    ToRider: function() {
        wx.navigateToMiniProgram({
            appId: app.globalData.syStem.rider_appid,
            path: "make_rider/auth/auth",
            envVersion: "release",
            success: function(t) {},
            fail: function(t) {}
        });
    },
    toBusiness: function() {
        var o = this;
        homeModule.businessStatus().then(function(t) {
            o.setData({
                is_business: t[0]
            });
            var i = t[0];
            0 == i ? wx.showModal({
                title: "提示",
                content: "大客户审核暂未通过，是否要前往修改提交信息~",
                success: function(t) {
                    t.confirm ? wx.navigateTo({
                        url: "/make_speed/big_customer/join/join?type=1"
                    }) : t.cancel && console.log("用户点击取消");
                }
            }) : -1 == i ? wx.navigateTo({
                url: "/make_speed/big_customer/join/join?type=0"
            }) : 0 < i && (app.globalData.business_id = i, wx.navigateTo({
                url: "/make_speed/big_customer/info/info?id=" + i
            }));
        }, function(t) {});
    },
    isBusiness: function() {
        var i = this;
        homeModule.businessStatus().then(function(t) {
            i.setData({
                is_business: t[0]
            });
        }, function(t) {});
    },
    getUserInfo: function() {
        var i = this;
        homeModule.getUserInfo().then(function(t) {
            i.setData({
                info: t
            });
        }, function(t) {});
    },
    myCoupon: function() {
        wx.navigateTo({
            url: "../coupons/coupons"
        });
    },
    myMoney: function() {
        wx.navigateTo({
            url: "../my_money/my_money"
        });
    },
    myOrder: function() {
        wx.navigateTo({
            url: "../order_list/order_list"
        });
    },
    gralCity: function() {
        wx.navigateTo({
            url: "/make_speed/shop/store/store"
        });
    },
    oftenQuestion: function() {
        wx.navigateTo({
            url: "../setting/setting"
        });
    },
    inviteActive: function() {
        var i = this;
        settingModule.auth(0).then(function(t) {
            t ? wx.navigateTo({
                url: "../activity/activity"
            }) : i.goLogin();
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