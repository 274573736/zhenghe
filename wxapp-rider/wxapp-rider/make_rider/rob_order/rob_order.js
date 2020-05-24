var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        top_id: 0,
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        page: 1,
        map: 0,
        underwayOrder: [],
        isData: !0,
        img_url: app.globalData.imgUrl
    },
    onLoad: function(a) {
        var t = a.top_id;
        t ? this.setData({
            top_id: t
        }) : t = 0, 1 == a.map && this.setData({
            map: 1
        }), this.postData(t, 1);
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        app.listenWss(this);
    },
    topTap: function(a) {
        var t = a.currentTarget.id;
        this.setData({
            top_id: t,
            page: 1,
            isData: !0
        }), this.postData(t, 1);
    },
    cancelOrder: function(a) {
        var t = a.detail.idx, e = this.data.underwayOrder;
        return e.splice(t, 1), this.setData({
            underwayOrder: e
        }), app.hint("取消接单成功~");
    },
    robOrderSuccess: function(a) {
        var t = a.detail.top_id;
        this.setData({
            top_id: t
        }), this.postData(t, 1);
    },
    postData: function(a, e) {
        var r = this;
        if (1 < e && !this.data.isData) return app.hint("暂无更多的订单~");
        var t = 0;
        if (0 == a ? t = 2 : 1 == a ? t = 3 : 2 == a && (t = 4), 1 == this.data.map && 0 == a) {
            var i = [];
            return i[0] = wx.getStorageSync("map_data"), void this.setData({
                underwayOrder: i
            });
        }
        homeModule.getRiderOrder({
            status: t,
            page: e
        }).then(function(a) {
            var t = a;
            1 < e && (t = r.data.underwayOrder.concat(a)), r.setData({
                underwayOrder: t,
                isData: !0,
                page: e,
                map: 0
            });
        }, function(a) {
            return 1 < e ? (r.setData({
                isData: !1
            }), app.hint("暂无更多的订单~")) : r.setData({
                underwayOrder: [],
                page: e,
                map: 0
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = this.data.page, t = this.data.top_id;
        a = 1 * a + 1, this.postData(t, a);
    },
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});