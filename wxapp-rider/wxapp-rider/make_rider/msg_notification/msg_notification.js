var _home = require("../../modules/home");

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl,
        idx: 0,
        list: [],
        page: 1,
        isData: !0
    },
    onLoad: function(t) {
        app.setNavigation();
    },
    tapSwitch: function(t) {
        var e = t.currentTarget.dataset.idx;
        this.setData({
            idx: e
        }), 1 == e && this.postMsg("list", 0, "page", 1, "isData");
    },
    topMsg: function(t) {
        var e = t.currentTarget.dataset.idx, a = "";
        0 == e ? (a = "系统通知", e = 1) : (a = "处罚通知", e = 2), wx.navigateTo({
            url: "../msg/msg?title=" + a + "&idx=" + e
        });
    },
    postMsg: function(i, t, n, r, o) {
        var s = this;
        homeModule.msg("riderMessage", {
            page: r,
            type: t
        }).then(function(t) {
            var e, a = t;
            1 < r && (a = s.data[i].concat(t)), s.setData((_defineProperty(e = {}, i, a), _defineProperty(e, n, r), 
            _defineProperty(e, o, !0), e));
        }, function(t) {
            1 < r && (app.hint("暂无更多数据~"), s.setData(_defineProperty({}, o, !1)));
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
        if (!this.data.isData) return app.hint("暂无更多信息~");
        var t = 1 * this.data.page + 1;
        this.postMsg("list", 0, "page", t, "isData");
    },
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});