var app = getApp();

Page({
    data: {
        img_url: app.globalData.img_url
    },
    onLoad: function() {},
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    question: function() {
        wx.navigateTo({
            url: "../question/question"
        });
    },
    userProtocol: function() {
        wx.navigateTo({
            url: "../protocol/protocol?title=用户协议&type=user_agreement"
        });
    },
    rechargeProtocol: function() {
        wx.navigateTo({
            url: "../protocol/protocol?title=充值协议&type=user_recharge"
        });
    },
    onShareAppMessage: function() {
        return app.getShare(), {
            title: app.globalData.syStem.user_program_title,
            path: "/make_speed/router/router?recommend_id=" + app.globalData.user_id,
            imageUrl: app.globalData.syStem.user_share_img ? app.globalData.syStem.user_share_img : ""
        };
    }
});