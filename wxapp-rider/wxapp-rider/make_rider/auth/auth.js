var _apps = require("../../modules/apps.js"), _home = require("../../modules/home"), app = getApp(), homeModule = new _home.home(), appsModule = new _apps.apps();

Page({
    data: {
        img_url: app.globalData.imgUrl
    },
    onLoad: function(e) {
        var a = this, t = setInterval(function() {
            app.globalData.syStem && (clearInterval(t), a.setData({
                img: app.globalData.syStem.rider_auth_bg
            }));
        }, 10);
        app.util.getUserInfo(function(e) {
            e && appsModule.getRiderStatus(app);
        });
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    goLogin: function() {
        wx.navigateTo({
            url: "../login/login"
        });
    },
    auth: function(t) {
        wx.getSetting({
            success: function(e) {
                e.authSetting["scope.userInfo"] ? app.util.getUserInfo(function(e) {
                    if (e) {
                        var a = wx.getStorageSync("userInfo");
                        if (a && (a.wxInfo = t.detail.userInfo || "", wx.setStorageSync("userInfo", a), 
                        homeModule.updateRiderInfo({
                            nickName: t.detail.userInfo.nickName,
                            avatarUrl: t.detail.userInfo.avatarUrl,
                            sex: t.detail.userInfo.gender
                        }).then(function(e) {}, function(e) {})), 1 == getCurrentPages().length) return void appsModule.getRiderStatus(app);
                        wx.navigateBack();
                    }
                }) : app.hint("进入小程序需要授权");
            },
            fail: function(e) {
                app.hint("进入小程序需要先授权");
            }
        });
    },
    onHide: function() {},
    onUnload: function() {}
});