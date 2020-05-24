var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        top_array: [ "全部", "进行中", "完成单", "取消单" ],
        idx: 0,
        img_url: app.globalData.imgUrl,
        underwayOrder: [],
        isData: !0,
        page: 1,
        time_picker: !0,
        year: 2019,
        month: 2,
        time: ""
    },
    topTap: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            idx: a,
            isData: !0,
            time: ""
        }), this.postData(a, 1, "");
    },
    bindTime: function() {
        this.setData({
            time_picker: !1
        });
    },
    confirmTime: function(t) {
        var a = t.detail.year, e = t.detail.month, i = a + "-" + e, r = this.data.idx;
        this.setData({
            year: a,
            month: e,
            time: i
        }), this.postData(r, 1, i);
    },
    postData: function(t, e) {
        var i = this, a = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "";
        if (1 < e && !this.data.isData) return app.hint("暂无更多的订单~");
        var r = 0;
        0 == t ? r = 0 : 1 == t ? r = -1 : 2 == t ? r = 6 : 3 == t && (r = 7), homeModule.getRiderOrder({
            status: r,
            page: e,
            time: a
        }).then(function(t) {
            var a = t;
            1 < e && (a = i.data.underwayOrder.concat(a)), i.setData({
                underwayOrder: a,
                page: e,
                isData: !0
            });
        }, function(t) {
            if (1 < e) return i.setData({
                isData: !1
            }), app.hint("暂无更多的订单~");
            i.setData({
                underwayOrder: {},
                page: e
            });
        });
    },
    orderDetail: function() {
        wx.navigateTo({
            url: "../order-detail/order-detail"
        });
    },
    onLoad: function(t) {
        app.setNavigation(), this.postData(0, 1, "");
        var a = new Date(), e = a.getFullYear(), i = a.getMonth() + 1;
        this.setData({
            year: e,
            month: i
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
        var t = this.data.idx, a = 1 * this.data.page + 1, e = this.data.time;
        this.postData(t, a, e);
    },
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});