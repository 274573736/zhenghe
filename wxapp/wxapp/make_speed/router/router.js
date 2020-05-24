var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {},
    onLoad: function(e) {
        console.log("rooter.js ---onLoad---");
        var t = this;
        wx.showNavigationBarLoading(), wx.showLoading({
            title: "加载中"
        }), wx.removeStorageSync("fahuo"), wx.removeStorageSync("fahuo_temporary"), wx.removeStorageSync("shouhuo"), 
        wx.removeStorageSync("shouhuo_temporary");
        var n = -1;
        -1 < e.type && (n = e.type);
        var o = e.recommend_id || 0, r = e.rider_id || 0;
        e.recommend_id && wx.setStorageSync("recommend_id", e.recommend_id), e.rider_id && wx.setStorageSync("rider_id", e.rider_id), 
        app.util.getUserInfo(function(e) {
            homeModule.getUserId({
                recommend_id: o,
                rider_id: r
            }).then(function(e) {
                app.globalData.user_id = e.user_id;
                var o = setInterval(function() {
                    app.globalData.syStem && (clearInterval(o), t.isBigCustomer(n));
                }, 10);
            }, function(e) {});
        });
    },
    isBigCustomer: function(o) {
        console.log("rooter.js ---isBigCustomer---");
        1 != wx.getStorageSync("is_big_customer") ? app.toUrl(app.globalData.syStem, o) : homeModule.businessStatus().then(function(e) {
            if (0 < e[0]) return wx.setStorageSync("is_big_customer", 0), app.globalData.business_id = e[0], 
            void wx.redirectTo({
                url: "/make_speed/big_customer/info/info?id=" + e[0]
            });
            app.toUrl(app.globalData.syStem, o);
        }, function(e) {});
    },
    onReady: function() { console.log("rooter.js ---onReady---");},
    onShow: function() {console.log("rooter.js ---onShow---");},
    onHide: function() {console.log("rooter.js ---onHide---");},
    onUnload: function() {console.log("rooter.js ---onUnload---");},
    onPullDownRefresh: function() {console.log("rooter.js ---onPullDownRefresh---");},
    onReachBottom: function() {console.log("rooter.js ---onReachBottom---");}
});