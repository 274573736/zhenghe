var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl,
        time_picker: !0,
        time: "",
        page: 1,
        list: [],
        isData: !0
    },
    bindTime: function() {
        this.setData({
            time_picker: !1
        });
    },
    confirmTime: function(t) {
        var a = t.detail.year, e = t.detail.month, i = a + "-" + e;
        this.setData({
            year: a,
            month: e,
            time: i
        }), this.postData(1, i);
    },
    postData: function(a) {
        var e = this, t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "", i = [];
        homeModule.riderCashList({
            page: a,
            time: t
        }).then(function(t) {
            i = t, 1 < a && (i = e.data.list.concat(t)), e.setData({
                page: a,
                list: i,
                isData: !0
            });
        }, function(t) {
            if (1 < a) return e.setData({
                isData: !1
            }), app.hint("暂无更多数据~");
            e.setData({
                list: i
            });
        });
    },
    onLoad: function(t) {
        app.setNavigation(), this.postData(1, "");
    },
    onReady: function() {},
    onShow: function() {
        app.listenWss(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        if (!this.data.isData) return app.hint("暂无更多数据~");
        var t = 1 * this.data.page + 1, a = this.data.time;
        this.postData(t, a);
    },
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});