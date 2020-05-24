var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        top_swiper: [],
        red_bag: !1,
        new_person: {},
        city: "",
        district: "",
        cardCur: 0,
        cardFreightCur: 0,
        is_tip_collect: !1
    },
    onLoad: function(e) {
        app.getAppSetting(4), this.getIsNewCoupons(), this.topSwiper();
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
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
    cardFreightSwiper: function(e) {
        this.setData({
            cardFreightCur: e.detail.current
        });
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
    topSwiper: function() {
        var t = this;
        homeModule.topSwiper().then(function(e) {
            t.setData({
                top_swiper: e
            });
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