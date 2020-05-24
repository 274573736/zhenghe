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
        idx: 0,
        arr: [ 0, 0, 0 ],
        val: "",
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl,
        list: [],
        id: 0,
        punishment_page: 1,
        is_punishment: !0
    },
    onLoad: function(e) {
        app.setNavigation(), this.rewardList("list", 1, "reward_page", 1, "is_reward");
    },
    selectTap: function(e) {
        for (var t = e.currentTarget.dataset.idx, a = e.currentTarget.dataset.id, r = this.data.arr, i = 0; i < r.length; i++) r[i] = 0;
        r[t] = 1, this.setData({
            arr: r,
            idx: t,
            id: a
        });
    },
    rewardList: function(n, e, o, d, p) {
        var s = this;
        homeModule.rewardList({
            page: d,
            appeal: e
        }).then(function(e) {
            var t, a = e;
            1 < d && (a = s.data[n].concat(e));
            for (var r = [], i = 0; i < a.length; i++) r[i] = 0;
            s.setData((_defineProperty(t = {}, n, a), _defineProperty(t, o, d), _defineProperty(t, p, !0), 
            _defineProperty(t, "arr", r), t));
        }, function(e) {
            1 < reward_page && (app.hint("暂无更多数据~"), s.setData(_defineProperty({}, p, !1)));
        });
    },
    input: function(e) {
        var t = e.detail.value;
        this.setData({
            val: t
        });
    },
    confirm: function() {
        var e = this.data.idx, t = this.data.arr, a = this.data.val, r = this.data.id;
        return this.data.list.length < 1 ? app.hint("您最近没有处罚哦~") : 1 != t[e] ? app.hint("请选择要申诉的处罚") : a ? a.length < 20 ? app.hint("申诉内容不能低于20字") : void homeModule.complain({
            id: r,
            content: a
        }).then(function(e) {
            wx.redirectTo({
                url: "../info/info"
            }), app.hint("提交成功", "success");
        }, function(e) {}) : app.hint("请填写申诉内容");
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