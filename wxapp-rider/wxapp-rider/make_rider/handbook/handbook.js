var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl,
        list: [],
        page: 1,
        isData: !0
    },
    onLoad: function(a) {
        app.setNavigation(), this.postData(1);
    },
    postData: function(e) {
        var o = this;
        homeModule.riderHandboook({
            page: e
        }).then(function(a) {
            var t = a;
            1 < e && (t = o.data.list.concat(a)), o.setData({
                list: t,
                page: e,
                isData: !0
            });
        }, function(a) {
            1 < e && (app.hint("暂无更多数据~"), o.setData({
                isData: !1
            }));
        });
    },
    handbookDetail: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../handbook_detail/handbook_detail?id=" + t
        });
    },
    onReady: function() {},
    onShow: function() {
        app.listenWss(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        if (!this.data.isData) return app.hint("暂无更多数据");
        var a = 1 * this.data.page + 1;
        this.postData(a);
    },
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});