var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl,
        list: {},
        order_btn: !0
    },
    onLoad: function(t) {
        var a = this;
        app.setNavigation();
        var e = t.id;
        homeModule.goodsDetail({
            id: e
        }).then(function(t) {
            a.setData({
                list: t
            });
        }, function(t) {});
    },
    imgScale: function() {
        var t = this.data.list.img;
        wx.previewImage({
            current: t,
            urls: [ t ]
        });
    },
    pay: function() {
        var a = this;
        this.setData({
            order_btn: !1
        }), homeModule.goodsPay({
            id: this.data.list.id,
            price: this.data.list.price
        }).then(function(t) {
            homeModule.confirmPay(t).then(function(t) {
                app.hint("购买成功~", "success"), setTimeout(function() {
                    wx.navigateBack({
                        delta: 1
                    });
                }, 400);
            }, function(t) {
                a.payFail();
            });
        }, function(t) {
            a.payFail();
        });
    },
    payFail: function() {
        app.hint("支付失败~"), setTimeout(function() {
            wx.navigateBack({
                delta: 1
            });
        }, 400);
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