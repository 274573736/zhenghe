var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        imgs: [],
        type: 0
    },
    onLoad: function(e) {
        var t = this;
        homeModule.businessSetting().then(function(e) {
            t.setData({
                imgs: e.business_poster
            });
        }, function(e) {}), this.setData({
            type: e.type ? e.type : 0
        });
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    onHide: function() {},
    confirm: function() {
        wx.navigateTo({
            url: "/make_speed/big_customer/register/register?type=" + this.data.type
        });
    },
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});