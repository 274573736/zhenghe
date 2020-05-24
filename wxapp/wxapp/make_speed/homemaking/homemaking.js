var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        server_type: [],
        server_list: [],
        server_select: 0
    },
    onLoad: function(e) {
        var t = this;
        homeModule.getHomemakingList().then(function(e) {
            t.setData({
                server_list: e
            });
        }, function(e) {}), app.getAppSetting(5), this.getIsNewCoupons();
    },
    onReady: function() {},
    onShow: function() {},
    serverType: function(e) {
        this.setData({
            server_select: e.currentTarget.dataset.idx
        });
    },
    goodsBtn: function(e) {
        wx.navigateTo({
            url: "/sundries/homemaking/order/order?id=" + e.currentTarget.dataset.id + "&title=" + e.currentTarget.dataset.title + "&offer=" + e.currentTarget.dataset.offer
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
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});