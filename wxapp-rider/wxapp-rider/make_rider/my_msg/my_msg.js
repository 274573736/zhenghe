var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl
    },
    onLoad: function(e) {
        var a = this;
        app.setNavigation(), homeModule.getRiderMsg().then(function(e) {
            a.setData({
                list: e
            });
        }, function(e) {});
    },
    form: function(e) {
        console.log(e);
        var a = e.detail.value.phone, t = e.detail.value.username, n = e.detail.value.address;
        return e.detail.value.age ? n ? t ? /^1(3|4|5|6|7|8|9)\d{9}$/.test(a) ? void app.hint("注册成功", "success") : app.hint("手机号输入有误") : app.hint("联系人不能为空") : app.hint("地址不能为空") : app.hint("年龄不能为空");
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