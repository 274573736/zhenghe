var _home = require("../../modules/home.js"), _setting = require("../../modules/setting"), settingModule = new _setting.setting(), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        recommend_id: 0,
        rider_id: 0,
        user_program_title: "",
        logo: ""
    },
    onLoad: function(e) {
        var t = this, a = e.recommend_id || 0, n = e.rider_id || 0;
        this.setData({
            recommend_id: a,
            rider_id: n
        });
        var o = setInterval(function() {
            app.globalData.syStem && (clearInterval(o), t.setData({
                logo: app.globalData.syStem.rider_logo
            }));
        }, 10);
        settingModule.auth(0).then(function(e) {
            e && (t.getUserId(), app.globalData.syStem && app.toUrl(app.globalData.syStem));
        }, function(e) {});
    },
    onReady: function(e) {
        app.setNavigation();
    },
    onShow: function() {},
    userMessage: function(a) {
        var n = this;
        settingModule.auth(0).then(function(e) {
            e ? app.util.getUserInfo(function(e) {
                if (e) {
                    var t = wx.getStorageSync("userInfo");
                    return t && (t.wxInfo = a.detail.userInfo || "", wx.setStorageSync("userInfo", t)), 
                    void n.saveUser(a.detail.userInfo);
                }
                app.hint("获取信息失败~");
            }) : wx.navigateBack({
                delta: 1
            });
        }, function(e) {});
    },
    getUserId: function() {
        homeModule.getUserId(this).then(function(e) {
            app.globalData.user_id = e.user_id;
        }, function(e) {});
    },
    saveUser: function(e) {
        var t = this;
        homeModule.login({
            nickName: e.nickName,
            avatarUrl: e.avatarUrl,
            sex: e.gender,
            recommend_id: this.data.recommend_id,
            rider_id: this.data.rider_id
        }).then(function(e) {
            if (t.getUserId(), !(0 != t.data.recommend_id && 1 == e.status || 0 != t.data.rider_id && 1 == e.status)) return 1 == getCurrentPages().length ? app.toUrl(app.globalData.syStem) : void wx.navigateBack();
            wx.redirectTo({
                url: "../new_person/new_person"
            });
        });
    },
    onHide: function() {},
    onUnload: function() {}
});