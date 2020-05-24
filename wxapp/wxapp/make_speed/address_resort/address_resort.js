var app = getApp();

Page({
    data: {
        id: 0,
        list: [],
        type: 0,
        skin: 0,
        skin_type: 0,
        order_type: 0
    },
    onLoad: function(t) {
        var a = t.skin || 0, e = t.skin_type || 0, s = t.order_type || 0, r = t.type || 0, o = "";
        o = "big" == s ? "big_history_address" : "big" != s && 0 == r ? "fa_history_address" : "shou_history_address";
        var i = wx.getStorageSync(o) || [];
        this.setData({
            list: i,
            type: r,
            skin: a,
            skin_type: e,
            order_type: s
        });
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    sAddress: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.list;
        0 == this.data.type ? (wx.setStorageSync("fahuo_temporary", e[a]), wx.setStorageSync("fahuo", e[a])) : (wx.setStorageSync("shouhuo_temporary", e[a]), 
        wx.setStorageSync("shouhuo", e[a])), 0 < this.data.skin ? app.toTwoUrl(this.data.skin_type) : wx.navigateBack({
            delta: 1
        });
    },
    dAddress: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.list;
        e.splice(a, 1), this.setData({
            list: e
        });
        var s = "";
        s = "big" == this.data.order_type ? "big_history_address" : "big" != this.data.order_type && 0 == this.data.type ? "fa_history_address" : "shou_history_address", 
        wx.setStorageSync(s, e);
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