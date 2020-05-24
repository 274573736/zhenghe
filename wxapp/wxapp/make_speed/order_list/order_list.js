var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        top_item: [ "全部", "进行中", "待评价", "完成单", "取消单" ],
        top_p: "0 30rpx",
        idx: 0,
        order_list: [],
        isData: !1,
        is_business: 0
    },
    onLoad: function(t) {
        var a = t.is_business ? t.is_business : 0;
        this.setData({
            is_business: a
        }), this.getData(0);
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
        var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 1;
        1 != this.data.is_business ? this.userOrder(t, a) : this.businessOrder(t, a);
    },
    userOrder: function() {
        var a = this, e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, s = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 1, i = [];
        homeModule.orderList({
            status: e,
            page: s
        }).then(function(t) {
            i = t, 1 < s && (i = a.data.order_list.concat(t)), a.setData({
                order_list: i,
                idx: e,
                page: s,
                isData: !0
            });
        }, function(t) {
            a.data.idx != e ? a.setData({
                order_list: i,
                idx: e,
                page: s
            }) : a.setData({
                isData: !1
            });
        });
    },
    businessOrder: function() {
        var a = this, e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, s = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 1, i = [];
        homeModule.businessOrder({
            status: e,
            page: s,
            bid: app.globalData.business_id
        }).then(function(t) {
            i = t, 1 < s && (i = a.data.order_list.concat(t)), a.setData({
                order_list: i,
                idx: e,
                page: s,
                isData: !0
            });
        }, function(t) {
            a.data.idx != e ? a.setData({
                order_list: i,
                idx: e,
                page: s
            }) : a.setData({
                isData: !1
            });
        });
    },
    toOrderDetail: function(t) {
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.status, s = t.currentTarget.dataset.type;
        wx.navigateTo({
            url: "../order_pay/order_pay?order_id=" + a + "&status=" + e + "&is_business=" + this.data.is_business + "&order_type=" + s
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