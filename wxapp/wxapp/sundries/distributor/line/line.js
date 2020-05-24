var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        top_item: [ "一级", "二级", "三级" ],
        top_p: "0 30rpx",
        idx: 0,
        order_list: [],
        isData: !1,
        d_tier: 1,
        distribution_name: ""
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("distributor"), a = [ "一级", "二级", "三级" ];
        2 == e.d_tier && (a = [ "一级", "二级" ]), this.setData({
            d_tier: e.d_tier,
            top_item: a,
            distribution_name: app.globalData.syStem.distribution_name
        }), this.getData(0);
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    Getidx: function(t) {
        var e = t.detail.idx;
        this.getData(e);
    },
    getData: function() {
        var e = this, a = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 1;
        homeModule.distributionLine({
            status: a,
            page: t
        }).then(function(t) {
            e.setData({
                order_list: t,
                idx: a
            });
        }, function(t) {
            e.setData({
                order_list: [],
                idx: a
            });
        });
    },
    scrollSole: function() {},
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