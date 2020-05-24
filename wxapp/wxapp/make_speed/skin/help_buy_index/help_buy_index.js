var app = getApp();

Page({
    data: {
        goods_idx: -1,
        remark: "",
        goods_list: []
    },
    onLoad: function(a) {
        wx.setStorageSync("is_remove_shou", 1), this.setData({
            goods_list: wx.getStorageSync("buy_goods_list"),
            goods_idx: app.globalData.buy_goods_idx,
            remark: app.globalData.buy_remark
        });
    },
    onReady: function() {
        app.setNavigation(), wx.setNavigationBarTitle({
            title: app.globalData.syStem.business_type[1].title
        });
    },
    onShow: function() {},
    onHide: function() {},
    sGoods: function(a) {
        this.setData({
            goods_idx: a.currentTarget.dataset.idx
        });
    },
    textarea: function(a) {
        this.setData({
            remark: a.detail.value
        });
    },
    confirmBtn: function(a) {
        var e = this;
        app.setFormId(a.detail.formId), app.getApplicationIsAuth().then(function(a) {
            if (1 == a) {
                var t = e.data.goods_idx;
                if (t < 0) return app.hint("请选择物品类型~");
                app.globalData.buy_goods_idx = t, app.globalData.buy_remark = e.data.remark, wx.redirectTo({
                    url: "/make_speed/skin/help_buy/help_buy"
                });
            }
        }, function(a) {});
    },
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