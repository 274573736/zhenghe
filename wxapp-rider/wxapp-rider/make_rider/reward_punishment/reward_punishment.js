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
        list: [],
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl,
        reward_list: [],
        reward_page: 1,
        is_reward: !0,
        punishment_list: [],
        punishment_page: 1,
        is_punishment: !0
    },
    tapSwitch: function(e) {
        var t = e.currentTarget.dataset.idx;
        this.setData({
            idx: t
        }), 0 == t ? this.rewardList("reward_list", 0, "reward_page", 1, "is_reward") : this.rewardList("punishment_list", 1, "punishment_page", 1, "is_punishment");
    },
    onLoad: function(e) {
        app.setNavigation(), this.rewardList("reward_list", 0, "reward_page", 1, "is_reward");
    },
    rewardList: function(i, e, r, n, s) {
        var o = this;
        homeModule.rewardList({
            page: n,
            type: e
        }).then(function(e) {
            var t;
            console.log(e);
            var a = e;
            1 < n && (a = o.data[i].concat(e)), o.setData((_defineProperty(t = {}, i, a), _defineProperty(t, r, n), 
            _defineProperty(t, s, !0), t));
        }, function(e) {
            1 < n && (app.hint("暂无更多数据~"), o.setData(_defineProperty({}, s, !1)));
        });
    },
    punishment: function(e) {},
    onReady: function() {},
    onShow: function() {
        app.listenWss(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        if (0 == this.data.idx) {
            this.data.is_reward || app.hint("暂无更多数据~");
            var e = 1 * this.data.reward_page + 1;
            this.rewardList("reward_list", 0, "reward_page", e, "is_reward");
        } else {
            this.data.is_punishment || app.hint("暂无更多数据~");
            var t = 1 * this.data.punishment_page + 1;
            this.rewardList("punishment_list", 1, "punishment_page", t, "is_punishment");
        }
    },
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});