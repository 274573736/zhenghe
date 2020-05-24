var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        idx: 0,
        info: {},
        page: 1,
        list: [],
        isData: !0
    },
    onLoad: function(t) {
        var a = this;
        homeModule.getUserInfo().then(function(t) {
            a.setData({
                info: t
            });
        }, function(t) {}), this.postData(1);
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    postData: function(e) {
        var o = this;
        homeModule.getShopping({
            page: e
        }).then(function(t) {
            if (1 < e && t.coupon_list.length < 1) return o.setData({
                isData: !1
            }), app.hint("没有更多数据了");
            var a = t.coupon_list;
            1 < e && (a = o.data.list.concat(a)), o.setData({
                list: a,
                page: e,
                isData: !0
            });
        }, function(t) {});
    },
    itemTap: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            idx: a
        });
    },
    goodsDetail: function(t) {
        wx.navigateTo({
            url: "/make_speed/shop/goods_detail/goods_detail?id=" + t.currentTarget.dataset.id
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        if (0 == this.data.idx) {
            if (!this.data.isData) return app.hint("暂无更多数据~");
            var t = 1 * this.data.page + 1;
            this.postData(t);
        }
    },
    onShareAppMessage: function() {
        return app.getShare(), {
            title: app.globalData.syStem.user_program_title,
            path: "/make_speed/router/router?recommend_id=" + app.globalData.user_id,
            imageUrl: app.globalData.syStem.user_share_img ? app.globalData.syStem.user_share_img : ""
        };
    }
});