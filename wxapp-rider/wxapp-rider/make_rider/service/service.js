var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl,
        idx: -1
    },
    lookQuestion: function(e) {
        var t = e.currentTarget.dataset.idx;
        this.setData({
            idx: t
        });
    },
    callTel: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.tel
        });
    },
    onLoad: function(e) {
        var t = this;
        app.setNavigation(), homeModule.getProtocol({
            type: "rider_service"
        }).then(function(e) {
            t.setData({
                protocol: e.content,
                tel: e.content.phone
            });
        }, function(e) {});
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