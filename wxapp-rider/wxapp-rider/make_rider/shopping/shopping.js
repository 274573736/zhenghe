var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        idx: 0,
        top_item: [ "装备", "我的" ],
        top_p: "0 100rpx 0 100rpx",
        goods_list: [],
        page: 0,
        goods_small_list: [],
        img_url: app.globalData.imgUrl,
        isData: !0,
        my_isData: !0,
        my_page: 1
    },
    onLoad: function(t) {
        app.setNavigation(), this.postData(1);
    },
    postMy: function(o) {
        var i = this;
        homeModule.myGoods({
            page: o
        }).then(function(t) {
            var a = t;
            1 < o && (a = i.data.goods_small_list.concat(t)), i.setData({
                goods_small_list: a,
                my_page: o,
                my_isData: !0
            });
        }, function(t) {
            1 < o && (app.hint("暂无更多数据~"), i.setData({
                my_isData: !1
            }));
        });
    },
    postData: function(o) {
        var i = this;
        homeModule.goodsList({
            page: o
        }).then(function(t) {
            var a = t;
            1 < o && (a = i.data.goods_list.concat(t)), i.setData({
                goods_list: a,
                page: o,
                isData: !0
            });
        }, function(t) {
            1 < o && (app.hint("暂无更多数据~"), i.setData({
                isData: !1
            }));
        });
    },
    Getidx: function(t) {
        var a = t.detail.idx;
        this.setData({
            idx: t.detail.idx
        }), 1 == a && this.postMy(1);
    },
    myBuy: function(t) {
        0 == t.currentTarget.dataset.status && wx.navigateTo({
            url: "../goods_detail/goods_detail?id=" + t.currentTarget.dataset.id
        });
    },
    goodsDetail: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../goods_detail/goods_detail?id=" + a
        });
    },
    scrollSole: function() {
        if (0 == this.data.idx) {
            if (!this.data.isData) return app.hint("暂无更多数据~");
            var t = 1 * this.data.page + 1;
            this.postData(t);
        } else {
            if (!this.data.my_isData) return app.hint("暂无更多数据~");
            var a = 1 * this.data.my_page + 1;
            this.postMy(a);
        }
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