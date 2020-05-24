var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {},
    onLoad: function(t) {},
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        var a = this;
        homeModule.staffList({
            id: app.globalData.business_id
        }).then(function(t) {
            a.setData({
                list: t
            });
        }, function(t) {});
    },
    onHide: function() {},
    staffInfo: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/make_speed/big_customer/staff_add/staff_add?id=" + a
        });
    },
    staffAdd: function() {
        wx.navigateTo({
            url: "/make_speed/big_customer/staff_add/staff_add"
        });
    },
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});