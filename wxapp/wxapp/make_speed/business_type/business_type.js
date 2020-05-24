var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        list: []
    },
    onLoad: function(e) {
        var a = this;
        homeModule.getBusinessType().then(function(e) {
            a.setData({
                list: e
            });
        }, function(e) {});
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    type: function(e) {
        app.setFormId(e.detail.formId);
        var a = e.currentTarget.dataset.id, t = "";
        t = 0 == a ? "/make_speed/index/index" : 1 == a ? "/make_speed/help_buy/help_buy" : 2 == a ? "/make_speed/all_powerful/all_powerful" : 3 == a ? "/make_speed/replace_driver/replace_driver" : 4 == a ? "/make_speed/freight/freight" : 5 == a ? "/make_speed/homemaking/homemaking" : "/make_speed/index/index", 
        wx.reLaunch({
            url: t
        });
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