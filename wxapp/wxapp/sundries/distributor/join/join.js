var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        tip: "",
        protocol: !1,
        title: "",
        img: "",
        distribution_name: ""
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("distributor");
        this.setData({
            img: e.d_img
        });
        var o = app.globalData.syStem;
        o && (this.setData({
            title: o.user_program_title,
            distribution_name: o.distribution_name
        }), wx.setNavigationBarTitle({
            title: o.distribution_name + "申请"
        }));
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    coopration: function() {
        wx.navigateTo({
            url: "/make_speed/protocol/protocol?title=推广协议&type=distribution"
        });
    },
    checkboxChange: function(t) {
        this.setData({
            protocol: t.detail.value[0] || !1
        });
    },
    confirm: function(t) {
        var e = this, o = t.detail.value;
        return o.name ? /^1(3|4|5|6|7|8|9)\d{9}$/.test(o.phone) ? this.data.protocol ? void homeModule.applyDistributor({
            name: o.name,
            phone: o.phone,
            invite_code: o.code,
            city_id: 0
        }).then(function(t) {
            1 != t.status ? wx.showModal({
                title: "温馨提示",
                content: "您的" + e.data.distribution_name + "信息已经提交审核，我们会尽快为您审核，请耐心等待。",
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.navigateBack({
                        delta: 1
                    });
                }
            }) : wx.navigateTo({
                url: "/sundries/distributor/info/info"
            });
        }, function(t) {}) : app.hint("需勾选同意推广协议~") : app.hint("请填写正确的手机号~") : app.hint("姓名不能为空~");
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