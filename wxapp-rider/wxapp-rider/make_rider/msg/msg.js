var _home = require("../../modules/home");

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
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
    onLoad: function(e) {
        var t = e.idx;
        wx.setNavigationBarTitle({
            title: e.title
        }), app.setNavigation(), this.setData({
            idx: t
        }), this.postMsg("list", t, "page", 1, "isData");
    },
    postMsg: function(i, e, n, o, r) {
        var s = this;
        homeModule.msg("riderMessage", {
            page: o,
            type: e
        }).then(function(e) {
            var t, a = e;
            1 < o && (a = s.data[i].concat(e)), s.setData((_defineProperty(t = {}, i, a), _defineProperty(t, n, o), 
            _defineProperty(t, r, !0), t));
        }, function(e) {
            1 < o && (app.hint("暂无更多数据~"), s.setData(_defineProperty({}, r, !1)));
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
        var e = 1 * this.data.page + 1;
        this.postMsg("list", this.data.idx, "page", e, "isData");
    },
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});