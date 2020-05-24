var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        top_item: [ "全部", "已打款", "待打款", "待审核" ],
        top_p: "0 30rpx",
        idx: 0,
        order_list: [],
        isData: !1
    },
    onLoad: function(t) {
        this.getData(0);
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    Getidx: function(t) {
        var a = t.detail.idx;
        this.getData(a);
    },
    getData: function() {
        var a = this, e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, i = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 1, o = [];
        homeModule.distributionWithdrawList({
            status: e,
            page: i
        }).then(function(t) {
            o = t, 1 < i && (o = a.data.order_list.concat(t)), a.setData({
                order_list: o,
                idx: e,
                page: i,
                isData: !0
            });
        }, function(t) {
            a.data.idx != e ? a.setData({
                order_list: o,
                idx: e,
                page: i
            }) : a.setData({
                isData: !1
            });
        });
    },
    scrollSole: function() {
        if (1 == this.data.isData) {
            var t = this.data.idx, a = 1 * this.data.page + 1;
            this.getData(t, a);
        } else app.hint("没有更多订单了");
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