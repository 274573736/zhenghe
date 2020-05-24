var app = getApp();

Page({
    data: {
        getGoods: [],
        record: !0,
        audio_url: ""
    },
    onLoad: function(a) {
        wx.setStorageSync("is_remove_shou", 1), this.setData({
            goods_list: wx.getStorageSync("all_goods_list"),
            goods_idx: app.globalData.all_goods_idx,
            remark: app.globalData.all_remark
        });
    },
    onReady: function() {
        app.setNavigation(), wx.setNavigationBarTitle({
            title: app.globalData.syStem.business_type[2].title
        });
    },
    onShow: function() {},
    onHide: function() {},
    textarea: function(a) {
        this.setData({
            remark: a.detail.value
        });
    },
    sGoods: function(a) {
        this.setData({
            goods_idx: a.currentTarget.dataset.idx
        });
    },
    confirm: function(a) {
        var e = this;
        app.setFormId(a.detail.formId), app.getApplicationIsAuth().then(function(a) {
            if (1 == a) {
                var t = e.data.goods_idx;
                if (t < 0) return app.hint("请选择服务类型~");
                app.globalData.all_goods_idx = t, app.globalData.all_remark = e.data.remark, app.globalData.all_audio_url = e.data.audio_url, 
                wx.redirectTo({
                    url: "/make_speed/skin/all_powerful/all_powerful"
                });
            }
        }, function(a) {});
    },
    voiceUrl: function(a) {
        this.setData({
            audio_url: a.detail.audio_url
        });
    },
    cancelBtn: function() {
        this.setData({
            input_bg: !0
        });
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