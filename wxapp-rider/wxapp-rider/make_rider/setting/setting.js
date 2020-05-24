var app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl
    },
    modifyPhone: function() {
        wx.navigateTo({
            url: "../modify_phone/modify_phone"
        });
    },
    orderSetting: function() {
        wx.navigateTo({
            url: "../order_setting/order_setting"
        });
    },
    logout: function() {
        app.closeWs(), wx.removeStorageSync("phone"), wx.reLaunch({
            url: "../login/login"
        });
    },
    onLoad: function(o) {
        app.setNavigation();
    },
    onReady: function() {},
    onShow: function() {
        app.listenWss(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});